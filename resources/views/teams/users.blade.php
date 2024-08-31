@extends('layouts.base')

@section('main')
    <div class="divider">
        User managment for <strong>{{ $law->law_name }}</strong>
    </div>

    <form action="{{ route('teams.update', ['law' => $law]) }}" method="POST">
        <div class="overflow-x-auto bg-base-100 shadow-md rounded">
            @csrf
            @method('PATCH')
            {{-- start table --}}
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th></th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Member</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles[0]->name }}</td>
                            <td>
                                <input name="team_users[{{ $user->id }}]" type="checkbox"
                                    {{ $user->is_part_of_law ? 'checked' : '' }} class="checkbox" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- end table --}}
        </div>

        <div class="mt-4">
            <a href="{{ route('teams.show') }}" class="btn btn-neutral">Go back</a>
            <button type="submit" class="btn btn-primary">Update team members</button>
        </div>

    </form>
@endsection
