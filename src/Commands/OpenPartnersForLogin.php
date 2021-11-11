<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;
use Symfony\Component\Process\Process;

class OpenPartnersForLogin extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Attempting to open Shopify Partners website in a chrome browser.',
            'Shopify Partners.'
        );

        $partnersId = env('SHOPIFY_PARTNERS_ID', '');

        $process = new Process([
            'google-chrome',
            '--new-tab',
            'https://partners.shopify.com/' . $partnersId . '/apps/new',
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            $feedback->advance('❌ Failed to open Shopify Partners website. Please head there now.');
            return $next($feedback);
        }

        $feedback->advance('✅ Partners opened in chrome browser');

        return $next($feedback);
    }
}
