@extends('layouts.base')

@section('main')
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
            <div class="stat-value text-info">75</div>
            <div class="stat-desc">75% of articles</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-error">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="stat-title">Non compliant</div>
            <div class="stat-value text-error">25</div>
            <div class="stat-desc">25% of articles</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-success">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
            <div class="stat-value ">75%</div>
            <div class="stat-title">Articles in compliance</div>
            <div class="stat-desc text-success">75/100</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3 h-96">

        <div class="bg-base-100 rounded-md p-3 overflow-x-auto shadow-md">
            <h2 class="text-center font-bold">Articles</h2>

            @for ($i = 0; $i < 10; $i++)
                <div class="collapse collapse-arrow bg-base-200 mt-3">
                    <input type="checkbox" />
                    <div class="collapse-title">
                        <i class="fa-regular fa-paste"></i> Articulo #{{ $i }}
                    </div>
                    <div class="collapse-content bg-base-300">
                        @for ($j = 0; $j < 5; $j++)
                            <div class="form-control transition-font-weight hover:font-bold">
                                <label class="label cursor-pointer">
                                    <span class="label-text"> Articulo {{ $j }}</span>
                                    <input type="button" name="goTo{{ $j }}"
                                        onclick="alert('hi {{ $j }}')">
                                    <div class="text-xs">
                                        <span class="text-primary">1</span> de <span class="">10</span> <i
                                            class="fa-regular fa-clipboard"></i>
                                    </div>
                                </label>
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor
        </div>

        <div id="container" class="rounded-md shadow-md">

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
        <form action="" method="POST">
            @method('POST')
            <button type="submit" class="btn btn-primary w-full">Mass upload</button>
        </form>

        <a href="{{ route('laws.index') }}" class="btn btn-neutral ">Go back</a>

        <form action="{{ route('laws.destroy', ['law' => $law]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error w-full">
                Archive law
            </button>
        </form>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/laws/compliance_chart.js'])
@endpush
