<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = $request->only('name', 'email', 'subject', 'message');

        // Gửi email
        Mail::to(['lhd4388@gmail.com', 'storebutler6@gmail.com'])->send(new ContactFormMail($data));

        return response()->json(['success' => 'Email đã được gửi thành công.'], 200);
    }
}
