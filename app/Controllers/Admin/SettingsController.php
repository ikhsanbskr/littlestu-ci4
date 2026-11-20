<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\SiteSettingModel;

class SettingsController extends BaseController
{
    public function index(): string
    {
        $settingsModel = new SiteSettingModel();
        $productModel  = new ProductModel();

        return view('admin/settings', [
            'pageTitle'  => 'Pengaturan Toko',
            'activeNav'  => 'settings',
            'settings'   => $settingsModel->getAllAssoc(),
            'products'   => $productModel->orderBy('name', 'ASC')->findAll(),
            'mediaFiles' => \App\Libraries\MediaLibrary::listImages(),
        ]);
    }

    public function save()
    {
        $settingsModel = new SiteSettingModel();

        $keys = [
            'topbar_text', 'hero_badge', 'hero_note', 'hero_title', 'hero_subtitle',
            'hero_image', 'hero_float_slug', 'promo_kicker', 'promo_title', 'promo_desc',
            'about_title', 'about_quote', 'about_desc',
            'whatsapp_number', 'shopee_url', 'tiktok_url', 'instagram_url',
        ];

        $payload = [];
        foreach ($keys as $k) {
            $val = $this->request->getPost($k);
            if ($val !== null) {
                $payload[$k] = trim((string) $val);
            }
        }

        $heroUpload = $this->request->getFile('hero_upload');
        if ($heroUpload && $heroUpload->isValid() && ! $heroUpload->hasMoved()) {
            $ext = strtolower($heroUpload->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $dir = FCPATH . 'uploads/site';
                if (! is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                $newName = $heroUpload->getRandomName();
                $heroUpload->move($dir, $newName);
                $payload['hero_image'] = 'uploads/site/' . $newName;
            }
        }

        $settingsModel->setMany($payload);

        return redirect()->to('/admin/settings')->with('success', 'Pengaturan toko berhasil disimpan.');
    }
}
