<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Mail\Contact as MailContact;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request)
    {
        Contact::create(Arr::except($request->validated(), 'privacy') + [
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit($request->userAgent(), 255),
        ]);

        try {
            Mail::send(new MailContact($request->all()));
        } catch (Exception $e) {
            return back()->with('error', $e);
        }

        return back()->with('success', 'Thank you! I\'ll get back to you shortly');
    }
}
