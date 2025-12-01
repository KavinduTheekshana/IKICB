<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleMaterial extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'type',
        'order',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size > 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    public function getIconAttribute()
    {
        return match($this->type) {
            'pdf' => 'heroicon-o-document-text',
            'image' => 'heroicon-o-photo',
            'video' => 'heroicon-o-film',
            'document' => 'heroicon-o-document',
            default => 'heroicon-o-document',
        };
    }
}
