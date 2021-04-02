<template>
  <div id="main-page">
       <CWrapper class="main-section">
            <CCard bodyWrapper>
                <ul>
                    <li v-for="file in files" :key="file.id">
                        <img :src="file.icon" alt="Иконка">
                        <p>{{file.name}}</p> 
                        <p>{{file.parentId}}</p>
                        <p>{{file.type}}</p>
                    </li>
                </ul>
            </CCard>
        </CWrapper>
  </div>
</template>

<script>
import { CButton, CContainer, CRow, CCol, CNav, CNavItem, CHeader, CWrapper, CCard  } from '@coreui/vue';
import axios from 'axios';
export default {
    components: {
        CButton,
        CContainer, 
        CRow, 
        CCol,
        CNav,
        CNavItem,
        CHeader,
        CWrapper,
        CCard
    },
    data() {
        return {
            files: []
        }
    },
    mounted() {
        axios.get('/api/v1/drives/files').then((response) => {
            this.files = response.data.data;
        });
    }
}
</script>

<style lang="scss">

</style>