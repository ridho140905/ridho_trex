<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multipleupload extends Model
{
    use HasFactory;

    protected $table = 'multipleuploads';

    protected $fillable = [
        'filename',
        'ref_table',
        'ref_id',
    ];

    /**
     * Get the URL for the file
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->filename);
    }

    /**
     * Scope untuk file milik pelanggan tertentu
     */
    public function scopeForPelanggan($query, $pelangganId)
    {
        return $query->where('ref_table', 'pelanggan')
                    ->where('ref_id', $pelangganId);
    }
}
