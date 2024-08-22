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
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title text-md">
                        <i class="fa-regular fa-paste"></i> Articulo #{{ $i }}
                    </div>
                    <div class="collapse-content">
                        @for ($j = 0; $j < 5; $j++)
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text"> Articulo {{ $j }}</span>
                                    <input type="checkbox" {{ rand(0, 1) ? 'checked="checked"' : '' }}
                                        class="checkbox checkbox-primary" disabled />
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



    <button type="button" class="btn btn-primary w-1/5">Mass upload</button>
    <a href="{{ route('laws.index') }}" class="btn btn-neutral w-1/5">Volver</a>
@endsection

@push('scripts')
    @vite(['resources/js/laws/compliance_chart.js'])
@endpush
