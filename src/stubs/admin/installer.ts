import config from "@admin/config";
import { createApp } from "@shopify/app-bridge";
import { getSessionToken } from "@shopify/app-bridge-utils";
import { Redirect } from "@shopify/app-bridge/actions";

/**
 * AppBridge app instance
 */
export const app = createApp({
    apiKey: config.shopifyApiKey!,
    shopOrigin: config.shopDomain,
    forceRedirect: true,
});

/**
 * Handle AppBridge/OAuth redirects and validation
 */
export async function loadAppBridge(): Promise<void | never> {
    if (window.top == window.self) {
        return handleOutOfFrame();
    }
    // Loaded in the embed frame, ready to get token
    try {
        // Check that token is good
        await getSessionToken(app);
        // Everything is working and ready to go
    } catch (error) {
        // Token is invalid somehow, might need to oauth
        performOauthRedirect();
    }
}
function handleOutOfFrame(): never {
    if (config.oauthAction != 'installed') {
        // Might need to oauth
        performOauthRedirect();
    } else {
        // Out of frame, but OAuth was successful
        // -> wait for app bridge redirect to frame automatically
        // Fallback in case app bridge fails to handle redirect
        setTimeout(performOauthRedirect, 10000);
        throw new Error('Redirecting to embed frame');
    }
}
function performOauthRedirect(): never {

    if (window.top == window.self) {
        window.location.assign(config.oauthUrl);
    } else {
        Redirect.create(app).dispatch(Redirect.Action.REMOTE, config.oauthUrl);
    }
    throw new Error('Redirecting to oauth');
}
