<template>
  <div>

    <HomeHeader :userChecked="userChecked" :authUser="authUser"></HomeHeader>
    <SingleDoctorMain :formattedDates="formattedDates" :singledoc="singleDoc" :reviews="reviewsList"></SingleDoctorMain>
    <HomeFooter></HomeFooter>

  </div>
</template>

<script>

import HomeHeader from '../components/HomeHeader';
import SingleDoctorMain from '../components/SingleDoctorMain';
import HomeFooter from '../components/HomeFooter';

export default {
    name: "SingleDoctor",

    components: {
        HomeHeader,
        SingleDoctorMain,
        HomeFooter,
    },

    data() {
        return {

            singleDoc: [],
            reviewsList: [],
            formattedDates: [],

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
                    this.reviewsList = response.data.results
                    this.formattedDates = response.data.formatted
                    console.log(this.reviewsList)

                } else {
                    console.log('chiamata fallita')
                }
            })

            console.log(this.reviewsList)
        },

        //ottengo il singolo dottore
        getDoctors() {

            const slug = this.$route.params.slug;

            axios.get('/api/doctors/' + slug)
            .then(response => {

                if(response.data.success == false) {
                    abort(404, 'not found');

                } else {

                    this.singleDoc = response.data.results
                }
            })

            this.getReviews()

        }

    },
    mounted() {

        console.log(this.$route)
        this.checkAuth();

        this.getDoctors();


    }
}
</script>

<style>

</style>
