<template>
  <div id="main">
    <CSidebar colorScheme="Dark">
      <CSidebarNav>
        <CSidebarNavTitle>Areal Google Drive</CSidebarNavTitle>
        <CSidebarNavDropdown icon="cil-storage" name="Диски">
            <CSidebarNavItem to="/dashboard/my-drive" name="Мой диск"></CSidebarNavItem>
            <CSidebarNavItem name="Общие диски"></CSidebarNavItem>
        </CSidebarNavDropdown>
        <CSidebarNavItem icon="cil-code" name="Логи"></CSidebarNavItem>
        <CSidebarNavItem icon="cil-settings" name="Настройки"></CSidebarNavItem>
        <CSidebarNavItem href="/login/google"
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
import { CWrapper, CSidebar, CSidebarNavItem, CSidebarNav, CSidebarNavDropdown  } from "@coreui/vue";
export default {
  components: {
    CSidebar,
    CSidebarNavItem, 
    CSidebarNav,
    CWrapper,
    CSidebarNavDropdown
  },
};
</script>