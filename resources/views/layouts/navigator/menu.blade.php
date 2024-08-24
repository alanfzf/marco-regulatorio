<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Law compliance</title>
        <link rel="icon" href="" type="image/x-icon">
        @yield('css')
    </head>

    <body data-theme="light">
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
                </ul>
            </div>
        </div>
        @yield('js')
    </body>

</html>
