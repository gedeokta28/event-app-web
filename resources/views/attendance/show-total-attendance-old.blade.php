<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Count</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fc;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            display: flex;
            align-items: center;
        }

        .attendance-icon {
            font-size: 50px;
            color: #4CAF50;
            margin-right: 20px;
        }

        .attendance-count {
            font-size: 36px;
            font-weight: bold;
        }

        .attendance-label {
            font-size: 18px;
            color: #666;
        }

        .btn-refresh {
            background-color: #4CAF50;
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-refresh:hover {
            background-color: #45a049;
        }

        .container {
            max-width: 600px;
        }

        .alert-success {
            background-color: #e9f6ec;
            border-color: #4CAF50;
        }

        .alert-success strong {
            color: #4CAF50;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Total Attendance</h2>

        <!-- If totalAttendance exists, display the count -->
        @if (isset($totalAttendance))
            <div class="card mt-4">
                <div class="card-body">
                    <i class="fas fa-users attendance-icon"></i>
                    <div>
                        <div class="attendance-count">{{ $totalAttendance }}</div>
                        <div class="attendance-label">{{ $selectedDate }}</div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-refresh" onclick="location.reload();"><i class="fas fa-sync-alt"></i>
                    Refresh</button>
            </div>
        @else
            <div class="alert alert-info text-center">
                <strong>Please select a date to view the attendance count.</strong>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    setTimeout(function() {
        location.reload();
    }, 50000);
</script>

</html>
