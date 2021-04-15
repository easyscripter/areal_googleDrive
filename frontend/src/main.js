import Vue from 'vue'
import App from './App.vue'
import router from './router'
import CoreuiVue from '@coreui/vue';

import { CWrapper, CSidebar, CSidebarNavItem,CSidebarNavTitle, CSidebarNav, CSidebarNavDropdown, CCard, CCardBody, CDataTable, CBreadcrumbRouter, CIcon, CSidebarNavLInk } from "@coreui/vue";
import { cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft, cilSmile} from '@coreui/icons'
import dotenv from 'dotenv'
const HelloJs = require('hellojs/dist/hello.all.min.js');
const VueHello = require('vue-hellojs');


Vue.config.productionTip = false

Vue.use(CoreuiVue);

Vue.component('CWrapper', CWrapper)
Vue.component('CCard', CCard)
Vue.component('CSidebar', CSidebar)
Vue.component('CSidebarNavItem', CSidebarNavItem)
Vue.component('CSidebarNavTitle', CSidebarNavTitle)
Vue.component('CSidebarNav', CSidebarNav)
Vue.component('CSidebarNavDropdown', CSidebarNavDropdown)
Vue.component('CSidebarNavLInk', CSidebarNavLInk)
Vue.component('CIcon', CIcon)
Vue.component('CCardBody', CCardBody)
Vue.component('CDataTable', CDataTable)
Vue.component('CBreadcrumbRouter', CBreadcrumbRouter)

dotenv.config()

HelloJs.init({
  google: '744887238689-i3p531fodl1jjeknp61h738pq9juqbpk.apps.googleusercontent.com'
}, {
  redirect_uri: '/login/google/callback'
});
Vue.use(VueHello, HelloJs);

new Vue({
  router,
  icons: {cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft, cilSmile},
  render: h => h(App)
}).$mount('#app')
