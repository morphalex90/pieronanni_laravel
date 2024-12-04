<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Mail\Contact as MailContact;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request)
    {
        Contact::create($request->validated() + [
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit($request->userAgent(), 255),
        ]);

        Mail::send(new MailContact($request->all()));
    }
}
