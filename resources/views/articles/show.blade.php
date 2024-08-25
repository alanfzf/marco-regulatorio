@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>"{{ strtoupper($article->article_name) }}"</strong> status
    </div>

    <div class="mb-3 flex justify-end gap-3">
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

    @if ($errors->any())
        <div role="alert" class="alert alert-error shadow-lg">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <h3 class="font-bold">Error</h3>

                @foreach ($errors->all() as $error)
                    <ul class="list-inside list-disc">
                        <li class="text-sm">{{ $error }}</li>
                    </ul>
                @endforeach
            </div>
        </div>
    @endif




    <form method="POST" enctype="multipart-form/data"
        action="{{ route('articles.validate_items', ['law' => $law, 'article' => $article]) }}">
        @csrf
        @method('PATCH')

        {{-- start the table --}}
        <section class="bg-base-100 rounded-md shadow-md mb-3">
            <div class="overflow-x-auto">
                <table class="table table-zebra" id="items_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Compliant</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($article->items as $index => $item)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $item->item_title }}</td>
                                <td>
                                    <!-- The button to open modal -->
                                    <label for="desc_{{ $item->id }}" class="btn btn-xs ghost">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span class="max-sm:hidden">
                                            See description
                                        </span>

                                    </label>
                                    <!-- Put this part before </body> tag -->
                                    <input type="checkbox" id="desc_{{ $item->id }}" class="modal-toggle" />
                                    <div class="modal" role="dialog">
                                        <div class="modal-box">
                                            <h3 class="text-lg font-bold">Item {{ $item->item_title }}</h3>
                                            <p class="py-4">{{ $item->item_description }}</p>
                                        </div>
                                        <label class="modal-backdrop" for="desc_{{ $item->id }}">Close</label>
                                    </div>
                                </td>

                                <td>
                                    {{-- informative --}}
                                    @if ($item->item_is_informative)
                                        <span class="text-xs italic">informative</span>
                                    @else
                                        <span class="text-xs italic">non informative</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- compliant --}}
                                    <label>
                                        <input id="{{ $item->id }}" type="checkbox" name="items[{{ $item->id }}]"
                                            class="checkbox checkbox-sm check-compliant laravel-check"
                                            {{ $item->item_is_informative ? 'disabled checked' : '' }}
                                            {{ $item->item_is_complete ? 'checked' : '' }} />
                                    </label>
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
        {{-- end the table --}}

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('laws.show', ['law' => $law]) }}" class="btn btn-neutral">Go back</a>
        </div>
    </form>
@endsection

@push('scripts')
    @vite(['resources/js/articles/validate.js']);
@endpush
