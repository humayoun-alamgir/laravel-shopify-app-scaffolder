<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;
use Illuminate\Support\Facades\File;

class SetupJsAdminDirectory extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Setting up the JS admin directory for the Shopify admin.',
            'Shopify admin directory'
        );

        $this->setupJsAdmin();
        $this->replaceWebRoutesFile();
        $this->setupAdminBladeFile();
        $this->setupAdminController();

        $feedback->advance('✅ Admin directory set up.');

        return $next($feedback);
    }

    private function setupJsAdmin()
    {
        if (File::exists(resource_path('js/admin'))) {
            return;
        }

        File::copyDirectory(
            __DIR__ . '/../stubs/admin',
            resource_path('js/admin')
        );
    }

    private function replaceWebRoutesFile()
    {
        if (File::exists(base_path('routes/web.php.bak'))) {
            return;
        }

        file_put_contents(
            base_path('routes/web.php.bak'),
            file_get_contents(base_path('routes/web.php'))
        );

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/../stubs/routes/web.php.stub')
        );
    }

    private function setupAdminBladeFile()
    {
        if (File::exists(resource_path('views/app.blade.php'))) {
            return;
        }

        File::copy(
            __DIR__ . '/../stubs/resources/views/app.blade.php.stub',
            resource_path('views/app.blade.php')
        );
    }

    private function setupAdminController()
    {
        if (File::exists(app_path('Http/Controllers/Admin'))) {
            return;
        }

        File::makeDirectory(
            app_path('Http/Controllers/Admin')
        );

        File::copy(
            __DIR__ . '/../stubs/app/Http/Controllers/Admin/ShopifyAdminController.php.stub',
            app_path('Http/Controllers/Admin/ShopifyAdminController.php')
        );
    }
}
