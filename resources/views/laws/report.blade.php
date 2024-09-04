@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>{{ $law->law_name }}</strong> general report
    </div>

    @php
        $art_comp = $law->articles_in_compliance;
        $art_not_comp = $law->articles_count - $law->articles_in_compliance;
        $art_total = $law->articles_count;
        $art_comp_perc = round(($art_comp / max($art_total, 1)) * 100, 2);
        $art_not_comp_perc = round(($art_not_comp / max($art_total, 1)) * 100, 2);
        $informative_items = $law->informative_items_count;
        $total_items = $law->items_count;
        $informative_perc = round(($informative_items / max($total_items, 1)) * 100, 2);

        $levels = [
            '1' => 'Initial',
            '2' => 'Managed',
            '3' => 'Defined',
            '4' => 'Quantitatively Managed',
            '5' => 'Optimizing'
        ];

        $avgRounded = round($avgMaturity, 2);
        $avgNearest = round($avgMaturity);
        $levelName = $levels[$avgNearest] ?? 'Incomplete';
    @endphp

    <div class="flex justify-between">
        <h1 class="text-xl font-bold">Metrics</h1>
        <a href="{{ route('laws.show', ['law' => $law]) }}" class="btn btn-neutral btn-sm">Go back</a>

    </div>



    <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Art. in compliance</div>
                <div class="font-bold text-success">{{ $art_comp }} / {{ $art_total }}</div>
                <div class="stat-desc"> {{ $art_comp_perc }}% of articles</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Art. not in compliance</div>
                <div class="font-bold text-error">{{ $art_not_comp }} / {{ $art_total }}</div>
                <div class="stat-desc">{{ $art_not_comp_perc }}% of articles</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Average madurity level</div>
                <div class="font-bold">{{ $levelName }}</div>
                <div class="stat-desc">Overall score {{ $avgRounded }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Informative items</div>
                <div class="font-bold text-info">{{ $informative_items }}</div>
                <div class="stat-desc">{{ $informative_perc }}% of items</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Total items</div>
                <div class="font-bold">{{ $total_items }}</div>
                <div class="stat-desc">For "{{ $law->law_name }}"</div>
            </div>
        </div>


    </section>

    <section class="my-4 grid grid-cols-1 lg:grid-cols-2 gap-3">
        <div id="pie_chart" class="shadow-md rounded"></div>
        <div id="bar_chart" class="shadow-md rounded"></div>
    </section>

    @livewire('laws.roadmap', ['law' => $law, 'lawId' => $law->id])
@endsection

@push('scripts')
    <script>
        window.maturity = @json($maturityLevels);
        window.items = @json([
            'in_complaince' => $art_comp_perc,
            'non_complaince' => $art_not_comp_perc
        ]);
    </script>

    @vite(['resources/js/laws/report.js'])
@endpush
