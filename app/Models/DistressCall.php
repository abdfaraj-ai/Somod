<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistressCall extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'detailed_address',
        'description',
        'status',
        'evacuation_block_id',
    ];

    public function evacuationBlock()
    {
        return $this->belongsTo(EvacuationBlock::class);
    }
}
