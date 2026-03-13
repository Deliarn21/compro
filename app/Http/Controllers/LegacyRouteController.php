<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\LegacyRedirect;
use Illuminate\Http\RedirectResponse;

class LegacyRouteController extends Controller
{
    public function __invoke(string $legacyPath): RedirectResponse
    {
        $path = trim($legacyPath, '/');

        if ($path === '') {
            return redirect()->route('home', status: 301);
        }

        $redirect = LegacyRedirect::query()
            ->where('is_active', true)
            ->where('old_path', $path)
            ->first();

        if ($redirect !== null) {
            return $this->redirectToPath($redirect->new_path, $redirect->status_code);
        }

        $content = Content::query()
            ->where('legacy_path', $path)
            ->first();

        if ($content !== null) {
            return $this->redirectToPath($this->contentPath($content), 301);
        }

        abort(404);
    }

    private function redirectToPath(string $path, int $statusCode): RedirectResponse
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return redirect()->away($path, $statusCode);
        }

        return redirect($path, $statusCode);
    }

    private function contentPath(Content $content): string
    {
        return match ($content->type) {
            Content::TYPE_PAGE => $content->slug === 'company-profile'
                ? route('corporate.index', absolute: false)
                : route('corporate.show', $content->slug, absolute: false),
            Content::TYPE_BUSINESS_UNIT => route('business-units.show', $content->slug, absolute: false),
            Content::TYPE_CSR_PILLAR => route('csr.show', $content->slug, absolute: false),
            Content::TYPE_PUBLICATION => route('media-center.show', [$content->category, $content->slug], absolute: false),
            Content::TYPE_LOCATION => route('contact.index', absolute: false),
            default => route('home', absolute: false),
        };
    }
}
