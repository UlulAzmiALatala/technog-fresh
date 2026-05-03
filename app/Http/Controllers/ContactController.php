<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\MeetingRequest; // Tambah Model MeetingRequest
use App\Mail\MeetingRequestAdminMail; // Tambah Mailable Admin
use App\Mail\MeetingRequestClientMail; // Tambah Mailable Client

class ContactController extends Controller
{
    /**
     * Menampilkan halaman kontak ke publik dengan data dinamis.
     */
    public function index()
    {
        // Ambil semua setting dan ubah jadi format [ 'key' => 'value' ]
        $settings = Setting::pluck('value', 'key');

        // Ambil data social links dan urutkan sesuai sort_order
        $socialLinks = SocialLink::orderBy('sort_order')->get();

        return view('public.contact', compact('settings', 'socialLinks'));
    }

    /**
     * Handle the incoming request (Form Kontak Biasa).
     */
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|min:10',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        // Sebaiknya email penerima ini juga diambil dari database jika ada
        $adminEmail = Setting::where('key', 'contact_email')->value('value') ?? 'andririzki@technogsolutionss.com';
        Mail::to($adminEmail)->send(new ContactMail($details));

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Memproses permintaan meeting dari Pop-up Landing Page
     */
    public function requestMeeting(Request $request)
    {
        // 1. Validasi Inputan
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'meeting_type' => 'required|string',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|string',
            'topic' => 'nullable|string',
        ]);

        // 2. SIMPAN KE DATABASE
        // Status otomatis 'pending' sesuai default di migrasi
        $meeting = MeetingRequest::create($validatedData);

        // Ambil email admin untuk notifikasi
        $adminEmail = Setting::where('key', 'contact_email')->value('value') ?? 'andririzki@technogsolutionss.com';

        // 3. PROSES PENGIRIMAN EMAIL
        try {
            // A. Kirim notif Mailable cantik ke Admin/Founder
            Mail::to($adminEmail)->send(new MeetingRequestAdminMail($meeting));

            // B. Kirim Auto-Responder ke Klien HANYA JIKA inputannya adalah format email yang valid
            if (filter_var($validatedData['contact'], FILTER_VALIDATE_EMAIL)) {
                Mail::to($validatedData['contact'])->send(new MeetingRequestClientMail($meeting));
            }

            // Redirect kembali dengan pesan sukses
            return back()->with('success', 'Permintaan meeting berhasil dikirim! Tim kami akan segera menghubungi Anda melalui kontak yang diberikan.');
        } catch (\Exception $e) {
            // Jika email gagal terkirim (misal SMTP error), data tetap tersimpan di database
            return back()->with('success', 'Permintaan Anda telah kami simpan. Tim kami akan segera menghubungi Anda.');
        }
    }
}
