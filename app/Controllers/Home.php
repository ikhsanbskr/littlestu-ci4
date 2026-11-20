<?php

namespace App\Controllers;

use App\Models\FaqModel;
use App\Models\LookbookSlideModel;
use App\Models\ProductModel;
use App\Models\ReviewModel;
use App\Models\SiteSettingModel;
use App\Models\SizeGuideModel;

class Home extends BaseController
{
    public function index(): string
    {
        $settingsModel = new SiteSettingModel();
        $productModel  = new ProductModel();
        $lookbookModel = new LookbookSlideModel();
        $reviewModel   = new ReviewModel();
        $faqModel      = new FaqModel();
        $sizeModel     = new SizeGuideModel();

        $products = $productModel->getActiveProducts();
        $productMap = [];
        foreach ($products as $p) {
            $productMap[$p['slug']] = $p;
        }

        $settings = $settingsModel->getAllAssoc();
        $heroFloatSlug = $settings['hero_float_slug'] ?? 'alicia-set';
        $heroFloatProduct = $productMap[$heroFloatSlug] ?? ($products[0] ?? null);

        $slides = $lookbookModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
        $reviews = $reviewModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
        $faqs = $faqModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
        $sizeGuides = $sizeModel->orderBy('sort_order', 'ASC')->findAll();

        return view('storefront', [
            'settings'         => $settings,
            'products'         => $products,
            'productMap'       => $productMap,
            'heroFloatProduct' => $heroFloatProduct,
            'slides'           => $slides,
            'reviews'          => $reviews,
            'faqs'             => $faqs,
            'sizeGuides'       => $sizeGuides,
        ]);
    }
}
