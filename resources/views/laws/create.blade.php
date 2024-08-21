@extends('layouts.base')

@section('main')
    {{-- TODO: maybe refactor this out of here --}}
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


    <div class="flex w-full flex-col border-opacity-50">
        <div class="divider">Create new law
            <i class="fa-solid fa-gavel"></i>
        </div>
    </div>

    <form method="POST" action="{{ route('laws.store') }}" enctype='multipart/form-data'>
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

            <label class="form-control w-full ">
                <div class="label">
                    <span class="label-text">Law name</span>
                </div>
                <input type="text" class="input input-bordered w-full" name="law_name" />
            </label>

            <label class="form-control w-full ">
                <div class="label">
                    <span class="label-text">Law reference (URL)</span>
                </div>
                <input type="text" class="input input-bordered w-full" name="law_url_reference" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Law publish date</span>
                </div>
                <input type="date" class="input input-bordered w-full" name="law_publish_date" />
            </label>

            <label class="form-control w-full ">
                <div class="label">
                    <span class="label-text">Law image</span>
                </div>
                <input type="file" class="file-input file-input-bordered w-full" name="law_image" />
            </label>

            <label class="form-control">
                <div class="label">
                    <span class="label-text">Law description</span>
                </div>
                <textarea class="textarea textarea-bordered" name='law_description'></textarea>
            </label>

            {{-- fix for grid jump --}}
            <div>
                &nbsp;
            </div>

            <a href="{{ route('laws.index') }}" class="btn btn-neutral">Volver</a>
            <button type="submit" class="btn btn-primary">
                Guardar
            </button>
        </div>
    </form>
@endsection
