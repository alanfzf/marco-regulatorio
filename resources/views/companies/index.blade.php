@extends('layouts.base')

@section('main')
    <div class="divider">
        Companies
    </div>

    <label for="create_company" class="btn btn-success">
        <i class="fa-solid fa-plus"></i>
        <span class="max-sm:hidden">
            Create company
        </span>
    </label>
    <input type="checkbox" id="create_company" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Add new company</h3>
            <form method="POST" enctype="multipart/form-data" action="{{ route('companies.store') }}">
                @csrf
                <input type="text" class="input input-bordered w-full input-sm" name="company_name" required />
                <button type="submit" class="btn btn-primary btn-sm mt-3">Create new company</button>
            </form>
        </div>
        <label class="modal-backdrop" for="create_company">Close</label>
    </div>


    <div class="overflow-x-auto bg-base-100 shadow-md rounded-md mt-3">
        <table class="table table-zebra">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Company name</th>
                    <th>Number of members</th>
                    <th>Manage</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @foreach ($companies as $i => $company)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td>{{ $company->company_name }}</td>
                        <td>{{ $company->users_count }}</td>
                        <td>
                            {{-- start edit modal --}}
                            <label for="edit_company" class="btn btn-xs btn-primary">
                                <i class="fa-solid fa-edit"></i>
                                <span class="max-sm:hidden">
                                    Edit company
                                </span>
                            </label>
                            <input type="checkbox" id="edit_company" class="modal-toggle" />
                            <div class="modal" role="dialog">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Edit company</h3>
                                    <form method="POST" enctype="multipart/form-data"
                                        action="{{ route('companies.update', ['company' => $company]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" class="input input-bordered w-full input-sm"
                                            name="company_name" required />
                                        <button type="submit" class="btn btn-primary btn-sm mt-3">Edit company</button>
                                    </form>
                                </div>
                                <label class="modal-backdrop" for="edit_company">Close</label>
                            </div>
                            {{-- end edit modal --}}
                        </td>
                        <td>
                            <a href="{{ route('companies.show', ['company' => $company]) }}"
                                class="btn btn-xs btn-neutral">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
