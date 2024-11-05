<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Disease;
use App\Models\Medicine;
use App\Models\Product;
use App\Models\Room;
use App\Models\Service;
use App\Models\Symptom;
use App\Models\Table;
use Closure;
use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class GlobalSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (!Cache::has('roles')) {
                $roles = Role::where('company_id', Auth::user()->company_id)
                    ->where('id', '!=', 1)
                    ->pluck('name', 'id');
                /**
                 * The authenticated user.
                 *
                 * @var \App\Models\User|null
                 */
                $user = Auth::user();
                if ($user->hasRole('Super Admin')) {
                    $roles->put(1, "Super Admin");
                }
                Cache::put('roles', $roles, now()->addHours(12));
            }
            if (!Cache::has('dealers')) {
                Cache::put('dealers', User::where('company_id', Auth::user()->company_id)->permission(User::CREATE_ORDER)->pluck('name', 'id'), now()->addHours(12));
            }
            if (!Cache::has('branches')) {
                Cache::put('branches', Branch::where('company_id', Auth::user()->company_id)->get(), now()->addHours(12));
            }
            if (!Cache::has('settings')) {
                $settings = Setting::where('company_id', Auth::user()->company_id)->pluck('value', 'key');
                Cache::put('settings', $settings, now()->addHours(12));
            }
            if (!Cache::has('companies')) {
                $companies = Company::find(Auth::user()->company_id);
                Cache::put('companies', $companies, now()->addHours(12));
            }
            if (!Cache::has('catalogues')) {
                Cache::put('catalogues', Controller::getCatalogueChildren(Catalogue::where('company_id', Auth::user()->company_id)->where('status', '>', 0)->with('children')->get()), now()->addHours(12));
            }
            if (!Cache::has('rooms')) {
                Cache::put('rooms', Room::where('company_id', Auth::user()->company_id)->get(), now()->addHours(12));
            }
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
            if (!Cache::has('cashier')) {
                Cache::put('cashier', json_encode(Auth::user()), now()->addHours(12));
            }

        }
        return $next($request);
    }
}
