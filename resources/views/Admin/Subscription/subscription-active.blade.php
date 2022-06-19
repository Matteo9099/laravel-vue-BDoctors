@extends('layouts.app')

@section('content')
    
    <div class="container mt-5 d-flex justify-content-center align-items-center h-50 border rounded bg-info bg-gradient">
        {{-- Sonsor attivo --}}
        {{-- <div class="row text-center gy-4">
            <div class="col">
                <h2 class="text-white fw-bold">Hai una sponsorizzazione già attiva</h2>
                <button class="btn btn-light mt-2">Aggiungi Sponsor</button>
                <button class="btn btn-light mt-2">Torna alla Home</button>
            </div>
            <div class="col d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Name sponsor</h5>
                        <p class="card-text">Durata: </p>
                        <h5 class="fw-bold">Prezzo</h5>
                        <span id="btn_time" href="#" class="btn btn-success text-white mt-1">Data scadenza</span>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- Fine sponsor attivo --}}


        {{-- Sponsor non attivo --}}
         <div class="d-flex flex-column text-center text-white fw-bold border p-4" id="ms-shadow">
            <h2>Scopri i vantaggi di una sponsorizzazione</h2>
            <p>Scegli il tuo piano sponsor e posizionati tra i primi risultati di ricerca.</p>
            <a href="#" class="btn btn-light mt-2">Scopri i Sponsor</a>
        </div> 

        {{-- Fine Sponsor non attivo --}}

    </div>

@endsection

<style scoped>
    #btn_time{
        position: absolute;
        left: 10%;
        width: 80%;
        cursor: auto;
    }

    #ms-shadow{
        box-shadow: 5px 0px 30px 10px rgb(248, 225, 198);
    }

</style>