<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->key)) {
            $schedules = Schedule::query()->where('company_id', Auth::user()->company_id);
            switch ($request->key) {
                case 'list':
                    return response()->json($schedules->get(), 200);
                case 'select2':
                    break;
                default:
                    $schedule = $schedules->find($request->key);
                    if ($schedule) {
                        $result = $schedule;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $schedules = Schedule::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc');
                return DataTables::of($schedules)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-schedule" data-id="' . $obj->id . '"><b>' . $obj->code . '</b></a>';
                    })
                    ->editColumn('user_id', function ($obj) {
                        return $obj->user->name;
                    })
                    ->editColumn('start_time', function ($obj) {
                        return date('d-m-Y H:i', strtotime($obj->start_time));
                    })
                    ->editColumn('end_time', function ($obj) {
                        return date('d-m-Y H:i', strtotime($obj->end_time));
                    })
                    // ->editColumn('slot', function ($obj) {
                    //     return $obj->slot;
                    // })
                    ->addColumn('action', function ($obj) {
                        return '<form method="post" action="' . route('admin.schedule.remove') . '" class="save-form">
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                                    <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>';
                    })
                    ->rawColumns(['checkboxes', 'start_time', 'end_time', 'code', 'action'])
                    ->make(true);
            } else {
                $users = User::all()->filter(function ($user) {
                    return $user->getRoleNames()->isNotEmpty() && $user->getRoleNames()[0] !== 'Admin';
                });
                $pageName = 'Quản lý lịch làm việc';
                return view('admin.schedules', compact('pageName', 'users'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'date' => ['required'],
            'user_id' => ['required'],
            'slot' => ['required', 'integer', 'min:1'],
        ];

        $messages = [
            'user_id.required' => 'Chọn một nhân viên',
            'date.required' => 'Ngày không thể để trống',
            'slot.required' => 'Số lượng slot không được để trống',
        ];

        $request->validate($rules, $messages);

        // Giải mã slot_times từ JSON
        $slot_times = json_decode($request->slot_times);

        // Tạo Schedule cho mỗi slot time
        foreach ($slot_times as $time) {
            list($startHour, $endHour) = explode('-', $time);

            // Kiểm tra và điều chỉnh endHour nếu là 24
            if ($endHour == 24) {
                $endHour = 0; // Đặt endHour về 0
                $date = date('Y-m-d', strtotime($request->date . ' +1 day')); // Tăng ngày thêm 1
            } else {
                $date = $request->date; // Ngày không thay đổi
            }

            // Kết hợp ngày với giờ để tạo start_time và end_time
            $start_time = $request->date . ' ' . $startHour . ':00:00';
            $end_time = $date . ' ' . $endHour . ':00:00';

            // Tạo lịch làm việc
            Schedule::create([
                'company_id' => Auth::user()->company_id,
                'branch_id' => Auth::user()->main_branch ?? 1,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'slot' => $request->slot,
                'user_id' => $request->user_id, // Nếu bạn cũng muốn lưu user_id
            ]);
        }

        $response = [
            'status' => 'success',
            'msg' => 'Đã tạo lịch làm việc'
        ];

        return response()->json($response, 200);
    }


    public function update(Request $request)
    {
        $rules = [
            'date' => ['required'],
            'user_id' => ['required'],
            'slot' => ['nullable', 'integer', 'min:1'],
        ];

        $messages = [
            'user_id.required' => 'Chọn một nhân viên',
            'date.required' => 'Ngày không thể để trống',
        ];

        $request->validate($rules, $messages);

        // Giải mã slot_times từ JSON
        $slot_times = json_decode($request->slot_times);

        // Tạo Schedule cho mỗi slot time
        foreach ($slot_times as $time) {
            list($startHour, $endHour) = explode('-', $time);

            // Kiểm tra và điều chỉnh endHour nếu là 24
            if ($endHour == 24) {
                $endHour = 0; // Đặt endHour về 0
                $date = date('Y-m-d', strtotime($request->date . ' +1 day')); // Tăng ngày thêm 1
            } else {
                $date = $request->date; // Ngày không thay đổi
            }

            // Kết hợp ngày với giờ để tạo start_time và end_time
            $start_time = $request->date . ' ' . $startHour . ':00:00';
            $end_time = $date . ' ' . $endHour . ':00:00';

            $schedule = Schedule::find($request->id);

            $schedule->update([
                'company_id' => Auth::user()->company_id,
                'branch_id' => Auth::user()->main_branch ?? 1,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'slot' => $request->slot,
                'user_id' => $request->user_id,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Đã cập nhật thành công lịch làm việc'
        ], 200);

    }

    public function remove(Request $request)
    {
        $schedules = [];
        foreach ($request->choices as $id) {
            $schedule = Schedule::find($id);
            if ($schedule) {
                $schedule->delete();
                $schedules[] = $schedule->id;
            }
        }
        $response = [
            'status' => 'success',
            'msg' => 'Đã xóa lịch làm việc: ' . implode(', ', $schedules)
        ];
        return response()->json($response, 200);
    }
}
