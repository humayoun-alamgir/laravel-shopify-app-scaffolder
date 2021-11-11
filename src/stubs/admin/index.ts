import Vue from 'vue';
import VueRouter from 'vue-router';
import PolarisVue from '@eastsideco/polaris-vue';
import '@eastsideco/polaris-vue/lib/polaris-vue.css';
import { router } from './routes';
import { loadAppBridge } from './installer';

import App from '@admin/App.vue';
Vue.component('App', App);

Vue.use(VueRouter);
Vue.use(PolarisVue);

async function init() {
    // Load AppBridge
    try {
        await loadAppBridge();
    } catch (e) {
        console.warn(`AppBridge didn't load: ${e.message}`, e);
        return;
    }

    // Setup app
    new Vue({
        router,
        el: '#app',
        render: (h) => h(App),
    });
}
init();


