<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class SetupJSLibsAndConfig extends StepAlways
{
    const NPM_PACKAGES = [
        '@eastsideco/polaris-vue' => '^0.1.19',
        '@shopify/app-bridge' => '^1.29.0',
        '@shopify/app-bridge-utils' => '^1.29.0',
        '@types/lodash' => '^4.14.168',
        '@types/webpack-env' => '^1.16.0',
        '@typescript-eslint/eslint-plugin' => '^4.24.0',
        '@typescript-eslint/parser' => '^4.24.0',
        'debounce-decorator' => '^1.0.6',
        'eslint' => '^7.26.0',
        'eslint-plugin-ban' => '^1.5.2',
        'eslint-plugin-import' => '^2.23.2',
        'fork-ts-checker-webpack-plugin' => '^6.2.10',
        'popper.js' => '^1.12',
        'postcss' => '^8.2.15',
        'raw-loader' => '^4.0.2',
        'ts-loader' => '^8.0.17',
        'typescript' => '^4.2.4',
        'vue' => '^2.6.12',
        'vue-class-component' => '^7.2.6',
        'vue-loader' => '^15.9.7',
        'vue-property-decorator' => '^9.1.2',
        'vue-router' => '^3.5.1',
        'vue-template-compiler' => '^2.6.12',
    ];

    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Setting up the required JavaScript libraries and configuration files for your app.',
            'JavaScript libraries and Config'
        );

        $this->installWebpackMixFile();
        $this->setupTypescriptDefinitionsFile();
        $this->setupTypescriptShims();
        $this->setupTsConfig();
        $this->setupEsLint();
        $this->installNpmPackages();

        $feedback->advance('✅ Libraries and configuration complete.');

        return $next($feedback);
    }

    private function installWebpackMixFile()
    {
        // Backup the existing webpack.mix.js
        file_put_contents(
            base_path('webpack.mix.js.bak'),
            file_get_contents(base_path('webpack.mix.js'))
        );

        // Create the new webpack.mix.js from stub
        file_put_contents(
            base_path('webpack.mix.js'),
            file_get_contents(__DIR__ . '/../stubs/webpack.mix.stub')
        );
    }

    private function setupTypescriptDefinitionsFile()
    {
        file_put_contents(
            resource_path('js/types.d.ts'),
            "// Type definitions\n\n// Start of ESC Generated Types\n\n// End of ESC Generated Types"
        );
    }

    private function setupTypescriptShims()
    {
        file_put_contents(
            resource_path('js/polaris.shim.d.ts'),
            file_get_contents(__DIR__ . '/../stubs/polaris.shim.d.ts.stub')
        );

        file_put_contents(
            resource_path('js/vue.shim.d.ts'),
            file_get_contents(__DIR__ . '/../stubs/vue.shim.d.ts.stub')
        );
    }

    private function setupTsConfig()
    {
        file_put_contents(
            base_path('tsconfig.json'),
            file_get_contents(__DIR__ . '/../stubs/tsconfig.json.stub')
        );
    }

    private function setupEsLint()
    {
        file_put_contents(
            base_path('.eslintrc.js'),
            file_get_contents(__DIR__ . '/../stubs/.eslintrc.js.stub')
        );
    }

    private function installNpmPackages()
    {
        $packages = self::NPM_PACKAGES;

        array_walk($packages, function (&$version, $package) {
            $version = $package . '@' . $version;
        });

        $commands = array_merge([
            'npm',
            'install',
            '--save-dev',
        ], $packages);

        $output = $this->asyncProcess(
            array_values($commands),
            function ($string) {
                preg_match('/added \d+ packages from \d+ contributors/', $string, $matches);
                return !empty($matches);
            }
        );

        $output = $this->asyncProcess(
            ['npm', 'install'],
            function ($string) {
                preg_match('/added \d+ packages from \d+ contributors/', $string, $matches);
                return !empty($matches);
            }
        );
    }
}
