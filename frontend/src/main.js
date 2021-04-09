import Vue from 'vue'
import App from './App.vue'
import router from './router'
import CoreuiVue from '@coreui/vue';

import { CWrapper, CSidebar, CSidebarNavItem,CSidebarNavTitle, CSidebarNav, CSidebarNavDropdown, CCard, CCardBody, CDataTable, CBreadcrumbRouter, CIcon } from "@coreui/vue";
import { cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft} from '@coreui/icons'
import dotenv from 'dotenv'
import VueSession from 'vue-session'



Vue.config.productionTip = false

Vue.use(CoreuiVue);

Vue.component('CWrapper', CWrapper)
Vue.component('CCard', CCard)
Vue.component('CSidebar', CSidebar)
Vue.component('CSidebarNavItem', CSidebarNavItem)
Vue.component('CSidebarNavTitle', CSidebarNavTitle)
Vue.component('CSidebarNav', CSidebarNav)
Vue.component('CSidebarNavDropdown', CSidebarNavDropdown)
Vue.component('CIcon', CIcon)
Vue.component('CCardBody', CCardBody)
Vue.component('CDataTable', CDataTable)
Vue.component('CBreadcrumbRouter', CBreadcrumbRouter)

dotenv.config()

Vue.use(VueSession)

new Vue({
  router,
  icons: {cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft},
  render: h => h(App)
}).$mount('#app')
