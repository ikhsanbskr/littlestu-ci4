<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubscriberModel;

class SubscriberController extends BaseController
{
    public function index(): string
    {
        $subModel = new SubscriberModel();
        return view('admin/subscribers', [
            'pageTitle'   => 'Pelanggan Newsletter',
            'activeNav'   => 'subscribers',
            'subscribers' => $subModel->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function exportCsv()
    {
        $subModel = new SubscriberModel();
        $rows     = $subModel->orderBy('id', 'DESC')->findAll();

        $csv = "ID,Email,Tanggal Daftar\n";
        foreach ($rows as $row) {
            $csv .= sprintf("%d,\"%s\",\"%s\"\n", $row['id'], str_replace('"', '""', $row['email']), $row['created_at']);
        }

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="littlestu-newsletter-' . date('Ymd') . '.csv"')
            ->setBody($csv);
    }

    public function delete(int $id)
    {
        (new SubscriberModel())->delete($id);
        return redirect()->to('/admin/subscribers')->with('success', 'Email pelanggan berhasil dihapus.');
    }
}
