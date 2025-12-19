<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name',
        'template_image',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get active template
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Set this template as active
     */
    public function setAsActive()
    {
        // Deactivate all other templates
        self::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activate this template
        $this->update(['is_active' => true]);
    }
}
