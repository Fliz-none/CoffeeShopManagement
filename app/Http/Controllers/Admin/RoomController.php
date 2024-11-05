<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Room::query()->where('company_id', Auth::user()->company_id);
            switch ($request->key) {
                case 'load':
                    $rooms = Room::where('company_id', Auth::user()->company_id)->get();
                    return view('admin.includes.partials.rooms', compact('rooms')); // Đường dẫn đến view chứa danh sách phòng
                default:
                    $obj = $objs->find($request->key);
                    if ($obj) {
                        $result = $obj;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $rooms = Room::select('*')->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc');
                return DataTables::of($rooms)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('code', function ($obj) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-room" data-id="' . $obj->id . '"><b>' . $obj->code . '</b></a>';
                    })
                    ->editColumn('name', function ($obj) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-room" data-id="' . $obj->id . '"><b>' . $obj->name . '</b></a>';
                    })
                    ->editColumn('status', function ($obj) {
                        return $obj->statusStr;
                    })
                    ->addColumn('action', function ($obj) {
                        return '
                        <form method="post" action="' . route('admin.room.remove') . '" class="save-form">
                            <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>';
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'status', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý phòng';
                return view('admin.room', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:125']
        ];

        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 3 ký tự',
            'name.max' => 'Tên chứa tối đa 125 ký tự',
            'name.string' => 'Kiểu dữ liệu không hợp lệ',
        ];

        $request->validate($rules, $messages);

        $room = new Room([
            'name' => $request->name,
            'company_id' => Auth::user()->company_id,
            'note' => $request->note,
        ]);
        $room->save();
        $response = array(
            'status' => 'success',
            'msg' => 'Đã tạo ' . $room->name
        );

        return response()->json($response, 200);
    }


    public function update(Request $request)
    {
        $room = Room::find($request->id);

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:125']
        ];

        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 3 ký tự',
            'name.max' => 'Tên chứa tối đa 125 ký tự',
            'name.string' => 'Kiểu dữ liệu không hợp lệ',
        ];

        $request->validate($rules, $messages);
        if ($room) {
            $room->name = $request->name;
            $room->note = $request->note;
            $room->company_id = Auth::user()->company_id;
            $room->save();

            return response()->json([
                'status' => 'success',
                'msg' => 'Đã cập nhật thành công phòng ' . $room->name,
            ], 200);
        } else {
            return response()->json([
                'status' => 'danger',
                'msg' => 'Không tìm thấy phòng để cập nhật.',
            ], 404);
        }
    }


    public function remove(Request $request)
    {
        $rooms = [];
        foreach ($request->choices as $key => $id) {
            $room = Room::find($id);
            if ($room->status != 1 && $room->status != 2) {
                $room->delete();
            } else {
                return response()->json(['title' => 'Phòng đang hoạt động không thể xóa'], 422);
            }
            array_push($rooms, $room->name);
        }
        $response = array(
            'status' => 'success',
            'title' => 'Đã xóa phòng ' . implode(', ', $rooms)
        );
        return response()->json($response, 200);
    }
}
