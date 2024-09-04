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
    @if ($errors->any())
        <div role="alert" class="alert alert-error shadow-lg">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <h3 class="font-bold">Error</h3>

                @foreach ($errors->all() as $error)
                    <ul class="list-inside list-disc">
                        <li class="text-sm">{{ $error }}</li>
                    </ul>
                @endforeach
            </div>
        </div>
    @endif
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
