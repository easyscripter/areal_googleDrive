import Vue from 'vue'
import App from './App.vue'
import router from './router'
import CoreuiVue from '@coreui/vue';
import Axios from 'axios';
import { cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft, cilUser, cilCloudDownload, cilSearch} from '@coreui/icons'
import dotenv from 'dotenv'
import GAuth from 'vue-google-oauth2'


const gauthOption = {
  clientId: '699896923042-c9aobk41fmcqea58qfg6uggv002e8aq5.apps.googleusercontent.com',
  scope: 'https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/documents https://www.googleapis.com/auth/spreadsheets https://www.googleapis.com/auth/presentations',
  prompt: 'select_account',
}
Vue.use(GAuth, gauthOption)


Vue.prototype.$http = Axios;
Vue.config.productionTip = false

Vue.use(CoreuiVue);

dotenv.config()

new Vue({
  router,
  icons: {cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft, cilUser, cilCloudDownload, cilSearch},
  render: h => h(App)
}).$mount('#app')
