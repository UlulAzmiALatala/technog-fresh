<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::latest()->get();
        return view('admin.founder.workers.index', compact('workers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_account_name' => 'required|string',
        ]);
        Worker::create($data);
        return back()->with('success', 'Worker added successfully.');
    }

    public function update(Request $request, Worker $worker)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_account_name' => 'required|string',
        ]);
        $worker->update($data);
        return back()->with('success', 'Worker data updated.');
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();
        return back()->with('success', 'Worker removed.');
    }
}
