<?php

namespace App\Libraries;

class MediaLibrary
{
    /**
     * Memindai seluruh gambar yang tersedia di public/images dan public/uploads
     * agar admin bisa memilih foto secara visual tanpa mengetik path manual.
     */
    public static function listImages(): array
    {
        $dirs = [
            'images'           => FCPATH . 'images',
            'uploads/products' => FCPATH . 'uploads/products',
            'uploads/lookbook' => FCPATH . 'uploads/lookbook',
            'uploads/site'     => FCPATH . 'uploads/site',
        ];

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $files      = [];

        foreach ($dirs as $prefix => $fullDir) {
            if (! is_dir($fullDir)) {
                continue;
            }
            $entries = scandir($fullDir) ?: [];
            foreach ($entries as $entry) {
                if ($entry === '.' || $entry === '..') {
                    continue;
                }
                $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
                if (! in_array($ext, $allowedExt, true)) {
                    continue;
                }
                $relPath = $prefix . '/' . $entry;
                $files[] = [
                    'path'  => $relPath,
                    'name'  => $entry,
                    'group' => $prefix === 'images' ? 'Galeri Bawaan' : 'Unggahan Admin',
                    'url'   => base_url($relPath),
                ];
            }
        }

        usort($files, static fn ($a, $b) => strcmp($a['name'], $b['name']));

        return $files;
    }
}
