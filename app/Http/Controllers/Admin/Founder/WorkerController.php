<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        // Menggunakan pagination agar rapi saat data bertambah banyak
        $workers = Worker::latest()->paginate(15);
        $totalWorkers = Worker::count();

        return view('admin.founder.workers.index', compact('workers', 'totalWorkers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_account_name' => 'required|string',
            'modal_form' => 'required|string', // Menangkap state modal
        ]);

        Worker::create($request->except('modal_form'));

        return back()->with('success', 'Worker added successfully.');
    }

    public function update(Request $request, Worker $worker)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_account_name' => 'required|string',
            'modal_form' => 'required|string',
        ]);

        $worker->update($request->except('modal_form'));

        return back()->with('success', 'Worker data updated.');
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();
        return back()->with('success', 'Worker removed.');
    }
}
