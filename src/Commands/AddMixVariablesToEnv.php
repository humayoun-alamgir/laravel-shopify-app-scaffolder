<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class AddMixVariablesToEnv extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Setting up the MIX variables to be used in JavaScript',
            '.env MIX Variables'
        );

        file_put_contents(
            base_path('.env'),
            file_get_contents(__DIR__ . '/../stubs/mixvars.env.stub'),
            FILE_APPEND
        );

        $feedback->advance('✅ MIX variables added to your .env file');

        return $next($feedback);
    }
}
