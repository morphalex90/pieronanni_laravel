<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Mail\Contact as MailContact;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

final class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Contact::create($validated + [
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit($request->userAgent(), 255),
        ]);

        try {
            Mail::queue(new MailContact($validated));
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'Your message was saved, but the notification email could not be sent.');
        }

        return back()->with('success', 'Thank you! I\'ll get back to you shortly');
    }
}
