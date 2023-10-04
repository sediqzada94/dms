<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['tracker_id', 'path'];
    public function tracker():BelongsTo {
        return $this->BelongsTo(Tracker::class);
      }
}
