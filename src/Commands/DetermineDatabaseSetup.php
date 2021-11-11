<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class DetermineDatabaseSetup extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Tell us about your local database connection details.',
            'Database configuration'
        );

        $dbName = $this->ask('What is the name of your database?');
        $dbUser = $this->ask('What is your database user name?');
        $dbPass = $this->ask('What is your database password?');

        $fileContents = file_get_contents(base_path('.env'));

        $fileContents = str_replace('DB_DATABASE=laravel', 'DB_DATABASE=' . $dbName, $fileContents);
        $fileContents = str_replace('DB_USERNAME=root', 'DB_USERNAME=' . $dbUser, $fileContents);
        $fileContents = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $dbPass, $fileContents);

        file_put_contents(base_path('.env'), $fileContents);

        $feedback->advance('✅ Database configuration done.');

        return $next($feedback);
    }
}
