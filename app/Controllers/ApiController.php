<?php

namespace App\Controllers;

use App\Models\AnalyticsEventModel;
use App\Models\ProductModel;
use App\Models\SubscriberModel;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    public function track(): ResponseInterface
    {
        $json = $this->request->getJSON(true) ?? $this->request->getPost();
        $eventType = trim((string) ($json['event_type'] ?? ''));
        $slug      = trim((string) ($json['slug'] ?? ''));
        $meta      = substr(trim((string) ($json['meta'] ?? '')), 0, 120);

        $allowed = ['product_view', 'click_shopee', 'click_tiktok', 'click_wa', 'size_calc', 'search'];
        if (! in_array($eventType, $allowed, true)) {
            return $this->response->setStatusCode(400)->setJSON(['ok' => false, 'message' => 'Event tidak valid']);
        }

        $productId = null;
        if ($slug !== '') {
            $productModel = new ProductModel();
            $product = $productModel->where('slug', $slug)->first();
            if ($product) {
                $productId = (int) $product['id'];
                $fieldMap = [
                    'product_view' => 'views_count',
                    'click_shopee' => 'clicks_shopee',
                    'click_tiktok' => 'clicks_tiktok',
                    'click_wa'     => 'clicks_wa',
                ];
                if (isset($fieldMap[$eventType])) {
                    $col = $fieldMap[$eventType];
                    $productModel->set($col, "$col + 1", false)->where('id', $productId)->update();
                }
            }
        }

        $eventModel = new AnalyticsEventModel();
        $eventModel->insert([
            'event_type' => $eventType,
            'product_id' => $productId,
            'meta'       => $meta !== '' ? $meta : null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['ok' => true]);
    }

    public function newsletter(): ResponseInterface
    {
        $json  = $this->request->getJSON(true) ?? $this->request->getPost();
        $email = strtolower(trim((string) ($json['email'] ?? '')));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setStatusCode(422)->setJSON([
                'ok'      => false,
                'message' => 'Format alamat email belum sesuai. Contoh: nama@email.com',
            ]);
        }

        $subModel = new SubscriberModel();
        $exists   = $subModel->where('email', $email)->first();

        if ($exists) {
            return $this->response->setJSON([
                'ok'      => true,
                'message' => 'Email kamu sudah terdaftar di keluarga LITTLESTU. Terima kasih!',
            ]);
        }

        $subModel->insert([
            'email'      => $email,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'ok'      => true,
            'message' => 'Terima kasih! Email kamu berhasil didaftarkan untuk kabar koleksi terbaru.',
        ]);
    }
}
