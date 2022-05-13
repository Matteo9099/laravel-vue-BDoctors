<template>
    <div id="spec-wrap" class="col-12 col-lg-9 px-3 py-4 px-lg-4 py-lg-4">

        <div class="row justify-content-center">
            <!-- SELECT SPECIALIZZAZIONI -->
            <div class="col-12 col-lg-8 mb-2 mb-lg-0">
                <select class="form-select p-2" v-model="selectedSpecialty" >
                    <option  value="tutte le specializzazioni" >Tutti i Dottori - (oppure seleziona una specializzazione dal menu a tendina)</option>
                    <option v-for="specialty in specialtiesList" :key="specialty.id" :value="specialty.slug" > {{specialty.name}} </option>
                </select>
            </div>

            <!-- BUTTON CERCA -->
            <div class="col-12 col-lg-4">
                <router-link  id="advanced-search" class="btn btn-specialty p-2" :to="{name: 'search', params : {slug : selectedSpecialty}}">Cerca</router-link>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    name: "SelectSpecialty",
    props:{
        specialtiesList: Array,
    },
    data() {
        return {
            selectedSpecialty: 'tutte le specializzazioni',
        };
    }

};
</script>

<style scoped lang="scss">
@import '../../sass/home/main.scss';

</style>
