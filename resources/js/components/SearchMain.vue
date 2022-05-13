<template>
    <main>

        <div>
            <div id="jumbotron" class="position-relative">
                <form>
                    <div class="row row-no-gutter justify-content-center px-2">


                        <div id="spec-wrap" class="col-12 col-lg-9 px-3 py-4 px-lg-4 py-lg-4 d-inline">

                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-9 mb-2 mb-lg-0">
                                    <input type="text" class="form-control" placeholder="Digita il nome del medico" v-model="ricerca" >
                                </div>

                                <div class="col-12 col-lg-3">

                                    <button class="btn btn-specialty" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                                        Filtri
                                    </button>

                            </div>
                            </div>
                        </div>
                        <div class="d-inline collapse-container">


                            <div class="collapse collapse-horizontal my-collapse" id="collapseWidthExample">
                                <div class="card card-body">
                                    Media voto:
                                    <ul class="d-flex flex-wrap filters-list">
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedReview" class="form-check-input" type="checkbox" value="5" id="flexCheckDefault" >
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">5 <i class="fa-solid fa-star"></i></span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedReview" class="form-check-input" type="checkbox" value="4" id="flexCheckDefault" >
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">4+ <i class="fa-solid fa-star"></i></span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedReview" class="form-check-input" type="checkbox" value="3" id="flexCheckDefault" >
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">3+ <i class="fa-solid fa-star"></i></span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedReview" class="form-check-input" type="checkbox" value="2" id="flexCheckDefault" >
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">2+ <i class="fa-solid fa-star"></i></span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedReview" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" >
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">1+ <i class="fa-solid fa-star"></i></span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                    Numero di recensioni:
                                    <ul class="d-flex flex-wrap filters-list">
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedNumberReview" class="form-check-input" type="checkbox" value="10" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">> 10</span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedNumberReview" class="form-check-input" type="checkbox" value="5" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">5 - 10</span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="ms-2">
                                            <div class="form-check">
                                                <input v-model="checkedNumberReview" class="form-check-input" type="checkbox" value="0" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <span class="rating-stars">&lt; 5</span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>




                    </div>
                    <div class="row row-no-gutter justify-content-center px-2">

                        <SelectSpecialty :specialtiesList="specialtiesList" class="mt-4"/>
                    </div>
                </form>
            </div>





            <div id="container" class="col-12 p-4 p-lg-4 container">

                <div class="row">
                    <div class="col my-3">
                        <h2 v-if="$route.params.slug">Ecco tutti i dottori specializzati in <span class="text-capitalize text-danger">{{ $route.params.slug }}</span></h2>
                        <p v-if="notFound" class="text-danger">Nessun dottore trovato</p>
                        <div class="d-flex justify-content-center gap-3" v-if="loading">
                            <h2 class="text-center"> Caricamento in corso</h2>
                            <div class="spinner-border" role="status">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5 gx-4 gy-4 gx-lg-5 gy-lg-5 m_col-card">

                    <!-- CARD 1 -->
                    <div class="col" v-for="doctor in filteredDoctors" :key="doctor.id">
                        <div class="card h-100">

                            <img :src="doctor.photo" class="card-img-top">

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
                </div>
            </div>
        </div>


  </main>
</template>

<script>
import SelectSpecialty from "../components/SelectSpecialty";

export default {
    name: 'SearchMain',
    components: { SelectSpecialty },
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

</style>
