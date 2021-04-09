<template>
  <div id="main-page">
       <CWrapper class="main-section">
            <CHeader></CHeader>
            <router-view></router-view>
        </CWrapper>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
    };
  }
};
</script>

<style lang="scss">
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');
  .main-section {
      font-family: 'Roboto', sans-serif;
  }
  p {
    display: inline-block;
  }
</style>