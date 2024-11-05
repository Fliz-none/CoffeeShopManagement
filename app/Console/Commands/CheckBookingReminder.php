<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\NotificationController;
use App\Models\BookingTicket;
use App\Mail\SendMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckBookingReminder extends Command
{
    protected $signature = 'booking:checkreminder';
    protected $description = 'Kiểm tra các cuộc hẹn và gửi thông báo nếu đúng giờ remind_at';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $now = Carbon::now()->format('Y-m-d H:i:00');
            $bookings = BookingTicket::where(function ($query) use ($now) {
                $query->where('remind_at', $now)
                    ->orWhere('appointment_at', $now);
            })->whereStatus(1)->get();

            if ($bookings->isEmpty()) {
                $this->info($now . ': Không có cuộc hẹn nào cần nhắc nhở.');
                return 0;
            }

            foreach ($bookings as $booking) {
                $str = '<a class="d-flex align-items-center cursor-pointer fw-bold btn-preview text-primary py-2" data-url="' . route('admin.booking_ticket') . '" data-id="' . $booking->id . '" data-noti_id="%d">
                                <div class="row">
                                    <div class="col-2 px-0 d-flex justify-content-center">
                                        <div class="notification-icon bg-warning">
                                            <i class="bi bi-calendar4-range"></i>
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="notification-text text-wrap">
                                            <p class="notification-title fw-bold">Nhắc nhở cuộc hẹn</p>
                                            <small class="notification-subtitle">Bạn có cuộc hẹn vào lúc ' . Carbon::parse($booking->appointment_at)->format('H:i \n\g\à\y d/m/Y') . '. Vui lòng click để xem chi tiết</small>
                                        </div>
                                    </div>
                                </div>
                            </a>';

                $users = collect([$booking->_pet->_customer, $booking->_doctor, $booking->_author])->filter();

                $noti = NotificationController::create($str);
                NotificationController::push($noti, $users->reject(function ($user) use ($booking) {
                    return $user === $booking->_pet->_customer;
                }));

                $emails = $users->pluck('email');
                if ($emails->isNotEmpty()) {
                    Mail::to($emails)->send(new SendMail('admin.templates.emails.reminder_notification', [
                        'data' => $booking,
                    ], (cache()->get('settings')['company_brandname'] ?? '') . ': Nhắc nhở cuộc hẹn'));
                }

                // Kiểm tra nếu appointment_at bằng $now mới thực hiện tạo booking mới
                if ($booking->appointment_at == $now) {
                    //Tạo mới booking nếu như frequency có
                    switch ($booking->frequency) {
                        case '8': $minutes = 525600; break; // Hàng năm
                        case '7': $minutes = 131400; break; // 3 tháng
                        case '6': $minutes = 43800; break;  // Mỗi tháng
                        case '5': $minutes = 20160; break;  // 2 tuần
                        case '4': $minutes = 10080; break;  // Mỗi tuần
                        case '3': $minutes = 2880; break;   // 2 ngày
                        case '2': $minutes = 1440; break;   // Mỗi ngày
                        case '1': $minutes = 60; break;     // Mỗi giờ
                        default: continue 2; // Không nhắc
                    }
                    $newBooking = $booking->replicate();
                    $newBooking->remind_at = Carbon::parse($booking->remind_at)->addMinutes($minutes);
                    $newBooking->appointment_at = Carbon::parse($booking->appointment_at)->addMinutes($minutes);
                    $newBooking->save();
                }

                $this->info($now . ': Đã gửi thông báo lịch hẹn: ' . $booking->name);
            }
        } catch (\Throwable $e) {
            $this->error('Đã xảy ra lỗi: ' . $e->getMessage());
        }
        return 0;
    }
}