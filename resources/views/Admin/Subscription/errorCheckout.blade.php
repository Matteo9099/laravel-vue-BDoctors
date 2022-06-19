<?php
//    header("refresh:5;url=http://127.0.0.1:8000");
//?>

@extends('layouts.app')

@section('content')

    <div class="container mt-4 py-4 h-50 d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="text-danger me-4">Abbiamo riscontrato errori nel pagamento <i class="fa-solid fa-triangle-exclamation"></i></h1>
        <h1 class="h2 text-secondary">{{$errorString}}</h1>
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


</style>
