@extends('layouts.base')

@section('main')
    <div class="divider">
        Edit user
    </div>

    <form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Name</span>
                </div>
                <input name="name" type="text" placeholder="Type here" value="{{ $user->name }}"
                    class="input input-bordered w-full " />
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Email</span>
                </div>
                <input name="email" type="email" value="{{ $user->email }}" class="input input-bordered w-full shadow"
                    disabled />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Password</span>
                </div>
                <input name="password" type="password" placeholder="Type new password"
                    class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Confirm password</span>
                </div>
                <input name="password_confirmation" type="password" placeholder="Confirm new password"
                    class="input input-bordered w-full" />
            </label>
            <x-select id="role" title="Role" :required="true" :options="$roles" :value="$user->roles[0]->id" />
            <x-select id="company_id" title="Company" :required="true" :options="$companies" :value="$user->company_id" />
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Edit user</button>
            <a href="{{ route('users.index') }}" class="btn btn-neutral">Go back</a>
        </div>
    </form>
@endsection
