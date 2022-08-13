<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks_task";

    protected $fillable = [
        "id",
        "name",
        "created_at",
        "updated_at"
    ];
}
