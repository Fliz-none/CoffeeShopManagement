<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Variable;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $agent = new Agent();
        $isMobile = $agent->isMobile();

        $catalogues = Catalogue::where('status', 1)->orderBy('sort', 'ASC')->get();
        $variables = Variable::where('status', 1)->get();

        if ($request->catalogue) {
            $catalogue = Catalogue::with('products')->whereSlug($request->catalogue)->first();
            if ($catalogue) {
                if ($request->slug) {
                    $product = Product::whereSlug($request->slug)->first();
                    if ($product) {
                        $pageName = $product->name;
                        return view('web.product', compact('catalogue', 'product', 'pageName'));
                    } else {
                        abort(404);
                    }
                }
                $pageName = $catalogue->name;
                $products = $catalogue->products()->where('status', '>', 1)->paginate(12);
                foreach ($catalogue->products as $key => $product) {
                    $product->variables = Variable::where('product_id', $product->id)->get();
                    if ($product->variables->min('price') == $product->variables->max('price')) {
                        $product->price = number_format($product->variables->min('price')) . 'đ';
                    } else {
                        $product->price = number_format($product->variables->min('price')) . '₫ - ' . number_format($product->variables->max('price')) . '₫';
                    }
                }
                return view('web.products', compact('pageName', 'isMobile', 'catalogues', 'catalogue', 'products', 'variables'));
            } else {
                abort(404);
            }
        } else {
            $products = Product::where('status', '>', 1)
                ->orderBy('sort', 'ASC')
                ->paginate(12);
            $pageName = 'Tất cả sản phẩm';
            return view('web.products', compact('pageName', 'isMobile', 'catalogues', 'products', 'variables'));
        }
    }
    public function getAjax(Request $request)
    {
        switch ($request->type) {
            case 'product':
                $products = Product::with('catalogues')->where('status', '>', 1);
                switch ($request->key) {
                    case null:
                        return $products->get();
                        break;
                    case 'filter':
                        $products->with(['variables']);
                        $products->when($request->catalogues != null, function ($q) use ($request) {
                            return $q->whereHas('catalogues', function ($query) use ($request) {
                                $query->whereIn('catalogue_id', explode(',', $request->catalogues));
                            });
                        });
                        $products->when($request->search != null, function ($q) use ($request) {
                            return $q->where('name', 'like', '%' . $request->search . '%');
                        });
                        $products->when($request->order == 'price-az', function ($q) {
                            return $q->with(['variables' => function ($query) {
                                $query->orderBy('price', 'asc');
                            }]);
                        });
                        $products->when($request->order == 'price-za', function ($q) {
                            return $q->with(['variables' => function ($query) {
                                $query->orderBy('price', 'desc');
                            }]);
                        });
                        $products->when($request->order == 'name-az', function ($q) {
                            return $q->orderBy('name', 'asc');
                        });
                        $products->when($request->order == 'sales-az', function ($q) {
                            return $q->withCount('variables.details')->orderByDesc('variables.details_count');
                        });
                        $products = $products->get()->each(function($product, $i) {
                            $product->price = $product->displayPrice();
                        });
                        return $products;
                        break;

                    default:
                        # code...
                        break;
                }
                break;

            case 'post':
                # code...
                break;

            case 'review':
                return Review::with('children')->where('product_id', $request->key)->get();
                break;

            default:
                # code...
                break;
        }
    }
}
