<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqModel;
use App\Models\ReviewModel;
use App\Models\SizeGuideModel;

class ContentController extends BaseController
{
    public function index(): string
    {
        $reviewModel = new ReviewModel();
        $faqModel    = new FaqModel();
        $sizeModel   = new SizeGuideModel();

        return view('admin/content', [
            'pageTitle'  => 'Ulasan, FAQ & Panduan Ukuran',
            'activeNav'  => 'content',
            'reviews'    => $reviewModel->orderBy('sort_order', 'ASC')->findAll(),
            'faqs'       => $faqModel->orderBy('sort_order', 'ASC')->findAll(),
            'sizeGuides' => $sizeModel->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function storeReview()
    {
        (new ReviewModel())->insert([
            'author_name' => trim((string) $this->request->getPost('author_name')),
            'city'        => trim((string) $this->request->getPost('city')),
            'product_tag' => trim((string) $this->request->getPost('product_tag')),
            'rating'      => max(1, min(5, (int) $this->request->getPost('rating'))),
            'quote'       => trim((string) $this->request->getPost('quote')),
            'sort_order'  => (int) $this->request->getPost('sort_order'),
            'is_active'   => 1,
        ]);

        return redirect()->to('/admin/content')->with('success', 'Ulasan pelanggan berhasil ditambahkan.');
    }

    public function deleteReview(int $id)
    {
        (new ReviewModel())->delete($id);
        return redirect()->to('/admin/content')->with('success', 'Ulasan berhasil dihapus.');
    }

    public function storeFaq()
    {
        (new FaqModel())->insert([
            'question'   => trim((string) $this->request->getPost('question')),
            'answer'     => trim((string) $this->request->getPost('answer')),
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'is_active'  => 1,
        ]);

        return redirect()->to('/admin/content')->with('success', 'Pertanyaan FAQ berhasil ditambahkan.');
    }

    public function deleteFaq(int $id)
    {
        (new FaqModel())->delete($id);
        return redirect()->to('/admin/content')->with('success', 'FAQ berhasil dihapus.');
    }

    public function updateSizes()
    {
        $sizeModel = new SizeGuideModel();
        $ids       = (array) $this->request->getPost('id');
        $ages      = (array) $this->request->getPost('age_range');
        $heights   = (array) $this->request->getPost('height_range');
        $weights   = (array) $this->request->getPost('weight_range');

        foreach ($ids as $i => $id) {
            $sizeModel->update((int) $id, [
                'age_range'    => trim((string) ($ages[$i] ?? '')),
                'height_range' => trim((string) ($heights[$i] ?? '')),
                'weight_range' => trim((string) ($weights[$i] ?? '')),
            ]);
        }

        return redirect()->to('/admin/content')->with('success', 'Tabel panduan ukuran berhasil diperbarui.');
    }
}
