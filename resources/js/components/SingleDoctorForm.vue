<template>
  <div>

    <form @submit.prevent="sendForm">

        <!-- Nome e Cognome -->
        <div class="form-group mt-3">
            <label class="mb-2" for="author">Nome e Cognome</label>
            <input type="text" class="form-control" :class="{'is-invalid':errors.author}" id="author" name="author" v-model="author">

            <p v-for="(error, index) in errors.author" :key="'error_author'+index" class="invalid-feedback">
                {{error}}
            </p>

        </div>

        <!-- Email utente -->
        <div class="form-group mt-3">
            <label class="mb-2" for="email">Inserisci la tua email</label>
            <input type="email" class="form-control" :class="{'is-invalid':errors.email}" id="email" name="email" v-model="email">

            <p v-for="(error, index) in errors.email" :key="'error_email'+index" class="invalid-feedback">
                {{error}}
            </p>
            
        </div>

        <!-- Messaggio -->
        <div class="form-group mt-3">
            <label class="mb-2" for="message">Messaggio</label>
            <textarea class="form-control" :class="{'is-invalid':errors.message}" id="message" rows="6" name="message" v-model="message"></textarea>
            
            <p v-for="(error, index) in errors.message" :key="'error_message'+index" class="invalid-feedback">
                {{error}}
            </p>

        </div>

        <button type="submit" class="px-4 mt-3 text-white btn btn-success">{{sendingInProgress? 'Invio in corso...':'Invia'}}</button>

        <div v-if="success" class="alert alert-success mt-4 p-2 text-center">
          <i class="fa-solid fa-circle-check"></i> Messaggio inviato con successo!      
        </div>

    </form>

  </div>
</template>

<script>
export default {

  name: 'SingleDoctorForm',
  props: ['currentDoctor'],

  data() {

      return {
          
        author: '',
        email: '',
        message: '',
        sendingInProgress: false,
        errors: {},
        success: false,
        doctor: null
      }
        
  },

  methods: {
        sendForm() {

            this.sendingInProgress = true;
            axios.post('/api/leads', {
                
                'doctor_id': this.currentDoctor.id,
                'author': this.author,
                'email' : this.email,
                'message': this.message,

            }).then(response => {

                this.sendingInProgress = false;
                if(response.data.errors) {

                    this.errors = response.data.errors;
                    this.success = false;
                } else {

                    this.success = true;
                    this.author = '',
                    this.email= '',
                    this.message= '',
                    this.errors = {};

                }
            });
        }
    },
    mounted() {

        const slug = this.$route.params.slug;
        axios.get('/api/doctors/' + slug).then(response => {
            if(response.data.success == false) {

                abort(404, 'not found');
            } else {

                this.doctor = response.data.results;
            }

        })
    }
}

</script>

<style lang="scss" scoped>

  @import '../../sass/doctor/main.scss';

</style>