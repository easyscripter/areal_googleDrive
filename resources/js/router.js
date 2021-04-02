import VueRouter from 'vue-router'
import Vue from 'vue'

Vue.use(VueRouter);

import MyDrivePage from './Views/MyDrivePage.vue'

const routes = [
    {
        path: '/dashboard/my-drive',
        component: MyDrivePage
    }
]

export default new VueRouter ({
    mode: "history",
    routes
});
