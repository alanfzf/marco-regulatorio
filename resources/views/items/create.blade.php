@extends('layouts.base')

@section('main')
    <div class="divider">
        Create new item
    </div>

    <form action="{{ route('items.store', ['law' => $law, 'article' => $article]) }}" method="POST"
        enctype='multipart/form-data'>
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
            <label class="form-control w-full ">
                <div class="label">
                    <span class="label-text">Item title</span>
                </div>
                <input type="text" class="input input-bordered w-full" name="item_title" />
            </label>

            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text">Informative</span>
                    <input name="item_is_informative" type="checkbox" class="checkbox" />
                </label>
            </div>

            <label class="form-control">
                <div class="label">
                    <span class="label-text">Item description</span>
                </div>
                <textarea class="textarea textarea-bordered" name='item_description'></textarea>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('articles.show', ['law' => $law, 'article' => $article]) }}" class="btn btn-neutral">Go back</a>
    </form>
@endsection
