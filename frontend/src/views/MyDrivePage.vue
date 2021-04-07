<template>
  <div id="main-page">
       <CWrapper class="main-section">
            <CCard bodyWrapper>
                <CCardBody>
                    <CDataTable :items="files" :fields="fields">
                        <template #Name="{item}">
                            <td>
                                <img :src="item.icon" alt="Иконка">
                                {{item.name}}
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
            </CCard>
        </CWrapper>
  </div>
</template>

<script>
import axios from "axios";
export default {
  components: {},
  data() {
    return {
      files: [],
      fields: ['Name', 'ModifiedTime', 'Size']
    };
  },
  mounted() {
    axios
      .get(`https://areal-gdrive.com/api/v1/files/0AMyvxxX7olLcUk9PVA`)
      .then((response) => {
          this.files = response.data.data;
      });
  },
};
</script>

<style lang="scss">
</style>