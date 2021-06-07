<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\GioHang;
use App\Models\CTGioHang;
use App\Models\CTHoaDon;
use App\Models\HoaDon;
use App\Models\KhachHang;

class ql_bachhoaxanhController extends Controller
{
    public function Sanpham()
    {
        $sp = SanPham::limit(4)->get();
        return response()->json([
            'success' => true,
            'data' => $sp

        ], 200);
    }
    public function ctsanpham($id)
    {
        $sp = SanPham::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'data' => $sp
        ]);
    }
    public function danhmuc()
    {
        $dm = DanhMuc::all();
        return response()->json([
            'success' => true,
            'data' => $dm
        ]);
    }
    public function sanphamtheodm($id)
    {

        $dm = SanPham::where('id_dm', $id)->get();
        return response()->json([
            'success' => true,
            'data' => $dm
        ]);
    }
    public function addgiohang(Request $request)
    {
        $ktgh = GioHang::where('id_kh', $request->user()->id)->get();

        if ($ktgh->count() < 1) {
            $payload = [
                'id_kh' => $request->user()->id,
            ];
            $gh = new GioHang($payload);
            $gh->save();
            $idgh = $gh->id;
        } else {
            $idgh = $ktgh->first()->id;
        }

        $ktct = CTGioHang::where('id_sp', $request->id_sp)->where('id_gh', $idgh)->get();
        if ($ktct->count() > 0) {
            $slsp = $ktct->first()->so_luong + $request->so_luong;
            if ($slsp < 1) {
                $delete =  CTGioHang::where('id_sp', $request->id_sp)
                    ->where('id_gh', $idgh)
                    ->delete();
                if ($delete) {
                    $response = [
                        'success' => true,
                        'data' => [$delete, $idgh]
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'errorMessage' => 'error 500',
                    ];
                }
            } else {
                //$slsp = $ktct->first()->so_luong + $request->so_luong;
                $giasp = $ktct->first()->gia + $request->so_luong * $request->gia;
                $updateCt = CTGioHang::where('id_sp', $request->id_sp)
                    ->where('id_gh', $idgh)
                    ->update(['so_luong' => $slsp, 'gia' => $giasp]);
                if ($updateCt) {
                    $response = [
                        'success' => true,
                        'data' => [$updateCt, $idgh]
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'errorMessage' => 'error 500',
                    ];
                }
            }
        } else {
            $slsp = $request->so_luong;
            $giasp = $request->so_luong * $request->gia;
            $ctgh = new CTGioHang;
            $ctgh->id_gh = $idgh;
            $ctgh->id_sp = $request->id_sp;
            $ctgh->so_luong = $slsp;
            $ctgh->gia = $giasp;
            $ctgh->save();
            if ($ctgh) {
                $response = [
                    'success' => true,
                    'data' => [$ctgh, $idgh]
                ];
            } else {
                $response = [
                    'success' => false,
                    'errorMessage' => 'error 500',
                ];
            }
        }
        return response()->json($response, 200);
    }
    public function danhsachgiohang(Request $request)
    {
        $danhsach_gh = GioHang::with('ctgiohang.sanpham')->where('id_kh', $request->user()->id)->first();
        return response()->json([
            'success' => true,
            'data' => $danhsach_gh
        ]);
    }
    public function xoagiohang(Request $request)
    {
        $ktgh = GioHang::where('id_kh', $request->user()->id)->first();
        $ctgh = CTGioHang::where('id_gh', $ktgh->id)->where('id_sp', $request->id_sp)->delete();
        if ($ctgh) {
            $response = [
                'success' => true,
                'data' => $ctgh
            ];
        } else {
            $response = [
                'success' => false,
                'data' => 'error'
            ];
        }
        return response()->json($response, 200);
    }
    public function xoatatcagh(Request $request)
    {
        $ktgh = GioHang::where('id_kh', $request->user()->id)->first();
        $ctgh = CTGioHang::where('id_gh', $ktgh->id)->delete();
        if ($ctgh) {
            $response = [
                'success' => true,
                'data' => $ctgh
            ];
        } else {
            $response = [
                'success' => false,
                'data' => 'error'
            ];
        }
        return response()->json($response, 200);
    }
    public function thanhtoan(Request $request)
    {

        $hoadon = new HoaDon;
        $hoadon->id_kh = $request->user()->id;
        $hoadon->ho_ten = $request->ho_ten;
        $hoadon->email = $request->email;
        $hoadon->sdt = $request->sdt;
        $hoadon->dia_chi = $request->dia_chi;
        $hoadon->ngay_dat = $request->ngay_dat;
        $hoadon->ngay_giao = $request->ngay_giao;
        $hoadon->da_duyet = 0;
        $hoadon->da_thanh_toan = 0;
        $hoadon->da_giao_hang = 0;
        $hoadon->phuong_thuc_thanh_toan = 0;
        $hoadon->phi_van_chuyen = $request->phi_van_chuyen;
        $hoadon->Ma_buudien = $request->Ma_buudien;
        $hoadon->save();
        $idhd = $hoadon->id;
        foreach ($request->gio_hang as $key => $giohang) {
            $cthoadon = new CTHoaDon();
            $cthoadon->id_hd = $idhd;
            $cthoadon->id_sp = $giohang['sanpham']['id'];
            $cthoadon->gia = $giohang['gia'];
            $cthoadon->so_luong = $giohang['so_luong'];
            $cthoadon->save();
        }
        $ktgh = GioHang::where('id_kh', $request->user()->id)->first();
        CTGioHang::where('id_gh', $ktgh->id)->delete();
        $response = [
            'success' => true,
            'data' => 'thanhcong'
        ];
        return response()->json($response, 200);
    }
    public function thongtin(Request $request)
    {
        $ktkh = User::select('id', 'ho_ten', 'user_name', 'email', 'sdt', 'dia_chi')->where('id', $request->user()->id)->first();
        if ($ktkh) {
            $response = [
                'success' => true,
                'data' => $ktkh
            ];
        } else {
            $response = [
                'success' => false,
                'data' => 'error'
            ];
        }
        return response()->json($response, 200);
    }
}
