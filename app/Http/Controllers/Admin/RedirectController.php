<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegacyRedirect;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RedirectController extends Controller
{
    public function index(): View
    {
        $redirects = LegacyRedirect::query()
            ->orderBy('old_path')
            ->get();

        return view('admin.redirects.index', compact('redirects'));
    }

    public function create(): View
    {
        return view('admin.redirects.form', [
            'redirect' => new LegacyRedirect([
                'status_code' => 301,
                'is_active' => true,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        LegacyRedirect::create($this->validated($request, null));

        return redirect()
            ->route('admin.redirects.index')
            ->with('status', 'Redirect legacy berhasil ditambahkan.');
    }

    public function edit(LegacyRedirect $redirect): View
    {
        return view('admin.redirects.form', compact('redirect'));
    }

    public function update(Request $request, LegacyRedirect $redirect): RedirectResponse
    {
        $redirect->update($this->validated($request, $redirect));

        return redirect()
            ->route('admin.redirects.index')
            ->with('status', 'Redirect legacy berhasil diperbarui.');
    }

    public function destroy(LegacyRedirect $redirect): RedirectResponse
    {
        $redirect->delete();

        return redirect()
            ->route('admin.redirects.index')
            ->with('status', 'Redirect legacy berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?LegacyRedirect $redirect): array
    {
        $validated = $request->validate([
            'old_path' => [
                'required',
                'string',
                'max:255',
                Rule::unique('legacy_redirects', 'old_path')->ignore($redirect?->id),
            ],
            'new_path' => ['required', 'string', 'max:255'],
            'status_code' => ['required', 'integer', 'in:301,302'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        return $validated;
    }
}
