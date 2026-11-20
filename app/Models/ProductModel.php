<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'slug', 'name', 'category', 'category_label', 'badge', 'badge_style',
        'price_label', 'price_min', 'sizes_available', 'size_note', 'description',
        'primary_image', 'secondary_image', 'gallery_images', 'colors', 'pair_slugs',
        'shopee_url', 'tiktok_url', 'is_active', 'sort_order',
        'views_count', 'clicks_shopee', 'clicks_tiktok', 'clicks_wa',
    ];

    public function getActiveProducts(): array
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}
