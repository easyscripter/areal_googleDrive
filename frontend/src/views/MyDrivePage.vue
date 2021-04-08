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
  p {
    display: inline-block;
  }
</style>