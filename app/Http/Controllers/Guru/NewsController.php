<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | DAFTAR BERITA
        |--------------------------------------------------------------------------
        */

        $newsItems = News::query()
            ->latest()
            ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | STATISTIK BERITA
        |--------------------------------------------------------------------------
        |
        | Nama utama yang dipakai index.blade.php:
        |
        | $totalCount
        | $publishedCount
        | $draftCount
        |
        */

        $totalCount = News::query()
            ->count();


        $publishedCount = News::query()
            ->where(
                'status',
                'published'
            )
            ->count();


        $draftCount = News::query()
            ->where(
                'status',
                'draft'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | ALIAS
        |--------------------------------------------------------------------------
        |
        | Alias tetap dikirim untuk menjaga kompatibilitas jika ada
        | bagian Blade lama yang masih menggunakan:
        |
        | $totalNews
        | $publishedNews
        | $draftNews
        |
        */

        $totalNews =
            $totalCount;


        $publishedNews =
            $publishedCount;


        $draftNews =
            $draftCount;


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'guru.news.index',
            compact(
                'newsItems',

                'totalCount',
                'publishedCount',
                'draftCount',

                'totalNews',
                'publishedNews',
                'draftNews'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view(
            'guru.news.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'summary' => [
                'nullable',
                'string',
                'max:500',
            ],

            'content' => [
                'required',
                'string',
            ],

            'category' => [
                'nullable',
                'string',
                'max:100',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            /*
            |--------------------------------------------------------------------------
            | COVER POSITION
            |--------------------------------------------------------------------------
            */

            'image_position_x' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'image_position_y' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'image_zoom' => [
                'nullable',
                'numeric',
                'min:1',
                'max:2.5',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE NEWS
        |--------------------------------------------------------------------------
        */

        $news = new News();


        /*
        |--------------------------------------------------------------------------
        | BASIC DATA
        |--------------------------------------------------------------------------
        */

        $news->title =
            $validated['title'];


        $news->summary =
            $validated['summary']
            ?? null;


        $news->content =
            $validated['content'];


        $news->category =
            $validated['category']
            ?? 'Informasi KKO';


        $news->status =
            $validated['status'];


        /*
        |--------------------------------------------------------------------------
        | COVER SETTINGS
        |--------------------------------------------------------------------------
        */

        $news->image_position_x =
            (float) (
                $validated['image_position_x']
                ?? 50
            );


        $news->image_position_y =
            (float) (
                $validated['image_position_y']
                ?? 50
            );


        $news->image_zoom =
            (float) (
                $validated['image_zoom']
                ?? 1
            );


        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        |
        | Gambar disimpan dalam bentuk file asli.
        |
        | Tidak dilakukan:
        |
        | - crop permanen
        | - resize permanen
        | - pemotongan file
        |
        | Tampilan cover dikontrol melalui:
        |
        | image_position_x
        | image_position_y
        | image_zoom
        |
        */

        if (
            $request->hasFile(
                'image'
            )
        ) {

            $news->image =
                $request
                    ->file(
                        'image'
                    )
                    ->store(
                        'news',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | PUBLISHED AT
        |--------------------------------------------------------------------------
        */

        if (
            $news->status
            === 'published'
        ) {

            $news->published_at =
                now(
                    'Asia/Jakarta'
                );

        } else {

            $news->published_at =
                null;
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $news->save();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'guru.news.index'
            )
            ->with(
                'success',
                'Berita KKO berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        News $news
    ): View
    {
        return view(
            'guru.news.edit',
            compact(
                'news'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        News $news
    ): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'summary' => [
                'nullable',
                'string',
                'max:500',
            ],

            'content' => [
                'required',
                'string',
            ],

            'category' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | IMAGE OPTIONAL SAAT EDIT
            |--------------------------------------------------------------------------
            |
            | Kalau Guru tidak memilih file baru,
            | gambar lama tetap dipakai.
            |
            */

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'status' => [
                'required',
                'in:draft,published',
            ],

            /*
            |--------------------------------------------------------------------------
            | COVER SETTINGS
            |--------------------------------------------------------------------------
            */

            'image_position_x' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'image_position_y' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'image_zoom' => [
                'nullable',
                'numeric',
                'min:1',
                'max:2.5',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN STATUS LAMA
        |--------------------------------------------------------------------------
        |
        | Harus dilakukan sebelum status diganti.
        |
        */

        $oldStatus =
            $news->status;


        /*
        |--------------------------------------------------------------------------
        | BASIC DATA
        |--------------------------------------------------------------------------
        */

        $news->title =
            $validated['title'];


        $news->summary =
            $validated['summary']
            ?? null;


        $news->content =
            $validated['content'];


        $news->category =
            $validated['category']
            ?? 'Informasi KKO';


        /*
        |--------------------------------------------------------------------------
        | COVER SETTINGS
        |--------------------------------------------------------------------------
        |
        | Nilai ini akan digunakan oleh:
        |
        | - Dashboard siswa
        | - Semua Berita
        | - Detail Berita
        |
        */

        $news->image_position_x =
            (float) (
                $validated['image_position_x']
                ?? 50
            );


        $news->image_position_y =
            (float) (
                $validated['image_position_y']
                ?? 50
            );


        $news->image_zoom =
            (float) (
                $validated['image_zoom']
                ?? 1
            );


        /*
        |--------------------------------------------------------------------------
        | GANTI GAMBAR
        |--------------------------------------------------------------------------
        |
        | Cover lama hanya dihapus jika Guru benar-benar
        | memilih file gambar baru.
        |
        */

        if (
            $request->hasFile(
                'image'
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | SIMPAN PATH GAMBAR LAMA
            |--------------------------------------------------------------------------
            */

            $oldImage =
                $news->image;


            /*
            |--------------------------------------------------------------------------
            | SIMPAN GAMBAR BARU TERLEBIH DAHULU
            |--------------------------------------------------------------------------
            |
            | Ini lebih aman daripada menghapus gambar lama terlebih dahulu.
            |
            */

            $newImage =
                $request
                    ->file(
                        'image'
                    )
                    ->store(
                        'news',
                        'public'
                    );


            /*
            |--------------------------------------------------------------------------
            | GANTI PATH
            |--------------------------------------------------------------------------
            */

            $news->image =
                $newImage;


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR LAMA
            |--------------------------------------------------------------------------
            */

            if (
                $oldImage
                &&
                Storage::disk(
                    'public'
                )->exists(
                    $oldImage
                )
            ) {

                Storage::disk(
                    'public'
                )->delete(
                    $oldImage
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS BARU
        |--------------------------------------------------------------------------
        */

        $newStatus =
            $validated['status'];


        $news->status =
            $newStatus;


        /*
        |--------------------------------------------------------------------------
        | PUBLISHED AT
        |--------------------------------------------------------------------------
        |
        | LOGIKA:
        |
        | Published -> Published
        | tanggal lama dipertahankan.
        |
        | Draft -> Published
        | tanggal diisi waktu sekarang.
        |
        | Published -> Draft
        | published_at menjadi null.
        |
        */

        if (
            $newStatus
            === 'published'
        ) {

            /*
            |--------------------------------------------------------------------------
            | DRAFT -> PUBLISHED
            |--------------------------------------------------------------------------
            */

            if (
                $oldStatus
                !== 'published'
                ||
                !$news->published_at
            ) {

                $news->published_at =
                    now(
                        'Asia/Jakarta'
                    );
            }

        } else {

            /*
            |--------------------------------------------------------------------------
            | MENJADI DRAFT
            |--------------------------------------------------------------------------
            */

            $news->published_at =
                null;
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $news->save();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'guru.news.index'
            )
            ->with(
                'success',
                'Berita KKO berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TOGGLE STATUS
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(
        News $news
    ): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | PUBLISHED -> DRAFT
        |--------------------------------------------------------------------------
        */

        if (
            $news->status
            === 'published'
        ) {

            $news->status =
                'draft';


            $news->published_at =
                null;
        }

        /*
        |--------------------------------------------------------------------------
        | DRAFT -> PUBLISHED
        |--------------------------------------------------------------------------
        */

        else {

            $news->status =
                'published';


            $news->published_at =
                now(
                    'Asia/Jakarta'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $news->save();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'guru.news.index'
            )
            ->with(
                'success',
                $news->status
                === 'published'
                    ? 'Berita berhasil dipublikasikan.'
                    : 'Berita berhasil dijadikan draft.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(
        News $news
    ): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | SIMPAN PATH GAMBAR
        |--------------------------------------------------------------------------
        */

        $imagePath =
            $news->image;


        /*
        |--------------------------------------------------------------------------
        | DELETE NEWS DARI DATABASE
        |--------------------------------------------------------------------------
        */

        $news->delete();


        /*
        |--------------------------------------------------------------------------
        | DELETE IMAGE
        |--------------------------------------------------------------------------
        |
        | Dilakukan setelah row berita berhasil dihapus.
        |
        */

        if (
            $imagePath
            &&
            Storage::disk(
                'public'
            )->exists(
                $imagePath
            )
        ) {

            Storage::disk(
                'public'
            )->delete(
                $imagePath
            );
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'guru.news.index'
            )
            ->with(
                'success',
                'Berita KKO berhasil dihapus.'
            );
    }
}