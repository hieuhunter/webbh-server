<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTGioHang extends Model
{
    protected $table = 'chitiet_giohang';
    protected $primarykey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function SanPham()
    {
        return $this->belongsTo('App\Models\SanPham', 'id_sp', 'id');
    }
    public function GioHang()
    {
        return $this->belongsTo('App\Models\GioHang', 'id_gh', 'id');
    }
}
