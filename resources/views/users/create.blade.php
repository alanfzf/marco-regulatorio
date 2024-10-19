@extends('layouts.base')

@section('main')
    <div class="divider">
        Users
    </div>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Name</span>
                </div>
                <input name="name" type="text" placeholder="Type here" class="input input-bordered w-full " />
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Email</span>
                </div>
                <input name="email" type="email" placeholder="Type here" class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Password</span>
                </div>
                <input name="password" type="password" placeholder="Type here" class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Confirm password</span>
                </div>
                <input name="password_confirmation" type="password" placeholder="Type here"
                    class="input input-bordered w-full" />
            </label>
            <x-select id="role" title="Role" :required="true" :options="$roles" />
            <x-select id="company_id" title="Company" :required="true" :options="$companies" />
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Create user</button>
            <a href="{{ route('users.index') }}" class="btn btn-neutral">Go back</a>
        </div>
    </form>
@endsection
