<?php

namespace LV\ShopifyAppScaffolder;

use LV\BaseCommand\BaseCommandServiceProvider;

class ShopifyAppScaffolderServiceProvider extends BaseCommandServiceProvider
{
    public function registerArtisanCommand()
    {
        $this->commands([
            ShopifyAppScaffoldingCommand::class,
        ]);
    }
}
