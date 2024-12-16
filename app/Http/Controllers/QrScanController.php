<?php

namespace App\Http\Controllers;

use App\Models\ScanLog;
use App\Models\Qr_Code;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QrScanController extends Controller
{
    public function handleScan(Request $request, $id) // Handle scanned QR codes and show the details when it scanned
    {
       
        // Fetch the QR code details using the UUID
        $qrCodeRecord = Qr_Code::where('id', $id)->firstOrFail();
        $latestScan = ScanLog::where('scan_id', $id)->latest()->first();

        // Log the scan into the database
        // Log the scan event with QR code details
        ScanLog::create([
            'scan_id' => $id,
            'device_type' => $qrCodeRecord->device_type,
            'device_name' => $qrCodeRecord->device_name,
            'owner_name' => $qrCodeRecord->owner_name,
            'scanned_at' => now(),
        ]);

        return view('qr-code.details', compact('qrCodeRecord', 'latestScan'));
        // Redirect back with a success message
        // return redirect()->back()->with('status', 'QR Code created successfully.', compact('qrCodeRecord', 'latestScan'));
    }

    public function index() // Display all scanned QR codes
    {
        $scanLogs = ScanLog::all();
        return view('admin.scanlog.index', compact('scanLogs'));
    }

    public function destroy($id) // Delete Generate QR codes
    {
        $scanLogs = ScanLog::findOrFail($id);
        $scanLogs->delete();

        return redirect()->back()->with('status', 'QR Code scanned logs deleted successfully.');
    }

    // public function showDetails($id)
    // {
    //     $qrCodeRecord = Qr_Code::where('id', $id)->firstOrFail();
    //     $latestScan = ScanLog::where('scan_id', $id)->latest()->first();

    //     return view('qr-code.details', compact('qrCodeRecord', 'latestScan'));
    // }

    // public function processScan(Request $request)
    // {
    //     // Decode the JSON data from the QR code scan
    //     $scannedData = json_decode($request->input('qr_data'), true);

    //     if (!$scannedData || !isset($scannedData['id'])) {
    //         return response()->json(['error' => 'Invalid QR data'], 400);
    //     }

    //     // Find the device record using the ID
    //     $device = Qr_Code::find($scannedData['id']);
    //     if (!$device) {
    //         return response()->json(['error' => 'Device not found'], 404);
    //     }

    //     // Log the scan
    //     ScanLog::create([
    //         'item_id' => $device->id,
    //         'device_type' => $device->device_type,
    //         'device_name' => $device->device_name,
    //         'owner_name' => $device->owner_name,
    //         'scanned_at' => Carbon::now(),
    //     ]);

    //     // Respond with device details
    //     return response()->json([
    //         'device_type' => $device->device_type,
    //         'device_name' => $device->device_name,
    //         'owner_name' => $device->owner_name,
    //         'scanned_at' => Carbon::now()->toDateTimeString(),
    //     ]);
    // }
}
