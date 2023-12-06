<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>RITCC - Login</title>

    {{--
    <link rel="shortcut icon" href="assets/img/favicon.png"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    {{--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> --}}
</head>

<body class="login">

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <img class="img-fluid logo-dark mb-2" src="{{ asset('assets/img/FMDQLogo.png') }}"
                                alt="Logo">
                            <h1></h1>
                            <p class="account-subtitle">Login to <b>Road Infrastructure Tax Credit Certificate
                                    Auctionining System Portal</b></p>
                            <form action="{{ route('signIn') }}" method="POST" autocomplete="on">
                                @csrf
                                <div class="form-group">
                                    <label class="form-control-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="form-control pass-input" required>
                                        <span class="fas fa-eye toggle-password"></span>
                                        {{-- <i class="bi bi-eye-slash"></i> --}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <a class="forgot-link" href="forgot-password.html">Forgot Password ?</a>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-lg btn-block btn-primary w-100" type="submit"
                                    onclick="changeText(this);">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/script.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
Swal.fire({
icon: 'error',
title: 'Validation Error',
html: `{!! implode("<br>", $errors->all()) !!}`,
showConfirmButton: true,
confirmButtonColor: "#23346A",
});
 @elseif (session('success'))
Swal.fire({
icon: 'success',
title: 'Success',
text: '{{ session('success') }}',
showConfirmButton: true,
confirmButtonColor: "#23346A",
});
@elseif (session('info'))
Swal.fire({
icon: 'info',
// title: 'Informa',
text: '{{ session('info') }}',
showConfirmButton: true,
confirmButtonColor: "#23346A",
});
@endif
    </script>
</body>

</html>