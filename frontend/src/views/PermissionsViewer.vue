<template>
  <div>
    <CWrapper>

      <CCard bodyWrapper>
        <CCardBody>
          <CInput
              placeholder="Введите email для поиска"
              v-model="email"
          />
          <CButton
              color="primary"
              class="m-2"
              @click="searchFiles()"
          >Поиск</CButton>
          <p class="error_message">{{error}}</p>
          <CDataTable :items="files" :fields="fields">
            <template #Name="{ item }">
              <td>
                <img :src="item.icon" alt="Иконка" />
                <div class="file-name">
                  <a class="file-name__link"
                     v-if="
                    item.type.includes('application/vnd.google-apps') !== true
                  "
                     :href="item.webContentLink"
                     download
                  >{{ item.name }}</a
                  >
                  <a target="_blank" class="file-name__link"
                     v-else-if="item.type !== 'application/vnd.google-apps.folder'"
                     :href="item.webviewLink"
                  >{{ item.name }}</a>
                  <p class="file-name__folder" v-else>{{ item.name }}</p>
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
  name: "PermissionsViewer",
  data() {
    return {
      email: '',
      error: '',
      files: [],
      fields: [
        { key: "Name", label: "Название" },
      ],
    };
  },
  mounted() {

  },
  methods: {
    searchFiles() {
      this.$http
          .get(
              `https://areal-gdrive.com/api/v1/files/permissions/email=${this.email}`
          )
          .then((response) => {
            this.files = response.data.data;
          }).catch((error) => {
            console.log(error);
            this.error = 'Произошла ошибка во время поиска'
      })
    }
  }
}
</script>

<style scoped>

</style>