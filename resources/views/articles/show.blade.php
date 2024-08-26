@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>"{{ strtoupper($article->article_name) }}"</strong> status
    </div>


    <div class="mb-3 flex justify-end gap-3">

        <a href="{{ route('laws.show', ['law' => $law]) }}" class="btn btn-neutral btn-sm">Go back</a>
        <a href="{{ route('items.create', ['law' => $law, 'article' => $article]) }}" class="btn btn-sm btn-success">Create
            new
            item</a>

        <form method="POST" enctype="multipart/form-data"
            onsubmit="return confirm('Do you really want to delete this article?')"
            action="{{ route('articles.destroy', ['law' => $law, 'article' => $article]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-error w-full">Delete article</button>
        </form>
    </div>

    <section class="bg-base-100 rounded-md shadow-md mb-3">
        <div class="overflow-x-auto">
            <table class="table table-zebra" id="items_table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Compliance</th>
                        <th>Manage</th>
                        <th>View</th>
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
                                    @if ($item->item_is_complete || $item->item_is_informative)
                                        <i class="fa-solid fa-circle-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-circle-xmark text-error"></i>
                                    @endif
                                </label>
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

                                        <form method="POST" enctype="multipart-form/data"
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
                                                <textarea class="textarea textarea-bordered h-24" placeholder="Place a coment here.." name="item_comment">{{ $item->item_comment }}</textarea>
                                            </label>

                                            <div class="form-control">
                                                <label class="label cursor-pointer">
                                                    <span class="label-text">
                                                        <i class="fa-solid fa-clipboard-list"></i>
                                                        Compliance:
                                                    </span>
                                                    <input name="item_is_complete" type="checkbox"
                                                        {{ $item->item_is_complete ? 'checked' : '' }} class="checkbox" />
                                                </label>
                                            </div>

                                            <div class="flex justify-end mt-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>


                                        </form>

                                    </div>
                                    <label class="modal-backdrop" for="desc_{{ $item->id }}">Close</label>
                                </div>
                                {{-- end modal --}}
                            </td>

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
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    @vite(['resources/js/articles/validate.js'])
@endpush
