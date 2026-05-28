<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:200',
            'email'   => 'required|email',
            'subject' => 'required|string|max:300',
            'message' => 'required|string|max:3000',
        ]);

        // Mail::to(config('mail.from.address'))->send(new \App\Mail\ContactMail($data));
        // Uncomment above and create ContactMail when mail is configured.

        return back()->with('toast', "Thanks {$data['name']}! We'll get back to you soon 🎧");
    }
}
