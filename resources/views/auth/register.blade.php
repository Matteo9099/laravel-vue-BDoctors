@extends('layouts.app')

@section('content')
<div id="bg-register">
    <div class="container">
        <div class="row justify-content-center py-3">
            <div class="col-md-8">
                {{-- eliminazione user --}}
                @if (session('deletedUser'))
                    <div class="alert alert-danger">
                        {{ session('deletedUser') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header bg-white text-center text-uppercase">{{ __('Registra il tuo profilo') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    {{-- nome --}}
                                    <div class="mb-3 ">
                                        <div>
                                            <label for="name" class="form-label">{{ __('Nome *') }}</label>
                                            <input required id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    {{-- cognome --}}
                                    <div>
                                        <div class="">
                                            <label for="surname" class="form-label">{{ __('Cognome *') }}</label>
                                            <input required id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
                                            @error('surname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    {{-- indirizzo --}}
                                    <div class="mb-3">
                                        <div>
                                            <label for="address" class="form-label">{{ __('Indirizzo *') }}</label>
                                            <input required id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    {{-- email --}}
                                    <div class="mb-3">
                                        <div>
                                            <label for="email" class="form-label">{{ __('Indirizzo e-mail *') }}</label>
                                            <input required id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              {{-- specializzazione --}}
                              <div class="col-6">
                                    <div class="mb-3">
                                        <label for="specialty" class="form-label">{{ __('Specializzazione *') }}</label>
                                        <p class="text-danger mt-2" id="mustBeSelected"></p>
                                        <select onchange="checkSpec()" required id="specialty" class="form-select @error('specialties') is-invalid @enderror" name="specialty_id" required v-model="spec">
                                          <option value="select" class="text-muted">Seleziona una specializzazione/ Altro</option>
                                          @foreach ($specialties as $specialty)
                                            <option value=" {{$specialty->id}} "> {{$specialty->name}} </option>
                                          @endforeach
                                        </select>
                                        <input  onclick="checkSpec()" onkeyup="checkSpec()" placeholder="Inserisci una specializzazione" id="otherSpec" class="mt-3 form-control disabled" type="text" v-if=" spec == 12 " name="otherSpec">

                                        @error('specialties')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                {{-- password --}}
                                <div class="mb-3">
                                    <div>
                                        <label for="password" class="form-label">{{ __('Password *') }}</label>
                                        <input required  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" >
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- password --}}
                                <div class="mb-3">
                                    <div>

                                        <label for="password-confirm" class="form-label">{{ __('Conferma Password*') }}</label>
                                        <input  required id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" onkeyup="checkPass()">
                                        <span id="message"></span>

                                    </div>
                                </div>
                            </div>

                            <p class="text-muted fs-6">* campo richiesto</p>

                            <div class="form-group row mb-0">
                                <div class="mt-3 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary text-white" id="submit">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    {{-- <script src="{{ asset('js/register-vue.js') }}"></script> --}}
    <script>

        function checkPass() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            if (password == confirmPassword) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Le password corrispondono';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Le password non corrispondono';
            }
        }

       /* function checkInput(){
            const otherSpec = document.getElementById('otherSpec');
            const selectSpec = document.getElementById('specialty');
            if(otherSpec.value.length > 0){
                otherSpec.classList.remove('disabled');
                otherSpec.required = true;
                selectSpec.required = false ;
            } else {
                otherSpec.classList.add('disabled');
                selectSpec.required = true ;
                otherSpec.required = false;
            }
        }*/


        const checkedList = document.getElementById('specialty');
        const otherSpec = document.getElementById('otherSpec');
        console.log(checkedList.value);
        if(checkedList.value == 'select'  && otherSpec.value == ''){
            document.getElementById("submit").classList.add('disabled');
            otherSpec.classList.add('d-block');
            document.getElementById("mustBeSelected").innerHTML = "Seleziona almeno una specializzazione!";
        }
        function checkSpec(){
            if(checkedList.value == 'select'  && otherSpec.value == ''){
                document.getElementById("submit").classList.add('disabled')
                otherSpec.classList.add('d-block');
                otherSpec.classList.remove('d-none');
                checkedList.classList.add('d-block');
                checkedList.classList.remove('d-none');
                document.getElementById("mustBeSelected").innerHTML = "Seleziona almeno una specializzazione!";
            } else if (checkedList.value != 'select'){
                document.getElementById("submit").classList.remove('disabled');
                otherSpec.value = ''
                otherSpec.classList.remove('d-block');
                otherSpec.classList.add('d-none');
                document.getElementById("mustBeSelected").innerHTML = "";
            } else if (otherSpec.value != ''){
                document.getElementById("submit").classList.remove('disabled');
                checkedList.classList.add('d-none');
                checkedList.classList.remove('d-block');
                document.getElementById("mustBeSelected").innerHTML = "";
            }
        }



    </script>
@endsection
