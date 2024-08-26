@extends('layouts.navigator.menu')

{{-- estilos base para toda la app --}}
@section('css')
    {{-- css base --}}
    @vite(['resources/sass/app.scss'])
    {{-- custom styles --}}
    @stack('styles')
@endsection

{{-- footer principal para toda la app --}}
@section('content_header')
    @yield('header')
@endsection

{{-- contenido principal para toda la app --}}
@section('content')
    @yield('main')
@endsection

{{-- footer para toda la app --}}
@section('content_footer')
@endsection

{{-- apartado para los scripts base, estos seran utilizados por toda la app --}}
@section('js')
    {{-- js base --}}
    @vite(['resources/js/app.js'])
    {{-- custom scripts --}}
    @stack('scripts')
@endsection
