@extends('layouts.base')

@section('main')
    <div class="divider">
        Viewing company <strong>"{{ $company->company_name }}"</strong>
    </div>

    <a href="{{ route('companies.index') }}" class="btn btn-neutral">Go back</a>


    <div class="overflow-x-auto bg-base-100 shadow-md rounded-md mt-3">
        <table class="table table-zebra">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>User</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @foreach ($company->users as $i => $user)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->roles[0]->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
