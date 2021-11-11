<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class ComposerInstall extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Installing packages via composer.',
            'Composer Install'
        );

        $output = $this->asyncProcess(
            ['composer', 'install'],
            function ($string) {
                return strpos($string, 'Package manifest generated successfully') !== false;
            }
        );

        $feedback->advance('✅ Packages installed.');

        return $next($feedback);
    }
}
