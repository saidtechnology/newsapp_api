<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\PostsResource;

class CategoryController extends Controller
{
    /**
     * Paginated list of categories.
     */
    public function index()
    {
        return new CategoriesResource(
            Category::paginate(config('newsapp.categories_per_page'))
        );
    }

    /**
     * Posts belonging to a category.
     */
    public function posts($id)
    {
        $category = Category::findOrFail($id);

        return new PostsResource(
            $category->posts()->paginate(config('newsapp.posts_per_page'))
        );
    }
}
