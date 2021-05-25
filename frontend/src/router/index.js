import Vue from 'vue'
import VueRouter from 'vue-router'
import MyDrivePage from '../views/MyDrivePage.vue'
import FileExplorer from '../views/FileExplorer.vue'
import CommonDrivesPage from '../views/CommonDrivesPage.vue'
import ExportPage from "../views/ExportPage";
import PermissionsViewer from "../views/PermissionsViewer";


Vue.use(VueRouter)

const routes = [
    {
      path: '/my-drive',
      component: MyDrivePage,
      children: [
        {
          path:'folder/:folderId',
          name: 'folder',
          component: FileExplorer,
          props: true
        }
      ]
    },
    {
      path: '/common-drives',
      component: CommonDrivesPage,
    },
    {
      path: '/common-drives/folder/:folderId',
      component: FileExplorer,
      name: 'commonFolder',
      props:true
    },
    {
        path: '/export',
        component: ExportPage,
        name: 'ExportPage',
    },
    {
        path: '/search-files-with-permissions',
        component: PermissionsViewer,
        name: 'SearchFiles',
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
