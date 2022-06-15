<template>

  <main>
    <div id="professional-container">
      <div id="top-color-row">

        <div class="container d-flex">

            <!-- FOTO -->
            <div class="doc-ph-wrap">
              <img :src="singleprof.photo" class="img-thumbnail" alt="foto dottore">
            </div>

            <!-- NOME e COGNOME -->
            <div id="doc-title">
              <h2 class="doc-name"> {{singleprof.user.name}} {{singleprof.user.surname}} </h2>
            </div>

        </div>

      </div>

      <!-- CONTAINER INFORMAZIONI -->
      <div class="container">

          <div id="info-container">
            <div id="col-professional" class="row row-cols-1 row-cols-lg-2 justify-content-lg-between">

              <div id="col-info" class="col-lg-7">

                <div class="address ms_row-info">
                  <h3>Indirizzo</h3>
                  {{singleprof.medical_address}}
                </div>

                <div class="specialties ms_row-info">
                  <h3>Competenze</h3>
                  <ul class="spec-list">
                    <li v-for="(singlespec, index) in singleprof.specialties" :key="index">
                      {{singlespec.name}}
                    </li>
                  </ul>
                </div>

                <div class="performance ms_row-info">
                  <h3>Prestazioni</h3>
                  {{singleprof.performance}}
                </div>

                <!-- COMPONENT RECENSIONE -->
                <SingleProfessionalReview :currentProfessional="singleprof"></SingleProfessionalReview>

                <!-- LISTA RECENSIONI -->
                <div class="reviews ms_row-info">
                  <h3>{{singleprof.reviews.length}} Recensioni</h3>

                  <ul class="prova">
                    <li v-for="(review, index) in reviews" :key="index">

                      <h4>{{review.author}}</h4>

                      <div class="d-flex justify-content-between">

                        <!-- VOTO E TITOLO -->
                        <div class="vote-title-wrap">

                          <span class="rev-vote">
                            <i v-for="i in 5" :key="i" class="star-color fa-star" :class="(i <= review.vote) ? 'fa-solid' : 'fa-regular' "></i>
                          </span>
                      
                          <span class="rev-title">{{review.title}}</span>

                        </div>

                        <!-- DATA RECENSIONE -->
                        <div class="date-review">
                          <span class=""></span>
                        </div>

                      </div>

                      <p class="rev-text">{{review.review}}</p>

                    </li>
                  </ul>

                </div>

              </div>

              <div id="col-booking" class="col-lg-4">
                <div class="booking-title">
                  <h2>Prenota un appuntamento</h2>
                </div>

                <div class="phone">
                    <h3>Telefono</h3>
                    {{singleprof.phone}}
                </div>

                <div class="message">
                    <h3>Scrivi un messaggio</h3>

                    <!-- FORM INVIO MESSAGGIO -->
                    <SingleProfessionalForm :currentProfessional="singleprof"></SingleProfessionalForm>

                </div>
              </div>

            </div>
          </div>

      </div>

    </div>
  </main>

</template>

<script>

  import SingleProfessionalReview from './SingleProfessionalReview';
  import SingleProfessionalForm from './SingleProfessionalForm';

  export default {

    name: 'SingleProfessionalMain',
    props: ['singleprof', 'reviews', 'formattedDates'],

    components: {

      SingleProfessionalReview,
      SingleProfessionalForm,
    
    },

  }

</script>

<style lang="scss" scoped>
  @import '../../sass/professional/main.scss';
</style>