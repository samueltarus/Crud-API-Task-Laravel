<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'is_complete' => 'boolean',
    ];
    
    protected $fillable = [
        'user_id',
        'name', 
        'title',
        'details',
        'is_complete',

    ]; 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
