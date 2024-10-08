@extends('layouts.base')

@section('main')
    @php
        $articles = $law->articles_count;
        $compliance = $law->compliance_articles;
        $non_compliance = $articles - $compliance;
        $compliance_percentage = round(($compliance / max($articles, 1)) * 100, 2);
        $non_compliance_percentage = round(($non_compliance / max($articles, 1)) * 100, 2);
    @endphp



    <div class="flex w-full flex-col border-opacity-50">
        <div class="divider">
            <strong>"{{ strtoupper($law->law_name) }}"</strong> compliance status
        </div>
    </div>


    <div class="stats shadow mb-3 w-full">
        <div class="stat">
            <div class="stat-figure text-info">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="stat-title">In complaince</div>
            <div class="stat-value text-info">{{ $compliance }}</div>
            <div class="stat-desc">{{ $compliance_percentage }}% of articles</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-error">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="stat-title">Not in compliance</div>
            <div class="stat-value text-error">{{ $non_compliance }}</div>
            <div class="stat-desc">{{ $non_compliance_percentage }}% of articles</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-success">
                <i class="fa-solid fa-chart-simple"></i>
            </div>
            <div class="stat-title">Total articles</div>
            <div class="stat-value text-success">{{ $articles }}</div>
            <div class="stat-desc">Overall compliance {{ $compliance }}/{{ $articles }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3 h-96">

        <div class="bg-base-100 rounded-md p-3 overflow-x-auto shadow-md">
            <div class="flex flex-row justify-between mb-3">
                <h2 class="text-center font-bold"><i class="fa-solid fa-newspaper"></i> Articles </h2>

                @role('admin|auditor')
                    <label for="create_article" class="btn btn-xs ghost">
                        <i class="fa-solid fa-plus"></i>
                        <span class="max-sm:hidden">
                            Add new article
                        </span>
                    </label>
                    <input type="checkbox" id="create_article" class="modal-toggle" />
                    <div class="modal" role="dialog">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Add new article</h3>
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('articles.store', ['law' => $law->id]) }}">
                                @csrf
                                <input type="text" class="input input-bordered w-full input-sm" name="article_name"
                                    required />
                                <button type="submit" class="btn btn-primary btn-sm mt-3">Create new article</button>
                            </form>
                        </div>
                        <label class="modal-backdrop" for="create_article">Close</label>
                    </div>
                @endrole
                {{-- form end  --}}
            </div>
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Article</th>
                        <th>Compliance status</th>
                        @hasanyrole('admin|auditor')
                            <th>View</th>
                        @endhasanyrole
                    </tr>
                </thead>
                <tbody>

                    @foreach ($law->articles as $index => $article)
                        @php
                            $items = $article->items->toArray();
                            $all = count($items);
                            $count = count(
                                array_filter($items, function ($item) {
                                    return $item['item_is_informative'] == 1 ||
                                        $item['maturity']['maturity_level'] >= 1;
                                })
                            );
                        @endphp

                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <td>
                                <i class="fa-regular fa-paste"></i> {{ $article->article_name }}
                            </td>
                            <td>
                                <div class="text-xs">
                                    <span class="text-primary">{{ $count }}</span> of <span
                                        class="">{{ $all }}</span>
                                    <i class="fa-solid fa-list-check"></i>
                                </div>
                            </td>

                            @hasanyrole('admin|auditor')
                                <td>
                                    <a class="btn btn-ghost btn-xs"
                                        href="{{ route('articles.show', ['law' => $law, 'article' => $article]) }}">details</a>
                                </td>
                            </tr>
                        @endhasanyrole
                    @endforeach
                </tbody>
            </table>

        </div>

        <div id="container" class="rounded-md shadow-md">

        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
        <a href="{{ route('laws.index') }}" class="btn btn-neutral ">Go back</a>


        @hasanyrole('admin|executive')
            <a href="{{ route('laws.report', ['law' => $law]) }}" class="btn btn-success">See detailed report</a>
        @endhasanyrole
        @role('admin')
            {{-- empieza modal --}}
            <label for="massupload" class="btn btn-primary">
                Mass upload
            </label>

            <input type="checkbox" id="massupload" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <form action="{{ route('laws.upload', ['law' => $law]) }}" method="POST" enctype='multipart/form-data'>
                        @csrf
                        <h3 class="text-lg font-bold mb-3">Mass upload of articles</h3>
                        <input type="file" name="articles" class="file-input file-input-bordered file-input-sm mb-3"
                            required />
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
                <label class="modal-backdrop" for="massupload">Close</label>
            </div>
            {{-- termina modal --}}

            <a href="{{ route('laws.edit', ['law' => $law->id]) }}" class="btn btn-info">Edit</a>

            <form action="{{ route('laws.destroy', ['law' => $law]) }}" method="POST"
                onsubmit="return confirm('Do you really want to archive this law?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error w-full">
                    Archive law
                </button>
            </form>
        @endrole
    </div>
@endsection

@push('scripts')
    <script>
        window.compliance = @js(['in_complaince' => $compliance_percentage, 'non_complaince' => $non_compliance_percentage])
    </script>
    @vite(['resources/js/laws/compliance_chart.js'])
@endpush
