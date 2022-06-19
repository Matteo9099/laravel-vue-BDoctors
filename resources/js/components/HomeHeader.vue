<template>

  <header>
    <div id="header">


      <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">


            <a id="nav-logo" class="navbar-brand" href="/"><h1> BDoctors.it </h1></a>


            <button class="navbar-toggler my-btn-color" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

                <div id="head-btn" class="navbar-nav" v-if="userChecked == false">
                  <div class="p-1">
                    <a class="nav-link btn btn-reg text-white px-4" href="/register">Registrati</a>
                  </div>
                  <div class="p-1">
                    <a class="nav-link btn btn-login px-3" href="/login">Accedi</a>
                  </div>
                </div>


                <div v-if="userChecked">
                    <span class=" text-white" >Bentornato/a  {{ authUser.name }} {{authUser.surname}}</span>
                </div>

                <div class="navbar-nav" id="head-btn" v-if="userChecked">
                  <div class="p-1">
                    <a class="nav-link btn btn-login px-3" href="/admin">Pannello admin</a>
                  </div>
                </div>

            </div>

          </div>
      </nav>

    </div>
  </header>

</template>

<script>

export default {

  name: "HomeHeader",

  props:{
      userChecked : Boolean,
      authUser : Object,
  }

}

</script>

<style lang="scss" scoped>

  @import '../../sass/home/header.scss';

</style>
