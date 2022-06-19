<template>
  <div id="search-select-specialty">

      <div class="ms_new-specialty-search mb-2">Nuova ricerca per specializzazione</div>

      <div class="d-flex flex-lg-row flex-column align-items-center">
          <!-- SELECT SPECIALIZZAZIONI -->
          <div class="ms_select-spec col-12 col-lg-8 pe-lg-2 mb-2 mb-lg-0">
              <select class="form-select" v-model="selectedSpecialty" >
                  <option value="tutte le specializzazioni">Tutte le specializzazioni</option>
                  <option v-for="specialty in specialtiesList" :key="specialty.id" :value="specialty.slug" > {{specialty.name}} </option>
              </select>
          </div>

          <!-- BUTTON CERCA -->
          <div id="btn-cerca" class="col-12 col-lg-4">
              <router-link id="btn-search" class="text-white btn btn-primary" :to="{name: 'search', params : {slug : selectedSpecialty}}">Cerca</router-link>
          </div>

      </div>
  </div>
</template>

<script>
export default {
    name: "SearchSelectSpecialty.vue",
    /*
    props:{
        specialtiesList: Array,
    },
    */

    props:{
        specialtiesList: Array,
    },
    data() {
        return {
            selectedSpecialty: '',
        };
    },
    mounted() {

        this.selectedSpecialty = this.$route.params.slug
    }

};
</script>

<style lang="scss" scoped >
  @import '../../sass/search/searchmain.scss';
</style>
