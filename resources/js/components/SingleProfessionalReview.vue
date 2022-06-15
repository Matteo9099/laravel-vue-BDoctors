<template>
  <div>

      <div class="review">

          <div id="click-collapse" class="ms_row-info" data-bs-toggle="collapse" data-bs-target="#review-wrap" aria-expanded="false" aria-controls="review-wrap">
            <h3 @click="changeArrow()">Scrivi una recensione <i class="fa-solid" :class="(arrow === true)? 'fa-angle-down' : 'fa-angle-up' "></i></h3>
          </div>

          <!-- FORM RECENSIONE -->
          <div class="collapse" id="review-wrap">

            <form @submit.prevent="sendReview">

              <!-- INIZIO VOTO -->
              <div id="star-vote" class="mb-3">
                <p>Da 1 a 5 come valuteresti la visita?</p>

                <input @click="goldStar(index)" v-for="(i, index) in 5" :key="i" type="radio" :id="'star' + i" name="vote" :value="i" v-model="voteValue">
                <label v-for="i in 5" :key="'a' + i" :for="'star' + i">
                  <i class="fa-star" :class="(goldStarArray.includes(i))? 'fa-solid checked' : 'fa-regular' "></i>
                </label>

              </div>
              <!-- FINE VOTO -->

              <!-- TITOLO -->
              <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title" required placeholder="Scrivi un titolo per la recensione" v-model="title">
              </div>

              <!-- NOME AUTORE -->
              <div class="mb-3">
                <label for="name" class="form-label">Il tuo nome</label>
                <input type="text" class="form-control" id="name" name="author" required placeholder="Scrivi il tuo nome" v-model="name">
              </div>

               <!-- EMAIL -->
                <div class="mb-3">
                    <label for="email" class="form-label">La tua email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Scrivi la tua email" v-model="email">
                </div>

              <!-- TESTO RECENSIONE -->
              <div class="mb-3">
                <label for="text-review" class="form-label">Scrivi la recensione</label>
                <textarea class="form-control" id="text-review" name="review" required rows="3" v-model="reviewText"></textarea>
              </div>

              <!-- BUTTON SUBMIT -->
              <button type="submit" class="btn btn-success text-white">Pubblica</button>


              <div v-if="success" class="alert alert-success mx-auto w-75 mt-4 p-2 text-center">
                  <i class="fa-solid fa-circle-check"></i> Recensione pubblicata!
              </div>

            </form>

          </div>

      </div>
  </div>
</template>

<script>

  export default {
    name: 'SingleProfessionalReview',

    props: ['currentProfessional'],

    data() {
      return {
          arrow: true,

          voteValue: '',
          title: '',
          name: '',
          email: '',
          reviewText: '',
          goldStarValue: '',
          goldStarArray: [],
          success: false,

      }
    },

    methods: {

      changeArrow() {
        this.arrow = !this.arrow;
      },


      goldStar(index) {

        this.goldStarValue = index + 1;

        //se goldStarArray non include il valore di goldStarValue
        if(!this.goldStarArray.includes(this.goldStarValue)) {

            // ciclo for di i uguale o minore al value di goldStarValue
            for (let i = 1; i <= this.goldStarValue; i++) {

                //se goldStarArray non include già il valore di i
                if(!this.goldStarArray.includes(i)){

                  //lo pusho nell'array
                  this.goldStarArray.push(i);
                }
            }
        } else {

            this.goldStarArray.splice(this.goldStarValue);
        }
      },


      sendReview() {

        axios.post('/api/review', {

          'professional_id': this.currentProfessional.id,
          'vote': this.voteValue,
          'title': this.title,
          'email' : this.email,
          'author': this.name,
          'review': this.reviewText,


        }).then(response =>{

            console.log(response);
            if (response.data.errors) {

              this.success = false;
              console.log(this.success);
            } else {

              this.success = true;
              this.voteValue = '',
              this.title = '',
              this.name = '',
              this.email = '',
              this.reviewText = '',
              this.goldStarValue = '',
              console.log(this.success);
            }

        });

      }

    }
  }

</script>

<style lang="scss" scoped>
  @import '../../sass/professional/main.scss';
</style>
