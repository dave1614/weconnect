<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Schema::defaultStringLength(191);

        // Route::prefix('posts/{post}')->group(function () {
        //     Route::model('comment',Comment::class, function ($value, $route) {
        //         $post = $route->parameter('post');
        //         return Comment::where('post_id', $post->id)
        //             ->where('id', $value)->firstOrFail();
        //     });

        //     // Route::get('comments/{comment}', function (Post $category, Comment $comment) {
        //     //     return Comment::where('id', $)
        //     // });
        // });
    }
}
