@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>"{{ strtoupper($article->article_name) }}"</strong> status
    </div>

    <div class="mb-3 flex justify-end">
        <a href="{{ route('items.create', ['article' => $article->id]) }}" class="btn btn-sm btn-success">Create new item</a>
    </div>

    <section class="bg-base-100 rounded-md shadow-md mb-3">
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Compliant</th>
                        <th>View</th>
                        <th>Delete</th>
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
                                    <input type="checkbox" class="checkbox checkbox-sm"
                                        {{ $item->item_is_informative ? 'disabled checked' : '' }}
                                        {{ $item->item_is_complete ? 'checked' : '' }} />
                                </label>
                            </td>
                            <td>
                                <a class="btn btn-xs ghost" href="{{ route('items.edit', ['item' => $item]) }}">
                                    <span class="max-sm:hidden">
                                        Edit
                                    </span>
                                    <i class="fa-solid fa-gears"></i>
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('items.destroy', ['item' => $item]) }}"
                                    onsubmit="return confirm('Do you really want to delete this item')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-error">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
        <button id="save" type="button" class="btn btn-primary">Save</button>
        <a href="{{ route('laws.show', ['law' => $article->law_id]) }}" class="btn btn-neutral">Go back</a>
        <form method="POST" enctype="multipart/form-data"
            onsubmit="return confirm('Do you really want to delete this article?')"
            action="{{ route('articles.destroy', ['article' => $article]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error w-full">Delete article</button>
        </form>
    </div>
@endsection
