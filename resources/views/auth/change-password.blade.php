<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>RITCC - Change Password</title>
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}">
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
                <img class="img-fluid logo-dark mb-2" src="{{ asset('assets/img/FMDQLogo.png') }}" alt="Logo">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
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
                            <h1>Update Password</h1>
                            {{-- <h4 class="account-subtitle">Change Your Password</h4> --}}
                            <form action="{{ route('updatePassword') }}" class="needs-validation confirmation"
                                method="POST" novalidate>
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                    <label class="form-control-label">Default Password</label>
                                    <input type="password" name="default" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">New Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="form-control pass-input" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Confirm New Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password_confirmation"
                                            class="form-control pass-input" required>
                                    </div>
                                </div>

                                <button class="btn btn-lg btn-block btn-primary w-100" type="submit">Change
                                    Password</button>
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
    			html: `{!! implode('<br>', $errors->all()) !!}`,
    			showConfirmButton: true,
    			confirmButtonColor: "#23346A",
    		});
    	@elseif (session('error'))
    		Swal.fire({
    			icon: 'error',
    			title: 'Error',
    			text: '{{ session('error') }}',
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
    {{-- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.confirmation');

            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent default form submission
                    // Check if the form is valid
                    if (form.checkValidity()) {
                        // Show SweetAlert confirmation
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'Are you sure you want to submit?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#1D326C',
                            cancelButtonColor: '#969698',
                            confirmButtonText: 'Yes, go ahead',
                            cancelButtonText: 'No, cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show message indicating action in progress
                                Swal.fire({
                                    text: 'Please wait...',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false
                                });
                                // Simulate action process (replace with actual logic)
                                setTimeout(function() {
                                    form.submit(); // Submit the form
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>