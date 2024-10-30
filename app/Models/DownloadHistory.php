<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadHistory extends Model
{
    use HasFactory;
     
    protected $table = 'download_history';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'image_path',// para caso ficar salvo em algum local como o storage
        'image_name',// // para caso ficar salvo em algum local como o storage
        'image_origin',
        'image_url',
        'date',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
