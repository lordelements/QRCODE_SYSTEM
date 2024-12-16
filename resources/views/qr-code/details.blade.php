<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        // This script will show a prompt with the details when the page is loaded
        window.onload = function() {
            var qrDetails = `Device Type: {{ $qrCodeRecord->device_type }}\n` +
                            `Device Name: {{ $qrCodeRecord->device_name }}\n` +
                            `Owner Name: {{ $qrCodeRecord->owner_name }}\n` +
                            `Last Scanned: {{ \Carbon\Carbon::parse(now())->timezone('Asia/Manila')->format('F j, Y, g:i A') }}`;

            // Show prompt with QR Code details
            alert(qrDetails);
        };
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">QR Code Scanned</h2>

        <!-- <div class="card">
            <div class="card-body">
                <h5 class="card-title">Device Information</h5>
                <p><strong>Device Type:</strong> {{ $qrCodeRecord->device_type }}</p>
                <p><strong>Device Name:</strong> {{ $qrCodeRecord->device_name }}</p>
                <p><strong>Owner Name:</strong> {{ $qrCodeRecord->owner_name }}</p>
                
                @if ($latestScan)
                <p><strong>Last Scanned At:</strong> {{ $latestScan->scanned_at }}</p>
                @else
                <p><strong>Last Scanned At:</strong> Not yet scanned</p>
                @endif

            </div>
        </div> -->
        <p class="text-align-center">The QR code has been scanned successfully and its details are shown in the prompt.</p>
    </div>
</body>

</html>
