<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //--------------------
        // ルーティングとモデルの紐づけ
        // アクションのパラメータでモデルをDIできるようにする
        // https://readouble.com/laravel/5.4/ja/routing.html
        //--------------------

        Route::bind('user', function ($id) {
            // id型チェック 数値以外はNotFound
            if(! is_numeric($id)){
                throw new NotFoundHttpException(trans('message.error.record_not_found'));
            }

           $user = User::findOrFail($id);

            if (is_null($user)) {
                throw new NotFoundHttpException(trans('message.error.record_not_found'));
            }

           return $user;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapFrontRoutes();
        $this->mapAdminRoutes();
    }

    /**
     * フロント用
     */
    protected function mapFrontRoutes()
    {
        Route::prefix('')
            ->middleware('web')
            ->namespace($this->namespace. '\Front')
            ->group(base_path('routes/web_front.php'));
    }

    /**
     * 管理画面用
     */
    protected function mapAdminRoutes()
    {
        // URL総当たり攻撃対策のため、prefixは長めにしている
        Route::prefix(ADMIN_PREFIX)
            ->middleware('web')
            ->namespace($this->namespace.'\Admin')
            ->group(base_path('routes/web_admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
