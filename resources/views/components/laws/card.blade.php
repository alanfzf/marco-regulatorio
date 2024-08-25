@props(['href' => '#', 'law' => null])

<a href="{{ $href }}">
    <div class="card bg-base-100 w-96 h-[32rem] shadow-xl group">
        <figure class="relative">
            <img src="{{ Utils::storageFile($law->law_image) }}" onerror="this.src='https://i.imgur.com/vPfc3VJ.png';"
                class="blur-[3px] group-hover:blur-none transition duration-300 min-h-96" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">
                <div class="w-4/5">


                    <p class="truncate">
                        <span class="text-sm">
                            {{ $law['law_name'] ?? '---' }}
                        </span>
                    </p>
                </div>

                @php
                    $items = $law['items_count'];
                    $done = $law['complete_items_count'];
                    $percentage = ($done / $items) * 100;
                @endphp

                <div @class([
                    'badge',
                    'badge-success' => $percentage >= 90,
                    'badge-warning' => $percentage >= 46,
                    'badge-error' => $percentage < 45
                ])>
                    <span class="text-xs">{{ $done }}/{{ $items }}</span>

                </div>
            </h2>
            <p>
                {{ $law['law_description'] ?? '---' }}
            </p>
            <div class="card-actions justify-end">
                <div class="badge badge-outline">{{ $law['law_publish_date'] ?? '---' }}</div>
                <div class="badge badge-outline">
                    Articulos: &nbsp; <strong>{{ $law['articles_count'] ?? 0 }}</strong>
                </div>
            </div>
        </div>
    </div>
</a>
