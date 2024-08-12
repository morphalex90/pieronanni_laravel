<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Models\Contact;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request)
    {
        Contact::create($request->validated() + [
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit($request->userAgent(), 255),
        ]);
    }
}
