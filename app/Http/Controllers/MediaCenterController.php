<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Contracts\View\View;

class MediaCenterController extends Controller
{
    /**
     * @return array<string, string>
     */
    private function mediaTypes(): array
    {
        return [
            'all' => 'Semua Publikasi',
            'news' => 'News',
            'press-release' => 'Press Release',
            'multimedia' => 'Multimedia',
            'gallery' => 'Gallery',
        ];
    }

    public function index(): View
    {
        return $this->renderIndex('all');
    }

    public function type(string $type): View
    {
        return $this->renderIndex($type);
    }

    public function show(string $type, string $slug): View
    {
        abort_unless(array_key_exists($type, $this->mediaTypes()) && $type !== 'all', 404);

        $publication = Content::publications()
            ->published()
            ->where('category', $type)
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPublications = Content::publications()
            ->published()
            ->where('category', $type)
            ->where('id', '!=', $publication->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('media.show', [
            'mediaTypes' => $this->mediaTypes(),
            'publication' => $publication,
            'relatedPublications' => $relatedPublications,
            'selectedType' => $type,
        ]);
    }

    private function renderIndex(string $type): View
    {
        abort_unless(array_key_exists($type, $this->mediaTypes()), 404);

        $query = Content::publications()
            ->published()
            ->orderByDesc('published_at');

        if ($type !== 'all') {
            $query->where('category', $type);
        }

        $publications = $query->paginate(9)->withQueryString();

        $featuredPublications = Content::publications()
            ->published()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('media.index', [
            'featuredPublications' => $featuredPublications,
            'mediaTypes' => $this->mediaTypes(),
            'publications' => $publications,
            'selectedType' => $type,
        ]);
    }
}
