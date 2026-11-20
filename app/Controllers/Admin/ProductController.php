<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index(): string
    {
        $productModel = new ProductModel();
        $q      = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));

        if ($q !== '') {
            $productModel->groupStart()
                ->like('name', $q)
                ->orLike('category', $q)
                ->orLike('category_label', $q)
                ->groupEnd();
        }
        if ($status === 'active') {
            $productModel->where('is_active', 1);
        } elseif ($status === 'hidden') {
            $productModel->where('is_active', 0);
        }

        $products = $productModel->orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->findAll();

        return view('admin/products/index', [
            'pageTitle' => 'Manajemen Produk',
            'activeNav' => 'products',
            'products'  => $products,
            'searchQ'   => $q,
            'statusF'   => $status,
        ]);
    }

    public function create(): string
    {
        $productModel = new ProductModel();
        return view('admin/products/form', [
            'pageTitle'   => 'Tambah Koleksi Baru',
            'activeNav'   => 'products',
            'product'     => null,
            'allProducts' => $productModel->orderBy('name', 'ASC')->findAll(),
            'mediaFiles'  => \App\Libraries\MediaLibrary::listImages(),
        ]);
    }

    public function edit(int $id)
    {
        $productModel = new ProductModel();
        $product      = $productModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }

        return view('admin/products/form', [
            'pageTitle'   => 'Ubah Produk: ' . $product['name'],
            'activeNav'   => 'products',
            'product'     => $product,
            'allProducts' => $productModel->where('id !=', $id)->orderBy('name', 'ASC')->findAll(),
            'mediaFiles'  => \App\Libraries\MediaLibrary::listImages(),
        ]);
    }

    public function store()
    {
        return $this->saveProduct(null);
    }

    public function update(int $id)
    {
        return $this->saveProduct($id);
    }

    private function saveProduct(?int $id)
    {
        $productModel = new ProductModel();
        $existing     = $id ? $productModel->find($id) : null;

        $name = trim((string) $this->request->getPost('name'));
        if ($name === '') {
            return redirect()->back()->withInput()->with('error', 'Nama produk wajib diisi.');
        }

        $slug = trim((string) $this->request->getPost('slug'));
        if ($slug === '') {
            $slug = url_title($name, '-', true);
        }

        // Pastikan slug unik
        $slugCheck = $productModel->where('slug', $slug);
        if ($id) {
            $slugCheck->where('id !=', $id);
        }
        if ($slugCheck->first()) {
            $slug .= '-' . substr((string) time(), -4);
        }

        // Tangani unggahan foto utama & kedua
        $primaryImg = $this->handleUpload('primary_upload')
            ?? trim((string) $this->request->getPost('primary_image'));
        if ($primaryImg === '' && $existing) {
            $primaryImg = $existing['primary_image'];
        }

        $secondaryImg = $this->handleUpload('secondary_upload')
            ?? trim((string) $this->request->getPost('secondary_image'));
        if ($secondaryImg === '' && $existing && $this->request->getPost('secondary_image') === null) {
            $secondaryImg = $existing['secondary_image'];
        }

        // Galeri foto (pilihan visual + unggahan multi-file)
        $galleryRaw = (string) $this->request->getPost('gallery_images');
        $galleryArr = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $galleryRaw))));

        $galleryFiles = $this->request->getFiles();
        if (! empty($galleryFiles['gallery_uploads'])) {
            $uploadDir = FCPATH . 'uploads/products';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            foreach ($galleryFiles['gallery_uploads'] as $gFile) {
                if ($gFile->isValid() && ! $gFile->hasMoved()) {
                    $ext = strtolower($gFile->getExtension());
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                        $newName = $gFile->getRandomName();
                        $gFile->move($uploadDir, $newName);
                        $galleryArr[] = 'uploads/products/' . $newName;
                    }
                }
            }
        }
        if ($primaryImg !== '' && ! in_array($primaryImg, $galleryArr, true)) {
            array_unshift($galleryArr, $primaryImg);
        }

        // Warna swatch
        $colorNames  = (array) $this->request->getPost('color_name');
        $colorHexes  = (array) $this->request->getPost('color_hex');
        $colorImages = (array) $this->request->getPost('color_image');
        $colors      = [];
        foreach ($colorNames as $i => $cName) {
            $cName = trim((string) $cName);
            if ($cName === '') {
                continue;
            }
            $colors[] = [
                'name'  => $cName,
                'hex'   => trim((string) ($colorHexes[$i] ?? '#8b6f52')),
                'image' => trim((string) ($colorImages[$i] ?? $primaryImg)),
            ];
        }

        // Ukuran tersedia
        $sizesArr = (array) $this->request->getPost('sizes');
        $sizesStr = ! empty($sizesArr) ? implode(',', $sizesArr) : 'S,M,L,2L,3L,4L';

        // Mix & Match pair slugs
        $pairSlugs = array_values(array_filter((array) $this->request->getPost('pair_slugs')));

        // Kategori gabungan
        $cats = array_values(array_filter((array) $this->request->getPost('categories')));
        $catStr = ! empty($cats) ? implode(' ', $cats) : 'girls tops';

        $data = [
            'slug'            => $slug,
            'name'            => $name,
            'category'        => $catStr,
            'category_label'  => trim((string) $this->request->getPost('category_label')) ?: 'Koleksi',
            'badge'           => trim((string) $this->request->getPost('badge')) ?: null,
            'badge_style'     => $this->request->getPost('badge_style') === 'sage' ? 'sage' : 'default',
            'price_label'     => trim((string) $this->request->getPost('price_label')) ?: 'Rp0',
            'price_min'       => (int) $this->request->getPost('price_min'),
            'sizes_available' => $sizesStr,
            'size_note'       => trim((string) $this->request->getPost('size_note')) ?: 'Tersedia dalam ukuran S–4L',
            'description'     => trim((string) $this->request->getPost('description')),
            'primary_image'   => $primaryImg ?: 'images/littlestu.jpeg',
            'secondary_image' => $secondaryImg ?: null,
            'gallery_images'  => json_encode($galleryArr),
            'colors'          => json_encode($colors),
            'pair_slugs'      => json_encode($pairSlugs),
            'shopee_url'      => trim((string) $this->request->getPost('shopee_url')),
            'tiktok_url'      => trim((string) $this->request->getPost('tiktok_url')),
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'      => (int) $this->request->getPost('sort_order'),
        ];

        if ($id) {
            $productModel->update($id, $data);
            return redirect()->to('/admin/products')->with('success', 'Produk "' . $name . '" berhasil diperbarui.');
        }

        $productModel->insert($data);
        return redirect()->to('/admin/products')->with('success', 'Koleksi baru "' . $name . '" berhasil ditambahkan.');
    }

    public function toggle(int $id)
    {
        $productModel = new ProductModel();
        $product      = $productModel->find($id);
        if ($product) {
            $next = (int) $product['is_active'] === 1 ? 0 : 1;
            $productModel->update($id, ['is_active' => $next]);
        }
        return redirect()->to('/admin/products')->with('success', 'Status tampilan produk berhasil diubah.');
    }

    public function delete(int $id)
    {
        $productModel = new ProductModel();
        $productModel->delete($id);
        return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus dari katalog.');
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
        $uploadDir = FCPATH . 'uploads/products';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $newName = $file->getRandomName();
        $file->move($uploadDir, $newName);
        return 'uploads/products/' . $newName;
    }
}
