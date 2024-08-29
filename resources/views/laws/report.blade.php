@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>{{ $law->law_name }}</strong> general report
    </div>

    <h1 class="text-xl font-bold">Metrics</h1>
    <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Compliant articles</div>
                <div class="stat-desc">21% more than last month</div>

                <div class="stat-value">89,400</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Non compliant articles</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Validated items</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Non validated items</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Nivel de cumplimiento</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Comentarios</div>
                <div class="stat-value">89,400</div>
                <div class="stat-desc">21% more than last month</div>
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
