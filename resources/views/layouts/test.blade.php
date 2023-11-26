<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('myForm');
    const submitButton = document.getElementById('loading');
    // const form = document.getElementById('update');
    // const updateButton = document.getElementById('updateButton');

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