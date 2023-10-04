<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deadline extends Model
{
    use HasFactory;
    protected $fillable = ['days', 'doc_type_id'];
    public function tracks():HasMany {
        return $this->hasMany(Tracker::class);
      }

    public function docType():BelongsTo {
    return $this->belongsTo(DocType::class);
    }
}
