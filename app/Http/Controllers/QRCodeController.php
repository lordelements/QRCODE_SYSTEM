<?php

namespace App\Http\Controllers;

use App\Models\QR_Code;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class QRCodeController extends Controller
{

    public function index()  // Display all genearted QR codes
    {
        
        $data = QR_Code::orderBy('created_at', 'desc')->get();
        $total_qrcodes  = Qr_Code::count();
        return view('admin.index', compact('data', 'total_qrcodes'));
    }

    public function store(Request $request) // Generate QR codes
    {
        // Validate the input data
        $validatedData = $request->validate([
            'device_type' => 'required|string',
            'device_name' => 'required|string',
            'owner_name' => 'required|string',
        ]);

        // Create the database record
        $qrCodeRecord = Qr_Code::create($validatedData);

        // Generate QR Code data
        // $data = 'ID: ' . $qrCodeRecord->id . "\n" .
        //     'Owner: ' . $qrCodeRecord->owner_name . "\n" .
        //     'Device: ' . $qrCodeRecord->device_name . "\n" .
        //     'Type: ' . $qrCodeRecord->device_type;

        // Generate the QR Code URL (route to handle scans)
        $scanUrl = route('qr-code.details', ['id' => $qrCodeRecord->id]);


        // Generate the QR code and save it as an image
        $qrCodePath = 'qrcodes_generated/' . $qrCodeRecord->id . '.png';

        QrCode::size(300)
            ->style('dot')
            ->eye('circle')
            ->color(0, 0, 255)
            ->margin(1)
            ->format('png')
            ->generate($scanUrl, public_path($qrCodePath));

        // Update the record with the QR code file path
        $qrCodeRecord->update(['qr_code_path' => $qrCodePath]);

        // Redirect back with a success message
        return redirect()->back()->with('status', 'QR Code created successfully.');
    }

    // public function store(Request $request)
    // {
    //     // Validate the input data
    //     $validatedData = $request->validate([
    //         'device_type' => 'required|string',
    //         'device_name' => 'required|string',
    //         'owner_name' => 'required|string',
    //     ]);

    //     // Create the device record
    //     $device = Qr_Code::create($validatedData);

    //     // Generate QR Code data containing device details
    //     $data = 'ID: ' . $device->id . "\n" .
    //         'Owner: ' . $device->owner_name . "\n" .
    //         'Device: ' . $device->device_name . "\n" .
    //         'Type: ' . $device->device_type;


    //     // $scanUrl = route($data, ['id' => $device->id]);

    //     // Generate QR code with embedded payload (e.g., device ID or encoded JSON)
    //     $payload = json_encode([
    //         'id' => $device->id,
    //     ]);

    //     $qrCodePath = 'qrcodes_generated/' . $device->id . '.png';

    //     // Generate and save the QR code
    //     QrCode::size(300)
    //         ->style('dot')
    //         ->eye('circle')
    //         ->color(0, 0, 255)
    //         ->margin(1)
    //         ->format('png')
    //         ->generate($payload, public_path($qrCodePath));

    //     // Save the QR code path to the device record
    //     $device->update(['qr_code_path' => $qrCodePath]);

    //     return redirect()->back()->with('status', 'Device created successfully!');
    // }

    // public function store(Request $request)
    // {
    //     // Validate the input data
    //     $validatedData = $request->validate([
    //         'device_type' => 'required|string',
    //         'device_name' => 'required|string',
    //         'owner_name' => 'required|string',
    //     ]);

    //     // Create the device record
    //     $device = Qr_Code::create($validatedData);

    //     // Embed device details or unique identifier in the QR code data
    //      $data = 'ID: ' . $device->id . "\n" .
    //         'Owner: ' . $device->owner_name . "\n" .
    //         'Device: ' . $device->device_name . "\n" .
    //         'Type: ' . $device->device_type;

    //     $qrCodePath = 'qrcodes_generated/' . $device->id . '.png';

    //     // Generate and save the QR code
    //     QrCode::size(300)
    //         ->style('dot')
    //         ->eye('circle')
    //         ->color(0, 0, 255)
    //         ->margin(1)
    //         ->format('png')
    //         ->generate($data, public_path($qrCodePath));

    //     // Save the QR code path to the device record
    //     $device->update(['qr_code_path' => $qrCodePath]);

    //     return redirect()->back()->with('status', 'Device created successfully!');
    // }

    public function editForm($id) // QR Code Edit Form
    {

        $qrCode = Qr_Code::findOrFail($id); // Fetch the device by ID
        return view('admin.qrcode_editForm', compact('qrCode')); // Return the edit form view

    }

    public function update(Request $request, $id) // QR Code Update function
    {
        // Validate the input data
        $validatedData = $request->validate([
            'device_type' => 'required|string|in:Laptop,Tablet,Phone,Earphone,Other',
            'device_name' => 'required|string',
            'owner_name' => 'required|string',
        ]);

        // Fetch the device by UUID
        $qrCode = Qr_Code::where('id', $id)->firstOrFail();

        // Update the device details
        $qrCode->update($validatedData);

        // // Regenerate QR Code data with updated details
        // $data = 'UUID: ' . $device->uuid . "\n" .
        //     'Owner: ' . $device->owner_name . "\n" .
        //     'Device: ' . $device->device_name . "\n" .
        //     'Type: ' . $device->device_type;

        // Generate the QR Code URL (route to handle scans)
        $scanUrl = route('qr-code.details', ['id' => $qrCode->id]);


        // Generate the QR code and save it as an image
        $qrCodePath = 'qrcodes_generated/' . $qrCode->id . '.png';

        QrCode::size(300)
            ->style('dot')
            ->eye('circle')
            ->color(0, 0, 255)
            ->margin(1)
            ->format('png')
            ->generate($scanUrl, public_path($qrCodePath));

        // Update the record with the QR code file path
        $qrCode->update(['qr_code_path' => $qrCodePath]);

        // Redirect back with a success message
        return redirect()->back()->with('status', 'QR Code updated successfully.');
    }

    public function show(Qr_Code $request, $id) // Show details of each Generate QR codes
    {
        // $qrCode = QrCode::size(200)->generate(json_encode($qrCode_details));
        $qr = Qr_Code::find($id);
        $data = ' Owner: ' . $qr->owner_name . ', Device: ' . $qr->device_name . ', Type: ' . $qr->device_type;
        $gener_qrCode = QrCode::size(200)->generate(json_encode($data));  // Generate QR Code
        return view('admin.show', compact('qr', 'gener_qrCode'));
    }

    public function destroy($id) // Deleted Generate QR codes
    {
        // Find the QR code record in the database
        $data = Qr_Code::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('status', 'QR Code and file added to archive.');
    }

    public function forceDeleteQrCode($id) //Sofdelete Function
    {
        // Find the soft-deleted record
        $qrCode = Qr_Code::withTrashed()->findOrFail($id);

        // Get the file path
        $filePath = public_path($qrCode->qr_code_path); // Ensure this column stores the correct file path

        // Check if the file exists
        if (File::exists($filePath)) {
            // Delete the file
            File::unlink($filePath);
        }

        // Delete the record permanently (this triggers the isForceDeleting logic)
        $qrCode->forceDelete();
        return redirect()->back()->with('status', 'QR Code has been permanently deleted.');
    }

    public function restoreQrCode($id) // Restore Function
    {
        // Find the soft-deleted record
        $qrCode = Qr_Code::withTrashed()->findOrFail($id);

        // Restore the record
        $qrCode->restore();

        // Move the file back to the original location
        $archivePath = public_path('qrcodes/archive/' . basename($qrCode->qr_code_path));
        $originalPath = public_path($qrCode->qr_code_path);

        if (file_exists($archivePath)) {
            @mkdir(dirname($originalPath), 0755, true); // Create the folder if it doesn't exist
            rename($archivePath, $originalPath); // Move the file back to the original location
        }

        return redirect()->back()->with('status', 'QR Code has been restored.');
    }

    public function showArchived() //Display archive data on a table
    {
        $archivedQrCodes = Qr_Code::onlyTrashed()->paginate(10);
        $total_archive_deleted  = Qr_Code::onlyTrashed()->get()->count();
        return view('admin.qrcodes_archive.archive', compact('archivedQrCodes', 'total_archive_deleted'));
    }

    public function downloadQrCode($id) // Download Generate QR codes
    {
        $device = Qr_Code::findOrFail($id);
        $data = 'Owner: ' . $device->owner_name . ', Device: ' . $device->device_name . ', Type: ' . $device->device_type;

        // Generate the URL for showing details
        // $detailsUrl = route('qr-code.details', ['id' => $device->id]);

        // Generate QR Code as a PNG
        $qrCode = QrCode::format('png')
            ->style('dot')
            ->eye('circle')
            ->color(0, 0, 255)
            ->margin(1)
            ->size(300)->generate($data);

        // Define file name
        $fileName = 'device_' . $id . '_qr_code.png';
        // $qrCodePath = 'qrcodes_generated/' . $device->id . '.png';

        // Save the file to temporary storage
        $tempPath = storage_path('app/public/qrcodes_generated/' . $fileName);
        file_put_contents($tempPath, $qrCode);

        // Return the file as a download response
        return response()->download($tempPath, $fileName)->deleteFileAfterSend();
    }
}
