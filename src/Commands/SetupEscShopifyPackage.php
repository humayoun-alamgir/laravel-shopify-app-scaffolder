<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class SetupEscShopifyPackage extends StepAlways
{
    const PACKAGE_STRING = 'esc/shopify:v3.x-dev';
    const SEARCH_STRING = 'App\Providers\RouteServiceProvider::class,';
    const INSERT_STRING = 'Esc\Shopify\Providers\APIServiceProvider::class,';

    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Setting up the ESC Shopify package composer package.',
            'ESC Shopify Package'
        );

        $this->installPackage();
        $this->updateConfig();
        $this->publishAssets();
        $this->createShopModel();
        $this->addShopifyUserTraitToUserModel();

        $feedback->advance('✅ ESC Shopify package setup complete');

        return $next($feedback);
    }

    private function installPackage()
    {
        $output = $this->asyncProcess(
            ['composer', 'require', self::PACKAGE_STRING],
            function ($string) {
                return strpos($string, 'Package manifest generated successfully') !== false;
            }
        );
    }

    private function updateConfig()
    {
        $this->updateFile(
            base_path('config/app.php'),
            self::SEARCH_STRING,
            "\n\n        " . self::INSERT_STRING
        );
    }

    private function publishAssets()
    {
        $output = $this->asyncProcess(
            ['php', 'artisan', 'vendor:publish', '--provider=Esc\Shopify\Providers\APIServiceProvider'],
            function ($string) {
                return strpos($string, 'Publishing complete') !== false;
            }
        );
    }

    private function createShopModel()
    {
        file_put_contents(
            app_path('Shop.php'),
            file_get_contents(__DIR__ . '/../stubs/App_Shop.stub')
        );
    }

    private function addShopifyUserTraitToUserModel()
    {
        $this->updateFile(
            app_path('User.php'),
            'use Illuminate\Notifications\Notifiable;',
            'use Esc\Shopify\Traits\ShopifyUser;'
        );

        $this->updateFile(
            app_path('User.php'),
            'use Notifiable;',
            "\n    " . 'use ShopifyUser;'
        );
    }
}
