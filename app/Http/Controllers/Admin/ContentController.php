<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContentController extends Controller
{
    public function index(Request $request, string $section): View
    {
        $sectionConfig = $this->section($section);

        $contents = Content::query()
            ->ofType($sectionConfig['type'])
            ->with('parent')
            ->when(
                $section === 'publications' && filled($request->string('category')->toString()),
                fn ($query) => $query->where('category', $request->string('category')->toString())
            )
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.content.index', [
            'contents' => $contents,
            'sectionConfig' => $sectionConfig,
            'sectionKey' => $section,
            'sectionMap' => $this->sections(),
        ]);
    }

    public function create(string $section): View
    {
        $sectionConfig = $this->section($section);

        return view('admin.content.form', [
            'businessUnitOptions' => $this->businessUnitOptions(),
            'content' => new Content([
                'is_published' => true,
                'sort_order' => 0,
            ]),
            'sectionConfig' => $sectionConfig,
            'sectionKey' => $section,
            'sectionMap' => $this->sections(),
        ]);
    }

    public function store(Request $request, string $section): RedirectResponse
    {
        $sectionConfig = $this->section($section);
        $validated = $this->validateContent($request, $section, null);

        Content::create($this->payloadFromRequest($validated, $section, $sectionConfig));

        return redirect()
            ->route('admin.contents.index', $section)
            ->with('status', $sectionConfig['singular'].' berhasil ditambahkan.');
    }

    public function edit(string $section, Content $content): View
    {
        $sectionConfig = $this->section($section);
        $this->ensureContentMatchesSection($content, $sectionConfig);

        return view('admin.content.form', [
            'businessUnitOptions' => $this->businessUnitOptions(),
            'content' => $content,
            'sectionConfig' => $sectionConfig,
            'sectionKey' => $section,
            'sectionMap' => $this->sections(),
        ]);
    }

    public function update(Request $request, string $section, Content $content): RedirectResponse
    {
        $sectionConfig = $this->section($section);
        $this->ensureContentMatchesSection($content, $sectionConfig);

        $validated = $this->validateContent($request, $section, $content);
        $content->update($this->payloadFromRequest($validated, $section, $sectionConfig));

        return redirect()
            ->route('admin.contents.index', $section)
            ->with('status', $sectionConfig['singular'].' berhasil diperbarui.');
    }

    public function destroy(string $section, Content $content): RedirectResponse
    {
        $sectionConfig = $this->section($section);
        $this->ensureContentMatchesSection($content, $sectionConfig);
        $content->delete();

        return redirect()
            ->route('admin.contents.index', $section)
            ->with('status', $sectionConfig['singular'].' berhasil dihapus.');
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function sections(): array
    {
        return [
            'pages' => [
                'type' => Content::TYPE_PAGE,
                'label' => 'Halaman',
                'singular' => 'Halaman',
                'description' => 'Profil perusahaan, K3L, karier, dan landing page statis lainnya.',
                'requires_slug' => true,
                'supports_parent' => false,
                'categories' => [
                    'corporate' => 'Corporate',
                    'support' => 'Pendukung',
                ],
            ],
            'business-units' => [
                'type' => Content::TYPE_BUSINESS_UNIT,
                'label' => 'Strategic Business Unit',
                'singular' => 'Business Unit',
                'description' => 'Landing page tujuh pilar bisnis Hasnur Group.',
                'requires_slug' => true,
                'supports_parent' => false,
                'categories' => [],
            ],
            'business-entities' => [
                'type' => Content::TYPE_BUSINESS_ENTITY,
                'label' => 'Entitas Anak Usaha',
                'singular' => 'Entitas',
                'description' => 'Profil entitas yang berada di dalam setiap business unit.',
                'requires_slug' => false,
                'supports_parent' => true,
                'categories' => [],
            ],
            'milestones' => [
                'type' => Content::TYPE_MILESTONE,
                'label' => 'Milestone',
                'singular' => 'Milestone',
                'description' => 'Timeline sejarah perusahaan sejak 1966 hingga transformasi terkini.',
                'requires_slug' => false,
                'supports_parent' => false,
                'categories' => [],
            ],
            'executives' => [
                'type' => Content::TYPE_EXECUTIVE,
                'label' => 'Manajemen',
                'singular' => 'Profil Manajemen',
                'description' => 'Jajaran komisaris, direksi, dan pimpinan kunci.',
                'requires_slug' => false,
                'supports_parent' => false,
                'categories' => [],
            ],
            'csr-pillars' => [
                'type' => Content::TYPE_CSR_PILLAR,
                'label' => 'Pilar CSR',
                'singular' => 'Pilar CSR',
                'description' => 'Pilar program keberlanjutan dan social impact Hasnur Group.',
                'requires_slug' => true,
                'supports_parent' => false,
                'categories' => [],
            ],
            'publications' => [
                'type' => Content::TYPE_PUBLICATION,
                'label' => 'Publikasi',
                'singular' => 'Publikasi',
                'description' => 'News, press release, multimedia, dan gallery.',
                'requires_slug' => true,
                'supports_parent' => false,
                'categories' => [
                    'news' => 'News',
                    'press-release' => 'Press Release',
                    'multimedia' => 'Multimedia',
                    'gallery' => 'Gallery',
                ],
            ],
            'locations' => [
                'type' => Content::TYPE_LOCATION,
                'label' => 'Lokasi & Kontak',
                'singular' => 'Lokasi',
                'description' => 'Alamat kantor pusat, kantor perwakilan, dan kanal komunikasi.',
                'requires_slug' => false,
                'supports_parent' => false,
                'categories' => [],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function section(string $section): array
    {
        $sections = $this->sections();
        abort_unless(array_key_exists($section, $sections), 404);

        return $sections[$section];
    }

    private function ensureContentMatchesSection(Content $content, array $sectionConfig): void
    {
        abort_unless($content->type === $sectionConfig['type'], 404);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateContent(Request $request, string $section, ?Content $content): array
    {
        $config = $this->section($section);

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                Rule::requiredIf($config['requires_slug']),
                'nullable',
                'string',
                'max:255',
                Rule::unique('contents', 'slug')->ignore($content?->id),
            ],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'legacy_path' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('contents', 'legacy_path')->ignore($content?->id),
            ],
            'category' => [
                Rule::requiredIf(! empty($config['categories'])),
                'nullable',
                Rule::in(array_keys($config['categories'])),
            ],
            'parent_id' => [
                Rule::requiredIf($config['supports_parent']),
                'nullable',
                'integer',
                'exists:contents,id',
            ],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
            'extra_theme' => ['nullable', 'string', 'max:255'],
            'extra_accent' => ['nullable', 'string', 'max:255'],
            'extra_code' => ['nullable', 'string', 'max:255'],
            'extra_website' => ['nullable', 'string', 'max:255'],
            'extra_year' => ['nullable', 'string', 'max:255'],
            'extra_role' => ['nullable', 'string', 'max:255'],
            'extra_division' => ['nullable', 'string', 'max:255'],
            'extra_icon' => ['nullable', 'string', 'max:255'],
            'extra_impact' => ['nullable', 'string', 'max:255'],
            'extra_author' => ['nullable', 'string', 'max:255'],
            'extra_source' => ['nullable', 'string', 'max:255'],
            'extra_phone' => ['nullable', 'string', 'max:255'],
            'extra_email' => ['nullable', 'string', 'max:255'],
            'extra_map_link' => ['nullable', 'string', 'max:255'],
            'extra_office_hours' => ['nullable', 'string', 'max:255'],
            'extra_highlight' => ['nullable', 'string', 'max:255'],
            'extra_cta_label' => ['nullable', 'string', 'max:255'],
            'extra_cta_url' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $validated
     * @param  array<string, mixed>  $sectionConfig
     * @return array<string, mixed>
     */
    private function payloadFromRequest(array $validated, string $section, array $sectionConfig): array
    {
        $slug = blank($validated['slug'] ?? null) ? null : Str::slug((string) $validated['slug']);

        if ($slug === null && $sectionConfig['requires_slug']) {
            $slug = Str::slug((string) $validated['title']);
        }

        return [
            'type' => $sectionConfig['type'],
            'category' => $validated['category'] ?? null,
            'parent_id' => $sectionConfig['supports_parent'] ? ($validated['parent_id'] ?? null) : null,
            'title' => $validated['title'],
            'slug' => $slug,
            'subtitle' => $validated['subtitle'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'body' => $validated['body'] ?? null,
            'image_path' => $validated['image_path'] ?? null,
            'link_url' => $validated['link_url'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'legacy_path' => blank($validated['legacy_path'] ?? null)
                ? null
                : trim((string) $validated['legacy_path'], '/'),
            'extra' => $this->extraPayload($validated, $section),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_published' => (bool) ($validated['is_published'] ?? false),
            'published_at' => $validated['published_at'] ?? null,
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>|null
     */
    private function extraPayload(array $validated, string $section): ?array
    {
        $extra = match ($section) {
            'pages' => [
                'highlight' => $validated['extra_highlight'] ?? null,
                'cta_label' => $validated['extra_cta_label'] ?? null,
                'cta_url' => $validated['extra_cta_url'] ?? null,
            ],
            'business-units' => [
                'theme' => $validated['extra_theme'] ?? null,
                'accent' => $validated['extra_accent'] ?? null,
            ],
            'business-entities' => [
                'code' => $validated['extra_code'] ?? null,
                'website' => $validated['extra_website'] ?? null,
            ],
            'milestones' => [
                'year' => $validated['extra_year'] ?? null,
            ],
            'executives' => [
                'role' => $validated['extra_role'] ?? null,
                'division' => $validated['extra_division'] ?? null,
            ],
            'csr-pillars' => [
                'icon' => $validated['extra_icon'] ?? null,
                'impact' => $validated['extra_impact'] ?? null,
            ],
            'publications' => [
                'author' => $validated['extra_author'] ?? null,
                'source' => $validated['extra_source'] ?? null,
            ],
            'locations' => [
                'phone' => $validated['extra_phone'] ?? null,
                'email' => $validated['extra_email'] ?? null,
                'map_link' => $validated['extra_map_link'] ?? null,
                'office_hours' => $validated['extra_office_hours'] ?? null,
            ],
            default => [],
        };

        $extra = array_filter($extra, fn ($value) => filled($value));

        return $extra === [] ? null : $extra;
    }

    /**
     * @return \Illuminate\Support\Collection<int, Content>
     */
    private function businessUnitOptions()
    {
        return Content::businessUnits()->orderBy('title')->get();
    }
}
