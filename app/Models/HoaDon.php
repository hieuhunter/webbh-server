<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoadon extends Model
{
    use HasFactory;
    protected $table = 'hoadon';
    protected $primarykey = 'id';
    public $timestamps = false;
    public $incrementing = true;
    protected $guarded = [];
    public function CTHoaDon()
    {
        return $this->hasMany('App\Models\CTHoaDon', 'id_hd', 'id');
    }
    public function KhachHang()
    {
        return $this->belongsTo('App\Models\KhachHang', 'id_kh', 'id');
    }
}
