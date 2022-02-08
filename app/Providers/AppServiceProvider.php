<?php

namespace App\Providers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Telescope\TelescopeServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        Relation::morphMap([
            'user' => 'App\User',
            'news' => 'App\News',
            'release' => 'App\Release',
            'track' => 'App\Track',
            'comment' => 'App\Comment',
            'asset' => 'App\Asset',
            'report' => 'App\Report',
            'post' => 'App\Post',
            'like' => 'App\Like',
            'event' => 'App\Event',
            'share' => 'App\Share',
            'video' => 'App\Video',
            'merch' => 'App\Merch',
            'page' => 'App\Page',
            'thread' => 'App\Thread',
            'order' => 'App\Order',
        ]);

        view()->composer('*', function(View $view) {
            $route = explode('/', Request::path());

            if (!isset($route[1])) {
                $path = '';
            } else {
                $path = $route[1];
            }

            $view->with('searchPath', $path);
        });

        \Illuminate\Support\Facades\Gate::define('viewMailcoach', function ($user = null) {
            return optional($user)->hasPermissionTo('view admin dashboard');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path('Http/Helpers.php');

        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
