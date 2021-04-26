<template>
  <div id="main-page">
    <CCard bodyWrapper>
      <CRow>
        <CCol md="6">
          <CCard>
            <CCardHeader>
              Экспорт документов Google Drive
            </CCardHeader>
            <CCardBody>
              <CInput
                  label="Имя папки:"
                  placeholder="Укажите папку, в которую будет происходить экспорт"
                  v-model="folderNameToExportDrive"
              />
              <CButton
                  color="info"
                  :size="md"
                  class="m-2"
                  @click="exportToGoogleDrive"
              >
              Экспортировать
              </CButton>
            </CCardBody>
            <CCardFooter>
              <p class="result">{{resultOfExportDrive}}</p>
            </CCardFooter>
          </CCard>
        </CCol>
        <CCol md="6">
          <CCard>
            <CCardHeader>
              Скачать на локальный диск
            </CCardHeader>
            <CCardBody>
              <CInput
                  label="Имя папки:"
                  placeholder="Укажите папку, в которую будет происходить скачивание"
                  v-model="folderNameToDownload"
              />
              <CButton
                  color="info"
                  :size="md"
                  class="m-2"
              >
                Скачать файлы
              </CButton>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CCard>
  </div>
</template>

<script>
export default {
  name: "ExportPage",
  data() {
    return {
      folderNameToExportDrive: '',
      folderNameToDownload: '',
      resultOfExportDrive: '',
      resultOfDownload: ''
    }
  },
  methods: {
    exportToGoogleDrive() {
      this.$http.get(`https://areal-gdrive.com/api/v1/export/${this.folderNameToExportDrive}`)
      .then((response) => this.resultOfExportDrive = response.data)
      .catch((error) => {
        this.resultOfExportDrive = 'Файлы были экспортированы неудачно!';
        console.log(error);
      })
    }
  }
}
</script>

<style lang="scss" scoped>
</style>