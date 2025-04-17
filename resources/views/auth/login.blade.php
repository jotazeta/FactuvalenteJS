@extends('layouts.app')

@section('content')


    <div class="flex items-center min-h-[32rem] p-6 bg-gray-50 dark:bg-gray-900 h-full">
      <div class="flex-1 max-w-4xl mx-auto h-9/10 overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden"
              src="../assets/img/login-office.jpeg"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="../assets/img/login-office-dark.jpeg"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="flex items-center justify-center p-6 w-full">
                  <form method="POST" action="{{ route('login') }}">
                  @csrf
                    <div
                        class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 m-px mb-3"
                      >
                      <span class="text-gray-700 dark:text-gray-400">Correo Electrónico</span>
                        <input
                        class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                        form-control @error('email') is-invalid @enderror"
                        placeholder="introduzca correo"
                        id="email" type="email"
                        name="email" value="{{ old('email') }}"
                        required autocomplete="email" autofocus
                            
                              />

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div
                          class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 m-px"
                        >
                        <span class="text-gray-700 dark:text-gray-400">Contraseña</span>
                            <input
                            class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                            focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                            form-control @error('password') is-invalid @enderror"
                            placeholder="introduzca contraseña"
                            id="password" type="password"
                            name="password" required autocomplete="current-password"
                                
                                  />

                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>

                
                  

                        <button
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                        hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple mt-3"
                        type="submit"
                        >Iniciar Sesión
                        </button>
                  </form>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection