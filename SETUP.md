# Sistem Monitoring Digitalisasi

Sistem monitoring komprehensif untuk melacak progress digitalisasi di berbagai departemen dan entitas (PT).

## Fitur Utama

### 📊 Dashboard Overview
- Agregasi progress real-time per entitas
- Summary statistik keseluruhan (Total Progress, Items, Completed, In Progress, Delayed)
- Visualisasi progress bar dengan Tailwind CSS
- Filter berdasarkan Entitas, Status, dan Kategori

### 📋 Manajemen Inventori (CRUD)
- **Create**: Modal form untuk menambah items baru via AJAX
- **Read**: Halaman listing dengan pagination
- **Update**: Edit items dengan validasi form
- **Delete**: Soft Deletes untuk audit trail
- Dropdown filter untuk filter dinamis

### 🏢 Manajemen Entitas
- Create, Read, Update, Delete PT/Departemen
- Contact information management
- Tracking total items per entitas
- Average progress calculation

### 📈 Visualisasi Progress
- Progress bars dengan Tailwind utilities
- Status badges (Pending, In Progress, Completed, Delayed)
- Entity-level progress overview
- Category-based analytics

### 🔒 Features Tambahan
- Soft Deletes untuk data recovery
- Form validation dengan Laravel
- API endpoints untuk quick updates
- Responsive design (mobile-friendly)

## Teknologi Stack

- **Backend**: Laravel 12 dengan PHP 8.2+
- **Frontend**: Vue 3 dengan Inertia.js
- **Styling**: Tailwind CSS v4
- **Database**: SQLite/MySQL/PostgreSQL
- **HTTP Client**: Axios

## Setup & Installation

### 1. Prerequisites
```bash
php 8.2 atau lebih tinggi
composer
node.js & npm
```

### 2. Clone & Setup Project
```bash
cd /path/to/Digitalisasi
cp .env.example .env
composer install
npm install
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=sqlite
# atau untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=digitalisasi
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Jalankan Migrations & Seeders
```bash
php artisan migrate --seed
```

### 6. Build Assets
```bash
npm run build
# atau untuk development dengan hot reload:
npm run dev
```

### 7. Jalankan Development Server
```bash
php artisan serve
```

Aplikasi akan tersedia di: `http://localhost:8000`

Untuk development dengan hot reload (di terminal baru):
```bash
php artisan serve
npm run dev
```

## Struktur Database

### Table: entities
Menyimpan data PT/Departemen
```sql
- id (Primary Key)
- name (string)
- code (string unique)
- type (enum: 'department', 'pt')
- description (text)
- contact_person (string)
- contact_email (email)
- contact_phone (string)
- timestamps
- soft_deletes
```

### Table: digitalization_items
Menyimpan data items yang dimonitor
```sql
- id (Primary Key)
- entity_id (Foreign Key to entities)
- item_name (string)
- category (string)
- description (text)
- progress_actual (float 0-100+)
- progress_target (float)
- status (enum: 'pending', 'in_progress', 'completed', 'delayed')
- start_date (date)
- target_date (date)
- completion_date (date)
- notes (text)
- assigned_to (string)
- timestamps
- soft_deletes
```

## Routes

### Monitoring Routes
```
GET  /monitoring                          → Dashboard
GET  /monitoring/analytics                → Analytics
GET  /monitoring/entities                 → List Entities
POST /monitoring/entities                 → Create Entity
PUT  /monitoring/entities/{id}            → Update Entity
DELETE /monitoring/entities/{id}          → Delete Entity
GET  /monitoring/entities/{id}            → Show Entity Detail

GET  /monitoring/items                    → List Items
POST /monitoring/items                    → Create Item
PUT  /monitoring/items/{id}               → Update Item
DELETE /monitoring/items/{id}             → Delete Item
POST /monitoring/items/{id}/progress      → Update Progress (API)
GET  /monitoring/items/entity/{entity}    → Get Items by Entity (API)
```

## Models & Methods

### Entity Model
```php
// Relations
$entity->digitalizationItems()

// Attributes
$entity->average_progress        // Rata-rata progress computed
$entity->total_items             // Total items count
$entity->completed_items         // Items dengan progress >= 100
```

### DigitalizationItem Model
```php
// Relations
$item->entity()

// Attributes
$item->progress_percentage       // Progress 0-100
$item->status_color              // Color based on status

// Scopes
DigitalizationItem::completed()
DigitalizationItem::inProgress()
DigitalizationItem::delayed()
```

## Vue Components

### Pages
- `Pages/Dashboard/Index.vue` - Main dashboard dengan statistics
- `Pages/Entities/Index.vue` - List & manage entities
- `Pages/Entities/Show.vue` - Entity detail dengan items
- `Pages/Items/Index.vue` - List & manage items dengan modal CRUD

### Components
- `Components/StatCard.vue` - Card statistik
- `Components/StatusBadge.vue` - Status badge

## API Endpoints (JSON)

### Quick Progress Update
```
POST /monitoring/items/{id}/progress
Body: {
  "progress_actual": 85,
  "status": "in_progress"
}
```

### Get Items by Entity
```
GET /monitoring/items/entity/{entity_id}
Response: [item1, item2, ...]
```

## Sample Data

Jalankan seeder untuk membuat data contoh:
```bash
php artisan db:seed --class=DigitalisasiSeeder
```

Ini akan membuat 4 entities dengan 5 items masing-masing.

## Troubleshooting

### 1. Database Error
```bash
# Reset database
php artisan migrate:refresh --seed

# Manual migration
php artisan migrate
php artisan db:seed
```

### 2. Asset Build Error
```bash
npm install
npm run build
```

### 3. Clear Cache
```bash
php artisan optimize:clear
php artisan view:clear
php artisan cache:clear
```

### 4. Inertia Middleware Issue
Pastikan `HandleInertiaRequests` middleware sudah ditambahkan ke `app/Http/Kernel.php` pada section `$middlewareGroups['web']`

## Development Tips

### Hot Module Replacement (HMR)
Untuk live reload saat development, jalankan di 2 terminal:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

### Database Inspection
Gunakan Laravel Tinker untuk inspect data:
```bash
php artisan tinker
>>> Entity::with('digitalizationItems')->get()
>>> DigitalizationItem::avg('progress_actual')
```

### Form Debugging
Browser developer tools akan menampilkan request/response untuk form submission.

## Production Deployment

```bash
# Build untuk production
npm run build

# Migrate database
php artisan migrate --force

# Seed production data
php artisan db:seed --class=DigitalisasiSeeder --force

# Clear all caches
php artisan optimize
```

## License

MIT License

## Contact

Untuk pertanyaan atau feedback, hubungi tim development.
