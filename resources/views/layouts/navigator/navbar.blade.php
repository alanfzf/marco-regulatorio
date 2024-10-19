<div class="navbar bg-neutral text-neutral-content">
    <div class="flex-none">
        <label for="main-drawer" class="btn btn-square btn-ghost drawer-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block w-5 h-5 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
    </div>
    <div class="flex-1">
        <a class="text-xl btn btn-ghost" href="/">Law Compliance</a>
    </div>

    <div class="flex-none">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="avatar placeholder">
                    <div class="bg-neutral text-neutral-content rounded-full">
                        <span>N/A</span>
                    </div>
                </div>

            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-neutral rounded-box z-[1] mt-3 w-52 p-2 shadow">
                <li>
                    <button type="button">Perfil</button>
                </li>
                <li>
                    <label class="w-full swap swap-rotate">
                        <!-- this hidden checkbox controls the state -->
                        <input id="theme-changer" type="checkbox" class="theme-controller"
                            onchange="toggleTheme(this)" />

                        <!-- sun icon -->
                        <div class="fill-current swap-off">
                            <i class="fa-solid fa-sun"></i>
                        </div>

                        <!-- moon icon -->
                        <div class='fill-current swap-on'>
                            <i class="fa-solid fa-moon"></i>
                        </div>
                    </label>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
