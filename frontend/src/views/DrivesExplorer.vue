<template>
  <div>
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
import axios from "axios";

export default {
  name: "DrivesExplorer",
  data() {
    return {
      disks: [],
      fields: [
        { key: 'DiskName', label: 'Имя Диска'},
      ]
    };
  },
  mounted() {
    axios
        .get(`https://areal-gdrive.com/api/v1/sharedDrives`)
        .then((response) => {
          this.disks = response.data;
        });
  },
  methods: {
    goToDisk(folderId) {
      this.$router.push({ name: "commonDrivesFolder", params: { folderId: folderId } });
    }
  }
}
</script>

<style scoped>

</style>