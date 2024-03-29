<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script> --}}
{{-- <script
    src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.6/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.10.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.2.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js">
</script> --}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script
    src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js">
</script>
{{-- <script>
    // Reload the page every 10 seconds
    setInterval(function(){
        location.reload();
    }, 10000);
</script> --}}

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
                        title: 'Are you sure you wamt to submit?',
                        // text: 'Are you sure you want to submit?',
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

{{-- --}}
<script>
    $(function() {
		// Initialize DataTable for elements with class 'datatable'
     		$("#example1").DataTable({
		  "responsive": true,
		  "lengthChange": false,
		  "autoWidth": false,
          "paging": true,
          "searching": true,
          "ordering": false,
          "info": false,
          "dom": 'Bfrtip',
		  "buttons": ["copy", "csv", "excel", "pdf", "print"]
		});
	});
</script>

<script>
    @if ($errors->any())
		Swal.fire({
			icon: 'error',
			title: 'Validation Error',
			html: `{!! implode('<br>', $errors->all()) !!}`,
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
        //
        var packageSelect = document.getElementById("packageSelect");
        var accountNumber = document.getElementById("accountNumber");
        // Add an event listener to the package select element
                packageSelect.addEventListener("change", function() {
                var selectedPackageId = packageSelect.value;
                if (selectedPackageId === "7" || selectedPackageId === "8" || selectedPackageId ===
                "9" ||
                selectedPackageId === "10" || selectedPackageId === "11" || selectedPackageId ===
                "12") {
                // Display the RTGS Account Number field
                accountNumber.style.display = "block";
                accountNumber.setAttribute("required", true);
                // Hide the FMDQ Account Number field
                FMDQ.style.display = "none";
                } else {
                // Hide the FMDQ Account Number field
                // FMDQ.style.display = "none";
                accountNumber.style.display = "none";
                accountNumber.removeAttribute("required");
                }
                });
	    });
</script>