<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class SafetyCheck extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->caution('Only run in a fresh Laravel 6 codebase.' . PHP_EOL . 'Running these commands will make many changes to aspects of your project files.');
        $feedback->note('Before proceeding further with these installation steps, please open Chrome browser and log in to your target dev store via Shopify Partners. This will enable full installation of your new app into the store.');
        $message = $this->ask('Are you absolutely sure you wish to run the scaffolder?');

        if (strtolower($message) === 'yes') {
            $feedback->advance('✅ About to begin tasks', 'Confirmation');
            return $next($feedback);
        }
        $feedback->abort();
    }
}
