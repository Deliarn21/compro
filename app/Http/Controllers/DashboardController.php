<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\DigitalizationItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard overview with aggregated progress
     */
    public function index(Request $request)
    {
        $entityFilter = $request->query('entity');
        $statusFilter = $request->query('status');
        $categoryFilter = $request->query('category');

        // Get entities with average progress
        $entities = Entity::withAvg('digitalizationItems', 'progress_actual')
            ->withCount('digitalizationItems')
            ->get()
            ->map(function ($entity) {
                return [
                    'id' => $entity->id,
                    'name' => $entity->name,
                    'code' => $entity->code,
                    'type' => $entity->type,
                    'average_progress' => round($entity->digitalization_items_avg_progress_actual ?? 0, 2),
                    'total_items' => $entity->digitalization_items_count,
                    'completed_items' => $entity->digitalizationItems()->completed()->count(),
                ];
            });

        // Build query for items
        $query = DigitalizationItem::with('entity');

        if ($entityFilter) {
            $query->where('entity_id', $entityFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($categoryFilter) {
            $query->where('category', $categoryFilter);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $totalProgress = DigitalizationItem::avg('progress_actual') ?? 0;
        $totalItems = DigitalizationItem::count();
        $completedItems = DigitalizationItem::completed()->count();
        $inProgressItems = DigitalizationItem::where('status', 'in_progress')->count();
        $delayedItems = DigitalizationItem::where('status', 'delayed')->count();

        // Get categories for filter
        $categories = DigitalizationItem::distinct('category')->pluck('category');

        return view('monitoring.dashboard', [
            'entities' => $entities,
            'items' => $items,
            'statistics' => [
                'total_progress' => round($totalProgress, 2),
                'total_items' => $totalItems,
                'completed_items' => $completedItems,
                'in_progress_items' => $inProgressItems,
                'delayed_items' => $delayedItems,
            ],
            'filters' => [
                'entity' => $entityFilter,
                'status' => $statusFilter,
                'category' => $categoryFilter,
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Show analytics dashboard
     */
    public function analytics(Request $request)
    {
        $entities = Entity::withAvg('digitalizationItems', 'progress_actual')
            ->get()
            ->map(function ($entity) {
                return [
                    'id' => $entity->id,
                    'name' => $entity->name,
                    'average_progress' => round($entity->digitalization_items_avg_progress_actual ?? 0, 2),
                ];
            });

        $categoriesAnalytics = DigitalizationItem::selectRaw('category, AVG(progress_actual) as average_progress, COUNT(*) as total_count')
            ->groupBy('category')
            ->get();

        $statusAnalytics = DigitalizationItem::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return InertiaResponse::render('Dashboard/Analytics', [
            'entities' => $entities,
            'categories' => $categoriesAnalytics,
            'statuses' => $statusAnalytics,
        ]);
    }
}

