<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'due_date',
        'description',
        'status_id'
    ];

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
