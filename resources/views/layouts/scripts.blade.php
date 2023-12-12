{{-- <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
--}}
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
{{-- <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script
    src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-1.13.6/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.10.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.2.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js">
</script>

{{-- <script>
    function changeText(btn) {
    btn.innerText = 'Please wait...'; // Change the button text to indicate submission
    btn.disabled = true; // Disable the button to prevent multiple submissions
       btn.form.submit(); // Submit the form
   return true;
    }
</script> --}}
{{-- --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('create');
        const form = document.getElementById('update');
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
                        // If user confirms, disable the activate button
                        // loadingButton.disabled = true;

                        // Show message indicating activation in progress
                        Swal.fire({
                            title: 'Please wait',
                            text: 'Activating attestation...',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false
                        });

                        // Simulate activation process (replace with actual logic)
                        setTimeout(function() {
                            // Upon successful activation, redirect or perform other actions
                          form.submit();
                            // window.location.href = '/success'; // Replace '/success' with your success route
                        }); // Replace 3000 with the duration of your activation process in milliseconds
                    }
                });
            }
        });
    });
</script>


<script>
    $(function() {
		// Initialize DataTable for elements with class 'datatable'
		$("#example1").DataTable({
		  "responsive": false,
		  "lengthChange": false,
		  "autoWidth": false,
		  "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		}).buttons().container().appendTo('.col-md-12:eq(0)');

		// Check if #example2 already has DataTable initialized
		if (!$.fn.DataTable.isDataTable('#example2')) {
			// If not initialized, then initialize DataTable
			$('#example2').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"ordering": false,
				"info": true,
				"autoWidth": true,
				"responsive": true
			});
		}
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
        //
        // const form = document.getElementById('myForm');

        // Add an event listener to the package select element
                packageSelect.addEventListener("change", function() {
                var selectedPackageId = packageSelect.value;
                if (selectedPackageId === "7" || selectedPackageId === "8" || selectedPackageId ===
                "9" ||
                selectedPackageId === "10" || selectedPackageId === "11" || selectedPackageId ===
                "12") {
                // Display the RTGS Account Number field
                accountNumber.style.display = "block";
                // Hide the FMDQ Account Number field
                FMDQ.style.display = "none";
                } else {
                // Hide the FMDQ Account Number field
                // FMDQ.style.display = "none";
                accountNumber.style.display = "none";
                }
                });

		// //
		// form.addEventListener('submit', function(event) {
		// 	event.preventDefault(); // Prevent default form submission

        //     // Check if the form is valid
        //     if (form.checkValidity()) {
        //         // Show SweetAlert confirmation
        //         Swal.fire({
        //             title: 'Are you sure?',
        //             text: 'Are you sure you want to submit?',
        //             icon: 'question',
        //             showCancelButton: true,
        //             confirmButtonColor: '#1D326C',
        //             cancelButtonColor: '#969698',
        //             confirmButtonText: 'Yes, go ahead',
        //             cancelButtonText: 'No, cancel'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 // If user confirms, disable the activate button
        //                 // loadingButton.disabled = true;

        //                 // Show message indicating activation in progress
        //                 Swal.fire({
        //                     title: 'Please wait.....',
        //                     // text: 'Activating attestation...',
        //                     icon: 'info',
        //                     allowOutsideClick: false,
        //                     allowEscapeKey: false,
        //                     showConfirmButton: false
        //                 });
        //                 form.submit();
        //                 // // Simulate activation process (replace with actual logic)
        //                 // setTimeout(function() {
        //                 //     // Upon successful activation, redirect or perform other actions
        //                 //   form.submit();
        //                 //     // window.location.href = '/success'; // Replace '/success' with your success route
        //                 // }, 3000); // Replace 3000 with the duration of your activation process in milliseconds
        //             }
        //         });
        //     }
        // });
    });
</script>