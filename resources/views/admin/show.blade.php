@extends('admin.theme.default')

@section('content')

<div class="card mb-3">
    <form action="{{ url('admin/show/'.$qr->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="position-relative">
            <p  hidden>{{ $data = ' Owner Name: ' . $qr->owner_name . ', 
                Device Name: ' . $qr->device_name . ', 
                Device Type: ' . $qr->device_type }}</p>
            <div class="position-absolute top-50 start-50 translate-middle">
                <div class="card-body"> <img src="{{ asset($qr->qr_code_path) }}" alt="QR Code" class="img-thumbnail w-auto p-3"> </div>
            </div>
        </div>
    </form>
</div>

@endsection