<template>
  <div id="app">
    <CSidebar colorScheme="Dark">
      <CSidebarNav>
        <CSidebarNavTitle
          ><a class="nav-title" href="/"
            >Areal Google Drive</a
          ></CSidebarNavTitle
        >
        <CSidebarNavDropdown icon="cil-storage" name="Диски">
          <CSidebarNavItem
            to="/my-drive/folder/root"
            name="Мой диск"
          ></CSidebarNavItem>
          <CSidebarNavItem
            to="/common-drives"
            name="Общие диски"
          ></CSidebarNavItem>
        </CSidebarNavDropdown>
        <CSidebarNavItem
          to="/export"
          icon="cil-cloud-download"
          name="Экспорт"
        ></CSidebarNavItem>
        <CSidebarNavItem icon="cil-code" name="Логи"></CSidebarNavItem>
   <!--     <CSidebarNavItem
          @click="auth('google')"
          icon="cib-google"
          name="Войти в Google"
          v-if="!user_data.hasOwnProperty('name')"
        ></CSidebarNavItem>-->
        <CButton color="primary" @click="auth('google')">Войти в Google</CButton>
    <!--<CSidebarNavDropdown v-else icon="cil-user" name="Аккаунт">
         <CSidebarNavItem>
            <a class="c-sidebar-nav-link">
              <img :src="user_data.avatar" alt="Аватар" srcset="" />
              <p>Привет, {{ user_data.name }}</p>
            </a>
          </CSidebarNavItem>
          <CSidebarNavItem href="/user/logout" name="Выход"></CSidebarNavItem>
        </CSidebarNavDropdown>-->
      </CSidebarNav>
    </CSidebar>
    <CWrapper>
      <router-view :key="$route.fullPath"></router-view>
    </CWrapper>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user_data: {},
    };
  },
  mounted() {
    this.$http.get("https://areal-gdrive.com/api/v1/user").then(
      (response) =>
        (this.user_data = {
          name: response.data.name,
          email: response.data.email,
          avatar: response.data.avatar,
        })
    );
  },
  methods: {
    auth(network) {
      const hello = this.hello;
      hello(network)
        .login()
        .then(
          () => {
            const authRes = hello(network).getAuthResponse();
            this.$http
              .get("api/v1/google-login", {
                params: {
                  access_token: authRes.access_token,
                  provider: network,
                },
              })
              .then((response) => console.log(response.data))
              .catch((error) => console.log(error));
          },
          (e) => {
            console.log(e);
          }
        );
    },
  },
};
</script>
<style lang="scss">
@import "~@coreui/coreui/scss/coreui";
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap");

body {
  font-family: "Roboto", sans-serif;
}
.nav-title {
  color: #ffffff;
  &:hover {
    color: #ffffff;
    text-decoration: none;
  }
}
.c-sidebar-nav-link {
  p {
    margin-left: 1rem;
    margin-right: 0.8rem;
    margin-top: calc(25px / 2);
  }
}
</style>
