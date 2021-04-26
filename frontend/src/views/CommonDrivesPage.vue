<template>
  <div id="common-disks__page">
       <CWrapper class="folder-section">
            <CCard bodyWrapper>
                <CCardBody>
                  <CBreadcrumbRouter/>
                    <CDataTable :items="disks" :fields="fields">
                        <template #DiskName="{item}">
                            <td>
                                <div @click="goToDisk(item.id)" class="drive">
                                  <CIcon size="lg" name="cil-storage"></CIcon>
                                  <p class="drive__name">
                                    {{item.name}}
                                  </p>
                                </div>
                            </td>
                        </template>
                    </CDataTable>
                 </CCardBody>
            </CCard>
        </CWrapper>
  </div>
</template>

<script>
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
    this.$http
      .get(`https://areal-gdrive.com/api/v1/sharedDrives`)
      .then((response) => {
          this.disks = response.data;
      });
  },
  methods: {
    goToDisk(folderId) {
      this.$router.push({ name: "commonFolder", params: { folderId: folderId } });
    }
  }
};
</script>

<style lang="scss">
.drive {
  display: flex;
  font-size: 16px;
  align-items: center;
  cursor: pointer;
  &__name {
    margin-left: 10px;
    margin-bottom: 0;
  }
}
</style>