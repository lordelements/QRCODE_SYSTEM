@extends('admin.theme.default')

@section('content')

<div class="card">
    <form action="{{ url('admin/show/'.$qr->id) }}" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="card-img-top p-3">
                <h5 class="mb-4">Dynamically Generated QR Code:</h5>
                {!! $generatedQrCode !!}
            </div>

            @if ($storedQrCodeUrl)
            <div class="card-img-top p-3">
                <h5 class="mb-4">Stored QR Code:</h5>
                <img src="{{ $storedQrCodeUrl }}" class="img-thumbnail p-3" alt="Stored QR Code" width="200">
            </div>
            @else
            <p>No stored QR code found.</p>
            @endif
        </div>
    </form>
</div>

@endsection