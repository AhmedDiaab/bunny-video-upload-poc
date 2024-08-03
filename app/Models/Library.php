<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $table = 'libraries';
    
    protected $primaryKey = 'id';
    
    public $incrementing = true;
    
    public $timestamps = true;

    protected $fillable = [
        'name',
        'reference_id'
    ];
    
    // Define which attributes should be hidden for arrays
    protected $hidden = [
        'updated_at',
    ];
}
