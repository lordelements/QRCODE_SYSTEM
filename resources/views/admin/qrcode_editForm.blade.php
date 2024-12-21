@extends('admin.theme.default')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Hey!{{ session('status') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Hey!{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
            @endif

            <h5 class="card-title fs-5">Update QR Code</h5>
            <form class="row g-3" action="{{ url('qr-codes/update/'.$qrCode->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    <select class="form-control" name="device_type" required>
                        <option selected disabled value="">Select Device Type</option>
                        <option value="Laptop" {{ $qrCode->device_type == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                        <option value="Phone" {{ $qrCode->device_type == 'Phone' ? 'selected' : '' }}>Phone</option>
                        <option value="Tablet" {{ $qrCode->device_type == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="Earphone" {{ $qrCode->device_type == 'Earphone' ? 'selected' : '' }}>Earphone</option>
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="validationCustom02" class="form-label">Device Name</label>
                    <input type="text" class="form-control" name="device_name" value="{{ $qrCode->device_name }}" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="validationCustom02" class="form-label">Owner Name</label>
                    <input type="text" class="form-control" name="owner_name" value="{{ $qrCode->owner_name }}" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="color">Choose QR Code Color</label>
                    <input type="color" class="rounded" id="color" name="color_picker" value="#000000" onchange="updateColorInput(this.value)">
                    <input type="hidden" name="color" id="color_input" value="0,0,0">
                </div>
                <div class="col-md-6 mt-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

<script>
    function updateColorInput(hex) {
        const rgb = hexToRgb(hex);
        document.getElementById('color_input').value = `${rgb.r},${rgb.g},${rgb.b}`;
    }

    function hexToRgb(hex) {
        const bigint = parseInt(hex.slice(1), 16);
        return {
            r: (bigint >> 16) & 255,
            g: (bigint >> 8) & 255,
            b: bigint & 255
        };
    }
</script>

<style>
    input[type="color" i] {
        border-radius: 50%;
        inline-size: 30px;
        block-size: 30px;
        border-width: 1px;
        border-style: solid;
        border-color: rgb(153, 153, 153);
    }
</style>