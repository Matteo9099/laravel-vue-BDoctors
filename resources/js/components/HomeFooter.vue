<template>
    <footer>

      <div id="footer">
          <div class="container">

            <div class="social-row">
                <span>Seguici sui social</span>
                <i class="fa-brands fa-instagram-square"></i>
                <i class="fa-brands fa-facebook-square"></i>
                <i class="fa-brands fa-twitter-square"></i>
                <i class="fa-brands fa-linkedin"></i>
            </div>
            
            <!-- DUE COLONNE MAIN -->
            <div class="row row-cols-2">

              <!-- COLONNA 1 -->
              <div class="col">
                  <div class="row row-cols-1 row-cols-md-3 gy-4">

                      <!-- COLONNA sub 1 -->
                      <div class="col d-flex flex-column">
                        <h5>Bdoctors.it</h5>
                        <a href="#">Chi siamo</a>
                        <a href="#">Team</a>
                        <a href="#">Le nostre app</a>
                        <a href="#">Ufficio Stampa</a>
                        <a href="#">Dati societari</a>
                      </div>

                      <!-- COLONNA sub 2 -->
                      <div class="col d-flex flex-column">
                        <h5>Web</h5>
                        <a href="#">Cookies</a>
                        <a href="#">Termini e Condizioni</a>
                        <a href="#">Privacy</a>
                        <a href="#">Social</a>
                        <a href="#">Pubblicità</a>
                      </div>

                      <!-- COLONNA sub 3 -->
                      <div class="col d-flex flex-column">
                      <h5>Lavora con noi</h5>
                        <a href="#">Curriculum</a>
                        <a href="#">Inoltra la tua candidatura</a>
                        <a href="#">Le posizioni aperte</a>
                        <a href="#">Storico</a>
                      </div>
                  </div>
              </div>

              <!-- COLONNA 2 -->
              <div class="col">
                  <div class="row row-cols-1 row-cols-md-3 gy-4">

                      <!-- COLONNA sub 1 -->
                      <div class="col d-flex flex-column">
                        <h5>Strutture iscritte</h5>
                        <a href="#">Centri Medici</a>
                        <a href="#">Uffici consulto</a>
                        <a href="#">Aree Sanitarie</a>
                        <a href="#">Strumenti iscrizione</a>
                        <a href="#">Documentazione</a>
                      </div>
                      
                      <!-- COLONNA sub 2 -->
                      <div class="col d-flex flex-column">
                        <h5>Medici</h5>
                        <a href="#">Iscriviti</a>
                        <a href="#">Come iscriversi</a>
                        <a href="#">Contattaci</a>
                        <a href="#">Regolamento</a>
                        <a href="#">Lista documentazione</a>
                      </div>

                      <!-- COLONNA sub 3 -->
                      <div class="col d-flex flex-column">
                      <h5>Per gli utenti</h5>
                        <a href="#">FAQ</a>
                        <a href="#">Contattaci</a>
                        <a href="#">I nostri servizi</a>
                        <a href="#">Assistenza web</a>
                        <a href="#">Assistenza telefonica</a>
                      </div>
                  </div>
              </div>
              
            </div>  

          </div>
      </div>

    </footer>
</template>

<script>

  export default {
    name: 'HomeFooter',
  }

</script>

<style lang="scss" scoped>
  @import '../../sass/home/footer.scss';
</style>