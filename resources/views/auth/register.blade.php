@extends('layouts.app')

@section('content')
<div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="../assets/img/create-account-office.jpeg"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="../assets/img/create-account-office-dark.jpeg"
              alt="Office"
            />
          </div>

        

          <div class="flex items-center justify-center p-6 ">
            <div class="w-full">

                <form method="POST" action="{{ route('register') }}">
                @csrf
                    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 p-2 mb-3">
                        <span class="text-gray-700 dark:text-gray-400">Nombre:</span>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                            
                    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 p-2 mb-3">
                        <span class="text-gray-700 dark:text-gray-400">Email:</span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 p-2 mb-3">
                        <span class="text-gray-700 dark:text-gray-400">Contraseña:</span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                        name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 p-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            Confirma Contraseña
                        </span>
                        <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                                
                    <button
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                        hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple mt-3"
                        type="submit"
                        >Registrar
                    </button>                  
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
