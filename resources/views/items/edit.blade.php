@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>"{{ strtoupper($item->item_title) }}"</strong> edit
    </div>


    <form action="{{ route('items.update', ['item' => $item]) }}" method="POST" enctype='multipart/form-data'>
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
            <label class="form-control w-full ">
                <div class="label">
                    <span class="label-text">Item title</span>
                </div>
                <input type="text" class="input input-bordered w-full" name="item_title" value="{{ $item->item_title }}" />
            </label>

            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text">Informative</span>
                    <input name="item_is_informative" type="checkbox" {{ $item->item_is_informative ? 'checked' : '' }}
                        class="checkbox" />
                </label>
            </div>

            <label class="form-control">
                <div class="label">
                    <span class="label-text">Item description</span>
                </div>
                <textarea class="textarea textarea-bordered" name='item_description'>{{ $item->item_description }}</textarea>
            </label>

        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('articles.show', ['article' => $item->article_id]) }}" class="btn btn-neutral">Go back</a>
    </form>
@endsection
