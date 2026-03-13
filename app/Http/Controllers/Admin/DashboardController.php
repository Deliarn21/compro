<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\Content;
use App\Models\LegacyRedirect;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'pages' => Content::pages()->count(),
            'business_units' => Content::businessUnits()->count(),
            'publications' => Content::publications()->count(),
            'csr_pillars' => Content::csrPillars()->count(),
            'redirects' => LegacyRedirect::count(),
            'inquiries' => ContactInquiry::count(),
        ];

        $recentInquiries = ContactInquiry::query()
            ->latest()
            ->take(8)
            ->get();

        $recentPublications = Content::publications()
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('recentInquiries', 'recentPublications', 'stats'));
    }
}
