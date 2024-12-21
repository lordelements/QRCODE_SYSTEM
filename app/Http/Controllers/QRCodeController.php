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
            'color' => 'required|string|regex:/^\d{1,3},\d{1,3},\d{1,3}$/', // Validate RGB format
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

        // Parse the chosen color (e.g., "255,0,0")
        [$red, $green, $blue] = explode(',', $validatedData['color']);

        $qrCodeContent = QrCode::size(300)
            ->style('dot')
            ->eye('circle')
            ->color($red, $green, $blue)
            ->margin(1)
            ->format('png')
            ->generate($scanUrl);

        // Save the QR code to the public storage folder
        Storage::disk('public')->put($qrCodePath, $qrCodeContent);

        // Update the record with the QR code file path
        $qrCodeRecord->update(['qr_code_path' => $qrCodePath]);

        // Redirect back with a success message
        return redirect()->back()->with('status', 'QR Code created successfully.');
    }

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
            'color' => 'required|string|regex:/^\d{1,3},\d{1,3},\d{1,3}$/', // Validate RGB format
        ]);

        // Fetch the device by UUID
        $qrCode = Qr_Code::where('id', $id)->firstOrFail();

        // Update the device details
        $qrCode->update($validatedData);

        // Generate the QR Code URL (route to handle scans)
        $scanUrl = route('qr-code.details', ['id' => $qrCode->id]);

        // Generate the QR code and save it as an image
        $qrCodePath = 'qrcodes_generated/' . $qrCode->id . '.png';

        // Parse the chosen color (e.g., "255,0,0")
        [$red, $green, $blue] = explode(',', $validatedData['color']);

        $qrCodeContent = QrCode::size(300)
            ->style('dot')
            ->eye('circle')
            ->color($red, $green, $blue)
            ->margin(1)
            ->format('png')
            ->generate($scanUrl);

        // Save the QR code to the public storage folder
        Storage::disk('public')->put($qrCodePath, $qrCodeContent);

        // Update the record with the QR code file path
        $qrCode->update(['qr_code_path' => $qrCodePath]);

        // Redirect back with a success message
        return redirect()->back()->with('status', 'QR Code updated successfully.');
    }

    // public function show(Qr_Code $request, $id) // Show details of each Generate QR codes
    // {
    //     // $qrCode = QrCode::size(200)->generate(json_encode($qrCode_details));
    //     $qr = Qr_Code::find($id);
    //     $data = ' Owner: ' . $qr->owner_name . ', Device: ' . $qr->device_name . ', Type: ' . $qr->device_type;
    //     $gener_qrCode = QrCode::size(200)->generate(json_encode($data));  // Generate QR Code
    //     return view('admin.show', compact('qr', 'gener_qrCode'));
    // }

    public function show($id) // Updated Show details of each generated QR code
    {
        // Find the QR Code record by ID
        $qr = Qr_Code::findOrFail($id);

        // Prepare the data to display
        $data = 'Owner: ' . $qr->owner_name . ', Device: ' . $qr->device_name . ', Type: ' . $qr->device_type;

        // Generate a QR code dynamically for the data
        $generatedQrCode = QrCode::size(200)->generate($data);

        // Get the stored QR code path
        $qrCodePath = $qr->qr_code_path;

        // Check if the stored QR code exists in public storage
        $storedQrCodeUrl = null;
        if (Storage::disk('public')->exists($qrCodePath)) {
            $storedQrCodeUrl = Storage::url($qrCodePath); // Generate a public URL
        }

        // Pass the details to the view
        return view('admin.show', compact('qr', 'generatedQrCode', 'storedQrCodeUrl'));
    }

    // public function destroy($id) // Deleted Generate QR codes
    // {
    //     // Find the QR code record in the database
    //     $data = Qr_Code::findOrFail($id);
    //     $data->delete();
    //     return redirect()->back()->with('status', 'QR Code and file added to archive.');
    // }

    public function destroy($id)  // Updated Delete function
    {
        // Find the QR code record in the database
        $data = Qr_Code::findOrFail($id);

        // Check if the QR code file exists in the public storage
        if ($data->qr_code_path && Storage::disk('public')->exists($data->qr_code_path)) {
            // Define the archive path
            $archivePath = 'archive/' . basename($data->qr_code_path);

            // Move the QR code file to the archive folder
            Storage::disk('public')->move($data->qr_code_path, $archivePath);
        }

        // Delete the record from the database
        $data->delete();

        return redirect()->back()->with('status', 'QR Code deleted and file added to archive.');
    }

    // public function forceDeleteQrCode($id) //Sofdelete Function
    // {
    //     // Find the soft-deleted record
    //     $qrCode = Qr_Code::withTrashed()->findOrFail($id);

    //     // Get the file path
    //     $filePath = public_path($qrCode->qr_code_path); // Ensure this column stores the correct file path

    //     // Save the QR code to the public storage folder
    //     $storagePath = Storage::disk('public')->put($filePath, $qrCode);

    //     // Check if the file exists
    //     if (File::exists($storagePath)) {
    //         // Delete the file
    //         File::unlink($storagePath);
    //     }

    //     // Delete the record permanently (this triggers the isForceDeleting logic)
    //     $qrCode->forceDelete();
    //     return redirect()->back()->with('status', 'QR Code has been permanently deleted.');
    // }

    public function forceDeleteQrCode($id) // Updated` Permanently Delete Function
    {
        // Find the soft-deleted record
        $qrCode = Qr_Code::withTrashed()->findOrFail($id);

        // Define the paths
        $originalFilePath = $qrCode->qr_code_path; // Original file path
        $archiveFilePath = 'archive/' . basename($originalFilePath); // Archived file path

        // Delete the file from the original location
        if (Storage::disk('public')->exists($originalFilePath)) {
            Storage::disk('public')->delete($originalFilePath);
        }

        // Delete the file from the archive
        if (Storage::disk('public')->exists($archiveFilePath)) {
            Storage::disk('public')->delete($archiveFilePath);
        }

        // Permanently delete the record
        $qrCode->forceDelete();

        return redirect()->back()->with('status', 'QR Code has been permanently deleted.');
    }

    // public function restoreQrCode($id) // Restore Function
    // {
    //     // Find the soft-deleted record
    //     $qrCode = Qr_Code::withTrashed()->findOrFail($id);

    //     // Restore the record
    //     $qrCode->restore();

    //     // Move the file back to the original location
    //     $archivePath = public_path('qrcodes/archive/' . basename($qrCode->qr_code_path));
    //     $originalPath = public_path($qrCode->qr_code_path);

    //     if (file_exists($archivePath)) {
    //         @mkdir(dirname($originalPath), 0755, true); // Create the folder if it doesn't exist
    //         rename($archivePath, $originalPath); // Move the file back to the original location
    //     }

    //     return redirect()->back()->with('status', 'QR Code has been restored.');
    // }

    public function restoreQrCode($id) // Updated Restore Function
    {
        // Find the soft-deleted record
        $qrCode = Qr_Code::withTrashed()->findOrFail($id);

        // Restore the record
        $qrCode->restore();

        // Define the paths
        $archivePath = 'archive/' . basename($qrCode->qr_code_path);
        $originalPath = $qrCode->qr_code_path;

        // Move the file back to the original location
        if (Storage::disk('public')->exists($archivePath)) {
            // Ensure the original directory exists
            Storage::disk('public')->makeDirectory(dirname($originalPath));

            // Move the file from archive back to its original location
            Storage::disk('public')->move($archivePath, $originalPath);
        }

        return redirect()->back()->with('status', 'QR Code has been restored successfully.');
    }

    // public function showArchived() //Display archive data on a table
    // {
    //     $archivedQrCodes = Qr_Code::onlyTrashed()->paginate(10);
    //     $total_archive_deleted  = Qr_Code::onlyTrashed()->get()->count();
    //     return view('admin.qrcodes_archive.archive', compact('archivedQrCodes', 'total_archive_deleted'));
    // }

    public function showArchived() // Updated Display archive data on a table
    {
        // Fetch soft-deleted records with pagination
        $archivedQrCodes = Qr_Code::onlyTrashed()->paginate(10);

        // Transform the paginated items manually
        foreach ($archivedQrCodes as $qrCode) {
            $archivePath = 'archive/' . basename($qrCode->qr_code_path);

            // Check if the file exists in the archive
            if (Storage::disk('public')->exists($archivePath)) {
                $qrCode->archived_qr_code_url = Storage::url($archivePath); // Generate public URL for the archive file
            } else {
                $qrCode->archived_qr_code_url = null; // Handle missing archive file
            }
        }

        // Count total archived records
        $total_archive_deleted = Qr_Code::onlyTrashed()->count();

        // Return the view with data
        return view('admin.qrcodes_archive.archive', compact('archivedQrCodes', 'total_archive_deleted'));
    }

    public function downloadQrCodeURL($id) // Download Generate QR codes
    {
        $device = Qr_Code::findOrFail($id);

        // Generate the URL for showing details
        $detailsUrl = route('qr-code.details', ['id' => $device->id]);

        // Generate QR Code as a PNG
        $qrCode = QrCode::format('png')
            ->style('dot')
            ->eye('circle')
            ->color(0, 0, 255)
            ->margin(1)
            ->size(300)->generate($detailsUrl);

        // Define file name
        $fileName = 'device_' . $id . '_qr_code.png';
        // $qrCodePath = 'qrcodes_generated/' . $device->id . '.png';

        // Save the file to temporary storage
        $tempPath = storage_path('app/public/qrcodes_generated/' . $fileName);
        file_put_contents($tempPath, $qrCode);

        // Return the file as a download response
        return response()->download($tempPath, $fileName)->deleteFileAfterSend();
    }
    public function downloadQrCode($id) // Download Generate QR codes
    {
        $device = Qr_Code::findOrFail($id);

        $data = 'ID: ' . $device->id . "\n" .
            'Owner: ' . $device->owner_name . "\n" .
            'Device: ' . $device->device_name . "\n" .
            'Type: ' . $device->device_type;

        // Generate the URL for showing details
        // $detailsUrl = route('qr-code.details', ['id' => $device->id]);

        // Parse the chosen color (e.g., "255,0,0")
        [$red, $green, $blue] = explode(',', $device['color']);


        // Generate QR Code as a PNG
        $qrCode = QrCode::format('png')
            ->style('dot')
            ->eye('circle')
            ->color($red, $green, $blue)
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
