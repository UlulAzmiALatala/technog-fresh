<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\MeetingRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MeetingController extends Controller
{
    public function index()
    {
        // Ambil semua data meeting
        $meetings = MeetingRequest::orderBy('meeting_date', 'desc')->orderBy('meeting_time', 'desc')->get();

        // Siapkan data event untuk FullCalendar
        $events = [];
        foreach ($meetings as $meeting) {
            // Mewarnai event berdasarkan status
            $color = '#3b82f6'; // Biru (Default)
            if ($meeting->status == 'pending') $color = '#f59e0b'; // Kuning
            if ($meeting->status == 'scheduled') $color = '#10b981'; // Hijau
            if ($meeting->status == 'completed') $color = '#6b7280'; // Abu-abu
            if ($meeting->status == 'canceled') $color = '#ef4444'; // Merah

            $events[] = [
                'id' => $meeting->id,
                'title' => $meeting->name . ' (' . $meeting->meeting_type . ')',
                'start' => $meeting->meeting_date . 'T' . $meeting->meeting_time,
                'color' => $color,
                'extendedProps' => [
                    'contact' => $meeting->contact,
                    'topic' => $meeting->topic,
                    'status' => $meeting->status,
                ]
            ];
        }

        return view('admin.pemasukan.meetings.index', compact('meetings', 'events'));
    }

    // Fungsi untuk mengubah status meeting
    public function updateStatus(Request $request, $id)
    {
        $meeting = MeetingRequest::findOrFail($id);
        $meeting->update(['status' => $request->status]);

        return back()->with('success', 'Status meeting berhasil diperbarui!');
    }
}
