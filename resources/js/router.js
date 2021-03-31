import VueRouter from 'vue-router'
import Vue from 'vue'

Vue.use(VueRouter);

import MainPage from './Views/MainPage.vue'

const routes = [
    {
        path: '/home',
        component: MainPage
    }
]

export default new VueRouter ({
    mode: "history",
    routes
});
