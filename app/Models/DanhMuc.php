<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    protected $table = 'danhmuc';
    protected $primarykey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function SanPham()
    {
        return $this->hasMany('App\Models\SanPham', 'id_dm', 'id_dm');
    }
}
