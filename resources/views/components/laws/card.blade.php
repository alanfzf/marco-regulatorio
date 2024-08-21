<a href="">
    <div class="card bg-base-100 w-96 h-[32rem] shadow-xl group">
        <figure class="relative">
            <img src="https://i.imgur.com/vPfc3VJ.png" alt="Shoes"
                class="blur-[3px] group-hover:blur-none transition duration-300" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">
                JM 47-2022

                @php
                    $classes = ['badge-warning', 'badge-error', 'badge-success'];
                    $randomClass = $classes[array_rand($classes)];
                @endphp

                <div class="badge {{ $randomClass }}">
                    <span class="text-sm">OK</span>
                </div>
            </h2>
            <p>Reglamento para la Administración del Riesgo de Crédito, con vigencia a partir del 1 de enero de 2023.
            </p>
            <div class="card-actions justify-end">
                <div class="badge badge-outline">2024-02-02</div>
                <div class="badge badge-outline">
                    Articulos: &nbsp; <strong> 99</strong>
                </div>
            </div>
        </div>
    </div>
</a>
