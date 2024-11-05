<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\ExportDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    const NAME = 'chi tiết đơn hàng';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }

    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $obj = Detail::find($id);
            if ($obj) {
                // if($obj->quicktest) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu xét nghiệm nhanh']]], 422);
                // }
                // if($obj->ultrasound) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu siêu âm']]], 422);
                // }
                // if($obj->beauty) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu spa - grooming']]], 422);
                // }
                // if($obj->biochemical) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu sinh hóa máu']]], 422);
                // }
                // if($obj->bloodcell) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu XNTB máu']]], 422);
                // }
                // if($obj->microscope) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu soi kính hiển vi']]], 422);
                // }
                // if($obj->xray) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu X quang']]], 422);
                // }
                // if($obj->surgery) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu phẫu thuật']]], 422);
                // }
                // if($obj->treatment) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu điều trị']]], 422);
                // }
                // if($obj->hotel) {
                //     return response()->json(['errors' => ['message' => ['Dịch vụ đã thực hiện. Hãy thử xóa phiếu khách sạn']]], 422);
                // }
                if ($obj->stock_id != null) {
                    array_push($names, $obj->quantity . ' ' . $obj->_unit->term . ' ' . $obj->_stock->import_detail->_variable->_product->name . ' - ' . $obj->_stock->import_detail->_variable->name);
                    $obj->_stock->increment('quantity', $obj->quantity * $obj->_unit->rate);
                    $obj->export_detail->update(['quantity' => 0]);
                    $obj->update(['quantity' => 0]);
                    $obj->export_detail->delete();
                }
                $obj->delete();
            }
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Đã xóa chi tiết đơn hàng ' . implode(', ', $names),
        ], 200);
    }
}
