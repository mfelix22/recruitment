<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportingDocument extends Model
{
    protected $fillable = [
        'description',
        'status',
        'format_file',
        'sort_order',
    ];

    public const STATUSES = ['mandatory', 'optional'];
    public const FORMATS  = ['pdf', 'jpg', 'png', 'doc', 'docx'];

    public function isMandatory(): bool
    {
        return $this->status === 'mandatory';
    }

    public function applicantDocuments()
    {
        return $this->hasMany(ApplicantDocument::class);
    }
}
