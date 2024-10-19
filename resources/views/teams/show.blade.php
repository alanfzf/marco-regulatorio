@extends('layouts.base')

@section('main')
    <div class="divider">
        Team management
    </div>

    <div class="overflow-x-auto bg-base-100 shadow-md rounded">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th></th>
                    <th>Law</th>
                    <th>Description</th>
                    <th>Publish date</th>
                    <th>Manage team</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laws as $index => $law)
                    <tr>
                        <th>{{ $index + 1 }}</th>
                        <td>{{ $law->law_name }}</td>
                        <td>{{ $law->law_description }}</td>
                        <td>{{ $law->law_publish_date }}</td>
                        <td>
                            <a href="{{ route('teams.users', ['law' => $law]) }}" class="btn btn-xs ghost">
                                <span class="max-sm:hidden">
                                    Manage
                                </span>
                                <i class="fa-solid fa-users-gear"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
