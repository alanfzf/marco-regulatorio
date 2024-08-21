@props(['href' => '#', 'law_name', 'law_date', 'law_description' => null, 'law_image' => null])
<a href="{{ $href }}">
    <div class="card bg-base-100 w-96 h-[32rem] shadow-xl group">
        <figure class="relative">
            <img src="{{ $law_image }}" onerror="this.src='https://i.imgur.com/vPfc3VJ.png';"
                class="blur-[3px] group-hover:blur-none transition duration-300 min-h-96" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">
                {{ $law_name }}

                @php
                    $classes = ['badge-warning', 'badge-error', 'badge-success'];
                    $randomClass = $classes[array_rand($classes)];
                @endphp

                <div class="badge badge-neutral">
                    <span class="text-sm">N/A</span>
                </div>
            </h2>
            <p>
                {{ $law_description ?? '---' }}
            </p>
            <div class="card-actions justify-end">
                <div class="badge badge-outline">{{ $law_date }}</div>
                <div class="badge badge-outline">
                    Articulos: &nbsp; <strong>?</strong>
                </div>
            </div>
        </div>
    </div>
</a>
