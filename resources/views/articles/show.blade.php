@extends('layouts.base')

@section('main')
    <div class="divider">
        <strong>"{{ strtoupper($article->article_name) }}"</strong> status
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
                                <a class="btn btn-xs ghost" href="#">
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
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ url()->previous() }}" class="btn btn-neutral">Go back</a>
@endsection
