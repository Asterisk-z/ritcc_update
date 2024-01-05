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
                });
            });
</script>