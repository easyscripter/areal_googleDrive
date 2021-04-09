<template>
  <div id="common-disks__page">
       <CWrapper class="folder-section">
            <CCard bodyWrapper>
                <CCardBody>
                  <CBreadcrumbRouter/>
                    <CDataTable :items="disks" :fields="fields">
                        <template #DiskName="{item}">
                            <td>
                                {{item.name}}
                            </td>
                        </template>
                 </CCardBody>
            </CCard>
        </CWrapper>
  </div>
</template>

<script>
// import axios from "axios";
export default {
  data() {
    return {
      disks: [],
      fields: [
        { key: 'DiskName', label: 'Имя Диска'},
      ]
    };
  },
  mounted() {
    // axios
    //   .get(`https://areal-gdrive.com/api/v1/files/${this.$route.params.folderId}`)
    //   .then((response) => {
    //       this.files = response.data.data;
    //   });
  },
};
</script>

<style lang="scss">
</style>