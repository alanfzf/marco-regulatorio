@extends('layouts.base')

@section('main')
    @php
        $articles = $law->articles_count;
        $compliant = $law->compliant_articles;
        $non_compliant = $articles - $compliant;
        $compliant_percentage = round(($compliant / max($articles, 1)) * 100, 2);
        $non_compliant_percentage = round(($non_compliant / max($articles, 1)) * 100, 2);
    @endphp

    <div class="flex w-full flex-col border-opacity-50">
        <div class="divider">
            <strong>"{{ strtoupper($law->law_name) }}"</strong> compliance status
        </div>
    </div>

    <div class="stats shadow mb-3 w-full">
        <div class="stat">
            <div class="stat-figure text-info">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="stat-title">Compliant</div>
            <div class="stat-value text-info">{{ $compliant }}</div>
            <div class="stat-desc">{{ $compliant_percentage }}% of articles</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-error">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="stat-title">Non compliant</div>
            <div class="stat-value text-error">{{ $non_compliant }}</div>
            <div class="stat-desc">{{ $non_compliant_percentage }}% of articles</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-success">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
            <div class="stat-title">Total articles</div>
            <div class="stat-value text-success">{{ $articles }}</div>
            <div class="stat-desc">Overall compliance {{ $compliant }}/{{ $articles }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3 h-96">

        <div class="bg-base-100 rounded-md p-3 overflow-x-auto shadow-md">
            <h2 class="text-center font-bold">Articles</h2>
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Article</th>
                        <th>Compliance status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($law->articles as $index => $article)
                        @php
                            $items = $article->items->toArray();
                            $all = count($items);
                            $count = count(
                                array_filter($items, function ($item) {
                                    return $item['item_is_informative'] == 1 || $item['item_is_complete'] == 1;
                                })
                            );
                        @endphp

                        <tr>
                            <th>{{ $index }}</th>
                            <td>
                                <i class="fa-regular fa-paste"></i> {{ $article->article_name }}
                            </td>
                            <td>
                                <div class="text-xs">
                                    <span class="text-primary">{{ $count }}</span> of <span
                                        class="">{{ $all }}</span>
                                    <i class="fa-solid fa-list-check"></i>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-ghost btn-xs"
                                    href="{{ route('articles.show', ['article' => $article]) }}">details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div id="container" class="rounded-md shadow-md">

        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
        <a href="{{ route('laws.index') }}" class="btn btn-neutral ">Go back</a>
        <form action="" method="POST">
            @method('POST')
            <button type="submit" class="btn btn-primary w-full">Mass upload</button>
        </form>

        <a href="{{ route('laws.edit', ['law' => $law->id]) }}" class="btn btn-info">Edit</a>

        <form action="{{ route('laws.destroy', ['law' => $law]) }}" method="POST"
            onsubmit="return confirm('Do you really want to archive this law?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error w-full">
                Archive law
            </button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        window.compliance = @js(['complaint' => $compliant_percentage, 'non_compliant' => $non_compliant_percentage])
    </script>
    @vite(['resources/js/laws/compliance_chart.js'])
@endpush
