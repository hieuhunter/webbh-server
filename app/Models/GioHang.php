<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    protected $table = 'giohang';
    protected $primarykey = 'id';
    public $timestamps = false;
    public $incrementing = true;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_kh', 'id');
    }
    public function CTGioHang()
    {
        return $this->hasMany('App\Models\CTGioHang', 'id_gh', 'id');
    }
}
