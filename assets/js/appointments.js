let currentPage = 1;
const limit = 10;

$(document).ready(function() {
    fetchAppointments();

    $('#search-input').on('keyup', function() {
        fetchAppointments();
    });

    $('#dates').datepicker({
        multidate: true,
        format: 'yyyy-mm-dd'
    });

});

function fetchAppointments(page = 1) {
    const search = $('#search-input').val();
    $.ajax({
        url: '../api/appointments/get.php',
        method: 'GET',
        data: { page: page, limit: limit, search: search },
        success: function(response) {
            if (response.status === 'success') {
                displayAppointments(response.data);
                setupPagination(response.total, response.page, response.limit);
            } else {
                toastr.error('Failed to fetch appointments')
            }
        },
        error: function() {
            toastr.error('An error occurred while fetching appointments');
        }
    });
}

function displayAppointments(appointments) {
    const tbody = $('#appointments-table-body');
    tbody.empty();

    appointments.forEach(appointment => {
        const row = `<tr>
                    <td>${appointment.name}</td>
                    <td>${appointment.email}</td>
                    <td>${appointment.telephone}</td>
                    <td>${appointment.comment}</td>
                    <td>${appointment.date}</td>
                    <td>${appointment.time}</td>
                    <td>${appointment.status}</td>
                </tr>`;
        tbody.append(row);
    });
}

function setupPagination(total, page, limit) {
    const totalPages = Math.ceil(total / limit);
    const pagination = $('#pagination');
    pagination.empty();

    for (let i = 1; i <= totalPages; i++) {
        const pageItem = `<li class="page-item ${i === page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>`;
        pagination.append(pageItem);
    }
}

function changePage(page) {
    currentPage = page;
    fetchAppointments(page);
}