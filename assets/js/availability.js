$(document).ready(function() {
    loadTime();
    loadAvailabilities();

    $('#add-availability-form').on('submit', function(e) {
        e.preventDefault();

        const dates = $('#dates').val();
        const time = $('#time').val();

        $.ajax({
            url: '../api/availabilities/create.php',
            method: 'POST',
            data: { date: dates, time: time },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success('Availability added successfully')
                    $('#addAvailabilityModal').modal('hide');
                    // Optionally, refresh the availability list
                } else {
                    toastr.error('Failed to add availability');
                }
            },
            error: function() {
                toastr.error('An error occurred while adding availability');
            }
        });
    });

    $(document).on('click', '.editAvailabilityBtn', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '/api/availability/getAll',
            method: 'GET',
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    const availability = res.data.find(a => a.id === id);
                    if (availability) {
                        $('#editAvailabilityId').val(availability.id);
                        $('#editDate').val(availability.date);
                        editTimeChoices.setValue(JSON.parse(availability.time).map(time => ({ value: time, label: time })));
                        $('#editAvailabilityModal').modal('show');
                    }
                }
            }
        });
    });

    $('#saveEditAvailability').on('click', function() {
        const id = $('#editAvailabilityId').val();
        const date = $('#editDate').val();
        const times = $('#editTime').val();

        $.ajax({
            url: '/api/availability/update',
            method: 'POST',
            data: {
                id: id,
                date: date,
                time: times
            },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Availability updated successfully');
                    $('#editAvailabilityModal').modal('hide');
                    loadAvailabilities();
                } else {
                    alert('Failed to update availability: ' + res.message);
                }
            },
            error: function() {
                alert('An error occurred while updating availability');
            }
        });
    });

    $(document).on('click', '.deleteAvailabilityBtn', function() {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this availability?')) {
            $.ajax({
                url: '/api/availability/delete',
                method: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('Availability deleted successfully');
                        loadAvailabilities();
                    } else {
                        alert('Failed to delete availability: ' + res.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting availability');
                }
            });
        }
    });
});

function loadTime() {
    const timeSelect = $('#time');
    const startTime = 8;
    const endTime = 21;

    // Populate time options
    for (let hour = startTime; hour <= endTime; hour++) {
        let time = hour < 10 ? '0' + hour + ':00' : hour + ':00';
        let option = new Option(time, hour, false, false);
        timeSelect.append(option);
    }

    // Initialize Choices.js
    new Choices('#time', {
        removeItemButton: true,
        searchEnabled: false,
        placeholder: true,
        placeholderValue: 'Select time(s)'
    });
}

function loadAvailabilities(page = 1, search = '') {
    $.ajax({
        url: '../api/availabilities/get.php',
        method: 'GET',
        success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                const availabilities = res.data;
                let html = '';
                availabilities.forEach(function(availability) {
                    html += `
                            <tr>
                                <td>${availability.date}</td>
                                <td>${JSON.parse(availability.time).join(', ')}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editAvailabilityBtn" data-id="${availability.id}">Edit</button>
                                    <button class="btn btn-danger btn-sm deleteAvailabilityBtn" data-id="${availability.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                });
                $('#availabilityTableBody').html(html);
            }
        }
    });
}