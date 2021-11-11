<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;
use Dotenv\Dotenv;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;

class ReloadEnv extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Reloading your .env file.',
            'Reloading .env'
        );

        with(Dotenv::create(app()->environmentPath(), app()->environmentFile()))->overload();
        with(new LoadConfiguration())->bootstrap(app());

        $feedback->advance('✅ .env file reloaded');

        return $next($feedback);
    }
}
