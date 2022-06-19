<template>
  <div>

    <HomeHeader :userChecked="userChecked" :authUser="authUser"></HomeHeader>
    <HomeMain></HomeMain>
    <HomeFooter></HomeFooter>

  </div>
</template>

<script>

  import HomeHeader from '../components/HomeHeader';
  import HomeMain from '../components/HomeMain';
  import HomeFooter from '../components/HomeFooter';

  export default {

    name: 'Home',

    components: {

      HomeHeader,
      HomeMain,
      HomeFooter,

    },

    methods: {
        checkAuth() {
            if(this.authUser){
                this.userChecked = true;
            } else {
                this.userChecked = false;
            }

        }
    },

    mounted(){
        this.checkAuth();
    },
    data() {
        return {
            authUser: window.authUser,
            userChecked: false,
        }
    },
  }

</script>

<style lang="scss" scoped>

  @import "../../sass/home/home.scss";

</style>
