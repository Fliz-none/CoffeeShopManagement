<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Lấy logs theo công ty của người dùng hiện tại
            $logs = Log::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc');

            return DataTables::of($logs)
                ->addColumn('user', function ($log) {
                    return $log->user_id; // Hiển thị ID người dùng, có thể thay đổi thành tên người dùng nếu có
                })
                ->addColumn('action', function ($log) {
                    return $log->action;
                })
                ->addColumn('type', function ($log) {
                    return $log->type;
                })
                ->addColumn('object', function ($log) {
                    return $log->object;
                })
                ->addColumn('geolocation', function ($log) { $geo = json_decode($log->geolocation, true);
                    if ($geo) {
                        // Tạo danh sách HTML từ dữ liệu geolocation
                        return '<ul>' .
                            '<li>IP: ' . ($geo['ip'] ?? '') . '</li>' .
                            '<li>Hostname: ' . ($geo['hostname'] ?? '') . '</li>' .
                            '<li>City: ' . ($geo['city'] ?? '') . '</li>' .
                            '<li>Region: ' . ($geo['region'] ?? '') . '</li>' .
                            '<li>Country: ' . ($geo['country'] ?? '') . '</li>' .
                            '<li>Location: ' . ($geo['loc'] ?? '') . '</li>' .
                            '<li>Org: ' . ($geo['org'] ?? '') . '</li>' .
                            '<li>Postal: ' . ($geo['postal'] ?? '') . '</li>' .
                            '<li>Timezone: ' . ($geo['timezone'] ?? '') . '</li>' .
                            '</ul>';
                    }
                    return '';
                })
                ->addColumn('device', function ($log) {
                    return $log->device;
                })
                ->addColumn('created_at', function ($log) {
                    return $log->created_at;
                })
                ->rawColumns(['geolocation'])
                ->make(true);
        } else {
            $pageName = 'Nhật ký hệ thống';
            return view('admin.logs', compact('pageName'));
        }
    }

    static function create($action, $object, $object_id, $ip = null)
    {
        $agent = new Agent();
        $geolocation = Http::get('https://ipinfo.io/' . session('ip') . '/json?token=d89e4a0555c438')->json();
        Log::create([
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'action' => $action,
            'type' => $object,
            'object' => $object_id,
            'geolocation' => json_encode($geolocation),
            'device' => ($agent->isRobot()) ? $agent->robot() : $agent->device(),
        ]);
    }
}
