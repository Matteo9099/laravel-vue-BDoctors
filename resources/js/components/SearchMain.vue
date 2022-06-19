<template>
    <main>

      <!-- NUOVA STRUTTURA -->
      <div id="ms_max-width" class="">
        <div class="p-1 row d-flex ms_search-res">

          <!-- COLONNA SX RICERCA E FILTRI -->
          <div class="col-filtro col-12 col-md-3 col-xl-2">
              
            <!-- RICERCA MEDICO PER NOME -->
            <div id="name-search" class="col-12 p-rows">
                <div class="row">

                    <div class="name-field">
                        <input type="text" class="form-control" placeholder="Scrivi un medico da cercare" v-model="ricerca" >
                    </div>
                    
                </div>
            </div>

            <!-- SELECT SCEGLI UNA SPECIALIZZAZIONE -->
            <div id="specialty-select" class="p-rows">
                <SearchSelectSpecialty :specialtiesList="specialtiesList"></SearchSelectSpecialty>
              <!-- <SelectSpecialty :specialtiesList="specialtiesList" class="mt-4"/> -->
            </div>

            <div id="filtri-select" class="p-rows">

                <div class="navbar navbar-expand-md navbar-light">


                  <!-- DIV CLICCABILE PER ATTIVARE MENU -->
                  <div id="ms_filter-toggler" class="pt-3 pb-3 navbar-toggler" data-bs-toggle="collapse" data-bs-target="#filter-menu-collapse" aria-controls="filter-menu-collapse" aria-expanded="false" aria-label="Toggle navigation">
                      <div class="d-flex align-items-center justify-content-end">Filtra la ricerca <i class="fa-solid fa-angle-down"></i></div>
                  </div>

                  <!-- INIZIO MENU COLLAPSE -->
                  <div class="collapse navbar-collapse flex-column pt-3" id="filter-menu-collapse">

                      <div class="filter-header w-100">
                        <h3>Filtra per:</h3>
                      </div>

                      <!-- MEDIA VOTI RECENSIONI -->
                      <div id="rating-stars-wrap">

                        <div class="rating-title">Media voto</div>
                        <ul class="d-flex flex-wrap">

                          <!-- FILTRI DA 1 A 4 STELLE -->
                          <li v-for="i in 4" :key="i">
                            <div class="form-check">

                                <input v-model="checkedReview" class="form-check-input" type="checkbox" :value="i" :id="'star-' + i">
                                <label class="form-check-label" :for="'star-' + i">
                                    <span class="rating-stars"> {{i}}+ <i class="fa-solid fa-star"></i></span>
                                </label>

                            </div>
                          </li>

                          <!-- FILTRO 5 STELLE -->
                          <li>
                              <div class="form-check">
                                  <input v-model="checkedReview" class="form-check-input" type="checkbox" value="5" id="star-5" >
                                  <label class="form-check-label" for="star-5">
                                      <span class="rating-stars">5 <i class="fa-solid fa-star"></i></span>
                                  </label>
                              </div>
                          </li>

                        </ul>

                      </div>
                      <!-- FINE MEDIA VOTI RECENSIONI -->

                      <!-- INIZIO NUMERO RANGE RECENSIONI -->
                      <div id="range-reviews-wrap">

                        <div class="reviews-range-title">Numero recensioni</div>

                        <ul class="d-flex flex-row flex-md-column">

                            <!-- RECENSIONI RANGE 5 -->
                            <li>
                                <div class="form-check">
                                    <input v-model="checkedNumberReview" class="form-check-input" type="checkbox" value="0" id="review-5">
                                    <label class="form-check-label" for="review-5">
                                        <span class="rating-stars">meno di 5</span>
                                    </label>
                                </div>
                            </li>

                            <!-- RECENSIONI RANGE 5-10  -->
                            <li>
                                <div class="form-check">
                                    <input v-model="checkedNumberReview" class="form-check-input" type="checkbox" value="5" id="review-5_10">
                                    <label class="form-check-label" for="review-5_10">
                                        <span class="rating-stars">tra 5 e 10</span>
                                    </label>
                                </div>
                            </li>

                            <!-- RECENSIONI RANGE >10  -->
                            <li>
                                <div class="form-check">
                                    <input v-model="checkedNumberReview" class="form-check-input" type="checkbox" value="10" id="review-10">
                                    <label class="form-check-label" for="review-10">
                                        <span class="rating-stars">più di 10</span>
                                    </label>
                                </div>
                            </li>

                        </ul>

                      </div>
                      <!-- FINE NUMERO RANGE RECENSIONI -->

                  </div>
                  <!-- FINE MENU COLLAPSE -->
                
                </div>

            </div>

          </div>

          <!-- COLONNA DX RISULTATI DOTTORI -->
          <div class="mt-5 mt-md-0 px-sm-2 px-md-3 px-xl-5 col-dottori col-12 col-md-9 col-xl-10">
            
              <div class="row">

                <div class="col my-3">
                    <p>Risultati per <span class="text-capitalize text-success">{{ $route.params.slug }}</span></p>
                    <p v-if="notFound" class="text-danger">Nessun dottore trovato</p>

                    <div class="d-flex justify-content-center gap-3" v-if="loading">
                      <h2 class="text-center"> Caricamento in corso</h2>
                      <div class="spinner-border" role="status"></div>
                    </div>
                </div>

              </div>

              <!--
              <div class="row">
                  <div class="col my-3">
                        <h2 v-if="$route.params.slug">Ecco tutti i dottori specializzati in <span class="text-capitalize text-danger">{{ $route.params.slug }}</span></h2>
                      
                  </div>
              </div>
              -->

              <!-- CARD CONTAINER -->
              <div id="card-doc-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 gy-5">

                  <!-- CARD 1 -->
                  <div class="col animate__animated animate__fadeInUp" v-for="doctor in filteredDoctors" :key="doctor.id">
                      <div class="ms_card card h-100">

                          <!-- IMMAGINE DOTTORE -->
                          <div class="img-card-wrap">
                            <img :src="doctor.photo" class="card-img-top img-thumbnail">
                          </div>

                          <div class="card-body">
                            <!-- NOME E COGNOME -->
                            <h5 class="card-title">
                                {{doctor.user.name}} {{doctor.user.surname}}
                            </h5>
                            <ul class="spec-list">
                                <!-- SPECIALTIES -->
                                <li v-for="(specName, index) in doctor.specialties" :key="index">
                                    {{specName.name}}
                                </li>
                            </ul>
                            <!-- INDIRIZZO -->
                            <p class="card-text">{{doctor.medical_address}}</p>

                            <!-- LINK PROFILO DOTTORE -->
                            <router-link class="btn btn-primary text-white" :to="'/doctors/' + doctor.slug">Vai al profilo</router-link>
                          </div>
                      </div>
                  </div>
                  <!-- FINE CARD 1 -->

              </div>

          </div>

        </div>
      </div>
      <!-- FINE NUOVA STRUTTURA -->

    </main>
