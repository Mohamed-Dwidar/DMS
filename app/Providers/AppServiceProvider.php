<?php

namespace App\Providers;

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\CategoryModule\app\Models\Category;
use Modules\CityModule\app\Models\City;
use Modules\CourseModule\app\Models\Course;
use Modules\PageModule\app\Models\Page;

class AppServiceProvider extends ServiceProvider
{

    use GeneralHelper;
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
        
    }
}
