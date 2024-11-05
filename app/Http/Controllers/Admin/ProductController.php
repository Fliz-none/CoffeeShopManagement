<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UnitsImport;
use App\Models\Unit;
use App\Models\Variable;
use App\Models\Product;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    const NAME = 'sản phẩm',
        MESSAGES = [
            'sku.string' => Controller::DATA_INVALID,
            'sku.max' => Controller::MAX,
            'name.required' => 'Tên sản phẩm :' . Controller::NOT_EMPTY,
            'name.string' => Controller::DATA_INVALID,
            'name.max' => Controller::MAX,
            'status.numeric' => Controller::DATA_INVALID,
            'catalogues.required' => 'Danh mục không thể bỏ trống',
            'catalogues.array' => 'Danh mục: ' . Controller::DATA_INVALID,
            'price.numeric' => Controller::DATA_INVALID,
            'price.required' => 'Giá sản phẩm: ' . Controller::NOT_EMPTY,
            'price.max' => "Giá sản phẩm: quá lớn",
        ];

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $catalogues = Cache::get('catalogues')->whereNull('parent_id');
            switch ($request->key) {
                case 'all':
                    $result = Product::where('company_id', Auth::user()->company_id)->with('catalogues')->get();
                    break;
                case 'render':
                    $request->validate([
                        'columns' => 'required',
                        'catalogue_id' => 'required|numeric',
                    ], [
                        'columns.required' => 'Vui lòng chọn ít nhất một cột',
                        'catalogue_id.required' => 'Danh mục không thể bỏ trống',
                    ]);
                    $objs = Product::with('variables')
                        ->where('products.company_id', $this->user->company_id)
                        ->when($request->catalogue_id, function ($query) use ($request) {
                            $query->whereHas('catalogues', function ($query) use ($request) {
                                $query->where('catalogues.id', $request->catalogue_id);
                            });
                        })
                        ->orderBy('sort', 'ASC')
                        ->get();
                    return view('admin.templates.renders.product', ['products' => $objs, 'columns' => $request->columns]);
                case 'new':
                    $pageName = 'Sản phẩm mới';
                    return view('admin.product', compact('pageName', 'catalogues'));
                case 'list':
                    $ids = json_decode($request->ids);
                    $result = Product::where('products.company_id', $this->user->company_id)->orderBy('sort', 'ASC')->when(count($ids), function ($query) use ($ids) {
                        $query->whereIn('id', $ids);
                    })->get();
                    break;
                case 'select2':
                    $result = Product::with('variables')
                        ->where('products.company_id', $this->user->company_id)
                        ->where('status', '>', 0)
                        ->where(function ($query) use ($request) {
                            $query->where('name', 'LIKE', '%' . $request->q . '%')
                                ->orWhere('sku', 'LIKE', '%' . $request->q . '%')
                                ->orWhereHas('variables', function ($query) use ($request) {
                                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                                });
                        })
                        ->orderByDesc('id')
                        ->distinct()
                        ->get()
                        ->map(function ($obj) {
                            return [
                                'id' => $obj->id,
                                'text' => $obj->sku . ' - ' . $obj->name
                            ];
                        });
                    break;
                default:
                    $product = Product::withTrashed()->with('catalogues')->find($request->key);
                    if ($product) {
                        if ($request->ajax()) {
                            $result = $product;
                        } else {
                            $pageName = 'Chi tiết sản phẩm';
                            return view('admin.product', compact('pageName', 'catalogues', 'product'));
                        }
                    } else {
                        return redirect()->route('admin.product', ['key' => 'new']);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $objs = Product::with([
                    'catalogues',
                ])->where('products.company_id', $this->user->company_id);
                $can_update_product = $this->user->can(User::UPDATE_PRODUCT);
                $can_read_catalogues = $this->user->can(User::READ_CATALOGUES);
                $can_delete_product = $this->user->can(User::DELETE_PRODUCT);
                return DataTables::of($objs)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) use ($can_update_product) {
                        if ($can_update_product) {
                            $code = '<a class="btn btn-link text-decoration-none btn-update-product fw-bold p-0" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        }
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
                                $query->where('products.id', 'like', "%" . $numericKeyword . "%");
                            }
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('name', function ($obj) use ($can_update_product) {
                        if ($can_update_product) {
                            $color = $obj->deleted_at ? 'danger' : 'success';
                            return '<a href="' . route('admin.product', ['key' => $obj->id]) . '" class="btn btn-link text-' . $color . ' text-decoration-none btn-update-product fw-bold text-start" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        }
                        return '<span class="fw-bold">' . $obj->name . '</span>';
                    })
                    ->filterColumn('name', function ($query, $keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%");
                    })
                    ->addColumn('avatar', function ($obj) {
                        return '<img src="' . $obj->avatarUrl . '" class="thumb cursor-pointer object-fit-cover" alt="Ảnh ' . $obj->name . '" width="60px" height="60px">';
                    })
                    ->addColumn('catalogues', function ($obj) use ($can_read_catalogues) {
                        return $obj->catalogues->map(function ($catalogue) use ($can_read_catalogues) {
                            if ($can_read_catalogues) {
                                return '<a class="btn btn-link text-decoration-none btn-update-catalogue py-0" data-id="' . $catalogue->id . '">' . $catalogue->fullName . '</a>';
                            } else {
                                return $catalogue->fullName;
                            }
                        })->join('');
                    })
                    ->filterColumn('catalogues', function ($query, $keyword) {
                        $query->whereHas('catalogues', function ($query) use ($keyword) {
                            $query->where('name', 'like', "%" . $keyword . "%");
                        });
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->orderColumn('status', function ($query, $order) {
                        $query->orderBy('status', $order);
                    })
                    ->addColumn('action', function ($obj) use ($can_delete_product) {
                        if ($can_delete_product) {
                            return '
                                <form action="' . route('admin.product.remove') . '" method="post" class="save-form">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '"/>
                                    <input type="hidden" name="choices[]" value="' . $obj->id . '" data-id="' . $obj->id . '"/>
                                    <button class="btn btn-link text-decoration-none btn-remove">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>';
                        }
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'avatar', 'catalogues', 'status', 'action'])
                    ->setTotalRecords($objs->count())
                    ->make(true);
            } else {
                $objs = Product::get();
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.products', compact('pageName'));
            }
        }
    }

    public function sort(Request $request)
    {
        $ids = $request->input('sort');
        $totalProducts = Product::where('products.company_id', $this->user->company_id)->count();

        if (count($ids) == $totalProducts) {
            $sql = "UPDATE products SET sort = CASE ";
            $idArray = [];

            foreach ($ids as $index => $id) {
                $sql .= "WHEN id = ? THEN ? ";
                $idArray[] = $id;
                $idArray[] = $index + 1;
            }

            $sql .= "END WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ") AND company_id = ?";

            $idArray = array_merge($idArray, $ids);
            $idArray[] = $this->user->company_id;

            DB::statement($sql, $idArray);
        } else {
            $sorts = Product::whereIn('id', $ids)->orderBy('sort', 'ASC')->pluck('sort');
            $sql = "UPDATE products SET sort = CASE ";
            $idArray = [];

            foreach ($sorts as $index => $sort) {
                $sql .= "WHEN id = ? THEN ? ";
                $idArray[] = $ids[$index];
                $idArray[] = $index + 1;
            }

            $sql .= "END WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";

            $idArray = array_merge($idArray, $ids);

            DB::statement($sql, $idArray);
        }

        return response()->json(['msg' => 'Thứ tự đã được cập nhật thành công']);
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:125'],
            'status' => ['nullable', 'numeric'],
            'price' => ['required', 'numeric', 'max:90000000'],
            'catalogues' => ['required'],
        ];
        $request->validate($rules, self::MESSAGES);

        if (!empty($this->user->can(User::CREATE_PRODUCT, User::UPDATE_PRODUCT))) {
            try {
                $product = Product::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'name' => $request->name,
                        'price' => $request->price,
                        'excerpt' => $request->excerpt,
                        'description' => $request->description,
                        'gallery' => $request->gallery,
                        'status' => $request->status,
                        'company_id' => Auth::user()->company_id,
                    ]
                );
                if ($product) {
                    $product->syncCatalogues($request->catalogues);
                }
                $action = ($request->id) ? 'sửa' : 'thêm';
                LogController::create($action, self::NAME, $product->id);
                $response = array(
                    'status' => 'success',
                    'msg' => 'Đã ' . $action . ' ' . self::NAME . ' ' . $product->name
                );
            } catch (\Exception $e) {
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return redirect()->route('admin.product', ['key' => $product->id])->with('response', $response);
    }

    // public function create(Request $request)
    // {
    //     $rules = [
    //         'sku' => ['nullable', 'string', 'max:125'],
    //         'name' => ['required', 'string', 'max:125'],
    //         'status' => ['nullable', 'numeric'],
    //         'catalogues' => ['required', 'array'],
    //     ];

    //     $request->validate($rules, self::MESSAGES);

    //     if (!empty($this->user->can(User::CREATE_PRODUCT, User::UPDATE_PRODUCT))) {
    //         DB::beginTransaction();
    //         try {
    //             $product = Product::create([
    //                 'sku' => $request->sku,
    //                 'name' => $request->name,
    //                 'slug' => Str::slug($request->name),
    //                 'excerpt' => $request->excerpt,
    //                 'description' => $request->description,
    //                 'specs' => $request->specs,
    //                 'keyword' => $request->keyword,
    //                 'gallery' => $request->gallery,
    //                 'allow_review' => $request->has('allow_review'),
    //                 'status' => $request->status,
    //                 'company_id' => Auth::user()->company_id,
    //             ]);
    //             if ($product) {
    //                 LogController::create('tạo', self::NAME, $product->id);
    //                 if ($request->avatar) {
    //                     $image = $request->file('avatar');
    //                     $imageName = $image->getClientOriginalName();
    //                     $tmp = explode('.', $imageName);
    //                     $path = 'public/' . Str::slug($tmp[0]) . '.' . $tmp[count($tmp) - 1];
    //                     $imageName = $product->code . ((Storage::exists($path)) ? Carbon::now()->format('-YmdHis.') : '.') . $tmp[count($tmp) - 1];
    //                     $uploadedImages[] = $image->storeAs('public/', $imageName);

    //                     $image = Image::create([
    //                         'name' => $imageName,
    //                         'author_id' => Auth::user()->id
    //                     ]);
    //                     LogController::create('tạo', 'Hình ảnh ' . $image->name, $image->id);
    //                     $product->update(['gallery' => '|' . $imageName]);
    //                 }
    //                 $product->syncCatalogues($request->catalogues);
    //             }
    //             DB::commit();
    //             $response = array(
    //                 'status' => 'success',
    //                 'msg' => 'Đã tạo ' . self::NAME . ' ' . $product->name
    //             );
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             Controller::resetAutoIncrement('products');
    //             Controller::resetAutoIncrement('images');
    //             return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
    //         }
    //     } else {
    //         return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
    //     }
    //     return response()->json($response, 200);
    // }

    // public function update(Request $request)
    // {
    //     $rules = [
    //         'sku' => ['nullable', 'string', 'max:125'],
    //         'name' => ['required', 'string', 'max:125'],
    //         'status' => ['nullable', 'numeric'],
    //         'catalogues' => ['required', 'array'],
    //     ];

    //     $request->validate($rules, self::MESSAGES);

    //     if (!empty($this->user->can(User::CREATE_PRODUCT, User::UPDATE_PRODUCT))) {
    //         if ($request->has('id')) {
    //             DB::beginTransaction();
    //             try {
    //                 $product = Product::find($request->id);
    //                 if ($product) {
    //                     $product->update([
    //                         'sku' => $request->sku,
    //                         'name' => $request->name,
    //                         'slug' => Str::slug($request->name),
    //                         'excerpt' => $request->excerpt,
    //                         'description' => $request->description,
    //                         'specs' => $request->specs,
    //                         'keyword' => $request->keyword,
    //                         'gallery' => $request->gallery,
    //                         'allow_review' => $request->has('allow_review'),
    //                         'status' => $request->status,
    //                         'company_id' => Auth::user()->company_id,
    //                     ]);

    //                     if ($request->avatar) {
    //                         $image = $request->file('avatar');
    //                         $imageName = $image->getClientOriginalName();
    //                         $tmp = explode('.', $imageName);
    //                         $path = 'public/' . Str::slug($tmp[0]) . '.' . $tmp[count($tmp) - 1];
    //                         $imageName = $product->code . ((Storage::exists($path)) ? Carbon::now()->format('-YmdHis.') : '.') . $tmp[count($tmp) - 1];
    //                         $uploadedImages[] = $image->storeAs('public/', $imageName);

    //                         $image = Image::create([
    //                             'name' => $imageName,
    //                             'author_id' => Auth::user()->id
    //                         ]);
    //                         LogController::create('tạo', 'Hình ảnh ' . $image->name, $image->id);
    //                         $product->update(['gallery' => '|' . $imageName]);
    //                     }

    //                     $product->syncCatalogues($request->catalogues);

    //                     LogController::create('sửa', self::NAME, $product->id);
    //                     DB::commit();
    //                     $response = array(
    //                         'status' => 'success',
    //                         'msg' => 'Đã cập nhật ' . self::NAME . ' ' . $product->name
    //                     );
    //                 } else {
    //                     DB::rollBack();
    //                     $response = array(
    //                         'status' => 'danger',
    //                         'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
    //                     );
    //                 }
    //             } catch (\Exception $e) {
    //                 DB::rollBack();
    //                 Controller::resetAutoIncrement('products');
    //                 Controller::resetAutoIncrement('images');
    //                 return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
    //             }
    //         } else {
    //             $response = array(
    //                 'status' => 'danger',
    //                 'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
    //             );
    //         }
    //     } else {
    //         return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
    //     }
    //     return response()->json($response, 200);
    // }

    public function remove(Request $request)
    {
        $success = [];
        if ($this->user->can(User::DELETE_PRODUCT)) {
            foreach ($request->choices as $key => $id) {
                $obj = Product::withTrashed()->find($id);
                if ($obj) {
                    $obj->delete();
                }
                LogController::create("xóa", self::NAME, $obj->id);
                array_push($success, $obj->name);
            }

            $msg = '';
            if (count($success)) {
                $msg .= 'Đã xóa ' . self::NAME . ' ' . implode(', ', $success) . '. ';
            }
            $response = array(
                'status' => 'success',
                'msg' => $msg
            );
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

}
