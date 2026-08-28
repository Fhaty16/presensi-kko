<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR BERITA
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $newsItems =
            News::query()
                ->where(
                    'status',
                    'published'
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now(
                        'Asia/Jakarta'
                    )
                )
                ->latest(
                    'published_at'
                )
                ->paginate(9);


        return view(
            'siswa.news.index',
            compact(
                'newsItems'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL BERITA
    |--------------------------------------------------------------------------
    */

    public function show(
        News $news
    ): View {

        /*
        |--------------------------------------------------------------------------
        | SISWA HANYA BOLEH MELIHAT BERITA PUBLISHED
        |--------------------------------------------------------------------------
        */

        if (
            $news->status !== 'published'
            ||
            !$news->published_at
            ||
            $news->published_at->isFuture()
        ) {

            abort(
                404
            );
        }


        return view(
            'siswa.news.show',
            compact(
                'news'
            )
        );
    }
}