<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;
use Symfony\Component\Process\Process;

class OpenAppInChromeBrowser extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Installing your app into your dev store and opening in a chrome browser.',
            'Finalize Installation.'
        );

        $process = new Process([
            'google-chrome',
            '--new-tab',
            config('app.url') . '/app',
        ]);

        $process->run();

        $feedback->advance('✅ App opened in chrome browser');

        return $next($feedback);
    }
}
