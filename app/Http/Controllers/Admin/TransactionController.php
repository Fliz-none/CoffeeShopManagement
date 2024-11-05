<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->key)) {
            $transactions = Transaction::query()->where('company_id', Auth::user()->company_id);
            switch ($request->key) {
                case 'list':
                    return response()->json($transactions->get(), 200);
                default:
                    $transaction = $transactions->find($request->key);
                    if ($transaction) {
                        $result = $transaction;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $transactions = Transaction::select('*')->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc');
                return DataTables::of($transactions)
                    ->editColumn('order_id', function ($transaction) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-order" data-id="' . $transaction->order_id . '"><b>' . $transaction->order->code . '</b></a>';
                    })
                    ->editColumn('customer_id', function ($transaction) {
                        return '<b>' . optional($transaction->customer)->name . '</b>';
                    })
                    ->editColumn('payment', function ($transaction) {
                        return $transaction->paymentStr;
                    })
                    ->editColumn('cashier_id', function ($transaction) {
                        return $transaction->cashier->name;
                    })
                    ->editColumn('amount', function ($transaction) {
                        return number_format($transaction->amount, 0);
                    })
                    ->editColumn('date', function ($transaction) {
                        return $transaction->date ? $transaction->date->format('d/m/Y') : '-';
                    })
                    ->rawColumns(['checkboxes', 'order_id', 'customer_id'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý giao dịch';
                return view('admin.transactions', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'order_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment' => 'required|string',
        ];

        $messages = [
            'order_id.required' => 'Mã đơn hàng không được để trống',
            'customer_id.required' => 'Mã khách hàng không được để trống',
            'amount.required' => 'Số tiền không được để trống',
            'date.required' => 'Ngày giao dịch không được để trống',
            'payment.required' => 'Phương thức thanh toán không được để trống',
        ];

        $request->validate($rules, $messages);

        $transaction = new Transaction([
            'company_id' => Auth::user()->company_id,
            'order_id' => $request->order_id,
            'customer_id' => $request->customer_id,
            'cashier_id' => Auth::id(),
            'payment' => $request->payment,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);
        $transaction->save();

        $response = [
            'status' => 'success',
            'msg' => 'Đã tạo giao dịch thành công',
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $transaction = Transaction::find($request->id);

        $rules = [
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment' => 'required|string',
        ];

        $messages = [
            'amount.required' => 'Số tiền không được để trống',
            'date.required' => 'Ngày giao dịch không được để trống',
            'payment.required' => 'Phương thức thanh toán không được để trống',
        ];

        $request->validate($rules, $messages);

        if ($transaction) {
            $transaction->amount = $request->amount;
            $transaction->date = $request->date;
            $transaction->payment = $request->payment;
            $transaction->note = $request->note;
            $transaction->company_id = Auth::user()->company_id;
            $transaction->save();

            return response()->json([
                'status' => 'success',
                'msg' => 'Đã cập nhật thành công giao dịch',
            ], 200);
        } else {
            return response()->json([
                'status' => 'danger',
                'msg' => 'Không tìm thấy giao dịch để cập nhật',
            ], 404);
        }
    }

    public function remove(Request $request)
    {
        $transactions = [];
        foreach ($request->choices as $id) {
            $transaction = Transaction::find($id);
            if ($transaction) {
                $transaction->delete();
                $transactions[] = $transaction->id;
            }
        }

        $response = [
            'status' => 'success',
            'title' => 'Đã xóa giao dịch ' . implode(', ', $transactions),
        ];

        return response()->json($response, 200);
    }
}
