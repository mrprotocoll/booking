let availableDates = ["2024-09-05", "2024-10-06", "2024-08-10", "2024-08-15"];
let selectedDate = '';
document.addEventListener('DOMContentLoaded', function() {
    $.ajax({
        type: 'GET',
        url: 'api/availabilities/getDate.php',
        success: function(response) {
            hjsCalendar(response.data, function(confirmTime) {
                selectedDate = confirmTime;
                // Set selected date and time
                document.getElementById('selectedDate').value = confirmTime;

                // Show the form
                document.getElementById('appointmentForm').classList.remove('d-none');
                // Enable the "Next" button
                document.getElementById('next-to-details').disabled = false;

                if (selectedDate) {
                    document.getElementById('selectedDate').value = selectedDate;
                    let tabTrigger = new bootstrap.Tab(document.querySelector('#enter-details-tab'));
                    tabTrigger.show();
                } else {
                    toastr.warning('Please select a date and time.');
                }
            });
        },
        error: function(response) {
            toastr.error('Failed to create appointment.');
        }
    });


    // Handle form submission
    $('#submit-appointment').on('click', function(e) {
        e.preventDefault();
        let formData = $('#appointment-form').serialize();

        $.ajax({
            type: 'POST',
            url: 'api/appointments/create.php',
            data: formData,
            success: function(response) {
                // Populate the confirmation details
                $('#confirm-name').text($('#name').val());
                $('#confirm-email').text($('#email').val());
                $('#confirm-telephone').text($('#telephone').val());
                $('#confirm-date').text($('#selectedDate').val());
                $('#confirm-time').text($('#selectedTime').val());
                $('#confirm-comment').text($('#comment').val());

                toastr.success('Appointment created successfully!');

                // Reset the form
                $('#appointment-form')[0].reset();
                // Hide the form again
                document.getElementById('appointmentForm').classList.add('d-none');

                // Move to the confirmation tab
                let tabTrigger = new bootstrap.Tab(document.querySelector('#confirmation-tab'));
                tabTrigger.show();
            },
            error: function(response) {
                toastr.error('Failed to create appointment.');
            }
        });
    });
});
