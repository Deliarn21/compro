<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\DigitalizationItem;
use App\Models\DigitalizationTask;
use Illuminate\Database\Seeder;

class DigitalisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create master digitalization tasks
        $masterTasks = [
            [
                'task_name' => 'Implementasi ERP System',
                'category' => 'Software',
                'description' => 'Implementasi sistem ERP untuk manajemen bisnis terintegrasi lengkap',
                'difficulty_level' => 'hard',
                'estimated_duration' => '6 bulan',
            ],
            [
                'task_name' => 'Cloud Migration',
                'category' => 'Infrastructure',
                'description' => 'Migrasi infrastruktur dan data ke cloud platform',
                'difficulty_level' => 'hard',
                'estimated_duration' => '4 bulan',
            ],
            [
                'task_name' => 'Business Process Automation',
                'category' => 'Process',
                'description' => 'Otomasi proses bisnis menggunakan RPA technology',
                'difficulty_level' => 'medium',
                'estimated_duration' => '3 bulan',
            ],
            [
                'task_name' => 'Hardware Upgrade & Modernization',
                'category' => 'Hardware',
                'description' => 'Upgrade semua server dan workstation dengan teknologi terbaru',
                'difficulty_level' => 'medium',
                'estimated_duration' => '2 bulan',
            ],
            [
                'task_name' => 'Cybersecurity Implementation',
                'category' => 'Security',
                'description' => 'Implementasi sistem keamanan cyber komprehensif',
                'difficulty_level' => 'hard',
                'estimated_duration' => '5 bulan',
            ],
            [
                'task_name' => 'Data Analytics Platform',
                'category' => 'Software',
                'description' => 'Setup platform analytics untuk business intelligence',
                'difficulty_level' => 'medium',
                'estimated_duration' => '3 bulan',
            ],
            [
                'task_name' => 'Mobile App Development',
                'category' => 'Software',
                'description' => 'Pengembangan aplikasi mobile untuk customer engagement',
                'difficulty_level' => 'hard',
                'estimated_duration' => '6 bulan',
            ],
            [
                'task_name' => 'Network Infrastructure Upgrade',
                'category' => 'Infrastructure',
                'description' => 'Upgrade jaringan ke teknologi fiber optic premium',
                'difficulty_level' => 'medium',
                'estimated_duration' => '3 bulan',
            ],
            [
                'task_name' => 'Employee Digital Training Program',
                'category' => 'Training',
                'description' => 'Program pelatihan digital literacy untuk semua karyawan',
                'difficulty_level' => 'easy',
                'estimated_duration' => '2 bulan',
            ],
            [
                'task_name' => 'Document Management System',
                'category' => 'Software',
                'description' => 'Implementasi sistem manajemen dokumen digital',
                'difficulty_level' => 'medium',
                'estimated_duration' => '2 bulan',
            ],
        ];

        $createdTasks = [];
        foreach ($masterTasks as $taskData) {
            $createdTasks[] = DigitalizationTask::create($taskData);
        }

        // Create sample entities
        $entities = [
            [
                'name' => 'PT Maju Jaya',
                'code' => 'PTM001',
                'type' => 'pt',
                'description' => 'Perusahaan manufaktur terkemuka',
                'contact_person' => 'Budi Santoso',
                'contact_email' => 'budi@majujaya.id',
                'contact_phone' => '08123456789',
            ],
            [
                'name' => 'Departemen IT',
                'code' => 'IT001',
                'type' => 'department',
                'description' => 'Divisi Teknologi Informasi',
                'contact_person' => 'Siti Nurhaliza',
                'contact_email' => 'siti@company.id',
                'contact_phone' => '08198765432',
            ],
            [
                'name' => 'PT Solusi Indonesia',
                'code' => 'PSI001',
                'type' => 'pt',
                'description' => 'Penyedia solusi digital',
                'contact_person' => 'Ahmad Rizki',
                'contact_email' => 'ahmad@solusi.id',
                'contact_phone' => '08567891234',
            ],
            [
                'name' => 'Departemen Finance',
                'code' => 'FIN001',
                'type' => 'department',
                'description' => 'Divisi Keuangan dan Akuntansi',
                'contact_person' => 'Dewi Kusumawati',
                'contact_email' => 'dewi@company.id',
                'contact_phone' => '08234567890',
            ],
        ];

        foreach ($entities as $entityData) {
            $entity = Entity::create($entityData);

            // Attach 3-5 random master tasks to each entity
            $selectedTasks = collect($createdTasks)->random(rand(3, 5));
            foreach ($selectedTasks as $task) {
                $entity->digitalizationTasks()->attach($task->id, [
                    'progress_actual' => rand(0, 100),
                    'progress_target' => 100,
                    'status' => $this->getRandomStatus(),
                    'start_date' => now()->subMonths(rand(1, 3)),
                    'target_date' => now()->addMonths(rand(2, 6)),
                    'assigned_to' => 'Tim Implementasi',
                ]);
            }

            // Also create some digitalization items for backward compatibility
            $items = [
                [
                    'item_name' => 'Implementasi ERP System',
                    'category' => 'Software',
                    'description' => 'Implementasi sistem ERP untuk manajemen bisnis terintegrasi',
                    'progress_actual' => 75,
                    'progress_target' => 100,
                    'status' => 'in_progress',
                    'start_date' => now()->subMonths(3),
                    'target_date' => now()->addMonths(2),
                    'assigned_to' => 'Tim Implementasi',
                ],
                [
                    'item_name' => 'Cloud Migration',
                    'category' => 'Infrastructure',
                    'description' => 'Migrasi data ke cloud infrastructure',
                    'progress_actual' => 45,
                    'progress_target' => 100,
                    'status' => 'in_progress',
                    'start_date' => now()->subMonths(1),
                    'target_date' => now()->addMonths(4),
                    'assigned_to' => 'Team Cloud',
                ],
                [
                    'item_name' => 'Process Automation',
                    'category' => 'Process',
                    'description' => 'Otomasi proses bisnis dengan RPA',
                    'progress_actual' => 25,
                    'progress_target' => 100,
                    'status' => 'pending',
                    'start_date' => now(),
                    'target_date' => now()->addMonths(6),
                    'assigned_to' => 'RPA Team',
                ],
                [
                    'item_name' => 'Hardware Upgrade',
                    'category' => 'Hardware',
                    'description' => 'Upgrade server dan workstation',
                    'progress_actual' => 100,
                    'progress_target' => 100,
                    'status' => 'completed',
                    'start_date' => now()->subMonths(6),
                    'target_date' => now()->subMonths(1),
                    'completion_date' => now()->subMonths(1),
                    'assigned_to' => 'IT Procurement',
                ],
                [
                    'item_name' => 'Cybersecurity Implementation',
                    'category' => 'Security',
                    'description' => 'Implementasi sistem keamanan cyber',
                    'progress_actual' => 60,
                    'progress_target' => 100,
                    'status' => 'in_progress',
                    'start_date' => now()->subMonths(2),
                    'target_date' => now()->addMonths(3),
                    'assigned_to' => 'Security Team',
                ],
            ];

            foreach ($items as $itemData) {
                DigitalizationItem::create(array_merge($itemData, ['entity_id' => $entity->id]));
            }
        }
    }

    private function getRandomStatus()
    {
        $statuses = ['pending', 'in_progress', 'completed', 'delayed'];
        return $statuses[array_rand($statuses)];
    }
}
