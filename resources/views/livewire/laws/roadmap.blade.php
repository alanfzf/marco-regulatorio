<div>

    <h1 class="text-xl font-bold">Article Roadmap</h1>
    @php

        $options = [
            0 => 'Incomplete',
            1 => 'Initial',
            2 => 'Managed',
            3 => 'Defined',
            4 => 'Quantitatively Managed',
            5 => 'Optimizing'
        ];
    @endphp


    <div class="grid grid-cols-3 gap-3 mb-3 w-full">

        <div class="form-control">

            <label class="label" for="search">
                <span class="label-text">
                    Search
                </span>
            </label>
            <input type="text" name="search" class="input input-bordered" wire:model.live="search">

        </div>

        <x-select title="Maturity level" id="maturity_level" :options="$options" wire:model.change="type" />
    </div>

    <div wire:loading class='h-96'>
        <span class="loading loading-spinner loading-lg text-primary"></span>
    </div>

    @php
        $articles = $law->articles->filter(function ($article) {
            return $article->items->count() > 0;
        });
    @endphp


    <div class="h-96 overflow-x-auto bg-base-100 rounded-md shadow-md" wire:loading.remove>
        <table class="table table-pin-rows z-0">
            @foreach ($articles as $article)
                <thead>
                    <tr class="bg-base-300">
                        <th>{{ $article['article_name'] }}</th>
                        <th class="text-left"></th>
                        <th class="text-right">
                            <div class="text-xs">
                                <span>{{ count($article->items) }}</span>
                                <i class="fa-solid fa-newspaper"></i>
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
                            <td></td>

                            {{-- COMMENTS --}}
                            <td class="text-right">
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
                                                    <i class="fa-solid fa-layer-group"></i>
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
                                            <textarea class="textarea textarea-bordered h-48" disabled> {{ $item['item_description'] }} </textarea>
                                        </label>

                                        <label class="form-control">
                                            <div class="label">
                                                <span class="label-text">
                                                    <i class="fa-solid fa-comment"></i>
                                                    Comment:
                                                </span>
                                            </div>
                                            <textarea class="textarea textarea-bordered h-48" disabled>{{ $item['item_comment'] }}</textarea>
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


</div>
