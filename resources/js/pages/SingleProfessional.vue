<template>
  <div>

    <HomeHeader :userChecked="userChecked" :authUser="authUser"></HomeHeader>
    <SingleProfessionalMain :singleprof="singleProf" :reviews="reviewsList"></SingleProfessionalMain>
    <HomeFooter></HomeFooter>

  </div>   
</template>

<script>

import HomeHeader from '../components/HomeHeader';
import SingleProfessionalMain from '../components/SingleProfessionalMain';
import HomeFooter from '../components/HomeFooter';

export default {
    name: "SingleProfessional",

    components: {
        HomeHeader,
        SingleProfessionalMain,
        HomeFooter,
    },
    
    data() {
        return {

            singleProf: [],
            reviewsList: [],

            authUser: window.authUser,
            userChecked: false,
          
        }
        
    },
    
    methods: {
        checkAuth() {
            if(this.authUser){
                this.userChecked = true;
            } else {
                this.userChecked = false;
            }

        },

        getReviews() {
            
            axios.get('/api/reviews/' + this.$route.params.slug)
            .then(response => {

                if (response.data.success) {

                    console.log(response.data.results)
                    console.log('ciao')
                    this.reviewsList = response.data.results
                    console.log(this.reviewsList)

                } else {
                    console.log('chiamata fallita')
                }
            })

            console.log(this.reviewsList)
        },

        //ottengo il singolo dottore
        getProfessionals() {

            const slug = this.$route.params.slug;

            axios.get('/api/professionals/' + slug)
            .then(response => {

                if(response.data.success == false) {
                    abort(404, 'not found');

                } else {
                    
                    this.singleProf = response.data.results
                }
            })

            this.getReviews()

        }

    },
    mounted() {

        console.log(this.$route)
        this.checkAuth();

        this.getProfessionals();


    }
}
</script>

<style>

</style>