<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'url',
        'reference_id',
        'library_id',
        'collection_id'
    ];

    // Define which attributes should be hidden for arrays
    protected $hidden = [
        'updated_at',
    ];

    public function library()
    {
        return $this->belongsTo(Library::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
