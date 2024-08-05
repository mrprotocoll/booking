<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Availability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

</head>
<body>
<div class="container my-5">
    <h1>Add Availability</h1>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
        Add Availability
    </button>

    <div id="availability-list" class="table-responsive my-5 ">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>Times</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="availabilityTableBody">
            <!-- Rows will be appended here by JavaScript -->
            </tbody>
        </table>
    </div>
</div>


<!--modal-->
<div class="modal fade" id="addAvailabilityModal" tabindex="-1" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAvailabilityModalLabel">Add Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-availability-form">
                    <div class="mb-3">
                        <label for="dates" class="form-label">Select Date</label>
                        <input type="date" class="form-control" id="dates" name="date">
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <select class="form-control" id="time" name="time[]" multiple>
                            <!-- Time options will be populated by JavaScript -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Availability</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Availability Modal -->
<div class="modal fade" id="editAvailabilityModal" tabindex="-1" aria-labelledby="editAvailabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAvailabilityModalLabel">Edit Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAvailabilityForm">
                    <input type="hidden" id="editAvailabilityId">
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editDate" name="date">
                    </div>
                    <div class="mb-3">
                        <label for="editTime" class="form-label">Time</label>
                        <select id="editTime" name="time[]" class="form-control" multiple></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditAvailability">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Choices JS -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script src="../assets/js/availability.js"></script>
</body>
</html>
