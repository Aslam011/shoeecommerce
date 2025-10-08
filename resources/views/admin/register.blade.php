@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-dark text-white">
                    <h4>Admin Register</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.register.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" class="form-control" required autofocus>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
