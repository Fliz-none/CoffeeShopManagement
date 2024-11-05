<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\Table;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    const DATA_INVALID = 'Dữ liệu không hợp lệ';
    const NOT_EMPTY = 'Vui lòng không để trống thông tin này';
    const ONE_LEAST = 'Phải có ít nhất một mục';
    const MIN = 'Phải có một số lượng tối thiểu';
    const MAX = 'Không được vượt quá số lượng tối đa';

    /**
     * The authenticated user.
     *
     * @var \App\Models\User|null
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->user = Auth::user();
            } else {
                $this->user = null;
            }
            return $next($request);
        });
    }

    // public function options()
    // {
    //     return array(
    //         'permissions' => Permission::all(),
    //         'roles' => Role::all(),
    //         'users' => User::whereStatus(1)->get(),
    //         'cashiers' => User::permission(User::CREATE_TRANSACTION)->whereStatus(1)->get(),
    //         'dealers' => User::permission(User::CREATE_ORDER)->whereStatus(1)->get(),
    //         'products' => Product::whereStatus(1)->get(),
    //         'variables' => Variable::with(['_product'])->whereStatus(1)->get(),
    //         'orders' => Order::get(),
    //         'stocks' => Stock::with('_variable._product')->whereHas('import', function ($query) {
    //             $query->whereIn('warehouse_id', Auth::user()->warehouses->pluck('id'));
    //         })->where('quantity', '>', 0)->get(),
    //         'catalogues' => $this->getCatalogueChildren(Catalogue::whereStatus(1)->with('children')->get()),
    //         'attributes' => Attribute::orderBy('key', 'ASC')->get(),
    //         'logs' => Log::all(),
    //         'warehouses' => Warehouse::whereStatus(1)->whereIn('id', Auth::user()->warehouses->pluck('id'))->get(),
    //         'suppliers' => Supplier::whereStatus(1)->get(),
    //         'settings' => Setting::pluck('value', 'key'),
    //         'locals' => Local::pluck('city', 'district'),
    //         'branches' => Branch::all(),
    //     );
    // }

    public static function getCatalogueChildren($catalogues)
    {
        foreach ($catalogues as $key => $catalogue) {
            if ($catalogue->children->where('status', 1)->isNotEmpty()) {
                $catalogue->children = self::getCatalogueChildren($catalogue->children->where('status', 1));
            }
        }
        return $catalogues;
    }

    static function resetAutoIncrement($table)
    {
        $maxId = DB::table($table)->max('id') + 1;
        DB::statement("ALTER TABLE $table AUTO_INCREMENT = $maxId;");
    }

    public static function reloadCache()
    {
        if (!Cache::has('tables')) {
            Cache::put('tables', json_encode(Table::where('company_id', Auth::user()->company_id)->get()), now()->addHours(12));
        }
        if (!Cache::has('products')) {
            $products = Product::where('company_id', Auth::user()->company_id)
                ->with('details', 'catalogues')
                ->withCount('details') // Đếm số lượng details
                ->orderBy('details_count', 'desc') // Sắp xếp theo số lượng details
                ->get();

            Cache::put('products', json_encode($products), now()->addHours(12));
        }
    }
}
