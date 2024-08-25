<section>
    <div class="flex w-full flex-col border-opacity-50">
        <div class="divider">Law compliance</div>
    </div>
    <div class="flex flex-row gap-3 mb-5">
        <label class="input input-bordered flex items-center gap-2 w-full" wire:model.live="search">
            <input type="text" class="grow" placeholder="Search" maxlength="50" />
            <i class="fa-solid fa-magnifying-glass"></i>
        </label>

        <a class="btn btn-success" href="{{ route('laws.create') }}">
            Add new Law <i class="fa-solid fa-gavel"></i>
        </a>
    </div>

    <div class="flex flex-row flex-wrap gap-3 items-center justify-center" wire:loading.flex>
        @for ($i = 0; $i < 10; $i++)
            <x-laws.card-skeleton></x-laws.card-skeleton>
        @endfor
    </div>

    <div class="flex flex-row flex-wrap gap-3 items-center justify-center" wire:loading.remove>
        @foreach ($laws as $law)
            <x-laws.card href="{{ route('laws.show', ['law' => $law['id']]) }}" :law="$law" />
        @endforeach
    </div>
</section>
