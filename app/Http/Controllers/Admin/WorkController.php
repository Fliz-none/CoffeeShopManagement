<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;
use Str;
use Yajra\DataTables\DataTables;

class WorkController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pageName = 'Thống kê giờ công';
        $settings = Auth::user()->company;
        return view('admin.work', compact('pageName', 'settings'));
    }

    public function management()
    {
        $pageName = 'Các chấm công';
        $settings = Auth::user()->company;
        return view('admin.work_management', compact('pageName', 'settings'));
    }

    public function load(Request $request)
    {
        $start = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $end = Carbon::createFromFormat('Y-m', $request->month)->endOfMonth();
        return Work::with('user')->whereBetween('created_at', [$start, $end])->get();
    }

    public function loadList()
    {
        $works = Work::all();
        return DataTables::of($works)
            ->editColumn('user_id', function ($obj) {
                return '<a class="btn btn-link text-decoration-none btn-update-work text-primary" data-id="' . $obj->id . '">' . $obj->user->name . '</a>';
            })
            ->editColumn('status', function ($obj) {
                return ($obj->status == 0) ? 'Checkin' : 'Checkout';
            })
            ->editColumn('image', function ($obj) {
                return '<img src="' . $obj->thumb . '" style="width: 100px; height: 100px; object-fit: cover" class="thumb cursor-pointer">';
            })
            ->editColumn('created_at', function ($obj) {
                return Carbon::parse($obj->created_at)->format('d/m/Y H:i:s');
            })
            ->rawColumns(['checkbox', 'user_id', 'image'])
            ->make(true);
    }

    public function get(Request $request)
    {
        if ($request->has('id')) {
            $work = Work::with('user')->find($request->id);
            return array(
                'work' => $work,
                'workAfter' => Work::where('id', '>', $request->id)->where('user_id', $work->user_id)->orderBy('id', 'asc')->first(),
                'workBefore' => Work::where('id', '<', $request->id)->where('user_id', $work->user_id)->orderBy('id', 'desc')->first(),
            );
        } else {
            return Work::with('user')->whereDate('created_at', $request->date)->orderBy('works.user_id')->get();
        }
    }

    public function create(Request $request)
    {
        $settings = Auth::user()->company;
        $data = $request->base64data;
        $image = explode('base64', $data);
        $imageName = Str::slug(Auth::user()->name) . '_' . Carbon::now()->format('d-m-Y_h-i-s') . '.jpg';
        // file_put_contents($imageName, base64_decode($image[1]));
        Storage::disk('public')->put('checkin/' . $imageName, base64_decode($image[1]));
        // if (!$settings['ip_attendance_required'] || $request->ip() == gethostbyname($settings['ip'])) {
            $work = Work::create([
                'user_id' => Auth::user()->id,
                'status' => $request->status,
                'img' => $imageName,
                'company_id' => Auth::user()->company_id,
            ]);
            // LogController::create('tạo', 'chấm công của ' . Auth::user()->name,  $work->id);
            if ($work) {
                $response = array(
                    'obj' => $work,
                    'status' => 'success',
                    'title' => 'Đã chấm công ' . ( $work->status ? 'ra' : 'vào' ) . ' lúc ' . Carbon::now()->format('H:i'),
                );
            } else {
                $response = array(
                    'status' => 'danger',
                    'title' => 'Đã có lỗi xảy ra! Vui lòng thử lại sau!',
                );
            }
        // } else {
        //     $response = array(
        //         'status' => 'danger',
        //         'title' => 'Hãy sử dụng kết nối wifi nơi làm việc',
        //     );
        // }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'work_created_at' => ['required'],
        ];
        $messages = [
            'work_created_at.required' => 'Thời gian đã chọn không hợp lệ!',
        ];
        $request->validate($rules, $messages);
        $work = Work::find($request->id);
        if ($work) {
            $work->created_at = Carbon::parse($request->work_created_at)->format('Y-m-d H:i:s');
            $work->save();
            LogController::create('cập nhật', 'chấm công của ' . Auth::user()->name,  $work->id);
            $response = array(
                'obj' => $work,
                'status' => 'success',
                'title' => 'Đã cập nhật thành công lượt chấm công của ' . $work->user->name,
            );
        } else {
            $response = array(
                'status' => 'danger',
                'title' => 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại sau.',
            );
        }
        return response()->json($response, 200);
    }

    public function attendance()
    {
        $settings = Auth::user()->company;
        $work = Work::where('user_id', Auth::user()->id)->latest()->first();

        $sumWorkTimes = 0;
        //Các lần đã chấm công trong ngày
        $works = Work::whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'asc')
            ->get();
        if (count($works)) {
            if ($works[0]->status == 0 && $works[count($works) - 1]->status == 1) {
                foreach ($works as $index => $work) {
                    if ($work->status == 1) {
                        $sumWorkTimes = $sumWorkTimes + $work->created_at->diffInMinutes($works[$index - 1]->created_at);
                    }
                }
            } elseif ($works[0]->status == 0 && $works[count($works) - 1]->status == 0) {
                foreach ($works as $index => $work) {
                    if ($work->status == 1) {
                        $sumWorkTimes = $sumWorkTimes + $work->created_at->diffInMinutes($works[$index - 1]->created_at);
                    }
                    if ($index == (count($works) - 1)) {
                        $duration = Carbon::now()->diffInMinutes($work->created_at);
                        if ($duration >= ($settings['standard_attendance_time']) * 60) {
                            $sumWorkTimes = $sumWorkTimes + ((int)$settings['standard_attendance_time'] * 60);
                        } else {
                            $sumWorkTimes = $sumWorkTimes + Carbon::now()->diffInMinutes($work->created_at);
                        }
                    }
                }
            } elseif ($works[0]->status == 1 && $works[count($works) - 1]->status == 1) {
                foreach ($works as $index => $work) {
                    if ($index == 0) {
                        $duration = $work->created_at->diffInMinutes(Carbon::parse($work->created_at->startOfDay())->format('Y-m-d'));
                        if ($duration >= ($settings['standard_attendance_time']) * 60) {
                            $sumWorkTimes = $sumWorkTimes + ((int)$settings['standard_attendance_time'] * 60);
                        } else {
                            $sumWorkTimes = $sumWorkTimes + $duration;
                        }
                    }
                    if ($work->status == 1 && $index != 0) {
                        $sumWorkTimes = $sumWorkTimes + $work->created_at->diffInMinutes($works[$index - 1]->created_at);
                    }
                }
            } elseif ($works[0]->status == 1 && $works[count($works) - 1]->status == 0) {
                foreach ($works as $index => $work) {
                    if ($index == 0) {
                        $duration = $work->created_at->diffInMinutes(Carbon::parse($work->created_at->startOfDay())->format('Y-m-d'));
                        if ($duration >= ($settings['standard_attendance_time']) * 60) {
                            $sumWorkTimes = $sumWorkTimes + ((int)$settings['standard_attendance_time'] * 60);
                        } else {
                            $sumWorkTimes = $sumWorkTimes + $duration;
                        }
                    }
                    if ($work->status == 1 && $index != 0) {
                        $sumWorkTimes = $sumWorkTimes + $work->created_at->diffInMinutes($works[$index - 1]->created_at);
                    }
                    if ($index == (count($works) - 1)) {
                        $duration = Carbon::now()->diffInMinutes($work->created_at);
                        if ($duration >= ($settings['standard_attendance_time']) * 60) {
                            $sumWorkTimes = $sumWorkTimes + ((int)$settings['standard_attendance_time'] * 60);
                        } else {
                            $sumWorkTimes = $sumWorkTimes + Carbon::now()->diffInMinutes($work->created_at);
                        }
                    }
                }
            }
        }
        if ($work && $work->status == 0) {
            // Kiem tra duration tu $work->created_at den Carbon::now()
            $duration = Carbon::now()->diffInMinutes($work->created_at);
            if ($duration >= ($settings['standard_attendance_time'] + 1) * 60) {
                $work->status = 1;
            }
        }
        $validToAttendance = ($sumWorkTimes / 60 <= (int)($settings['max_attendance_time'] + 1));
        $pageName = 'Chấm công';
        $agent = new Agent();

        return view('admin.attendance', compact('pageName', 'agent', 'work', 'settings', 'validToAttendance'));
    }

    public function summary(Request $request)
    {
        $startOfMonth = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $request->month)->endOfMonth();
        return Work::with('user')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get()->groupBy('user_id');
    }

}
