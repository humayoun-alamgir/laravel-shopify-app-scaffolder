# Laravel / Vue / Typescript Shopify App Scaffolder

Quick-starting shopify app development in Laravel. Using Vue JS and Typescript.

## Installation

```bash
composer require --dev humayoun-alamgir/laravel-shopify-app-scaffolder
```

## Before Usage

### Shopify Partner ID
One step will attempt to open a Chrome browser tab directly to Shopify Partners for you.

To enable it to do so, please add your Shopify Partner id into you project's `.env` file:
```bash
# For example
SHOPIFY_PARTNERS_ID=12345
```

you should also login to your partners account before running this command in order for it to oprn the correct page for you.

### Setup your local Nginx configuration
Set up your local nginx configuration for the app you are building, so that it is available at a valid local URL.

You will also need a self-signed SSL certificate. This is a stipulation of Shopify and their Apps.

```bash
# Examples coming soon
```

## Usage

Run the following command and follow the directions.

```bash
php artisan shopify:scaffold
```
