<!DOCTYPE html>
<html>

<head>
    <title>View Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .ticket {
            margin: 20px auto;
            max-width: 500px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .ticket-title {
            font-size: 20px;
            font-weight: bold;
        }

        .ticket-info {
            font-size: 14px;
            color: #666;
        }

        .ticket-content {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.5;
        }

        .ticket-details {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .qr-code {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="ticket-header">
            <div class="ticket-title">Event Name: My Event</div>
            <div class="ticket-info">Created on: May 23, 2023</div>
        </div>
        <div class="ticket-content">
            <p>
                <strong>Ticket Category:</strong> Technical Support
            </p>
            <p>
                <strong>Description:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer gravida
                mi eu mauris fringilla, at congue nunc pellentesque. Fusce varius enim et semper elementum.
            </p>
        </div>
        <div class="ticket-details">
            <p>
                <strong>Assigned To:</strong> John Doe
            </p>
            <p>
                <strong>Due Date:</strong> June 1, 2023
            </p>
            <p>
                <strong>Priority:</strong> High
            </p>
        </div>
        <div class="qr-code">
            <img src="{{ asset('assets/files/pdf/pdf.png') }}" alt="QR Code" width="200" height="200">
        </div>
    </div>
</body>

</html>
