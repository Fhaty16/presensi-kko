<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | Seluruh konfigurasi service pihak ketiga disimpan di sini.
    | Nilai sensitif tetap diambil dari file .env.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | POSTMARK
    |--------------------------------------------------------------------------
    */

    'postmark' => [

        'key' =>
            env(
                'POSTMARK_API_KEY'
            ),

    ],


    /*
    |--------------------------------------------------------------------------
    | RESEND
    |--------------------------------------------------------------------------
    */

    'resend' => [

        'key' =>
            env(
                'RESEND_API_KEY'
            ),

    ],


    /*
    |--------------------------------------------------------------------------
    | AMAZON SES
    |--------------------------------------------------------------------------
    */

    'ses' => [

        'key' =>
            env(
                'AWS_ACCESS_KEY_ID'
            ),

        'secret' =>
            env(
                'AWS_SECRET_ACCESS_KEY'
            ),

        'region' =>
            env(
                'AWS_DEFAULT_REGION',
                'us-east-1'
            ),

    ],


    /*
    |--------------------------------------------------------------------------
    | SLACK
    |--------------------------------------------------------------------------
    */

    'slack' => [

        'notifications' => [

            'bot_user_oauth_token' =>
                env(
                    'SLACK_BOT_USER_OAUTH_TOKEN'
                ),

            'channel' =>
                env(
                    'SLACK_BOT_USER_DEFAULT_CHANNEL'
                ),

        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | FONNTE WHATSAPP
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk mengirim notifikasi WhatsApp kepada
    | orang tua / wali siswa.
    |
    */

    'fonnte' => [

        'enabled' =>
            env(
                'FONNTE_ENABLED',
                false
            ),

        'token' =>
            env(
                'FONNTE_TOKEN'
            ),

        'base_url' =>
            env(
                'FONNTE_BASE_URL',
                'https://api.fonnte.com'
            ),

        'country_code' =>
            env(
                'FONNTE_COUNTRY_CODE',
                '62'
            ),

    ],


    /*
    |--------------------------------------------------------------------------
    | GROQ AI
    |--------------------------------------------------------------------------
    |
    | Digunakan oleh KKO AI Assistant.
    |
    | Service membaca konfigurasi:
    |
    | services.groq.api_key
    | services.groq.base_url
    | services.groq.model
    |
    */

    'groq' => [

        /*
        |--------------------------------------------------------------------------
        | API KEY
        |--------------------------------------------------------------------------
        */

        'api_key' =>
            env(
                'GROQ_API_KEY'
            ),


        /*
        |--------------------------------------------------------------------------
        | BASE URL
        |--------------------------------------------------------------------------
        */

        'base_url' =>
            env(
                'GROQ_BASE_URL',
                'https://api.groq.com/openai/v1'
            ),


        /*
        |--------------------------------------------------------------------------
        | MODEL
        |--------------------------------------------------------------------------
        */

        'model' =>
            env(
                'GROQ_MODEL',
                'openai/gpt-oss-20b'
            ),

    ],

];