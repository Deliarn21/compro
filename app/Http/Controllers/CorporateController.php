<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Contracts\View\View;

class CorporateController extends Controller
{
    public function index(): View
    {
        $page = Content::pages()
            ->published()
            ->where('slug', 'company-profile')
            ->firstOrFail();

        $relatedPages = Content::pages()
            ->published()
            ->whereIn('slug', ['history', 'vision-mission', 'core-values', 'management', 'hse-overview', 'careers'])
            ->ordered()
            ->get();

        $milestones = Content::milestones()->published()->ordered()->get();
        $executives = Content::executives()->published()->ordered()->get();

        return view('corporate.index', compact('executives', 'milestones', 'page', 'relatedPages'));
    }

    public function show(string $slug): View
    {
        $page = Content::pages()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPages = Content::pages()
            ->published()
            ->where('slug', '!=', $slug)
            ->ordered()
            ->get();

        $milestones = $slug === 'history'
            ? Content::milestones()->published()->ordered()->get()
            : collect();

        $executives = $slug === 'management'
            ? Content::executives()->published()->ordered()->get()
            : collect();

        return view('corporate.show', compact('executives', 'milestones', 'page', 'relatedPages'));
    }
}
