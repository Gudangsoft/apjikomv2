<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Share site settings to all views
        View::composer('*', function ($view) {
            try {
                $view->with([
                    'globalSiteName' => Setting::getValue('site_name') ?? 'APJIKOM',
                    'globalSiteLogo' => Setting::getValue('site_logo'),
                    'globalSiteFavicon' => Setting::getValue('site_favicon'),
                ]);
            } catch (\Exception $e) {
                // Fallback if settings table doesn't exist
                $view->with([
                    'globalSiteName' => 'APJIKOM',
                    'globalSiteLogo' => null,
                    'globalSiteFavicon' => null,
                ]);
            }
        });
        
        // Share menus to all views
        View::composer('*', function ($view) {
            try {
                $menus = Menu::with(['children.children', 'page'])
                    ->active()
                    ->topLevel()
                    ->ordered()
                    ->get();
                $view->with('globalMenus', $menus);
            } catch (\Exception $e) {
                // Fallback if menus table doesn't exist
                $view->with('globalMenus', collect());
            }
        });
    }
}
