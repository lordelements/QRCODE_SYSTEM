@extends('admin.theme.default')

@section('content')

<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">


        <div class="col-lg-12">
            <div class="block">
                <div class="title"><strong>QR Code Scanned Logs</strong></div>

                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('status') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                </div>
                @endif

                <div class="responsive-table">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Scan ID</th>
                                <th>Device Type</th>
                                <th>Device Name</th>
                                <th>Owner Name</th>
                                <th>Scanned At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $scanLogs as $log)

                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->scan_id }}</td>
                                <td>{{ $log->device_type }}</td>
                                <td>{{ $log->device_name }}</td>
                                <td>{{ $log->owner_name }}</td>
                                <td>{{ $log->scanned_at }}</td>
                                <td>

                                    <form action="{{ route('scanlog.destroy', $log->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                            </svg>
                                        </button>

                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <h5 class="text-center">There are no data.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
</section>

@endsection