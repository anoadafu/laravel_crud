<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Twig\TwigTest;

class TwigAddTests extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Twig::addTest(new TwigTest('string', function ($value) {
            return is_string($value);
        }));
        \Twig::addTest(new TwigTest('array', function ($value) {
            return is_array($value);
        }));
    }
}
