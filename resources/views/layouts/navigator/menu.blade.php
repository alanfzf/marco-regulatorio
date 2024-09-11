<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Law compliance</title>
        <link rel="icon" href="" type="image/x-icon">
        @yield('css')
    </head>

    <body>
        <div class="min-h-screen drawer bg-base-200">
            <input id="main-drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                {{-- contenido  header --}}
                <header>
                    @include('layouts.navigator.navbar')
                </header>

                {{-- contenido principal --}}
                <main>
                    <div class="container px-10 py-5 mx-auto">
                        @yield('content_header')
                        @yield('content')
                    </div>
                </main>

                {{-- contenido del footer --}}
                <footer>
                    @yield('content_footer')
                </footer>
            </div>
            <div class="drawer-side">
                <label for="main-drawer" aria-label="close sidebar" class="w-full drawer-overlay"></label>
                <ul class="min-h-full p-4 menu bg-neutral text-neutral-content w-80">

                    <li>
                        <a href="{{ route('laws.index') }}"> Law list <i class="fa-solid fa-scale-balanced"></i></a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">Users <i class="fa-solid fa-user"></i></a>
                    </li>

                    <li>
                        <a href="{{ route('companies.index') }}">Companies <i class="fa-solid fa-building"></i></a>
                    </li>

                    <li>
                        <a href="{{ route('teams.show') }}">Team <i class="fa-solid fa-users"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        @yield('js')
    </body>
</html>
