@extends('layouts.app')

@section('content')

  <div id="sponsor-container">

    <div class="container ms_container">
      <div class="row row-cols-1 row-cols-md-3 gx-5 gy-5">

          {{-- COLONNA BRONZE --}}
          <div class="col ms_col-sponsor">

              <div class="top-wrap">
                <h2 class="h2-bronze">Piano base</h2>
                <h3 class="h3-bronze">Bronze</h3>
                <h4 class="spons-price">2.99 &#8364;</h4>
              </div>


              <p class="sub-title">Il piano più economico fatto su misura per iniziare a farti notare fin da subito.</p>

              <a class="ms_btn-spons text-white d-block btn btn-primary btn-lg" href="{{route('admin.subscription.pay', $bronze->name)}}"">Prova il piano Bronze</a>

              <div class="spons-description">

                <ul class="ul-bronze">

                  <li><i class="fa-solid fa-check"></i> Sponsorizza il tuo profilo per <span class="hour-spons">24 ore</span></li>
                  <li><i class="fa-solid fa-check"></i> Ottieni visibilità immediata in homepage</li>
                  <li><i class="fa-solid fa-check"></i> Sarai tra i profili in evidenza</li>

                </ul>

              </div>


          </div>

          {{-- COLONNA SILVER --}}
          <div class="col ms_col-sponsor">

              <div class="top-wrap">
                <h2 class="h2-silver">Piano Professional</h2>
                <h3 class="h3-silver">Silver</h3>
                <h4 class="spons-price">5.99 &#8364;</h4>
              </div>


              <p class="sub-title">Il piano intermedio per avere facilmente e più a lungo una maggiore visibilità per il tuo profilo. </p>

              <a class="ms_btn-spons text-white d-block btn btn-primary btn-lg" href="{{route('admin.subscription.pay', $silver->name)}}"">Prova il piano Silver</a>

              <div class="spons-description">

                <ul class="ul-silver">

                  <li><i class="fa-solid fa-check"></i> Sponsorizza il tuo profilo per <span class="hour-spons">72 ore</span></li>
                  <li><i class="fa-solid fa-check"></i> Ottieni maggiore visibilità in homepage</li>
                  <li><i class="fa-solid fa-check"></i> Sarai tra i profili in evidenza</li>

                </ul>

              </div>


          </div>

          {{-- COLONNA GOLD --}}
          <div class="col ms_col-sponsor">

              <div class="top-wrap">
                <h2 class="h2-gold">Piano Advanced</h2>
                <h3 class="h3-gold">Gold</h3>
                <h4 class="spons-price">9.99 &#8364;</h4>
              </div>


              <p class="sub-title">Il piano perfetto se vuoi il massimo ottenendo estrema visibilità per il tuo profilo.</p>

              <a class="ms_btn-spons text-white d-block btn btn-primary btn-lg" href="{{route('admin.subscription.pay', $gold->name)}}">Prova il piano Gold</a>

              <div class="spons-description">

                <ul class="ul-gold">

                  <li><i class="fa-solid fa-check"></i> Sponsorizza il tuo profilo per <span class="hour-spons">144 ore</span></li>
                  <li><i class="fa-solid fa-check"></i> Ottieni massima visibilità in homepage</li>
                  <li><i class="fa-solid fa-check"></i> Il tuo profilo sarà tra i più in evidenza</li>

                </ul>

              </div>


          </div>


      </div>
    </div>

  </div>

@endsection
