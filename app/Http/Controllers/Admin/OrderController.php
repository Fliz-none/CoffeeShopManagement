<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addition;
use App\Models\Detail;
use App\Models\Export;
use App\Models\ExportDetail;
use App\Models\Order;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use App\Models\User;

class OrderController extends Controller
{
    const NAME = 'đơn hàng';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware('auth');
        // $this->middleware(['verified','auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Order::select('*')->where('orders.company_id', $this->user->company_id);
            // dd($request->key);
            switch ($request->key) {
                case 'getById':
                    $order = Order::with(['details.product', 'transactions.cashier', 'dealer', 'tables', 'additions'])->find($request->action);
                    return response()->json($order, 200);
                    case 'getByRoom':
                        $order = Order::with('customer')->whereHas('room', function ($query) use ($request) {
                            $query->where('rooms.id', $request->action);
                        })->with(['transactions.cashier', 'dealer', 'room'])->first();
                        if ($order) {
                            return response()->json($order, 200);
                        } else {
                            return 0;
                        }
                case 'getByTable':
                    $order = Order::with('customer')->whereHas('tables', function ($query) use ($request) {
                        $query->where('tables.id', $request->action);
                    })
                        ->whereNull('checkout_at')
                        ->with(['details.product', 'transactions.cashier', 'dealer', 'tables', 'additions'])
                        ->first();
                    if ($order) {
                        return response()->json($order, 200);
                    } else {
                        return 0;
                    }
                case 'pos':
                    $pageName = 'Bán hàng';
                    $settings = cache()->get('settings');
                    $bankInfos = [];
                    $rooms = Room::where('company_id', Auth::user()->company_id)->get();
                    // isset($settings['bank_info']) ? json_decode($settings['bank_info'], true) :
                    return view('admin.order', compact('pageName', 'bankInfos', 'rooms'));
                default:
                    $obj = $objs->with(['details.product', 'transactions.cashier', 'dealer', 'tables', 'additions'])->find($request->key);
                    if ($obj) {
                        switch ($request->action) {
                            case 'print':
                                return view('admin.templates.prints.order', ['order' => $obj]);
                            default:
                                $result = $obj;
                                break;
                        }
                    } else {
                        abort(404);
                    }
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Order::where('orders.company_id', $this->user->company_id)
                    ->with('branch', 'details');
                $can_read_order = $this->user->can(User::READ_ORDER);
                $can_read_user = $this->user->can(User::READ_USER);
                $can_delete_order = $this->user->can(User::DELETE_ORDER);
                $can_create_transaction = $this->user->can(User::CREATE_TRANSACTION);
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) use ($can_read_order) {
                        $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        return $code . '<br/><small>' . $obj->created_at->format('d/m/Y H:i') . '</small>';
                    })
                    ->filterColumn('code', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = (count($array) == 3 ? $array[2] : date('Y')) . '-' . str_pad($array[1], 2, "0", STR_PAD_LEFT) . '-' . str_pad($array[0], 2, "0", STR_PAD_LEFT);
                            $query->whereDate('created_at', $date);
                        });
                        $query->when(count($array) == 1, function ($query) use ($keyword) {
                            $numericKeyword = ltrim(preg_replace('/[^0-9]/', '', $keyword), '0');
                            if (!empty($numericKeyword)) {
                                $query->where('orders.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('customer', function ($obj) use ($can_read_user) {
                        if ($obj->customer_id) {
                            if ($can_read_user) {
                                return '<a class="btn btn-update-user text-primary text-start" data-id="' . optional($obj->customer)->id . '">' . optional($obj->customer)->fullName . '</a>';
                            }
                            return '<span class="fw-bold">' . $obj->_customer->name . '</span>';
                        } else {
                            return 'Vô danh';
                        }
                    })
                    ->filterColumn('customer', function ($query, $keyword) {
                        $query->whereHas('customer', function ($query) use ($keyword) {
                            $query->where('cutomers.name', 'like', "%" . $keyword . "%")
                                ->orWhere('cutomers.phone', 'like', "%" . $keyword . "%")
                                ->orWhere('cutomers.email', 'like', "%" . $keyword . "%")
                                ->orWhere('cutomers.address', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('customer', function ($query, $order) {
                        $query->select('orders.*', 'cutomers.name')->join('cutomers', 'orders.customer_id', '=', 'cutomers.id')
                            ->orderBy('cutomers.name', $order);
                    })
                    ->editColumn('dealer', function ($obj) use ($can_read_user) {
                        if ($can_read_user) {
                            return '<a class="btn btn-update-user text-primary text-start" data-id="' . $obj->dealer_id . '">' . optional($obj->dealer)->fullName . '</a>';
                        }
                        return '<span class="fw-bold">' . $obj->_dealer->name . '</span>';
                    })
                    ->filterColumn('dealer', function ($query, $keyword) {
                        $query->whereHas('dealer', function ($query) use ($keyword) {
                            $query->where('users.name', 'like', "%" . $keyword . "%")
                                ->orWhere('users.phone', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->orderColumn('dealer', function ($query, $order) {
                        $query->join('users', 'orders.dealer_id', '=', 'users.id')
                            ->orderBy('users.name', $order);
                    })
                    ->addColumn('paid', function ($obj) {
                        if ($obj->total > $obj->paid) {
                            $color = 'danger';
                            $minus = 'Thiếu ' . number_format($obj->total - $obj->paid);
                        } elseif ($obj->total < $obj->paid) {
                            $color = 'success';
                            $minus = 'Thừa ' . number_format($obj->paid - $obj->total);
                        } else {
                            $color = 'primary';
                            $minus = 'Thu đủ';
                        }
                        return '<div class="row justify-content-end">
                            <div class="col-6 border-end text-' . $color . '"><a data-bs-toggle="tooltip" data-bs-title="' . $minus . '">' . number_format($obj->paid) . '</a></div>
                            <div class="col-auto fw-bold">' . number_format($obj->total) . '</div>
                        </div>';
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) use ($can_delete_order, $can_create_transaction) {
                        if ($can_create_transaction) {
                            if ($obj->total > $obj->paid) {
                                $btnTransaction = '<button
                                                    type="button"
                                                    class="btn btn-link text-decoration-none btn-create-transaction text-danger"
                                                    data-bs-toggle="tooltip" data-bs-title="Thiếu ' . number_format($obj->total - $obj->paid) . '"
                                                    data-order="' . $obj->id . '"
                                                    data-customer="' . $obj->_customer_id . '"
                                                    data-amount="' . ($obj->total - $obj->paid) . '">
                                                            <i class="bi bi-coin"></i>
                                                    </button>';
                            } elseif ($obj->total < $obj->paid) {
                                $btnTransaction = '<button
                                                    type="button"
                                                    class="btn btn-link text-decoration-none btn-create-transaction text-success"
                                                    data-bs-toggle="tooltip" data-bs-title="Thừa ' . number_format($obj->paid - $obj->total) . '"
                                                    data-order="' . $obj->id . '"
                                                    data-customer="' . $obj->_customer_id . '"
                                                    data-amount="' . ($obj->total - $obj->paid) . '">
                                                            <i class="bi bi-coin"></i>
                                                    </button>';
                            } else {
                                $btnTransaction = '';
                            }
                        }
                        if ($can_delete_order) {
                            return $btnTransaction . '
                                <form action="' . route('admin.order.remove') . '" method="post" class="save-form d-inline-block">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'customer', 'sku', 'paid', 'branch', 'dealer', 'catalogue', 'status', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.orders', compact('pageName'));
            }
        }
    }

    public function booking(Request $request)
    {
        $rules = [
            'room_id' => 'required|exists:rooms,id',
            'note' => 'nullable|string|max:255',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'id' => 'nullable|exists:bookings,id'
        ];

        $messages = [
            'room_id.required' => 'Phòng là trường bắt buộc.',
            'room_id.exists' => 'Phòng được chọn không tồn tại.',
            'note.string' => 'Ghi chú phải là một chuỗi.',
            'note.max' => 'Ghi chú không được vượt quá :max ký tự.',
            'start_time.required' => 'Thời gian bắt đầu là trường bắt buộc.',
            'start_time.date' => 'Thời gian bắt đầu phải là ngày hợp lệ.',
            'start_time.before' => 'Thời gian bắt đầu phải trước thời gian kết thúc.',
            'end_time.required' => 'Thời gian kết thúc là trường bắt buộc.',
            'end_time.date' => 'Thời gian kết thúc phải là ngày hợp lệ.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
            'id.exists' => 'Không tìm thấy phòng.'
        ];
        $request->validate($rules, $messages);
        if (Auth::user()->can(User::CREATE_ORDER)) {
            $orderData['branch_id'] = Auth::user()->main_branch ?? 1;
            $orderData['company_id'] = Auth::user()->company_id ?? 1;
            $orderData['room_id'] = $request->room_id;
            $order = Order::create($orderData);
            if ($order) {
                $room = Room::find($order->room_id);
                $room->update(['status' => 1, 'start_time' => $request->start_time, 'end_time' => $request->end_time]);
                $response = array(
                    'status' => 'success',
                    'title' => 'Đã book phòng ' . $room->name,
                );
            } else {
                $response = array(
                    'status' => 'danger',
                    'title' => 'Đã có lỗi xảy ra trong quá trình đặt phòng',
                );
            }
            return response()->json($response, 200);
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
    }

    public function update(Request $request)
    {
        $rules = [
            //Đơn hàng
            'customer_id' => [
                'numeric'
            ],
            'discount' => ['nullable', 'numeric'],
            'note' => ['nullable', 'string', 'max:125'],
            'id' => ['nullable', 'numeric'],

            //Chi tiết đơn hàng
            'stock_ids' => ['required', 'array'],
            'prices' => ['required', 'array'],
            'discounts' => ['required', 'array'],
            'quantities' => ['required', 'array'],
            'notes' => ['array'],
            'ids' => ['array'],

            'stock_ids.*' => ['required', 'numeric'],
            'prices.*' => ['required', 'numeric'],
            'discounts.*' => ['nullable', 'numeric'],
            'quantities.*' => ['required', 'numeric'],
            'notes.*' => ['nullable', 'string', 'max:125'],
            'ids.*' => ['nullable', 'numeric'],

            //Thanh toán
            'transaction_payments' => ['nullable', 'array'],
            'transaction_amounts' => ['nullable', 'array'],
            'transaction_payments.*' => ['required', 'numeric'],
            'transaction_amounts.*' => ['required', 'numeric'],
        ];
        $messages = [
            //Đơn hàng
            'customer_id.numeric' => 'Khách hàng: ' . Controller::DATA_INVALID,
            'discount.numeric' => 'Giảm giá đơn hàng: ' . Controller::DATA_INVALID,
            'note.string' => 'Ghi chú đơn hàng: ' . Controller::DATA_INVALID,
            'note.max' => 'Ghi chú đơn hàng: ' . Controller::MAX,
            'id.numeric' => 'Mã đơn hàng: ' . Controller::DATA_INVALID,

            //Chi tiết đơn hàng
            'stock_ids.required' => 'Hàng hóa: ' . Controller::ONE_LEAST,
            'stock_ids.array' => 'Hàng hóa: ' . Controller::DATA_INVALID,
            'unit_ids.required' => 'Mã đơn vị tính: ' . Controller::ONE_LEAST,
            'unit_ids.array' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'prices.required' => 'Đơn giá hàng hóa: ' . Controller::ONE_LEAST,
            'prices.array' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'discounts.required' => 'Giảm giá hàng hóa: ' . Controller::ONE_LEAST,
            'discounts.array' => 'Giảm giá hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.required' => 'Số lượng hàng hóa: ' . Controller::ONE_LEAST,
            'quantities.array' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'rates.required' => 'Đơn vị tính hàng hóa: ' . Controller::ONE_LEAST,
            'rates.array' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'notes.array' => 'Ghi chú hàng hóa: ' . Controller::DATA_INVALID,
            'ids.required' => 'Mã chi tiết đơn hàng: ' . Controller::ONE_LEAST,
            'ids.array' => 'Mã chi tiết đơn hàng: ' . Controller::DATA_INVALID,

            'stock_ids.*.required' => 'Hàng hóa: ' . Controller::DATA_INVALID,
            'stock_ids.*.numeric' => 'Hàng hóa: ' . Controller::DATA_INVALID,
            'unit_ids.*.required' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'unit_ids.*.numeric' => 'Mã đơn vị tính: ' . Controller::DATA_INVALID,
            'prices.*.required' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'prices.*.numeric' => 'Đơn giá hàng hóa: ' . Controller::DATA_INVALID,
            'discounts.*.numeric' => 'Giảm giá hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.required' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'quantities.*.numeric' => 'Số lượng hàng hóa: ' . Controller::DATA_INVALID,
            'rates.*.required' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'rates.*.numeric' => 'Đơn vị tính hàng hóa: ' . Controller::DATA_INVALID,
            'notes.*.string' => 'Ghi chú hàng hóa: ' . Controller::DATA_INVALID,
            'ids.*.numeric' => 'Mã chi tiết đơn hàng: ' . Controller::DATA_INVALID,

            //Thanh toán
            'transaction_payments.array' => 'Hình thức thanh toán: ' . Controller::DATA_INVALID,
            'transaction_amounts.array' => 'Số tiền thanh toán: ' . Controller::DATA_INVALID,
            'transaction_refund.array' => 'Trạng thái hoàn tiền: ' . Controller::DATA_INVALID,

            'transaction_payments.*.required' => 'Hình thức thanh toán: ' . Controller::NOT_EMPTY,
            'transaction_refund.*.required' => 'Trạng thái hoàn tiền: ' . Controller::NOT_EMPTY,
            'transaction_refund.*.numeric' => 'Trạng thái hoàn tiền: ' . Controller::DATA_INVALID,
            'transaction_amounts.*.required' => 'Số tiền thanh toán: ' . Controller::NOT_EMPTY,
            'transaction_amounts.*.numeric' => 'Số tiền thanh toán: ' . Controller::DATA_INVALID,
        ];
        $request->validate($rules, $messages);
        if (!empty($this->user->can(User::UPDATE_ORDER))) {
            if ($request->has('id')) {
                if (!$request->has('id') && !$request->has('transaction_payments') && !$request->has('customer_id')) {
                    return response()->json(['errors' => ['customer_required' => ['Khách hàng: Vui lòng chọn một khách hàng để lưu công nợ!']]], 422);
                }
                DB::beginTransaction();
                try {
                    $order = Order::find($request->id);
                    if ($order) {
                        $order->update([
                            'customer_id' => $request->customer_id,
                            'dealer_id' => Auth::id(),
                            'method' => 1,
                            'discount' => $request->discount,
                            'status' => $request->has('status') ? $request->status : 0,
                            'note' => $request->note,
                            'company_id' => Auth::user()->company_id,
                        ]);
                        if ($request->has('transaction_payments') && count($request->transaction_payments)) {
                            foreach ($request->transaction_payments as $i => $payment) {
                                $refund = $request->transaction_refund[$i] ? -1 : 1;
                                Transaction::create([
                                    'order_id' => $order->id,
                                    'customer_id' => $request->customer_id,
                                    'cashier_id' => Auth::id(),
                                    'payment' => $request->transaction_payments[$i],
                                    'amount' => $request->transaction_amounts[$i] * $refund,
                                    'date' => Carbon::now(),
                                    'note' => $request->transaction_notes[$i] . ' - ' . $order->code,
                                    'company_id' => Auth::user()->company_id,
                                ]);
                            }
                        }

                        LogController::create('sửa', self::NAME, $order->id);
                        $response = array(
                            'id' => $order->id,
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . self::NAME . ' ' . $order->code
                        );
                        DB::commit();
                    } else {
                        DB::rollBack();
                        $response = [
                            'status' => 'danger',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!',
                        ];
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    Controller::resetAutoIncrement('orders');
                    Controller::resetAutoIncrement('details');
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e]]], 422);
                }
            } else {
                $response = [
                    'status' => 'danger',
                    'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!',
                ];
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    //Sync bill
    public function sync(Request $request)
    {
        try {
            $bill = $request->all();
            $order = Order::updateOrCreate([
                'id' => isset($bill['status']) && $bill['status'] > 0 ? $bill['id'] : null
            ], [
                'branch_id' => Auth::user()->main_branch ?? 1,
                'company_id' => Auth::user()->company_id ?? 1,
                'customer_id' => isset($bill['customer_id']) ? $bill['customer_id'] : null,
                'dealer_id' => Auth::id(),
                'method' => $bill['method'] ?? null,
                'note' => $bill['note'] ?? null,
            ]);

            if ($order) {
                LogController::create(isset($bill['status']) ? 'cập nhật' : 'thêm', self::NAME, $order->id);
                if (isset($bill['tables'])) {
                    $tableIds = array_map(function ($item) {
                        return $item['id'];
                    }, $bill['tables']);
                    $order->syncTables($tableIds);
                    $order->tables()->update(['status' => 1]);
                    Cache::forget('tables');
                }

                $order->additions()->delete();
                if (isset($bill['additions'])) {
                    foreach ($order->additions as $key => $addition) {
                        $exist = false;
                        foreach ($bill['additions'] as $key => $item) {
                            if ($item['id'] == $addition->id) {
                                $exist = true;
                            }
                        }
                        if (!$exist) {
                            $addition->delete();
                        }
                    }
                    foreach ($bill['additions'] as $key => $addition) {
                        Addition::updateOrCreate([
                            'id' => $addition['status'] > 0 ? $addition['id'] : null
                        ], [
                            'order_id' => $order->id,
                            'type' => $addition['type'],
                            'note' => $addition['note'],
                            'amount' => $addition['amount']
                        ]);
                    }
                }

                if (isset($bill['details'])) {
                    foreach ($order->details as $key => $detail) {
                        $exist = false;
                        foreach ($bill['details'] as $key => $item) {
                            if ($item['id'] == $detail->id) {
                                $exist = true;
                            }
                        }
                        if (!$exist) {
                            $detail->delete();
                        }
                    }

                    foreach ($bill['details'] as $key => $detail) {
                        $detail = Detail::updateOrCreate([
                            'id' => $detail['status'] > 0 ? $detail['id'] : null
                        ], [
                            'order_id' => $order->id,
                            'product_id' => $detail['product']['id'],
                            'quantity' => $detail['quantity'],
                            'price' => $detail['price'],
                            'note' => $detail['note']
                        ]);

                        LogController::create(isset($bill['status']) ? 'cập nhật' : 'thêm', 'chi tiết đơn hàng', $detail->id);
                    }
                }
                $action = $bill['status'] ? 'Đã cập nhật' : 'Đã thêm';
                $response = array(
                    'bill' => $order,
                    'status' => 'success',
                    'title' => $action . ' thành công bàn ' . implode(', ', $order->tables->pluck('name')->toArray()),
                );
                Cache::forget('products');
            } else {
                $response = array(
                    'bill' => $order,
                    'status' => 'danger',
                    'title' => 'Đã có lỗi xảy ra trong quá trình tạo đơn hàng',
                );
            }

            // Dừng 500ms trước khi trả về response
            // usleep(100000);

            return response()->json($response, 200);

        } catch (\Exception $exception) {
            $response = array(
                'status' => 'danger',
                'title' => 'Đã có lỗi xảy ra trong quá trình tạo đơn hàng',
            );
            return response()->json($response, 200);
        }
    }

    public function paybooking(Request $request)
    {
        $transactionData = $request->all();
        $transactionData['cashier_id'] = Auth::id();
        $transactionData['date'] = Carbon::now();
        $transactionData['company_id'] = Auth::user()->company_id;
        $transactionData['note'] = 'Thanh toán đơn hàng '.$request->order_id;

        $transaction = Transaction::create($transactionData);
        LogController::create(isset($transaction) ? 'thêm' : 'không xác định', 'giao dịch', $transaction->id);

        $order = Order::find($transaction['order_id']);
        $order->room()->update(['status' => 0]);
        $order->save();
        $response = array(
            'status' => 'success',
            'title' => 'Thanh toán thành công cho phòng ' . $order->room->name,
        );
        return response()->json($response, 200);
    }

    public function pay(Request $request)
    {
        $transactionData = $request->all();
        $transactionData['cashier_id'] = Auth::id();
        $transactionData['date'] = Carbon::now();
        $transactionData['company_id'] = Auth::user()->company_id;

        $transaction = Transaction::create($transactionData);
        LogController::create(isset($transaction) ? 'thêm' : 'không xác định', 'giao dịch', $transaction->id);

        $order = Order::find($transaction['order_id']);
        $order->checkout_at = Carbon::now();
        $order->tables()->update(['status' => 0]);
        $order->save();
        Cache::forget('tables');
        Cache::forget('products');
        Controller::reloadCache();
        $response = array(
            'bill' => $order,
            'status' => 'success',
            'title' => 'Thanh toán thành công cho bàn ' . implode(', ', $order->tables->pluck('name')->toArray()),
        );
        return response()->json($response, 200);
    }

    public function remove(Request $request)
    {
        $orders = [];
        foreach ($request->choices as $key => $id) {
            $obj = Order::find($id);
            if ($obj && $obj->status < 3) {
                DB::beginTransaction();
                try {
                    $obj->details->each(function ($detail) {
                        $detail->update(['quantity' => 0]);
                        $detail->delete();
                    });
                    $obj->delete();
                    $obj->tables()->update(['status' => 0]);
                    LogController::create('xóa', 'đơn hàng', $obj->id);
                    Cache::forget('tables');
                    DB::commit();
                    array_push($orders, $obj->code);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
                return response()->json(['errors' => ['message' => ['Không thể xóa đơn hàng đã hoàn thành']]], 422);
            }
        }
        $response = array(
            'status' => 'success',
            'msg' => 'Đã xóa đơn hàng ' . implode(', ', $orders)
        );
        return response()->json($response, 200);
    }

    public function bartending(Request $request)
    {
        $order_id = $request->order;
        return view('admin.bartending', compact('order_id'));
    }

}
