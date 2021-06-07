<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTHoaDon extends Model
{
    protected $table = 'chitiet_hoadon';
    protected $primarykey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function SanPham()
    {
        return $this->belongsTo('App\Models\SanPham', 'id_sp', 'id');
    }
    public function HoaDon()
    {
        return $this->belongsTo('App\Models\HoaDon', 'id_hd', 'id');
    }
}
