<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('subscribers', 'email')
            ]
        ], [
            'email.unique' => 'This email is already subscribed.'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('subscribe_error', true); // Sinyal error
        }

        Subscriber::create($validator->validated());

        return back()->with('subscribe_success', 'Thank you for subscribing!');
    }
}
