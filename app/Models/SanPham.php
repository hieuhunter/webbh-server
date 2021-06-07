<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $primarykey = 'id';
    protected $guarded = [];

    public function DanhMuc()
    {
        return $this->belongsTo('App\Models\DanhMuc', 'id_dm', 'id_dm');
    }

    public function CTGioHang()
    {
        return $this->hasMany('App\Models\CTGioHang', 'id_sp', 'id');
    }
}
