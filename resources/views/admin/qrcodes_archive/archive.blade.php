@extends('admin.theme.default')

@section('content')

<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">

        <div class="title"><strong>Archived QR Codes</strong></div>

        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        @if($archivedQrCodes->isEmpty())
        <p class="text-center mt-4">No archived QR codes found.</p>
        @else
        <div class="responsive-table">
            <span class="mt-4 bold"><strong>Total posts: {{ $total_archive_deleted }}</strong></span>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Device Type</th>
                        <th>Device Name</th>
                        <th>Owner Name</th>
                        <th>QR Code</th>
                        <th>Archived At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($archivedQrCodes as $qrCode)
                    <tr>
                        <td>{{ $qrCode->id }}</td>
                        <td>{{ $qrCode->device_type }}</td>
                        <td>{{ $qrCode->device_name }}</td>
                        <td>{{ $qrCode->owner_name }}</td>
                        <td>
                            @if(file_exists(public_path('qrcodes/archive/' . basename($qrCode->qr_code_path))))
                            <img src="{{ asset('qrcodes/archive/' . basename($qrCode->qr_code_path)) }}" alt="QR Code" width="100">
                            @else
                            <img src="{{ asset($qrCode->qr_code_path) }}" alt="QR Code" width="100">
                            @endif
                        </td>
                        <td>{{ $qrCode->deleted_at }}</td>
                        <td>
                            <!-- Restore Button -->
                            <form action="{{ route('qr-code.restore', $qrCode->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                    </svg>
                                </button>
                            </form>

                            <!-- Permanently Delete Button -->
                            <form action="{{ route('qr-code.forceDelete', $qrCode->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>

            </table>
            
            <!-- Pagination Links -->
            <div class="d-flex justify-content-end mt-4">
                <p class="mt-4">{{ $archivedQrCodes->links() }}</p>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection