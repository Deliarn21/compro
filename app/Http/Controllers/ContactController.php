<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use App\Models\Content;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(): View
    {
        $locations = Content::locations()->published()->ordered()->get();

        return view('contact.index', compact('locations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Silakan centang persetujuan privasi sebelum mengirim pesan.',
        ]);

        ContactInquiry::create([
            ...$validated,
            'consent' => true,
        ]);

        return back()->with('status', 'Pesan Anda sudah kami terima. Tim Hasnur Group akan menindaklanjuti secepatnya.');
    }
}
