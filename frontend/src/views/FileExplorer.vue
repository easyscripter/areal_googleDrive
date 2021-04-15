<template>
  <div>
    <CWrapper class="folder-explorer__section">
      <CCard bodyWrapper>
        <CCardBody>
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
                  >{{ item.name }}</a
                  >
                  <p class="file-name__folder" @click="goIntoFolder(item.id)" v-else>{{ item.name }}</p>
                </div>

              </td>
            </template>
            <template #ModifiedTime="{ item }">
              <td>
                {{ item.modifiedTime.toString() }}
              </td>
            </template>
            <template #Size="{ item }">
              <td>
                {{ (item.size / (1034*1024)).toFixed(2) || '-' }} MB
              </td>
            </template>
          </CDataTable>
          <CButton @click="goPrevFolder" color="primary" class="m-2"
            ><CIcon name="cil-arrow-left"
          /></CButton>
        </CCardBody>
      </CCard>
    </CWrapper>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: {
    folderId: {
      type: String,
      default: "root",
    },
  },
  data() {
    return {
      files: [],
      fields: [
        { key: "Name", label: "Название" },
        { key: "ModifiedTime", label: "Последние изменения" },
        { key: "Size", label: "Размер файла" },
      ],
    };
  },
  mounted() {
    axios
      .get(
        `https://areal-gdrive.com/api/v1/files/${this.folderId}`
      )
      .then((response) => {
        this.files = response.data.data;
      });
  },
  methods: {
    goIntoFolder(folderId) {
      this.$router.push({ name: "folder", params: { folderId: folderId } });
    },
    goPrevFolder() {
      this.$router.go(-1);
    },
  },
};
</script>

<style lang="scss">
  img {
    width: 25px;
    height: 25px;
  }
.file-name {
  display: inline-block;
  &__link {
    margin-left: 10px;
    text-decoration: none;
    color: #444444;
    &:hover {
      text-decoration: none;
      color: #6e6e6e;
    }
  }

  &__folder {
    margin-left: 10px;
    cursor: pointer;
    &:hover {
      color: #6e6e6e;
    }
  }
}
</style>