@extends('layouts.base')

@section('main')
    <div class="flex w-full flex-col border-opacity-50">
        <div class="divider">Law compliance</div>
    </div>

    <div class="flex flex-row flex-wrap gap-3 items-center justify-center">

        @for ($i = 0; $i < 10; $i++)
            <x-laws.card></x-laws.card>
        @endfor

    </div>
@endsection