</template>

<script>

import 'animate.css';
import SearchSelectSpecialty from "../components/SearchSelectSpecialty";

export default {
    name: 'SearchMain',
    components: { SearchSelectSpecialty },

    data() {
        return {
            doctors: [],
            ricerca: '',
            specialtiesList: [],
            checkedReview : [],
            checkedNumberReview:[],
            notFound: false,
            loading: false,
        }
    },

    methods: {

        getDoctors() {

            axios.get("/api/docs" )
                .then((response) => {
                    this.loading = false;
                    if(response.data.success == false ){
                        // this.notFound = true;
                    } else {
                        // this.notFound = false;
                        this.doctors = response.data.results;
                    }
                })
                .catch(function(error) {
                    // handle error
                })
                .then(function() {
                    // always executed
                });

        },

        //ottengo tutte le specializzazioni
        getSpecialties() {

            axios.get("/api")
                .then((response) => {

                    this.specialtiesList = response.data.results;

                })
                .catch(function(error) {
                    // handle error
                })
                .then(function() {
                    // always executed
                });

        },
        // filtro dottori
        doctorsFilter(){
           this.doctors = [];
            this.loading = true;
           this.checkedReview.forEach( check =>{
               const params = {
                   average : check,
                   rangeMin : this.rangeMin,
               }
               axios.get('/api/filter', {params}).then( res => {
                   /*this.doctors = res.data.results;
                   console.log(this.doctors);*/
                   this.loading = false;
                   console.log(res.data.success)
                   if(res.data.success == false){
                       // this.notFound = true;
                   } else{
                       // this.notFound = false;
                       res.data.results.forEach( doctor => {
                           if(!this.doctors.some( doc => doc.id === doctor.id)){
                               this.doctors.push(doctor);
                           }
                       })
                   }
               })
           })
            /*if(this.filteredDoctors.length == 0){
                this.notFound = true;
            } else {
                this.notFound = false;
            }*/
        },
        doctorsNumberFilter(){
            this.doctors = [];
            this.loading = true;
            this.checkedNumberReview.forEach( numb => {
                const params = {
                    average : this.average,
                    rangeMin: parseInt(numb),
                }
                axios.get('/api/filter', {params}).then( res => {
                    this.loading = false;
                    if(res.data.success == false){
                        // this.notFound = true;
                    } else {
                        // this.notFound = false;
                        console.log(res.data.results);
                        res.data.results.forEach( doctor => {
                            if(!this.doctors.some( doc => doc.id == doctor.id)){
                                this.doctors.push(doctor);
                            }
                        })
                    }
                })
            })
        },
        filterDoctors() {
            this.doctors = [];
            // selezionati entrambi
            this.loading = true;
            if(this.checkedReview.length > 0 && this.checkedNumberReview.length > 0 ){
                const paramsArrObj = [];
                if(this.checkedReview.length > this.checkedNumberReview.length){
                    this.checkedReview.forEach( (check, index) => {
                        let averageSet = check;
                        let rangeMinSet = this.checkedNumberReview[index];
                        if( rangeMinSet == undefined){
                            rangeMinSet = this.checkedNumberReview[index - index];
                        }
                        let paramsObj = {
                            average : averageSet,
                            rangeMin : rangeMinSet,
                        }
                        paramsArrObj.push(paramsObj);
                        if(paramsArrObj.length > 1){
                            const reversed = [...paramsArrObj].reverse();
                            paramsArrObj.forEach( (res, index) =>{
                                let crossedParams = {
                                    average : res.average,
                                    rangeMin: reversed[index].rangeMin,
                                }
                                paramsArrObj.push(crossedParams);
                            })
                        }
                        console.log(paramsArrObj);
                        paramsArrObj.forEach( objParams => {
                            const params = {
                                average : objParams.average,
                                rangeMin : objParams.rangeMin,
                            }
                            axios.get('/api/filter', {params}).then( res =>{
                                this.loading = false;
                                if(res.data.success == true){
                                    // console.log(res.data.results);
                                    // this.notFound = false;
                                    res.data.results.forEach( doctor =>{
                                        if(!this.doctors.some( doc => doc.id == doctor.id)){
                                            this.doctors.push(doctor);
                                        }
                                    })
                                } else {
                                    // this.notFound = true;
                                }
                            })
                        })
                    });
                } else {
                    this.checkedNumberReview.forEach( (check, index) => {
                        let rangeMinSet = check;
                        let averageSet = this.checkedReview[index];
                        if( averageSet == undefined){
                            averageSet = this.checkedReview[index - index];
                        }
                        let paramsObj = {
                            average : averageSet,
                            rangeMin : rangeMinSet,
                        }
                        paramsArrObj.push(paramsObj);
                        // se maggiore di 1
                        if(paramsArrObj.length > 1){
                            const reversed = [...paramsArrObj].reverse();
                            paramsArrObj.forEach( (res, index) =>{
                                let crossedParams = {
                                    average : reversed[index].average,
                                    rangeMin: res.rangeMin,
                                }
                                paramsArrObj.push(crossedParams);
                            })
                        }
                        console.log(paramsArrObj);
                        paramsArrObj.forEach( objParams => {
                            const params = {
                                average : objParams.average,
                                rangeMin : objParams.rangeMin,
                            }
                            axios.get('/api/filter', {params}).then( res =>{
                                this.loading = false;
                                if(res.data.success == true){
                                    // this.notFound = false;
                                    res.data.results.forEach( doctor =>{
                                        // console.log(res.data.results);
                                        if(!this.doctors.some( doc => doc.id == doctor.id)){
                                            this.doctors.push(doctor);
                                        }
                                    })
                                } else {
                                    // this.notFound = true;
                                }
                            })
                        })
                    });
                }
            } else if (this.checkedReview.length > 0 && this.checkedNumberReview.length == 0){
                // selezionato solo media voto
                this.doctors = [];
                //funcione per solo media
                this.doctorsFilter();
            } else if (this.checkedReview.length == 0 && this.checkedNumberReview.length > 0){
                //selezionato solo numero recensioni
                this.doctors = [];
                // funzione per solo numer rec
                this.doctorsNumberFilter();

            } else {
                this.doctor =[];
                this.getDoctors();
            }
        },
        setEmpty(){
            // console.log('vuoto');
            setTimeout(()=>{
                if(this.filteredDoctors.length == 0){
                    console.log('vuoto');
                    this.notFound = true;
                } else{
                    this.notFound = false;
                }
            }, 500)
        }
    },

    mounted() {
        this.getDoctors();
        this.getSpecialties();
    },
    computed:{
        filteredDoctors: function(){
            return this.doctors.filter(doc =>{
                let query = this.ricerca.toLowerCase().replaceAll(' ', "");
                if(this.$route.params.slug != 'tutte le specializzazioni'){
                    return !!doc.specialties.some(specialty => specialty.slug == this.$route.params.slug && doc.slug.replaceAll("-", '').includes(query));
                } else{
                    return doc.slug.replaceAll("-", '').includes(query);
                }
            })
        },
    },
    watch:{
        checkedReview: {
            immediate: true,
            handler: 'filterDoctors',
        },
        checkedNumberReview: {
            immediate: true,
            handler: 'filterDoctors',
        },
        filteredDoctors: {
            immediate: true,
            handler : 'setEmpty'
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../sass/home/main.scss';
@import '../../sass/search/searchmain.scss';

/*
.filter-item {
    width: 50%;

    p {
        display: inline-block;

    }
}
.show {
    display: flex;
    align-items: center;
}

.collapse-horizontal {

    max-height: 52px;
}

.row-no-gutter {
    --bs-gutter-x: 0;
}

.collapse-container {

    width: fit-content;
    height: fit-content;
    z-index: 2;
    height: 101%;
    margin-top: 17px;

    .my-collapse {

        width: 250px;
    }
}

.filters-list {
    list-style-type: none;
    font-size: 12px;
}
.rating-stars i {
    color: gold;
}
*/

</style>
