<template>

  <div id="sponsored-section">

    <div class="container">
      <div class="row p-2">

        <h2>In evidenza</h2>

        <!-- CARD DOTTORI SPONSORIZZATI -->
        <div id="sponsor-container" class="col-12 p-4 p-lg-4">
          <div v-if="doctors.length <= 0">
              <span class="h1">Nessun dottore sponsorizzato</span>
          </div>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5 gx-4 gy-4 gx-lg-5 gy-lg-5 m_col-card">

            <!-- CARD 1 -->
            <div class="col" v-for="singledoc in doctors" :key="singledoc.id">
              <div class="card h-100 ms_card">

                <div class="img-card-wrap">
                  <img :src="singledoc.photo" class="card-img-top img-thumbnail">
                </div>

                <div class="card-body">

                  <!-- NOME E COGNOME -->
                  <h5 class="card-title">
                    {{singledoc.user.name}} {{singledoc.user.surname}}
                  </h5>

                  <ul class="spec-list">
                      <!-- SPECIALTIES -->
                      <li v-for="(specName, index) in singledoc.specialties" :key="index">
                        {{specName.name}}
                      </li>
                  </ul>
                  <!-- INDIRIZZO -->
                  <p class="card-text">{{singledoc.medical_address}}</p>

                  <!-- LINK PROFILO DOTTORE -->
                  <router-link class="btn btn-primary text-white" :to="'/doctors/' + singledoc.slug">Vai al profilo</router-link>

                </div>
              </div>
            </div>
            <!-- FINE CARD 1 -->

          </div>

        <!-- LAST -->
        </div>

      </div>
    </div>

  </div>

</template>

<script>

  import 'animate.css';

  export default {
    name: 'HomeSponsorizzati',
    props: ['doctors'],

  }
</script>

<style lang="scss" scoped>

  @import '../../sass/home/sponsorizzati.scss';

</style>
