<?php

namespace LV\ShopifyAppScaffolder;

use LV\BaseCommand\Commands\BaseCommand;
use LV\ShopifyAppScaffolder\Commands\AddMixVariablesToEnv;
use LV\ShopifyAppScaffolder\Commands\ComposerInstall;
use LV\ShopifyAppScaffolder\Commands\FixProjectPermissions;
use LV\ShopifyAppScaffolder\Commands\PartnersSetupWalkThrough;
use LV\ShopifyAppScaffolder\Commands\ScaffoldPhpTesting;
use LV\ShopifyAppScaffolder\Commands\SetupEscShopifyPackage;
use LV\ShopifyAppScaffolder\Commands\SetupJSLibsAndConfig;
use LV\ShopifyAppScaffolder\Commands\SetupJsAdminDirectory;
use LV\ShopifyAppScaffolder\Commands\DetermineDatabaseSetup;
use LV\ShopifyAppScaffolder\Commands\MigrateAndSeed;
use LV\ShopifyAppScaffolder\Commands\OpenAppInChromeBrowser;
use LV\ShopifyAppScaffolder\Commands\OpenPartnersForLogin;
use LV\ShopifyAppScaffolder\Commands\ReloadEnv;
use LV\ShopifyAppScaffolder\Commands\RunNpmDev;
use LV\ShopifyAppScaffolder\Commands\SafetyCheck;

class ShopifyAppScaffoldingCommand extends BaseCommand
{
    protected $signature = 'shopify:scaffold';

    protected $commands = [
        SafetyCheck::class,
        SetupEscShopifyPackage::class,
        OpenPartnersForLogin::class,
        PartnersSetupWalkThrough::class,
        DetermineDatabaseSetup::class,
        AddMixVariablesToEnv::class,
        ReloadEnv::class,
        ScaffoldPhpTesting::class,
        SetupJsAdminDirectory::class,
        SetupJSLibsAndConfig::class,
        ComposerInstall::class,
        RunNpmDev::class,
        MigrateAndSeed::class,
        FixProjectPermissions::class,
        OpenAppInChromeBrowser::class,
    ];
}
