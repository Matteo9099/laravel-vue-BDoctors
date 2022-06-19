<template>
    <div>

        <HomeHeader id="header" :userChecked="userChecked" :authUser="authUser"></HomeHeader>
        <SearchMain></SearchMain>
        <HomeFooter></HomeFooter>

    </div>
</template>

<script>

    import HomeHeader from '../components/HomeHeader';
    import HomeFooter from '../components/HomeFooter';
    import SearchMain from '../components/SearchMain.vue';

export default {
    name: 'Search',
    components: {
    HomeHeader,
    HomeFooter,
    SearchMain
},

    data() {
        return {
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

        }
    },

    mounted(){
        this.checkAuth();
    },
    
  
}
</script>

<style lang="scss" scoped>

#header {

    z-index: 3;
}

</style>