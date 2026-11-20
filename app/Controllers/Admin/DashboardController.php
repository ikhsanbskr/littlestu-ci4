<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AnalyticsEventModel;
use App\Models\LookbookSlideModel;
use App\Models\ProductModel;
use App\Models\SubscriberModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $productModel    = new ProductModel();
        $subscriberModel = new SubscriberModel();
        $lookbookModel   = new LookbookSlideModel();
        $eventModel      = new AnalyticsEventModel();

        $allProducts = $productModel->orderBy('views_count', 'DESC')->findAll();
        $activeCount = count(array_filter($allProducts, static fn ($p) => (int) $p['is_active'] === 1));

        $totalViews  = 0;
        $totalShopee = 0;
        $totalTiktok = 0;
        $totalWa     = 0;
        foreach ($allProducts as $p) {
            $totalViews  += (int) $p['views_count'];
            $totalShopee += (int) $p['clicks_shopee'];
            $totalTiktok += (int) $p['clicks_tiktok'];
            $totalWa     += (int) $p['clicks_wa'];
        }

        $topProducts = array_slice($allProducts, 0, 5);
        $totalClicks = $totalShopee + $totalTiktok + $totalWa;
        $ctr         = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 1) : 0;

        $multiPhotoCount = count(array_filter($allProducts, static fn ($p) => ! empty($p['secondary_image'])));
        $reviewCount     = (new \App\Models\ReviewModel())->where('is_active', 1)->countAllResults();
        $faqCount        = (new \App\Models\FaqModel())->where('is_active', 1)->countAllResults();

        // Distribusi ukuran dari Kalkulator Ukuran
        $db = \Config\Database::connect();
        $sizeStats = $db->table('analytics_events')
            ->select('meta, COUNT(*) as total')
            ->where('event_type', 'size_calc')
            ->where('meta IS NOT NULL', null, false)
            ->groupBy('meta')
            ->orderBy('total', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        $recentEvents = $db->table('analytics_events ae')
            ->select('ae.*, p.name as product_name')
            ->join('products p', 'p.id = ae.product_id', 'left')
            ->orderBy('ae.id', 'DESC')
            ->limit(8)
            ->get()
            ->getResultArray();

        return view('admin/dashboard', [
            'pageTitle'       => 'Ringkasan Toko',
            'activeNav'       => 'dashboard',
            'activeCount'     => $activeCount,
            'totalProducts'   => count($allProducts),
            'totalViews'      => $totalViews,
            'totalClicks'     => $totalClicks,
            'ctr'             => $ctr,
            'multiPhotoCount' => $multiPhotoCount,
            'reviewCount'     => $reviewCount,
            'faqCount'        => $faqCount,
            'totalShopee'     => $totalShopee,
            'totalTiktok'     => $totalTiktok,
            'totalWa'         => $totalWa,
            'subscriberCount' => $subscriberModel->countAllResults(),
            'lookbookCount'   => $lookbookModel->where('is_active', 1)->countAllResults(),
            'topProducts'     => $topProducts,
            'sizeStats'       => $sizeStats,
            'recentEvents'    => $recentEvents,
        ]);
    }
}
