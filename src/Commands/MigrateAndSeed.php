<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class MigrateAndSeed extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Migrating your database and running any database seeder classes.',
            'Database migration and seeding'
        );

        $output = $this->asyncProcess(
            ['php', 'artisan', 'migrate:fresh'],
            function ($string) {
                return strpos($string, 'Migrated:  2019_08_19_000000_create_failed_jobs_table') !== false;
            }
        );

        $feedback->feedback('✅ Database migration complete.');

        $output = $this->asyncProcess(
            ['php', 'artisan', 'db:seed'],
            function ($string) {
                return strpos($string, 'Database seeding completed successfully') !== false;
            }
        );

        $feedback->advance('✅ Database seeding complete.');

        return $next($feedback);
    }
}
