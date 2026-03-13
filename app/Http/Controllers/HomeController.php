<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $corporatePages = Content::pages()
            ->published()
            ->whereIn('slug', ['company-profile', 'history', 'vision-mission', 'core-values', 'management'])
            ->ordered()
            ->get()
            ->keyBy('slug');

        $businessUnits = Content::businessUnits()
            ->published()
            ->with([
                'children' => fn ($query) => $query->published()->ordered(),
            ])
            ->ordered()
            ->get();

        $csrPillars = Content::csrPillars()
            ->published()
            ->ordered()
            ->get();

        $milestones = Content::milestones()
            ->published()
            ->ordered()
            ->get();

        $executives = Content::executives()
            ->published()
            ->ordered()
            ->get();

        $publications = Content::publications()
            ->published()
            ->orderByDesc('published_at')
            ->take(6)
            ->get();

        $locations = Content::locations()
            ->published()
            ->ordered()
            ->get();

        return view('home', compact(
            'businessUnits',
            'corporatePages',
            'csrPillars',
            'executives',
            'locations',
            'milestones',
            'publications',
        ));
    }
}
