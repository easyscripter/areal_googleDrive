import Vue from 'vue'
import VueRouter from 'vue-router'
import MyDrivePage from '../views/MyDrivePage.vue'
import FileExplorer from '../views/FileExplorer.vue'
import CommonDrivesPage from '../views/CommonDrivesPage.vue'


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
      // children: [
      //   {
      //     path:'folder/:folderId',
      //     name: 'folder',
      //     component: FileExplorer,
      //     props: true
      //   }
      // ]
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
