<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book an Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/hjsCalendar.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Book an Appointment</h1>
    <ul class="nav nav-tabs" id="appointmentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="select-date-tab" data-bs-toggle="tab" href="#select-date" role="tab" aria-controls="select-date" aria-selected="true">Select Date & Time</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="enter-details-tab" data-bs-toggle="tab" href="#enter-details" role="tab" aria-controls="enter-details" aria-selected="false">Enter Details</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="confirmation-tab" data-bs-toggle="tab" href="#confirmation" role="tab" aria-controls="confirmation" aria-selected="false">Confirmation</a>
        </li>
    </ul>
    <div class="tab-content" id="appointmentTabsContent">
        <div class="tab-pane fade show active" id="select-date" role="tabpanel" aria-labelledby="select-date-tab">
            <div id="hjsCalendar" class="mt-3"></div>
            <button type="button" class="btn btn-primary mt-3 d-none" id="next-to-details">Next</button>
        </div>
        <div class="tab-pane fade" id="enter-details" role="tabpanel" aria-labelledby="enter-details-tab">
            <div id="appointmentForm" class="mt-3">
                <form id="appointment-form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Telephone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone">
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <input type="hidden" id="selectedDate" name="date">
                    <button type="button" class="btn btn-primary" id="submit-appointment">Confirm Appointment</button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="confirmation" role="tabpanel" aria-labelledby="confirmation-tab">
            <div id="confirmation-details" class="mt-3">
                <h3>Appointment Details</h3>
                <p><strong>Name:</strong> <span id="confirm-name"></span></p>
                <p><strong>Email:</strong> <span id="confirm-email"></span></p>
                <p><strong>Telephone:</strong> <span id="confirm-telephone"></span></p>
                <p><strong>Date:</strong> <span id="confirm-date"></span></p>
                <p><strong>Comment:</strong> <span id="confirm-comment"></span></p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="assets/js/hjsCalendar.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
