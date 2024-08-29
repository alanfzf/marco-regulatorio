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

        $totalMaturityLevel = 0;
        $itemCount = 0;

        foreach ($law->articles as $article) {
            foreach ($article->items as $item) {
                $totalMaturityLevel += $item->maturity->maturity_level;
                $itemCount++;
            }
        }

        $averageMaturityLevel = $totalMaturityLevel / $itemCount;

    @endphp


    <h1 class="text-xl font-bold">Metrics</h1>
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
                <div class="font-bold">IDK</div>
                <div class="stat-desc">Overall score 3.33 </div>
            </div>
        </div>
    </section>


    <h2 class="text-lg font-bold my-3">Non compliant articles</h2>
    <div class="h-96 overflow-x-auto bg-base-100 rounded-md">
        <table class="table table-pin-rows z-0">
            @foreach ($law->articles as $article)
                <thead>
                    <tr class="bg-base-300">
                        <th>{{ $article['article_name'] }}</th>
                        <th>{{ $article['article_description'] }}</th>
                        <th class="text-right">
                            <div class="text-xs">
                                <span class="text-primary">{{ $article->compliant_items_count }}</span> of <span
                                    class="">{{ $article->all_items_count }}</span>
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($article->items as $item)
                        @php
                            $ok = $item->item_is_informative == 1 || $item->maturity->maturity_level >= 1;
                        @endphp
                        <tr>
                            {{-- TITLE --}}
                            <td @class([
                                'text-success' => $ok,
                                'text-error' => !$ok
                            ])>{{ $item['item_title'] }}</td>

                            {{-- COMMENTS --}}
                            <td class="text-right" colspan="2">
                                {{-- start modal --}}
                                <label for="desc_{{ $item['id'] }}" class="btn btn-xs ghost">
                                    <span class="max-sm:hidden">
                                        Comments
                                    </span>
                                    <i class="fa-regular fa-comment"></i>
                                </label>
                                <input type="checkbox" id="desc_{{ $item['id'] }}" class="modal-toggle" />
                                <div class="modal" role="dialog">
                                    <div class="modal-box">
                                        <h3 class="text-left text-lg font-bold">
                                            Item {{ $item['item_title'] }}
                                        </h3>

                                        <label class="form-control">
                                            <div class="label">
                                                <span class="label-text">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                    Maturity level
                                                </span>
                                            </div>
                                            <input class="input input-bordered"
                                                value="{{ $item->maturity->maturity_name }} ({{ $ok ? 'In complaince' : 'Not in complaince' }})"
                                                disabled />
                                        </label>


                                        <label class="form-control">
                                            <div class="label">
                                                <span class="label-text">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                    Description:
                                                </span>
                                            </div>
                                            <textarea class="textarea textarea-bordered h-24" disabled> {{ $item['item_description'] }} </textarea>
                                        </label>

                                        <label class="form-control">
                                            <div class="label">
                                                <span class="label-text">
                                                    <i class="fa-solid fa-comment"></i>
                                                    Comment:
                                                </span>
                                            </div>
                                            <textarea class="textarea textarea-bordered h-24" disabled>{{ $item['item_comment'] }}</textarea>
                                        </label>
                                    </div>
                                    <label class="modal-backdrop" for="desc_{{ $item['id'] }}">Close</label>
                                </div>
                                {{-- end modal --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endforeach
        </table>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/laws/report.js'])
@endpush
