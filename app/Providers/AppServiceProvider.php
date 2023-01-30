<?php

namespace App\Providers;

use App\Blocks\ImageBlock;
use App\Blocks\TextBlock;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // TODO dynamically load blocks
        foreach ([TextBlock::class, ImageBlock::class] as $test) {
            Livewire::component($test::getName(), $test);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
