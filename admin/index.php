<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container my-5">
    <h1>Admin Dashboard</h1>

    <a type="button" class="btn btn-primary mb-3" href="availability.php">
        Add Availability
    </a>

    <div class="mt-5">
        <h1 class="mb-4">Submitted Appointments</h1>
        <div class="mb-3">
            <input type="text" id="search-input" class="form-control" placeholder="Search by name or email">
        </div>
        <div id="appointment-list" class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody id="appointments-table-body">
                <!-- Appointments will be appended here -->
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination" id="pagination">
                <!-- Pagination will be appended here -->
            </ul>
        </nav>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.2/js/bootstrap.min.js"></script>
<script src="../assets/js/appointments.js"></script>
</body>
</html>
