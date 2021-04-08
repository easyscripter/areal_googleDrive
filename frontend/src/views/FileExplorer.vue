<template>
  <div id="folder-page">
       <CWrapper class="folder-section">
            <CCard bodyWrapper>
                <CCardBody>
                  <CBreadcrumbRouter/>
                    <CDataTable :items="files" :fields="fields">
                        <template #Name="{item}">
                            <td>
                                <img :src="item.icon" alt="Иконка">
                                <a v-if="item.type.includes('application/vnd.google-apps') != true" :href="item.webContentLink" download>{{item.name}}</a>
                                <a v-else-if="item.type !== 'application/vnd.google-apps.folder'" :href="item.webviewLink">{{item.name}}</a>
                                
                                <p @click="goIntoFolder(item.id)" v-else>{{item.name}}</p>
                            </td>
                        </template>
                        <template #ModifiedTime="{item}">
                            <td>
                                {{item.modifiedTime}}
                            </td>
                        </template>
                        <template #Size="{item}">
                            <td>
                                {{item.size}}
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
  props: {
    folderId: {
      type: String,
      default: 'root'
    },
  },
  data() {
    return {
      files: [],
      fields: [
        { key: 'Name', label: 'Название'},
        { key: 'ModifiedTime', label: 'Последние изменения'},
        { key: 'Size', label: 'Размер файла'},
      ]
    };
  },
  mounted() {
    axios
      .get(`https://areal-gdrive.com/api/v1/files/${this.$route.params.folderId}`)
      .then((response) => {
          this.files = response.data.data;
      });
  },
  methods: {
    goIntoFolder(folderId) {
      this.$router.push({name: 'folder', params: {folderId: folderId}})
    }
  },
};
</script>

<style lang="scss">
</style>