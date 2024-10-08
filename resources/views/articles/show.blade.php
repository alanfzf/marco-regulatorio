@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>"{{ strtoupper($article->article_name) }}"</strong> status
    </div>


    <div class="mb-3 flex justify-end gap-3">

        <a href="{{ route('laws.show', ['law' => $law]) }}" class="btn btn-neutral btn-sm">Go back</a>
        @role('admin|auditor')
            <a href="{{ route('items.create', ['law' => $law, 'article' => $article]) }}" class="btn btn-sm btn-success">
                Create new item
            </a>

            <form method="POST" enctype="multipart/form-data"
                onsubmit="return confirm('Do you really want to delete this article?')"
                action="{{ route('articles.destroy', ['law' => $law, 'article' => $article]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-error w-full">Delete article</button>
            </form>
        @endrole
    </div>

    <section class="bg-base-100 rounded-md shadow-md mb-3">
        <div class="overflow-x-auto">
            <table class="table table-zebra" id="items_table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Compliance</th>
                        <th>Maturity level</th>
                        <th>Manage</th>
                        @role('admin|auditor')
                            <th>View</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($article->items as $index => $item)
                        <tr>
                            <td>{{ $item->item_title }}</td>
                            <td>
                                {{-- informative --}}
                                @if ($item->item_is_informative)
                                    <span class="text-xs italic">informative</span>
                                @else
                                    <span class="text-xs italic">non informative</span>
                                @endif
                            </td>


                            <td>
                                <label>
                                    @if ($item->maturity->maturity_level >= 1 || $item->item_is_informative)
                                        <i class="fa-solid fa-circle-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-circle-xmark text-error"></i>
                                    @endif
                                </label>
                            </td>
                            <td>
                                {{ $item->item_is_informative ? 'N/A' : $item->maturity->maturity_name }}
                            </td>
                            <td>
                                {{-- start modal --}}
                                <label for="desc_{{ $item->id }}" class="btn btn-xs ghost">
                                    <span class="max-sm:hidden">
                                        Manage
                                    </span>
                                    <i class="fa-solid fa-list-check"></i>

                                </label>
                                <!-- Put this part before </body> tag -->
                                <input type="checkbox" id="desc_{{ $item->id }}" class="modal-toggle" />
                                <div class="modal" role="dialog">
                                    <div class="modal-box">

                                        <h3 class="text-lg font-bold">Item {{ $item->item_title }}</h3>

                                        <h4 class="my-3">
                                            <i class="fa-solid fa-circle-info"></i>
                                            Description:
                                        </h4>
                                        <textarea class="textarea w-full" placeholder="Bio" disabled> {{ $item->item_description }} </textarea>

                                        <form method="POST" enctype="multipart/form-data"
                                            action="{{ route('items.comment', ['law' => $law, 'article' => $article, 'item' => $item]) }}">
                                            @csrf
                                            @method('PATCH')

                                            <label class="form-control">
                                                <div class="label">
                                                    <span class="label-text">
                                                        <i class="fa-solid fa-comment"></i>
                                                        Comment:
                                                    </span>
                                                </div>
                                                <textarea class="textarea textarea-bordered h-24" placeholder="Place a coment here.." name="item_comment"
                                                    {{ $item->item_is_informative ? 'disabled' : '' }}>{{ $item->item_comment }}</textarea>
                                            </label>

                                            @php
                                                $levels = [
                                                    1 => 'Incomplete (0)',
                                                    2 => 'Initial (1)',
                                                    3 => 'Managed (2)',
                                                    4 => 'Defined (3)',
                                                    5 => 'Quantitatively Managed (4)',
                                                    6 => 'Optimizing (5)'
                                                ];

                                            @endphp
                                            <x-select title="Maturity level" id="maturity_id"
                                                required="{{ true }}" :value="$item->maturity->id" :options="$levels"
                                                :disabled="$item->item_is_informative" />


                                            <label class="form-control w-full max-w-xs">
                                                <div class="label">
                                                    <span class="label-text">Evidence</span>
                                                </div>
                                                <input id="item_evidence" name="item_evidence" type="file"
                                                    class="file-input file-input-bordered w-full max-w-xs"
                                                    {{ $item->item_is_informative ? 'disabled' : '' }} />
                                            </label>

                                            @if ($item->item_evidence)
                                                <div class="mt-3">
                                                    <a class="link link-primary"
                                                        href="{{ Utils::storageFile($item->item_evidence) }}"
                                                        target="_blank">Visualizar evidencia</a>
                                                </div>
                                            @endif




                                            <div class="flex justify-end mt-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>

                                    </div>
                                    <label class="modal-backdrop" for="desc_{{ $item->id }}">Close</label>
                                </div>
                                {{-- end modal --}}
                            </td>

                            @role('admin|auditor')
                                <td>
                                    <a class="btn btn-xs ghost"
                                        href="{{ route('items.edit', ['law' => $law, 'article' => $article, 'item' => $item]) }}">
                                        <span class="max-sm:hidden">
                                            Edit
                                        </span>
                                        <i class="fa-solid fa-gears"></i>
                                    </a>
                                </td>
                            </tr>
                        @endrole
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    @vite(['resources/js/articles/validate.js'])
@endpush
