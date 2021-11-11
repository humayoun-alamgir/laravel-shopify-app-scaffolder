import storage from 'local-storage-fallback';
const urlParams = new URLSearchParams(window.location.search);
let shopDomain: string = urlParams.get('shop')!;
const oauthAction: string = urlParams.get('oauth_action')!;

if(shopDomain) {
    storage.setItem('app_shop_domain', shopDomain);
} else {
    shopDomain = storage.getItem('app_shop_domain') || '';
}

let appBaseUrl = process.env.MIX_APP_BASE_URL;

export default {
    debug:  process.env.NODE_ENV == 'development',
    shopifyApiKey: process.env.MIX_SHOPIFY_API_KEY,
    authMethod: process.env.MIX_SHOPIFY_AUTH_METHOD || 'session',
    baseUrl: appBaseUrl,
    api: {
        url: process.env.MIX_ADMIN_API_URL,
        timeout: 30000,
    },
    shopDomain: shopDomain,
    oauthAction: oauthAction,
    oauthUrl: `${appBaseUrl}/oauth?shop=${shopDomain}`,
};
