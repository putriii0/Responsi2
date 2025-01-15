@extends('layouts.dashboard')

@section('title', 'Dashboard | Teska')

@section('content')
<div class="max-w-screen-xl px-6 py-12 mx-auto sm:px-8 lg:px-12">
  {{-- Hero Banner --}}
  <div class="relative w-full h-96 bg-gradient-to-r from-blue-800 to-blue-900 rounded-lg shadow-xl overflow-hidden"></div>
    <!-- Overlay with blur effect -->
    <div class="absolute inset-0 bg-black opacity-40"></div>

    <!-- Banner content with text and icon -->
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white p-6 z-10">
      <h2 class="text-4xl font-bold sm:text-5xl leading-tight transition-all duration-300 transform hover:scale-105">Dashboard</h2>
      <p class="mt-4 text-lg sm:text-xl max-w-lg mx-auto opacity-90 transition-all duration-300 hover:opacity-100">Selamat datang di halaman dashboard! Kelola bisnis Anda dengan mudah dan pantau performa secara menyeluruh.</p>
      
      <!-- Animated Icon (optional) -->
      <div class="mt-8 animate-bounce">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l2 2m-2-2v6m6-6l2-2m0 0l2 2m-2-2v6m6-6l2-2m0 0l2 2m-2-2v6"></path>
        </svg>
      </div>
    </div>
  </div>
</div>

@endsection
