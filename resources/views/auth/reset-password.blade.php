<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>RITCC - Forgot Password</title>

    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <img class="img-fluid logo-dark mb-2" src="{{ asset('assets/img/FMDQLogo.png') }}" alt="Logo">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Reset your password</h1>
                            <div class="">
                                <p style="color: red"><strong>Password must contain at least six characters</strong>
                                </p>
                                <p style="color: red"><strong>Password must be different from username</strong></p>
                                <p style="color: red"><strong>Password must contain at least one number
                                        (0-9)</strong></p>
                                <p style="color: red"><strong>Password must contain at least one lowercase
                                        letter (a-z)</strong></p>
                                <p style="color: red"><strong>Password must contain at least one uppercase
                                        letter (A-Z)</strong></p>
                            </div>
                            <hr>
                            {{-- <p class="account-subtitle">Enter your email to get a password reset link</p> --}}

                            <form action="{{ route('post.resetPassword') }}" class="needs-validation confirmation"
                                method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label class="form-control-label">Email Address</label>
                                    <input class="form-control" type="email" name="email" value="{{ $email }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-control-label">Password</label>
                                    <input type="password" id="password" class="form-control" name="password" required
                                        autofocus>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="form-control-label">Confirm
                                        Password</label>
                                    <input type="password" id="password-confirm" class="form-control"
                                        name="password_confirmation" required autofocus>
                                    @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-lg btn-block btn-primary w-100" type="submit">Reset
                                        Password</button>
                                </div>
                            </form>

                            <div class="text-center dont-have">Remember your password? <a
                                    href="{{ route('login') }}">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('auth.scripts')
</body>

</html>