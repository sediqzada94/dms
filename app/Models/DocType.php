<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function deadline():HasOne {
        return $this->hasOne(Deadline::class);
      }
}
 