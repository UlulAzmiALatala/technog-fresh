<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function submit(Request $request)
    {
        // Validasi data yang dikirimkan dari formulir
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|min:10',
        ]);

        // Buat array data untuk dikirim ke email
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        // Kirim email
        Mail::to('technog_solutions@outlook.co.id')->send(new ContactMail($details));

        // Redirect kembali ke halaman kontak dengan pesan sukses
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
