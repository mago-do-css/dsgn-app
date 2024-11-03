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
        'stock_path',// para caso ficar salvo em algum local como o storage
        'stock_name',// // para caso ficar salvo em algum local como o storage
        'stock_origin',
        'stock_origin_param',
        'stock_url',
        'stock_type',
        'stock_image_preview',
        'order_code',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
