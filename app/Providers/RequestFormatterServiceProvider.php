<?php

declare(strict_types=1);

namespace App\Providers;

use App\Formatters\Interfaces\ProductRequestFormatterInterface;
use App\Formatters\ProductRequestFormatter;
use Illuminate\Support\ServiceProvider;

final class RequestFormatterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRequestFormatterInterface::class,
            ProductRequestFormatter::class
        );
    }
}
