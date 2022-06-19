<?php
    header("refresh:5;url=http://127.0.0.1:8000");
?>

@extends('layouts.app')

@section('content')

    <div class="container mt-4 h-50 d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="text-success me-4">Pagamento avvenuto con successo <i class="fa-solid fa-check"></i></h1>
        <h5>Dettagli sponsor</h5>
        <div class="card text-center mt-4" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Sponsor  <span class="fw-bold text-uppercase">{{$subscription->name}}</span> </h5>
                <p class="card-text">Durata: fino al {{$expires->format('d m y')}} </p>
                <h5 class="fw-bold">Prezzo {{$subscription->price}}</h5>
                <span id="btn_time" href="#" class="btn btn-success text-white mt-1">Data scadenza {{$expires->format('d m y')}}</span>
            </div>
        </div>
        <div class="d-flex mt-5">
            <a href="/home" class=" nav-link">Vai alla home</a>
            <a href="{{route('admin.home')}}" class="nav-link">Torna alla dashboard</a>
        </div>
    </div>

@endsection

<style>

#btn_time{
        position: absolute;
        left: 10%;
        width: 80%;
        cursor: auto;
    }
    i{
        border: 2px solid green;
        border-radius: 50%;
        padding: 5px;
        color: green;
    }

</style>
