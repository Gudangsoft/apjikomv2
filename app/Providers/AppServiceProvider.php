<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Menu;
use App\Models\SocialMedia;
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
                    'globalSiteName'        => Setting::getValue('site_name', 'Website Asosiasi'),
                    'globalSiteTagline'     => Setting::getValue('site_tagline', 'Website Asosiasi'),
                    'globalSiteDescription' => Setting::getValue('site_description', 'Website Asosiasi'),
                    'globalMetaDescription' => Setting::getValue('meta_description', Setting::getValue('site_description', 'Website Asosiasi')),
                    'globalMetaKeywords'    => Setting::getValue('meta_keywords', 'website asosiasi'),
                    'globalContactEmail'    => Setting::getValue('contact_email', ''),
                    'globalSiteLogo'        => Setting::getValue('site_logo'),
                    'globalSiteFavicon'     => Setting::getValue('site_favicon'),
                    'globalThemePrimary'    => Setting::getValue('theme_primary', '#7C3AED'),
                    'globalThemeDark'       => Setting::getValue('theme_dark',    '#5B21B6'),
                    'globalThemeLight'      => Setting::getValue('theme_light',   '#8B5CF6'),
                    'globalThemePale'       => Setting::getValue('theme_pale',    '#EDE9FE'),
                    'globalThemeFooter'     => Setting::getValue('theme_footer',  '#3B0764'),
                    'globalCopyrightText'   => htmlspecialchars(
                        strip_tags(Setting::getValue('footer_copyright_text', '© ' . date('Y') . ' ' . Setting::getValue('site_name', 'Website Asosiasi') . '. All Rights Reserved.'))
                    ),
                ]);
            } catch (\Exception $e) {
                $view->with([
                    'globalSiteName'        => 'Website Asosiasi',
                    'globalSiteTagline'     => 'Website Asosiasi',
                    'globalSiteDescription' => 'Website Asosiasi',
                    'globalMetaDescription' => 'Website Asosiasi',
                    'globalMetaKeywords'    => 'website asosiasi',
                    'globalContactEmail'    => '',
                    'globalSiteLogo'        => null,
                    'globalSiteFavicon'     => null,
                    'globalThemePrimary'    => '#7C3AED',
                    'globalThemeDark'       => '#5B21B6',
                    'globalThemeLight'      => '#8B5CF6',
                    'globalThemePale'       => '#EDE9FE',
                    'globalThemeFooter'     => '#3B0764',
                    'globalCopyrightText'   => '&copy; ' . date('Y') . ' Website Asosiasi. All Rights Reserved.',
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
                $view->with('globalMenus', collect());
            }
        });

        // Share social media to all views
        View::composer('*', function ($view) {
            try {
                $view->with('globalSocialMedia', SocialMedia::where('is_active', true)->orderBy('order')->get());
            } catch (\Exception $e) {
                $view->with('globalSocialMedia', collect());
            }
        });
    }
}
