@extends('layouts.base')

@section('main')
    <div class="divider">
        Users
    </div>

    <a class="btn btn-success" href="{{ route('users.create') }}">Add new user</a>

    <div class="overflow-x-auto bg-base-100 shadow-md rounded-md mt-3">
        <table class="table table-zebra">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @foreach ($users as $i => $user)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles[0]->name }}</td>
                        <td>
                            <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-xs btn-primary">Manage</a>
                        </td>
                    </tr>
                @endforeach



            </tbody>
        </table>
    </div>
@endsection
