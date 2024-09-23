<!-- resources/views/emails/ticket.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Your Ticket for BEYOND LIVING 2024</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
        }

        .event-details {
            background-color: #eaf3ff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .event-details p {
            margin: 5px 0;
        }

        .barcode-section {
            text-align: center;
            margin-top: 20px;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hello, {{ $registration->pax_name }}!</h1>
        <p>We're excited to confirm your registration for <strong>BEYOND LIVING 2024</strong>!</p>
        <p>Prepare yourself for an incredible experience at one of the most anticipated events of the year.</p>

        <div class="event-details">
            <h2>Event Details:</h2>
            <p><strong>Event:</strong> {{ $event->event_name }}</p>
            <p><strong>Date:</strong> {{ $formattedDateRange }}</p>
            <p><strong>Location:</strong> {{ $event->event_location }}</p>
        </div>

        <p>Your personal ticket number is: <strong>{{ $registration->reg_ticket_no }}</strong></p>
        <p>Attached is your digital ticket. Please show the barcode at the entrance for seamless access.</p>

        <p>If you have any questions, feel free to reach out to our team at <a
                href="mailto:support@beyondliving2024.com">support@beyondliving2024.com</a>.</p>

        <p>See you at the event!</p>

        <div class="footer">
            <p>Best Regards,<br>BEYOND LIVING 2024 Team</p>
        </div>
    </div>
</body>

</html>
