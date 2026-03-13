<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\LegacyRedirect;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HasnurSiteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedPages();
        $units = $this->seedBusinessUnits();

        $this->seedBusinessEntities($units);
        $this->seedMilestones();
        $this->seedExecutives();
        $this->seedCsrPillars();
        $this->seedPublications();
        $this->seedLocations();
        $this->seedRedirects();
    }

    private function seedPages(): void
    {
        $items = [
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'corporate',
                'title' => 'Ikhtisar Hasnur Group',
                'slug' => 'company-profile',
                'summary' => 'Corporate profile yang merangkum identitas grup, arah pertumbuhan, dan filosofi Borneo Blossom.',
                'body' => $this->html([
                    'Hasnur Group tumbuh dari Banua sejak 1966 dan berkembang menjadi portofolio bisnis multiindustri dengan pijakan kuat pada operasional, kolaborasi, dan keberlanjutan.',
                    'Pada rejuvenation ini, halaman corporate profile diposisikan sebagai pintu masuk strategis yang tetap menjaga DNA situs lama, tetapi tampil lebih modern dan lebih siap menampung pertumbuhan konten.',
                ]),
                'legacy_path' => 'page/about-us',
                'extra' => ['highlight' => 'Borneo Blossom', 'cta_label' => 'Lihat Business Unit', 'cta_url' => '/business-units'],
                'sort_order' => 10,
                'is_published' => true,
            ],
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'corporate',
                'title' => 'Sejarah & Milestone',
                'slug' => 'history',
                'summary' => 'Perjalanan Hasnur Group dari fondasi usaha 1966 hingga transformasi terkini.',
                'body' => $this->html([
                    'Timeline baru dirancang untuk menonjolkan momen yang membentuk karakter perusahaan, mulai dari fase bertumbuh, ekspansi, hingga penguatan tata kelola.',
                    'Halaman ini juga disiapkan ramah SEO untuk menampung arsip milestone lama dan fase transformasi berikutnya.',
                ]),
                'legacy_path' => 'page/about-us/history',
                'sort_order' => 20,
                'is_published' => true,
            ],
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'corporate',
                'title' => 'Visi, Misi, & Borneo Blossom',
                'slug' => 'vision-mission',
                'summary' => 'Visi menjadi perusahaan kebanggaan Banua dan misi bertumbuh secara berkelanjutan.',
                'body' => $this->html([
                    'Visi: menjadi perusahaan yang terdepan dan membanggakan Banua.',
                    'Misi: tumbuh berkelanjutan, menjaga reputasi melalui kinerja sehat, dan memberi nilai tambah bagi seluruh stakeholder.',
                    'Borneo Blossom ditampilkan sebagai filosofi brand experience: akar yang kuat, sinergi yang tumbuh, dan dampak yang terasa nyata.',
                ]),
                'legacy_path' => 'page/about-us/vision-mission',
                'sort_order' => 30,
                'is_published' => true,
            ],
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'corporate',
                'title' => 'Core Values',
                'slug' => 'core-values',
                'summary' => 'Agile, Caring, Committed, Creative, Integrity, Nationalism, Professional, dan Teamwork.',
                'body' => $this->html([
                    'Core values Hasnur Group diterjemahkan menjadi delapan perilaku yang menuntun cara berpikir, mengambil keputusan, dan bekerja lintas unit.',
                    'Delapan nilai ini menjadi budaya kerja yang ingin terlihat oleh karyawan, mitra, maupun publik.',
                ]),
                'legacy_path' => 'page/about-us/core-value',
                'sort_order' => 40,
                'is_published' => true,
            ],
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'corporate',
                'title' => 'Manajemen & Struktur Organisasi',
                'slug' => 'management',
                'summary' => 'Profil pimpinan yang mengawal arah strategis, pertumbuhan, dan tata kelola Hasnur Group.',
                'body' => $this->html([
                    'Modul manajemen menampilkan jajaran pengarah dan eksekutif utama yang relevan bagi publik, mitra, dan pemangku kepentingan.',
                    'Struktur datanya disiapkan agar perubahan pimpinan dapat diperbarui dengan cepat tanpa mengubah arsitektur halaman.',
                ]),
                'legacy_path' => 'page/about-us/management',
                'sort_order' => 50,
                'is_published' => true,
            ],
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'support',
                'title' => 'CSR & Yayasan Hasnur Centre',
                'slug' => 'csr-overview',
                'summary' => 'Komitmen keberlanjutan dan program dampak sosial Hasnur Group.',
                'body' => $this->html([
                    'Portal CSR berfungsi sebagai etalase reputasi dan ruang akuntabilitas program keberlanjutan.',
                    'Pilar program disusun agar publik dapat melihat fokus, kisah dampak, dan peluang kolaborasi secara cepat.',
                ]),
                'legacy_path' => 'page/our-csr',
                'sort_order' => 60,
                'is_published' => true,
            ],
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'support',
                'title' => 'K3L & Budaya Kerja Aman',
                'slug' => 'hse-overview',
                'summary' => 'Halaman pendukung untuk menjaga fitur K3L yang sudah ada pada situs lama.',
                'body' => $this->html([
                    'Halaman ini disiapkan sebagai ruang untuk kebijakan kesehatan, keselamatan kerja, dan lingkungan.',
                    'Struktur ini memastikan fitur lama tetap ada dan mudah diperluas pada fase berikutnya.',
                ]),
                'legacy_path' => 'page/k3l',
                'sort_order' => 70,
                'is_published' => true,
            ],
            [
                'type' => Content::TYPE_PAGE,
                'category' => 'support',
                'title' => 'Karier',
                'slug' => 'careers',
                'summary' => 'Halaman karier yang menjaga touchpoint rekrutmen dan employer branding.',
                'body' => $this->html([
                    'Halaman karier baru menyiapkan ruang untuk informasi rekrutmen, budaya kerja, dan employer branding.',
                    'Pada fase awal, modul ini tetap ringan namun struktur datanya siap diperluas menjadi pusat lowongan kerja.',
                ]),
                'legacy_path' => 'page/career',
                'sort_order' => 80,
                'is_published' => true,
            ],
        ];

        foreach ($items as $item) {
            $this->upsertContent($item);
        }
    }

    /**
     * @return array<string, Content>
     */
    private function seedBusinessUnits(): array
    {
        $items = [
            'logistics' => ['title' => 'Logistics', 'subtitle' => 'Integrated maritime and supply chain operations', 'summary' => 'Pilar logistik yang menegaskan kekuatan shipping, hauling, dan operasi rantai pasok.', 'legacy_path' => 'page/our-business/logistic', 'accent' => '#144f91'],
            'agribusiness-forestry' => ['title' => 'Agribusiness & Forestry', 'subtitle' => 'Sustainable plantation and forestry value chain', 'summary' => 'Pilar agribisnis dan kehutanan yang menonjolkan keseimbangan produktivitas dan keberlanjutan.', 'legacy_path' => 'page/our-business/agribusiness-forestry', 'accent' => '#1b5a9f'],
            'energy' => ['title' => 'Energy', 'subtitle' => 'Mining operations and renewable transition roadmap', 'summary' => 'Pilar energi untuk kinerja operasional dan kesiapan menghadapi masa depan energi.', 'legacy_path' => 'page/our-business/energy', 'accent' => '#2466ad'],
            'technology-services' => ['title' => 'Technology & Services', 'subtitle' => 'Digital solutions and managed services', 'summary' => 'Unit teknologi yang memperkuat efisiensi dan transformasi digital grup.', 'legacy_path' => 'page/our-business/technology-services', 'accent' => '#103f74'],
            'education' => ['title' => 'Education', 'subtitle' => 'Foundation, schools, and talent acceleration', 'summary' => 'Unit pendidikan yang menampilkan investasi pada manusia dan talenta masa depan.', 'legacy_path' => 'page/our-business/education', 'accent' => '#2a6dbc'],
            'consumer' => ['title' => 'Consumer', 'subtitle' => 'Media, health, and lifestyle engagement', 'summary' => 'Pilar yang paling dekat dengan publik, termasuk media, kesehatan, dan olahraga.', 'legacy_path' => 'page/our-business/consumer', 'accent' => '#1d5fa8'],
            'investment' => ['title' => 'Investment', 'subtitle' => 'Strategic capital allocation and growth partnerships', 'summary' => 'Pilar investasi untuk strategi portofolio dan peluang pertumbuhan berikutnya.', 'legacy_path' => 'page/our-business/investment', 'accent' => '#0d3561'],
        ];

        $models = [];

        foreach ($items as $slug => $item) {
            $models[$slug] = $this->upsertContent([
                'type' => Content::TYPE_BUSINESS_UNIT,
                'title' => $item['title'],
                'slug' => $slug,
                'subtitle' => $item['subtitle'],
                'summary' => $item['summary'],
                'body' => $this->html([
                    $item['summary'],
                    'Halaman detailnya disiapkan untuk menampilkan entitas anak usaha, fokus layanan, dan storytelling yang lebih visual.',
                ]),
                'legacy_path' => $item['legacy_path'],
                'extra' => ['theme' => $item['subtitle'], 'accent' => $item['accent']],
                'sort_order' => count($models) * 10 + 10,
                'is_published' => true,
            ]);
        }

        return $models;
    }

    /**
     * @param  array<string, Content>  $units
     */
    private function seedBusinessEntities(array $units): void
    {
        $entities = [
            [$units['logistics']->id, 'PT Hasnur Internasional Shipping Tbk (HAIS)', 'Public listed shipping ecosystem'],
            [$units['logistics']->id, 'Hasnur Riung Transport (HRT)', 'Transport and hauling support'],
            [$units['technology-services']->id, 'Manage Service Unit', 'Managed service dan dukungan operasional digital'],
            [$units['education']->id, 'Yayasan Hasnur Centre', 'Program pendidikan dan keberdayaan komunitas'],
            [$units['education']->id, 'Codero', 'Program pengembangan talenta digital'],
            [$units['consumer']->id, 'PS Barito Putera', 'Sports engagement and community touchpoint'],
        ];

        foreach ($entities as $index => [$parentId, $title, $subtitle]) {
            $this->upsertContent([
                'type' => Content::TYPE_BUSINESS_ENTITY,
                'parent_id' => $parentId,
                'title' => $title,
                'subtitle' => $subtitle,
                'summary' => $subtitle,
                'sort_order' => $index * 10 + 10,
                'is_published' => true,
            ]);
        }
    }

    private function seedMilestones(): void
    {
        foreach ([
            ['1966', 'Fondasi Usaha Keluarga'],
            ['1987', 'Ekspansi ke Rantai Nilai Logistik'],
            ['2002', 'Portofolio Multiindustri'],
            ['2016', 'Penguatan Tata Kelola Grup'],
            ['2025', 'Transformasi Brand & Experience'],
        ] as $index => [$year, $title]) {
            $this->upsertContent([
                'type' => Content::TYPE_MILESTONE,
                'title' => $title,
                'subtitle' => $year,
                'summary' => 'Milestone strategis yang menandai fase pertumbuhan Hasnur Group.',
                'extra' => ['year' => $year],
                'sort_order' => $index * 10 + 10,
                'is_published' => true,
            ]);
        }
    }

    private function seedExecutives(): void
    {
        foreach ([
            ['Jayanti Sari', 'President Director'],
            ['Yuni Abdi Nur Sulaiman', 'Corporate Director, GRCD'],
            ['Tri Setiyonohadi', 'Director & Deputy CFO'],
            ['Leadership Team', 'Cross-functional executive collaboration'],
        ] as $index => [$name, $role]) {
            $this->upsertContent([
                'type' => Content::TYPE_EXECUTIVE,
                'title' => $name,
                'subtitle' => $role,
                'summary' => 'Profil manajemen untuk modul struktur organisasi dan kepemimpinan grup.',
                'extra' => ['role' => $role],
                'sort_order' => $index * 10 + 10,
                'is_published' => true,
            ]);
        }
    }

    private function seedCsrPillars(): void
    {
        foreach ([
            ['ekonomi', 'Pilar Ekonomi', 'Pemberdayaan usaha dan ekonomi lokal'],
            ['pendidikan', 'Pilar Pendidikan', 'Penguatan talenta masa depan'],
            ['sosial', 'Pilar Sosial', 'Social resilience and community care'],
            ['lingkungan-kesehatan', 'Pilar Lingkungan & Kesehatan', 'Sustainability and healthy living'],
        ] as $index => [$slug, $title, $impact]) {
            $this->upsertContent([
                'type' => Content::TYPE_CSR_PILLAR,
                'title' => $title,
                'slug' => $slug,
                'summary' => $impact,
                'body' => $this->html([$impact, 'Halaman detail dapat dikembangkan untuk menampilkan program dan indikator dampak.']),
                'extra' => ['impact' => $impact],
                'sort_order' => $index * 10 + 10,
                'is_published' => true,
            ]);
        }
    }

    private function seedPublications(): void
    {
        $items = [
            ['news', 'hd-hyundai-dan-hasnur-group-sepakati-kerja-sama-strategis-untuk-pengembangan-platform-inovasi-digital-hijau', 'HD Hyundai dan Hasnur Group Sepakati Kerja Sama Strategis untuk Pengembangan Platform Inovasi Digital Hijau', 'post/news/hd-hyundai-dan-hasnur-group-sepakati-kerja-sama-strategis-untuk-pengembangan-platform-inovasi-digital-hijau', '2025-11-06'],
            ['news', 'rkap-2025-hasnur-group-synergy-in-action', 'RKAP 2025 Hasnur Group: Synergy in Action untuk Pertumbuhan yang Terkelola', 'post/news/rkap-2025-hasnur-group-synergy-in-action', '2025-01-13'],
            ['press-release', 'top-csr-awards-2024-hasnur-group-raih-bintang-lima', 'Top CSR Awards 2024: Hasnur Group Raih Penghargaan Bintang Lima', 'post/press-release/top-csr-awards-2024-hasnur-group-raih-bintang-lima', '2024-06-05'],
            ['press-release', 'hasnur-group-perkuat-tata-kelola-dan-esg-untuk-siklus-bisnis-2026', 'Hasnur Group Perkuat Tata Kelola dan ESG untuk Siklus Bisnis 2026', 'post/press-release/hasnur-group-perkuat-tata-kelola-dan-esg-untuk-siklus-bisnis-2026', '2025-12-18'],
            ['multimedia', 'hasnur-group-corporate-reel-2025', 'Hasnur Group Corporate Reel 2025', 'page/multimedia', '2025-08-10'],
            ['gallery', 'gallery-kegiatan-grup-dan-community-impact', 'Gallery Kegiatan Grup dan Community Impact', 'page/gallery', '2025-09-22'],
        ];

        foreach ($items as $index => [$category, $slug, $title, $legacyPath, $publishedAt]) {
            $this->upsertContent([
                'type' => Content::TYPE_PUBLICATION,
                'category' => $category,
                'title' => $title,
                'slug' => $slug,
                'summary' => 'Arsip publikasi yang menjaga kontinuitas SEO dan kesiapan pengelolaan konten di versi baru.',
                'body' => $this->html([
                    'Konten ini menjadi contoh bagaimana arsip lama tetap bisa dipertahankan sambil mendapatkan struktur baca yang lebih modern.',
                    'Setiap item publikasi siap dihubungkan ke redirect 301 agar ranking dan jejak indeksasi lama tidak hilang.',
                ]),
                'legacy_path' => $legacyPath,
                'published_at' => Carbon::parse($publishedAt),
                'extra' => ['author' => 'Corporate Communication', 'source' => 'Hasnur Group'],
                'sort_order' => $index * 10 + 10,
                'is_published' => true,
            ]);
        }
    }

    private function seedLocations(): void
    {
        foreach ([
            ['Head Office Banjarmasin', 'Kalimantan Selatan', 'Jl. Mayjen Sutoyo S. No. 18, Banjarmasin 70231, Indonesia', '+62 511 6743 333'],
            ['Jakarta Representative Office', 'Office 8, Jakarta', 'Office 8 Building 22nd Floor Unit E-H, SCBD Lot 28, Jl. Jend. Sudirman Kav. 52-53, Jakarta Selatan 12190', '+62 21 3950 8691'],
        ] as $index => [$title, $subtitle, $address, $phone]) {
            $this->upsertContent([
                'type' => Content::TYPE_LOCATION,
                'title' => $title,
                'subtitle' => $subtitle,
                'summary' => $address,
                'body' => $this->html([$address]),
                'extra' => ['phone' => $phone, 'email' => 'corporate@hasnurgroup.com'],
                'sort_order' => $index * 10 + 10,
                'is_published' => true,
            ]);
        }
    }

    private function seedRedirects(): void
    {
        foreach ([
            'contact-us' => '/contact',
            'page/our-business' => '/business-units',
            'page/publication' => '/media-center',
            'page/update-terkini' => '/media-center/news',
            'page/multimedia' => '/media-center/multimedia',
            'page/gallery' => '/media-center/gallery',
            'page/career' => '/corporate/careers',
            'page/k3l' => '/corporate/hse-overview',
            'page/about-us' => '/corporate',
        ] as $oldPath => $newPath) {
            LegacyRedirect::updateOrCreate(
                ['old_path' => $oldPath],
                ['new_path' => $newPath, 'status_code' => 301, 'is_active' => true, 'notes' => 'Seeded for legacy SEO continuity.']
            );
        }
    }

    /**
     * @param  list<string>  $paragraphs
     */
    private function html(array $paragraphs): string
    {
        return collect($paragraphs)
            ->map(fn (string $paragraph): string => '<p>'.$paragraph.'</p>')
            ->implode('');
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function upsertContent(array $attributes): Content
    {
        $lookup = ['type' => $attributes['type'], 'title' => $attributes['title']];

        if (filled($attributes['slug'] ?? null)) {
            $lookup['slug'] = $attributes['slug'];
        }

        return Content::updateOrCreate($lookup, $attributes);
    }
}
