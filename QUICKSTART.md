# 🚀 Quick Start Guide - Digitalisasi Monitoring System

## Setup Cepat (5 menit)

### Langkah 1: Buka Terminal di Folder Digitalisasi
```bash
cd c:\Digitalisasi
```

### Langkah 2: Install Dependencies
```bash
composer install
npm install
```

### Langkah 3: Setup Database
```bash
# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database
php artisan migrate --seed
```

### Langkah 4: Build Frontend Assets
```bash
npm run build
```

### Langkah 5: Jalankan Development Server

**Terminal 1** - Backend Server:
```bash
php artisan serve
```

**Terminal 2** - Frontend Dev Server (opsional tapi recommended untuk hot reload):
```bash
npm run dev
```

### ✅ Aplikasi Siap!
Buka browser: http://localhost:8000/monitoring

---

## Demo Credentials (jika ada login)

Seeder sudah membuat data contoh:
- **4 Entities** (PT dan Departemen)
- **5 Items per Entity** (total 20 items)
- Mix of statuses: Pending, In Progress, Completed, Delayed

---

## Main Features yang Sudah Diimplementasi

### 1. 📊 Dashboard Overview
```
GET /monitoring
```
- Real-time progress aggregation
- 5 statistics cards (Total Progress, Items, Completed, In Progress, Delayed)
- Filter by Entity, Status, Category
- Interactive progress bars
- Paginated items table

### 2. 🏢 Manajemen Entitas
```
GET  /monitoring/entities              → List semua PT/Departemen
POST /monitoring/entities              → Create entitas baru
PUT  /monitoring/entities/{id}         → Edit entitas
DEL  /monitoring/entities/{id}         → Delete (soft delete)
GET  /monitoring/entities/{id}         → Detail entitas + items
```

**Features:**
- Modal form untuk Create/Edit
- Grid view dengan cards
- Average progress calculation
- Contact information management

### 3. 📋 Manajemen Items
```
GET  /monitoring/items                 → List semua items
POST /monitoring/items                 → Create item baru
PUT  /monitoring/items/{id}            → Edit item
DEL  /monitoring/items/{id}            → Delete (soft delete)
POST /monitoring/items/{id}/progress   → Quick progress update (API)
```

**Features:**
- AJAX modal form untuk CRUD
- Filter by Entity, Status, Category
- Progress bars
- Status badges
- PIC assignment
- Date tracking (start, target, completion)

### 4. 📈 Analytics
```
GET /monitoring/analytics
```
- Progress per entity (chart-like view)
- Status distribution
- Category performance breakdown

---

## Database Models

### Entity
- name, code, type (department/pt)
- contact_person, contact_email, contact_phone
- description
- Relations: hasMany(DigitalizationItem)
- Attributes: average_progress, total_items, completed_items

### DigitalizationItem
- entity_id (FK)
- item_name, category, description
- progress_actual (0-100+), progress_target
- status (pending, in_progress, completed, delayed)
- start_date, target_date, completion_date
- assigned_to (PIC name)
- notes
- Relations: belongsTo(Entity)
- Scopes: completed(), inProgress(), delayed()

---

## Frontend Stack

### Pages
- **Dashboard/Index.vue** - Main dashboard dengan statistics
- **Dashboard/Analytics.vue** - Analytics page
- **Entities/Index.vue** - List & manage entities dengan modal
- **Entities/Show.vue** - Detail entity dengan tabel items
- **Items/Index.vue** - List & manage items dengan modal CRUD

### Components  
- **StatCard.vue** - Reusable statistics card
- **StatusBadge.vue** - Status badge dengan warna
- **AppLayout.vue** - Navigation layout

### Styling
- Tailwind CSS v4 (utility-first)
- Responsive design (mobile, tablet, desktop)
- Progress bars dengan `w-full h-3 bg-indigo-500`

---

## API Endpoints (untuk Custom Integration)

### Quick Progress Update
```bash
curl -X POST http://localhost:8000/monitoring/items/1/progress \
  -H "Content-Type: application/json" \
  -d '{"progress_actual": 85, "status": "in_progress"}'
```

### Get Items by Entity (JSON)
```bash
curl http://localhost:8000/monitoring/items/entity/1
```

---

## Troubleshooting

### Error: "SQLSTATE[HY000]: General error"
```bash
# Delete & recreate database
php artisan migrate:refresh --seed
```

### Error: "route() is not defined"
- Frontend mungkin perlu refresh: Ctrl+R atau Cmd+R

### Assets not loading
```bash
# Rebuild assets
npm run build

# Atau untuk development:
npm run dev
```

### Database lock error
```bash
# Clear Laravel cache
php artisan optimize:clear
php artisan cache:clear
```

---

## Common Tasks

### Add New Entity via CLI
```bash
php artisan tinker
>>> Entity::create(['name' => 'Baru', 'code' => 'NEW001', 'type' => 'pt'])
```

### Check Database
```bash
php artisan tinker
>>> Entity::with('digitalizationItems:id,entity_id,item_name,progress_actual')->get()
>>> DigitalizationItem::where('status', 'delayed')->count()
```

### Enable Debugging
Update `.env`:
```env
APP_DEBUG=true
```

### Reset Everything
```bash
php artisan migrate:refresh --seed
php artisan optimize:clear
npm run build
```

---

## File Structure

```
c:\Digitalisasi\
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── EntityController.php
│   │   │   └── DigitalizationItemController.php
│   │   └── Middleware/
│   │       └── HandleInertiaRequests.php
│   └── Models/
│       ├── Entity.php
│       └── DigitalizationItem.php
├── database/
│   ├── migrations/
│   │   ├── *_create_entities_table.php
│   │   └── *_create_digitalization_items_table.php
│   └── seeders/
│       └── DigitalisasiSeeder.php
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   │   ├── Dashboard/
│   │   │   ├── Entities/
│   │   │   └── Items/
│   │   ├── Components/
│   │   ├── Layouts/
│   │   └── app.js
│   ├── css/
│   │   └── app.css
│   └── views/
│       └── app.blade.php
├── routes/
│   └── web.php
├── .env
├── vite.config.js
├── package.json
└── composer.json
```

---

## Next Steps / Future Enhancements

- [ ] Authentication & Authorization
- [ ] Export to Excel/PDF
- [ ] Email notifications
- [ ] History/Audit log for changes
- [ ] Advanced charts & dashboards
- [ ] Multi-language support
- [ ] SSO integration
- [ ] Mobile app
- [ ] Real-time collaboration

---

## Support

Jika ada issues atau pertanyaan, check:
1. Browser console (F12) untuk JS errors
2. Laravel logs: `storage/logs/laravel.log`
3. Database: Gunakan `php artisan tinker`

---

**Happy Digitalisasi Monitoring! 🎉**
