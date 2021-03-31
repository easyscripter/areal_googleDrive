<template>
  <div id="main-page">
       <CWrapper class="main-section">
            <CHeader>
                <CNav>
                    <CNavItem @click="showDisks = true" >Обзор</CNavItem>
                    <CNavItem @click="showExportCard = true">Экспорт документов</CNavItem>
                </CNav>
            </CHeader>
            <CCard v-show="showDisks" bodyWrapper>
                Content is rendered inside CCardBody component.
            </CCard>
            <CCard v-show="showExportCard" bodyWrapper>
                Content is rendered inside CCardBody component.
            </CCard>
        </CWrapper>
  </div>
</template>

<script>
import { CButton, CContainer, CRow, CCol, CNav, CNavItem, CHeader, CWrapper, CCard  } from '@coreui/vue';

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
            showDisks: true,
            showExportCard: false
        }
    },
}
</script>

<style lang="scss">

</style>