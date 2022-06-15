<template>
  <main>

    <div id="main">

      <div id="jumbotron">
        <!-- TESTO JUMBOTRON -->
        <div class="ms_title-jumbo container text-center text-white animate__animated animate__fadeIn">

          <h2 class="title-jumbo-home">Prenota online la tua visita medica</h2>

          <h3>Trova lo specialista che fa per te</h3>

        </div>


        <!-- RICERCA MEDICO PER SPECIALIZZAZIONE -->
        <div class="container mt-5 pt-4">
          <form>

            <div class="row justify-content-center px-2">

              <!-- WRAPPER SELECT e BUTTON -->
<!--              <div id="spec-wrap" class="col-12 col-lg-9 px-3 py-4 px-lg-4 py-lg-4">-->

<!--                <div class="row justify-content-center">-->
<!--                  &lt;!&ndash; SELECT SPECIALIZZAZIONI &ndash;&gt;-->
<!--                  <div class="col-12 col-lg-8 mb-2 mb-lg-0">-->
<!--                    <select class="form-select p-2" v-model="selectedSpecialty" >-->
<!--                      <option selected disabled value="">Scegli una specializzazione</option>-->
<!--                      <option v-for="specialty in specialtiesList" :key="specialty.id" :value="specialty.slug" > {{specialty.name}} </option>-->
<!--                    </select>-->
<!--                  </div>-->

<!--                  &lt;!&ndash; BUTTON CERCA &ndash;&gt;-->
<!--                  <div class="col-12 col-lg-4">-->
<!--                      <router-link id="advanced-search" class="btn btn-specialty p-2" :to="{name: 'search', params : {slug : selectedSpecialty}}">Cerca</router-link>-->
<!--                  </div>-->

<!--                </div>-->

<!--              </div>-->
                <SelectSpecialty :specialtiesList="specialtiesList"/>

            </div>

          </form>
        </div>

        <!-- RICERCA AVANZATA -->
<!--        <div class="container">
          <div class="row justify-content-center mt-5">
              <div class="col-10 col-lg-6 text-center">
                  <router-link id="advanced-search" class="btn btn-success p-2" :to="{name: 'search', params : {slug : selectedSpecialty}}">Ricerca avanzata</router-link>
              </div>
          </div>
        </div>-->

      </div>

      <div id="user-guide">

        <div class="container">

          <div class="row row-cols-1 row-cols-lg-3">

            <!-- COLONNA GUIDA 1 -->
            <div class="col d-flex flex-column">

                <!-- IMG GUIDA -->
                <div class="img-guide text-center">
                  <img src="../../images/search-frontend.png">
                </div>

                <!-- TESTO GUIDA -->
                <div class="text-guide text-center">
                  <h3>Cerca</h3>
                  <p>
                    Seleziona una specializzazione e cerca tra i nostri medici
                    che corrispondono alla tua richiesta.
                  </p>
                </div>

            </div>

            <!-- COLONNA GUIDA 2 -->
            <div class="col d-flex flex-column">

                <!-- IMG GUIDA -->
                <div class="img-guide text-center">
                  <img src="../../images/medical-team.png">
                </div>

                <!-- TESTO GUIDA -->
                <div class="text-guide text-center">
                  <h3>Scegli il medico</h3>
                  <p>
                    Fai la scelta migliore per le tue esigenze.
                    Valuta il curriculum e le recensioni dei pazienti
                  </p>
                </div>

            </div>

            <!-- COLONNA GUIDA 3 -->
            <div class="col d-flex flex-column">

                <!-- IMG GUIDA -->
                <div class="img-guide text-center">
                  <!-- <img src="../../images/professional_book.png"> -->
                </div>

                <!-- TESTO GUIDA -->
                <div class="text-guide text-center">
                  <h3>Prenota un appuntamento</h3>
                  <p>
                    Contatta il medico che hai scelto via telefono o scrivi un messaggio veloce.
                    Bastano pochi secondi.
                  </p>
                </div>

            </div>

          </div>

        </div>

      </div>


      <!-- SEZIONE DOTTORI SPONSORIZZATI -->
      <HomeSponsorizzati :professionals="profsList"></HomeSponsorizzati>
      <!-- FINE SEZIONE DOTTORI SPONSORIZZATI -->

    </div>

  </main>
</template>

<script>

  import 'animate.css';
  import HomeSponsorizzati from '../components/HomeSponsorizzati';
  import SelectSpecialty from '../components/SelectSpecialty';

  export default {

      name: 'MainHomepage',

      components: {
        SelectSpecialty,
        HomeSponsorizzati,
    },

    data() {

      return{

        specialtiesList: [],
        profsList: [],
        selectedSpecialty: '',

      };

    },

    methods: {

        //ottengo tutte le specializzazioni
        getSpecialties() {

            axios.get('/api')
            .then((response) => {

              this.specialtiesList = response.data.results;

            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
            .then(function () {
              // always executed
            });

        },

        //ottengo tutti i dottori (PROVVISORIO)
        getprofessionals() {

            axios.get('/api/sponsored')
            .then((response) => {

              this.profsList = response.data.results;
              console.log(this.profsList);

            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
            .then(function () {
              // always executed
            });

        },

    },

    mounted() {
        this.getSpecialties();

        this.getprofessionals();
    }

  }

</script>

<style lang="scss" scoped>

  @import '../../sass/home/main.scss';

</style>
