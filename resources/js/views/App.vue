<template>
    <div>

      <Main></Main>

    </div>
    

</template>

<script>

  import Home from './Home';
  import HomeHeader from '../components/HomeHeader.vue';
  import Main from '../components/Main.vue'

  export default {
    name: "App",

    components: {
    Home,
    HomeHeader,
    Main,

}
}

</script>

<style>

</style>
