<template>
  <div id="app">
    <CSidebar colorScheme="Dark">
      <CSidebarNav>
        <CSidebarNavTitle><a class="nav-title" href="/">Areal Google Drive</a></CSidebarNavTitle>
        <CSidebarNavDropdown icon="cil-storage" name="Диски">
            <CSidebarNavItem to="/my-drive" name="Мой диск"></CSidebarNavItem>
            <CSidebarNavItem name="Общие диски"></CSidebarNavItem>
        </CSidebarNavDropdown>
        <CSidebarNavItem icon="cil-code" name="Логи"></CSidebarNavItem>
        <CSidebarNavItem icon="cil-settings" name="Настройки"></CSidebarNavItem>
        <CSidebarNavItem href="https://areal-gdrive.com/login/google"
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
import axios from 'axios';
export default {
  components: {
  },
  mounted() {
    axios.get('')
  },
};
</script>
<style lang="scss">
@import "~@coreui/coreui/scss/coreui";
.nav-title {
  color: #ffffff;
  &:hover {
    color: #ffffff;
    text-decoration: none;
  }
}
</style>
