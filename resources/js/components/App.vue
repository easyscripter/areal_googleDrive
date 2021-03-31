<template>
  <div id="main">
    <CSidebar colorScheme="Dark">
      <CSidebarNav>
        <CSidebarNavTitle>Areal Google Drive</CSidebarNavTitle>
        <CSidebarNavItem active to="/home" icon="cil-home" name="Главная"></CSidebarNavItem>
        <CSidebarNavItem icon="cil-code" name="Логи"></CSidebarNavItem>
        <CSidebarNavItem icon="cil-settings" name="Настройки"></CSidebarNavItem>
        <CSidebarNavItem
          icon="cib-google"
          name="Войти в Google"
        ></CSidebarNavItem>
      </CSidebarNav>
    </CSidebar>
    <CWrapper>
      <router-view></router-view>
    </CWrapper>
  </div>
</template>

<script>
import { CWrapper, CSidebar, CSidebarNavItem, CSidebarNav  } from "@coreui/vue";
export default {
  components: {
    CSidebar,
    CSidebarNavItem, 
    CSidebarNav,
    CWrapper
  },
};
</script>