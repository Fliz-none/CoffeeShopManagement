<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $appends = ['code', 'galleryUrl', 'avatarUrl', 'catalogue_id'];
    protected $fillable = [
        'company_id',
        'name',
        'price',
        'excerpt',
        'slug',
        'description',
        'gallery',
        'sort',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function catalogues()
    {
        return $this->belongsToMany(Catalogue::class);
    }

    public function createdAt()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('H:i:s d/m/Y') : '';
    }

    public function createdDate()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('Y-m-d') : '';
    }

    public function createdTime()
    {
        return ($this->created_at) ? Carbon::parse($this->created_at)->format('H:i:s') : '';
    }

    public function assignCatalogue($catalogue)
    {
        $result = DB::table('catalogue_product')->insert([
            'product_id' => $this->id,
            'catalogue_id' => $catalogue
        ]);
        return $result;
    }

    public function syncCatalogues($catalogues)
    {
        DB::table('catalogue_product')->where('product_id', $this->id)->delete();
        $array = $catalogues ?? [];
        foreach ($array as $index => $catalogue) {
            $this->assignCatalogue($catalogue);
        }
        return true;
    }

    public function getGalleryUrlAttribute()
    {
        if ($this->gallery) {
            $gallery = explode('|', $this->gallery);
            $images = [];
            foreach ($gallery as $key => $image) {
                if ($key) {
                    $path = 'public/' . $image;
                    if (Storage::exists($path)) {
                        $url = asset(env('FILE_STORAGE', '/storage') . '/' . $image);
                    } else {
                        $url = asset('admin/images/placeholder_key.png');
                    }
                    array_push($images, $url);
                }
            }
        } else {
            $images = [asset('admin/images/placeholder_key.png')];
        }
        return $images;
    }

    public function getAvatarUrlAttribute()
    {
        return $this->gallery ? $this->galleryUrl[0] : asset('admin/images/placeholder_key.png');
    }

    public function getCatalogueIdAttribute()
    {
        $catalogue = $this->catalogues()->first();
        return $catalogue ? $catalogue->id : 0;
    }

    public function getStatusStrAttribute()
    {
        switch ($this->status) {
            case '1':
                $name = 'Đang bán';
                break;
            case '0':
                $name = 'Bị khóa';
                break;
            default:
                $name = 'Không xác định';
                break;
        }
        return $name;
    }

    public function getCodeAttribute()
    {
        return 'SP' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function displayPrice()
    {
        if ($this->variables->min('price') == $this->variables->max('price')) {
            $price = number_format($this->variables->min('price')) . 'đ';
        } else {
            $price = number_format($this->variables->min('price')) . '₫ - ' . number_format($this->variables->max('price')) . '₫';
        }
        return $price;
    }

    public function minPrice()
    {
        return number_format($this->variables->min('price')) . '₫';
    }

    public function maxPrice()
    {
        return number_format($this->variables->max('price')) . '₫';
    }

    public function salePrice()
    {
        return number_format($this->variables->min('price')) . '₫';
    }
    public function relatedProducts()
    {
        $relatedProducts = [];
        foreach ($this->catalogues as $key => $catalogue) {
            foreach ($catalogue->products as $key => $product) {
                if ($product->id != $this->id && !in_array($product->id, array_column($relatedProducts, 'id'))) {
                    array_push($relatedProducts, $product);
                }
            }
        }
        return array_slice($relatedProducts, 0, 12);
    }
    public function catalogsName()
    {
        $catalogues = [];
        foreach ($this->catalogues->pluck('name', 'slug') as $slug => $name) {
            $text = '<a class"text-capitalize" href="' . route('shop', ['catalogue' => $slug]) . '">' . $name . '</a>';
            array_push($catalogues, $text);
        }
        return implode(', ', $catalogues);
    }
}
