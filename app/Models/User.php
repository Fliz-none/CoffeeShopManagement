<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;
    protected $appends = array('code', 'avatarUrl');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'avatar',
        'gender',
        'password',
        'address',
        'company_id',
        'level',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const READ_USERS = 'Xem danh sách tài khoản';
    const READ_USER = 'Xem chi tiết tài khoản';
    const CREATE_USER = 'Tạo tài khoản';
    const UPDATE_USER = 'Cập nhật tài khoản';
    const DELETE_USER = 'Xóa tài khoản';
    const DELETE_USERS = 'Xóa hàng loạt tài khoản';

    const READ_ROLES = 'Xem danh sách vai trò';
    const READ_ROLE = 'Xem chi tiết vai trò';
    const CREATE_ROLE = 'Tạo vai trò';
    const UPDATE_ROLE = 'Cập nhật vai trò';
    const DELETE_ROLE = 'Xóa vai trò';

    const READ_CATALOGUES = 'Xem danh sách danh mục';
    const CREATE_CATALOGUE = 'Tạo danh mục';
    const UPDATE_CATALOGUE = 'Cập nhật danh mục';
    const DELETE_CATALOGUE = 'Xóa danh mục';
    const DELETE_CATALOGUES = 'Xóa hàng loạt danh mục';

    const READ_PRODUCTS = 'Xem danh sách sản phẩm';
    const READ_PRODUCT = 'Xem chi tiết sản phẩm';
    const CREATE_PRODUCT = 'Tạo sản phẩm';
    const UPDATE_PRODUCT = 'Cập nhật sản phẩm';
    const DELETE_PRODUCT = 'Xóa sản phẩm';
    const DELETE_PRODUCTS = 'Xóa hàng loạt sản phẩm';

    const READ_VARIABLES = 'Xem danh sách biến thể';
    const CREATE_VARIABLE = 'Tạo biến thể';
    const UPDATE_VARIABLE = 'Cập nhật biến thể';
    const DELETE_VARIABLE = 'Xóa biến thể';
    const DELETE_VARIABLES = 'Xóa hàng loạt biến thể';

    const READ_TABLES = 'Xem danh sách bàn';
    const CREATE_TABLE = 'Tạo bàn';
    const UPDATE_TABLE = 'Cập nhật bàn';
    const BOOK_TABLE = 'Đặt bàn';
    const DELETE_TABLE = 'Xóa bàn';
    const DELETE_TABLES = 'Xóa hàng loạt bàn';

    const READ_ROOMS = 'Xem danh sách phòng';
    const CREATE_ROOM = 'Tạo phòng';
    const UPDATE_ROOM = 'Cập nhật phòng';
    const BOOK_ROOM = 'Đặt phòng';
    const DELETE_ROOM = 'Xóa phòng';
    const DELETE_ROOMS = 'Xóa hàng loạt phòng';

    const READ_ORDERS = 'Xem danh sách đơn hàng';
    const READ_ORDER = 'Xem chi tiết đơn hàng';
    const CREATE_ORDER = 'Tạo đơn hàng';
    const UPDATE_ORDER = 'Cập nhật đơn hàng';
    const DELETE_ORDER = 'Xóa đơn hàng';
    const DELETE_ORDERS = 'Xóa hàng loạt đơn hàng';

    const READ_TRANSACTIONS = 'Xem danh sách giao dịch';
    const READ_TRANSACTION = 'Xem chi tiết giao dịch';
    const CREATE_TRANSACTION = 'Tạo giao dịch';
    const UPDATE_TRANSACTION = 'Cập nhật giao dịch';
    const DELETE_TRANSACTION = 'Xóa giao dịch';

    const READ_IMAGES = 'Xem danh sách hình ảnh';
    const READ_IMAGE = 'Xem chi tiết hình ảnh';
    const CREATE_IMAGE = 'Tạo hình ảnh';
    const UPDATE_IMAGE = 'Cập nhật hình ảnh';
    const DELETE_IMAGE = 'Xóa hình ảnh';
    const DELETE_IMAGES = 'Xóa hàng loạt hình ảnh';

    const READ_SCHEDULES = 'Xem danh sách lịch làm việc';
    const CREATE_SCHEDULE = 'Tạo lịch làm việc';
    const UPDATE_SCHEDULE = 'Cập nhật lịch làm việc';
    const DELETE_SCHEDULE = 'Xóa lịch làm việc';

    const READ_WORKS = 'Xem danh sách chấm công';
    const CREATE_WORK = 'Tạo chấm công';
    const READ_WORK = 'Xem chi tiết chấm công';
    const DELETE_WORK = 'Xóa chấm công';

    const ACCESS_ADMIN = 'Truy cập trang quản trị';
    const ACCESS_SETTING = 'Truy cập trang thiết lập';
    const ACCESS_DASHBOARD = 'Truy cập trang bảng tin';
    const ACCESS_LOG = 'Truy cập trang nhật ký hệ thống';
    const ACCESS_ERROR = 'Truy cập trang danh sách lỗi';

    const READ_COMPANIES = 'Xem danh sách công ty';
    const CREATE_COMPANY = 'Tạo công ty';
    const UPDATE_COMPANY = 'Cập nhật công ty';
    const READ_COMPANY = 'Xem chi tiết công ty';
    const UNACTIVE_COMPANY = 'Khóa công ty';

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'main_branch');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // public function timeSheets()
    // {
    //     return $this->hasMany(TimeSheet::class);
    // }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }


    public function getCodeAttribute()
    {
        return 'TK' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getFullNameAttribute()
    {
        $str = '<span class="' . ($this->deleted_at ? 'text-danger' : 'text-primary') . '">' . $this->name . '</span>';
        return $str;
    }

    public function getStatusStrAttribute()
    {
        return ($this->status) ? 'Kích hoạt' : 'Đã khóa';
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address ? $this->address . ', ' : '';
        $location = $this->local ? ($this->local->district . ', ' . $this->local->city) : '';
        $fullAddress = $address . $location;
        return $fullAddress ?: "Không có";
    }

    public function getAvatarUrlAttribute()
    {
        $path = 'public/user/' . $this->avatar;
        if ($this->avatar && Storage::exists($path)) {
            $image = asset(env('FILE_STORAGE') . '/user/' . $this->avatar);
        } else {
            $image = asset('admin/images/placeholder_key.png');
        }
        return $image;
    }

    public function getGenderStrAttribute()
    {
        switch ($this->gender) {
            case '2':
                $result = 'Khác';
                break;
            case '1':
                $result = 'Nữ';
                break;
            case '0':
                $result = 'Nam';
                break;
            default:
                $result = 'Không xác định';
                break;
        }
        return $result;
    }

    public function assignBranch($branch)
    {
        $result = DB::table('branch_user')->insert([
            'user_id' => $this->id,
            'branch_id' => $branch
        ]);
        $this->main_branch = $branch;
        $this->save();
        return $result;
    }

    public function syncBranches($branches)
    {
        DB::table('branch_user')->where('user_id', $this->id)->delete();
        $array = $branches ?? [];
        foreach ($array as $index => $branch) {
            $this->assignBranch($branch);
        }
        return true;
    }

    public function canRemove()
    {
        // if ($this->) {
        //     return false;
        // }
        return true;
    }
}
