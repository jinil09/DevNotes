<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    protected $fillable = [
        'branch_name',
        'commit_message',
        'file_path',
        'date',
        'user_id', 
    ];
    
    use HasFactory;
}
