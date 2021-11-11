<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class PartnersSetupWalkThrough extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Walking you through setting up a shopify app in Shopify partners account.',
            'Shopify Partners Setup'
        );

        $feedback->feedback('<comment>Go to the Shopify Partners "Create an app" page and click the Custom App box.</comment>');
        $feedback->feedback('<comment>Add a title for your app in the App name field.</comment>');
        $feedback->feedback('After entering your title in Shopify Partners UI, return here to continue installation.');

        $this->confirm('Press enter to confirm you have filled in the App name field in the Shopify Partners UI.');

        $feedback->feedback('Next you are going to need to enter a full, valid local domain and path into the Shopify Partners UI.');
        $feedback->feedback('Tell me your local root domain for your app, and I will give you a full domain and path to paste into the Shopify Partners UI.');

        // Ask app url
        $appUrl = $this->ask('Please enter your local root domain for your app and press enter.');
        $appUrl = $this->ensurePrefixedWith($appUrl, 'https://');

        $feedback->feedback('<comment>Please paste the following URL into the Shopify Partners UI, in its "App URL" field:</comment>');
        $feedback->feedback('<comment>' . $appUrl . '/app</comment>');

        $this->confirm('Press enter to confirm you have filled out the App URL field in the Shopify Partners UI');

        // Add url to the .env file
        $envFileContents = file_get_contents(base_path('.env'));
        $envFileContents = str_replace('APP_URL', '#APP_URL', $envFileContents);
        file_put_contents(base_path('.env'), $envFileContents);
        file_put_contents(base_path('.env'), PHP_EOL . 'APP_URL=' . $appUrl . PHP_EOL, FILE_APPEND);

        $feedback->feedback('✅ Your .env file has also been updated with the correct app url (APP_URL in your .env)');

        $feedback->feedback('Next is to configure the correct Allowed redirection URL(s) for your app.');
        $feedback->feedback('😛 Luckily for you I have already generated them for you.');

        // give developer whitelist apis to paste into partners.
        $feedback->feedback('<comment>Please paste the following four URLs into the Shopify Partners UI, in its "Allowed redirection URL(s)" field:</comment>');

        $format = "<comment>%s/oauth\n %s/oauth/\n %s/oauth/done\n %s/oauth/done/</comment>";
        $feedback->feedback(vsprintf($format, [$appUrl, $appUrl, $appUrl, $appUrl]));
        $this->confirm('Press enter when you have pasted the four urls into "Allowed redirection URL(s)" textarea.');

        $feedback->feedback('<comment>Click the Create App button in the Shopify Partners UI</comment>.');
        $feedback->feedback('<comment>You should now see an overview page for your new app with an "API Key" and "API Secret Key".</comment>');

        // Ask developer for Api key and secret from partners and add to .env file.
        $apiKey = $this->ask('What is your Shopify App API key? (paste here)');
        $apiSecret = $this->ask('What is your Shopify App API secret key? (paste here)');
        $format = PHP_EOL . 'SHOPIFY_AUTH_METHOD="app-bridge"' . PHP_EOL . 'SHOPIFY_API_KEY="%s"' . PHP_EOL . 'SHOPIFY_API_SECRET="%s"' . PHP_EOL;
        file_put_contents(base_path('.env'), vsprintf($format, [$apiKey, $apiSecret]), FILE_APPEND);

        $feedback->feedback('✅ Your .env file has also been updated with the correct values for: SHOPIFY_AUTH_METHOD, SHOPIFY_API_KEY and SHOPIFY_API_SECRET.');

        $feedback->advance('✅ Partners account ready');

        return $next($feedback);
    }
}
