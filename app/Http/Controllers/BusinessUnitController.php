<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Contracts\View\View;

class BusinessUnitController extends Controller
{
    public function index(): View
    {
        $businessUnits = Content::businessUnits()
            ->published()
            ->with([
                'children' => fn ($query) => $query->published()->ordered(),
            ])
            ->ordered()
            ->get();

        return view('business-units.index', compact('businessUnits'));
    }

    public function show(string $slug): View
    {
        $businessUnit = Content::businessUnits()
            ->published()
            ->with([
                'children' => fn ($query) => $query->published()->ordered(),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedUnits = Content::businessUnits()
            ->published()
            ->where('id', '!=', $businessUnit->id)
            ->ordered()
            ->take(3)
            ->get();

        $latestPublications = Content::publications()
            ->published()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('business-units.show', compact('businessUnit', 'latestPublications', 'relatedUnits'));
    }
}
