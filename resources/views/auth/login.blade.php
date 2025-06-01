@extends('layouts.template-auth')

@section('content')
    <h4>LOGIN</h4>
    <h6>Enter your Username and Password For Login or Signup</h6>
    <div class="card mt-4 p-4 mb-0">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert untuk Pesan Error (misalnya, kredensial salah) --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class="theme-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="col-form-label pt-0">Your Name</label>
                <input type="text" class="form-control form-control-lg" name="email" required>
            </div>
            <div class="mb-3">
                <label class="col-form-label">Password</label>
                <input type="password" class="form-control form-control-lg" name="password" required>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary">LOGIN</button>
                </div>
            </div>
        </form>
    </div>
@endsection
