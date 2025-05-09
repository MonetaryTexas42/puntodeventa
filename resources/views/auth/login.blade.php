@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mt-12">
    <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-4">
        <label for="email" class="block text-gray-700 mb-1">Email</label>
        <input id="email" name="email" type="email" required autofocus
               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-indigo-300"
               value="{{ old('email') }}">
        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4">
        <label for="password" class="block text-gray-700 mb-1">Contraseña</label>
        <input id="password" name="password" type="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-indigo-300">
        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
      </div>

      <div class="mb-4 flex items-center">
        <input id="remember" name="remember" type="checkbox"
               class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
        <label for="remember" class="ml-2 text-gray-700">Recordarme</label>
      </div>

      <div class="flex items-center justify-between">
        <a href="{{ route('password.request') }}"
           class="text-sm text-indigo-600 hover:underline">¿Olvidaste tu contraseña?</a>
        <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none">
          Ingresar
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
