<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'category',
        'location',
        'date',
        'full_name',
        'student_id',
        'department',
        'facebook_link',
        'contact_number',
        'email',
        'images',
        'status',
        'is_reported',
        'report_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}