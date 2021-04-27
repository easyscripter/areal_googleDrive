import Vue from 'vue'
import App from './App.vue'
import router from './router'
import CoreuiVue from '@coreui/vue';
import Axios from 'axios';
import { cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft, cilUser, cilCloudDownload} from '@coreui/icons'
import dotenv from 'dotenv'
import GAuth from 'vue-google-oauth2'


const gauthOption = {
  clientId: '744887238689-i3p531fodl1jjeknp61h738pq9juqbpk.apps.googleusercontent.com',
  scope: 'profile email',
  prompt: 'select_account',
}
Vue.use(GAuth, gauthOption)


Vue.prototype.$http = Axios;
Vue.config.productionTip = false

Vue.use(CoreuiVue);

dotenv.config()

new Vue({
  router,
  icons: {cilCode, cilHome, cibGoogle, cilSettings, cilStorage, cilArrowLeft, cilUser, cilCloudDownload},
  render: h => h(App)
}).$mount('#app')
