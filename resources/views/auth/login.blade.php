@extends('layouts.app')

@section('title', 'Login')

@push('custom-css')
    <style>
        html, body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('https://png.pngtree.com/background/20230519/original/pngtree-sunlit-river-runs-through-a-lush-green-forest-picture-image_2652088.jpg') !important;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .login-container {
            max-width: 900px;
            padding: 20px;
            background-color: rgba(248, 249, 250, 0.85); /* Semi-transparent background */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .login-form {
            flex: 1;
            padding-right: 20px;
        }

        .login-info {
            flex: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-left: 20px;
            border-left: 1px solid #ddd;
        }

        .login-info h1 {
            margin-bottom: 20px;
        }

        .login-info img {
            margin: 0 auto 20px auto; /* Centers the image horizontally and adds space below */
            max-width: 250px;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-info {
                border-left: none;
                border-top: 1px solid #ddd;
                padding-left: 0;
                padding-top: 20px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="login-container">
        <div class="login-form">
            <h2 class="mb-4 text-center">{{ __('Login') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3 form-floating">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}" required autofocus>
                    <label for="email" class="form-label">Email Address</label>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required>
                    <label for="password" class="form-label">Password</label>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>

        <div class="login-info">
            <h1 class="h3">Waste Management System</h1>
            <img src="https://dhillonmedicalcentre.com/wp-content/uploads/2023/10/cropped-Dhillon-Medical-Centre.png"
                 alt="Logo" class="img-thumbnail">
            <p class="mt-3">© {{ now()->year }} Waste Management System. All rights reserved.</p>
        </div>
    </div>
@endsection
