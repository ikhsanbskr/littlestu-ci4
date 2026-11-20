<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LookbookSlideModel;
use App\Models\ProductModel;

class LookbookController extends BaseController
{
    public function index(): string
    {
        $lookbookModel = new LookbookSlideModel();
        $productModel  = new ProductModel();

        return view('admin/lookbook', [
            'pageTitle'  => 'Lookbook & Hotspot Editor',
            'activeNav'  => 'lookbook',
            'slides'     => $lookbookModel->orderBy('sort_order', 'ASC')->findAll(),
            'products'   => $productModel->orderBy('name', 'ASC')->findAll(),
            'mediaFiles' => \App\Libraries\MediaLibrary::listImages(),
        ]);
    }

    public function store()
    {
        $lookbookModel = new LookbookSlideModel();
        $img = $this->handleUpload('image_upload') ?? trim((string) $this->request->getPost('image'));

        $hotspotsJson = (string) $this->request->getPost('hotspots_json');
        json_decode($hotspotsJson);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $hotspotsJson = '[]';
        }

        $lookbookModel->insert([
            'pill_label'  => trim((string) $this->request->getPost('pill_label')) ?: 'Look Baru',
            'title'       => trim((string) $this->request->getPost('title')) ?: 'Inspirasi Padu Padan',
            'description' => trim((string) $this->request->getPost('description')),
            'image'       => $img ?: 'images/zula.jpeg',
            'hotspots'    => $hotspotsJson,
            'sort_order'  => (int) $this->request->getPost('sort_order'),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/lookbook')->with('success', 'Slide Lookbook baru berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $lookbookModel = new LookbookSlideModel();
        $existing      = $lookbookModel->find($id);
        if (! $existing) {
            return redirect()->to('/admin/lookbook')->with('error', 'Slide tidak ditemukan.');
        }

        $img = $this->handleUpload('image_upload') ?? trim((string) $this->request->getPost('image'));
        if ($img === '') {
            $img = $existing['image'];
        }

        $hotspotsJson = (string) $this->request->getPost('hotspots_json');
        json_decode($hotspotsJson);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $hotspotsJson = $existing['hotspots'];
        }

        $lookbookModel->update($id, [
            'pill_label'  => trim((string) $this->request->getPost('pill_label')),
            'title'       => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'image'       => $img,
            'hotspots'    => $hotspotsJson,
            'sort_order'  => (int) $this->request->getPost('sort_order'),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/lookbook')->with('success', 'Slide Lookbook berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        (new LookbookSlideModel())->delete($id);
        return redirect()->to('/admin/lookbook')->with('success', 'Slide Lookbook berhasil dihapus.');
    }

    private function handleUpload(string $fieldName): ?string
    {
        $file = $this->request->getFile($fieldName);
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }
        $ext = strtolower($file->getExtension());
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            return null;
        }
        $uploadDir = FCPATH . 'uploads/lookbook';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $newName = $file->getRandomName();
        $file->move($uploadDir, $newName);
        return 'uploads/lookbook/' . $newName;
    }
}
