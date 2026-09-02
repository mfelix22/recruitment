<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantDocument extends Model
{
    protected $fillable = [
        'application_id',
        'supporting_document_id',
        'file_path',
        'original_name',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function supportingDocument()
    {
        return $this->belongsTo(SupportingDocument::class);
    }
}
