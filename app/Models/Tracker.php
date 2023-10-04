<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tracker extends Model
{
    use HasFactory;

    protected $fillable = [
      'sender_id',
      'receiver_id',
      'in_num',
      'out_num',
      'in_date',
      'out_date',
      'request_deadline',
      'remark',
      'attachment_count',
      'deadline_id',
      'status_id',
      'deadline_type_id',
      'security_level_id',
      'followup_type_id',
      'document_id',
      'doc_type_id',
    ];

    // BelongsTo tables
    public function sender():BelongsTo {
        return $this->belongsTo(Employee::class, 'sender_id');
      }

    public function receiver():BelongsTo {
        return $this->belongsTo(Employee::class, 'receiver_id');
      }

    public function document():BelongsTo {
        return $this->belongsTo(Document::class);
      }

    public function docType():BelongsTo {
        return $this->belongsTo(DocType::class);
      }

    public function followupType():BelongsTo {
        return $this->belongsTo(FollowupType::class);
      }

    public function securityLevel():BelongsTo {
        return $this->belongsTo(SecurityLevel::class);
      }

    public function status():BelongsTo {
        return $this->belongsTo(Status::class);
      }

    public function deadlineType():BelongsTo {
        return $this->belongsTo(DeadlineType::class);
      }

    public function deadline():BelongsTo {
        return $this->belongsTo(Deadline::class);
      }

    // HasMany tables
    public function attachments():HasMany {
        return $this->hasMany(Attachments::class);
      }

    public function docCopy():HasMany {
        return $this->hasMany(DocCopy::class);
      }
}
