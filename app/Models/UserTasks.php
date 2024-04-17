<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTasks extends Model
{
    use HasFactory;

    protected $table = 'user_assign_tasks';

    protected $fillable = [
        'task_id',
        'user_id'
    ];
}
