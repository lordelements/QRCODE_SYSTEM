<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class QR_Code extends Model
{
    use HasFactory;
    use SoftDeletes; // Add this trait
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'device_type',
        'device_name',
        'owner_name',
        'qr_code_path', // Path to the generated QR code
        'color',
    ];

    protected $dates = ['deleted_at']; // For soft delete timestamps

    protected static function boot()
    {
        parent::boot();

        // Move QR code files to the archive folder when soft-deleting a record
        static::deleting(function ($qrCode) {
            if ($qrCode->isForceDeleting()) {
                // When hard deleting, delete the file permanently
                $filePath = public_path($qrCode->qr_code_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } else {
                // When soft deleting, move the file to an archive folder
                $originalPath = public_path($qrCode->qr_code_path);
                $archivePath = public_path('qrcodes/archive/' . basename($qrCode->qr_code_path));
                
                if (file_exists($originalPath)) {
                    @mkdir(dirname($archivePath), 0755, true); // Create the archive folder if it doesn't exist
                    rename($originalPath, $archivePath); // Move the file to the archive
                }
            }
        });
    }

}
