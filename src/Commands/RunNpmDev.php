<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class RunNpmDev extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Compiling your front-end assets with npm.',
            'NPM compiling'
        );

        $output = $this->asyncProcess(
            ['npm', 'run', 'dev'],
            function ($string) {
                return true;
            }
        );

        $feedback->advance('✅ Front-end assets compiled.');

        return $next($feedback);
    }
}
