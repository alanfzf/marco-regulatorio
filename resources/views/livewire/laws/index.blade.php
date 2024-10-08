<section>
    @php
        $user = auth()->user();
    @endphp



    <h1 class="text-xl font-bold">Welcome, {{ $user->name }} </h1>
    <h2 class="text-sm"><i class="fa-solid fa-id-badge"></i> <strong>Role:</strong> {{ $user->roles[0]->name }}</h2>
    <h2 class="text-sm"><i class="fa-solid fa-building"></i> <strong>Company:</strong>
        {{ $user?->company?->company_name ?? 'N/A' }}
    </h2>


    <div class="flex w-full flex-col border-opacity-50">
        <div class="divider">Law compliance</div>
    </div>
    <div class="flex flex-row gap-3 mb-5 justify-center">
        <label class="input input-bordered flex items-center gap-2 w-full md:w-1/3" wire:model.live="search">
            <input type="text" class="grow" placeholder="Search" maxlength="50" />
            <i class="fa-solid fa-magnifying-glass"></i>
        </label>

        @role('admin')
            <a class="btn btn-success" href="{{ route('laws.create') }}">
                <span class="max-sm:hidden">
                    Add new Law
                </span>
                <i class="fa-solid fa-gavel"></i>
            </a>
        @endrole
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
