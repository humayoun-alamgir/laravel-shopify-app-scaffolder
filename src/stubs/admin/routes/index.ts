import VueRouter, { RawLocation } from 'vue-router';
import config from '@admin/config';
import { History, Redirect } from '@shopify/app-bridge/actions';
import { app } from '@/admin/installer';

import Demo from './Demo.vue';

export const router = new VueRouter({
    base: '/app/',
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Demo',
            component: Demo,
        },
    ],
});

router.beforeEach((to, from, next) => {
    to.query.shop = config.shopDomain;
    next();
});

router.afterEach((to, from) => {
    if (!app) { return; }
    const history = History.create(app);
    let path = router.resolve(to as RawLocation).href;
    if (to.name != 'Home') {
        history.dispatch(History.Action.PUSH, path);
        return;
    }
    const homeShimRoute: RawLocation = {
        ...to,
        name: 'HomeRedirect',
    };
    path = router.resolve(homeShimRoute).href;
    history.dispatch(History.Action.PUSH, path);
});
