<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagination sizes
    |--------------------------------------------------------------------------
    |
    | Centralised pagination configuration. Controllers must use config()
    | instead of env() so that values survive `php artisan config:cache`.
    |
    */

    'posts_per_page' => (int) env('POSTS_PER_PAGE', 15),

    'authors_per_page' => (int) env('AUTHORS_PER_PAGE', 15),

    'comments_per_page' => (int) env('COMMENTS_PER_PAGE', 15),

    'categories_per_page' => (int) env('CATEGORIES_PER_PAGE', 15),

];
