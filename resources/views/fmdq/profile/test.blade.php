@forelse ($profiles as $profile)
<tr>
    <td>{{ $i++; }}</td>
    <td>
        <h2 class="table-avatar">{{ $profile->firstName.' '.$profile->lastName }}
        </h2>
    </td>
    <td>{{ $profile->email }}</td>
    <td>{{ $profile->package->Name }}</td>
    <td>{{ $profile->institution->institutionName }}</td>
    {{-- <td>{{ date('F d, Y',strtotime($profile->inputDate))}}</td> --}}
    @if ($profile->status ==='0')
    <td><span class="badge bg-3">Pending Approval</span></td>
    @elseif($profile->status ==='1')
    <td><span class="badge bg-1">Approved</span></td>
    @elseif($profile->status ==='2')
    <td><span class="badge bg-2">Rejected</span></td>
    @elseif ($profile->status ==='3')
    <td><span class="badge bg-3">Pending Update</span></td>
    @elseif($profile->status ==='4')
    <td><span class="badge bg-3">Pending Delete</span></td>
    @endif
    <td class="d-flex align-items-center">
        <div class="dropdown dropdown-action">
            <a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i
                    class="fas fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <ul>
                    <li>
                        <a class="dropdown-item" href="edit-user.html"><i class="far fa-edit me-2"></i>View</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="edit-user.html"><i class="far fa-edit me-2"></i>Edit</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
                    </li>
                </ul>
            </div>
        </div>
    </td>
</tr>
@empty
{{ 'No information available yet' }}
@endforelse

{{-- --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('myForm');
        const loadingButton = document.getElementById('loadingButton'); // Replace with your button ID

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
                        loadingButton.disabled = true;

                        // Show message indicating activation in progress
                        Swal.fire({
                            title: 'Please wait',
                            text: 'Activating attestation...',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false
                        });
                    form.submit();
                        // // Simulate activation process (replace with actual logic)
                        // setTimeout(function() {
                        //     // Upon successful activation, redirect or perform other actions
                        //   form.submit();
                        //     // window.location.href = '/success'; // Replace '/success' with your success route
                        // }, 3000); // Replace 3000 with the duration of your activation process in milliseconds
                    }
                });
            }
        });
    });
</script>
{{-- create --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('myForm');
    const submitButton = document.getElementById('loading');
    const form = document.getElementById('update');
    const updateButton = document.getElementById('updateButton');

  form.addEventListener('submit', function(event) {
    //
    updateButton.disabled = true;
        // updateButton.innerHTML = 'Please wait...';
    event.preventDefault(); // Prevent default form submission

    // Check if the form is valid
    if (form.checkValidity()) {
      // Show SweetAlert confirmation
      updateButton.disabled = true;
      updateButton.innerHTML = 'Please wait...';
      Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to submit?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1D326C',
        cancelButtonColor: '#969698',
        confirmButtonText: 'Yes, go ahead',
        cancelButtonText:'No, cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // If user confirms, submit the form
          form.submit();
        }
      });
    }
  });
});
</script>

<table>
    <tr>
        <td>
            <div style="background-color: aliceblue; border-radius: 10px; ">
                <p>
                <h4>Password Policy</h4>
                </p>
                <p><img src="img/bullet2.png"> Password must contain at least six characters</p>
                <p><img src="img/bullet2.png"> Password must be different from username</p>
                <p><img src="img/bullet2.png"> Password must contain at least one number (0-9)</p>
                <p><img src="img/bullet2.png"> Password must contain at least one lowercase letter (a-z)</p>
                <p><img src="img/bullet2.png"> Password must contain at least one uppercase letter (A-Z)</p>
            </div>
        </td>
    </tr>
</table>