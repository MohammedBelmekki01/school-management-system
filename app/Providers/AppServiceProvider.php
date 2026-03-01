<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // User caching observer
        User::observe(UserObserver::class);

        // Custom 'if' query builder macro for conditional where clauses
        Builder::macro('if', function ($condition, $column, $operator, $value) {
            if ($condition) {
                return $this->where($column, $operator, $value);
            }

            return $this;
        });

        // Custom 'whereLike' query builder macro for flexible LIKE searches
        Builder::macro('whereLike', function ($column, $search) {
            return $this->where($column, 'LIKE', '%' . $search . '%');
        });

        // Custom 'whereActive' macro to filter active records
        Builder::macro('whereActive', function ($column = 'status') {
            return $this->where($column, '1');
        });

        // Register custom Blade directives
        $this->registerBladeDirectives();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register custom Blade template directives.
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        // @role('admin') ... @endrole
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role && auth()->user()->role->role_id == $role;
        });

        // @active($status) — outputs 'active' CSS class
        Blade::directive('active', function ($expression) {
            return "<?php echo ($expression) == '1' ? 'active' : 'inactive'; ?>";
        });

        // @dateformat($date) — outputs formatted date
        Blade::directive('dateformat', function ($expression) {
            return "<?php echo ($expression) ? \\Carbon\\Carbon::parse($expression)->format('d M, Y') : 'N/A'; ?>";
        });
    }
}
