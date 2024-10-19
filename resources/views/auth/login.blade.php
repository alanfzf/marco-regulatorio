<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        @vite(['resources/sass/app.scss'])
    </head>
    <body>
        <div class="hero bg-base-200 min-h-screen">
            <div class="hero-content flex-col lg:flex-row-reverse">
                <div class="text-center">
                    <h1 class="text-3xl">Compliance system</h1>
                    <h2 class="text-xl">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </h2>
                </div>
                <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">

                    <form class="card-body" route="{{ route('auth.login') }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input name="email" type="email" placeholder="email" class="input input-bordered"
                                required />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Password</span>
                            </label>
                            <input name="password" type="password" placeholder="password" class="input input-bordered"
                                required />
                        </div>

                        @if ($errors->any())
                            <span class="text-xs text-error">Error: {{ implode(', ', $errors->all()) }}</span>
                        @endif

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
