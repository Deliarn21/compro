<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Contracts\View\View;

class CsrController extends Controller
{
    public function index(): View
    {
        $page = Content::pages()
            ->published()
            ->where('slug', 'csr-overview')
            ->firstOrFail();

        $pillars = Content::csrPillars()
            ->published()
            ->ordered()
            ->get();

        $stories = Content::publications()
            ->published()
            ->whereIn('category', ['news', 'press-release'])
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('csr.index', compact('page', 'pillars', 'stories'));
    }

    public function show(string $slug): View
    {
        $pillar = Content::csrPillars()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $pillars = Content::csrPillars()
            ->published()
            ->where('id', '!=', $pillar->id)
            ->ordered()
            ->get();

        return view('csr.show', compact('pillar', 'pillars'));
    }
}
