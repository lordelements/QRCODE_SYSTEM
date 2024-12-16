<?php

namespace App\Http\Controllers;

use App\Models\QR_Code;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


class QRCodeController extends Controller
{

    public function index()  // Display all genearted QR codes
    {
        $data = QR_Code::all();
        return view('admin.index', compact('data'));
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
        // $data = 'Owner: ' . $qrCodeRecord->owner_name . ', Device: ' . $qrCodeRecord->device_name . ', Type: ' . $qrCodeRecord->device_type;

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
        $data = Qr_Code::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('status', 'QR Code deleted successfully.');
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

    // public function downloadQrCode($id)
    // {
    //     $qrCodeRecord = Qr_Code::findOrFail($id);

    //     // Generate the URL for showing details
    //     $detailsUrl = route('qr-code.details', ['id' => $qrCodeRecord->id]);

    //     // Generate and save the QR code
    //     $qrCodePath = 'qrcodes_generated/' . $qrCodeRecord->id . '.png';
    //     QrCode::size(300)
    //         ->format('png')
    //         ->generate($detailsUrl, Storage::path($qrCodePath));

    //     // Update the record with the QR code path
    //     $qrCodeRecord->qr_code_path = $qrCodePath;
    //     $qrCodeRecord->save();

    //     // return response()->download(Storage::path($qrCodePath))->with('message', 'QR Code downloaded successfully!');
    //     return redirect()->download(Storage::path($qrCodePath))->with('status', 'QR Code downloaded successfully!');
    // }
}
