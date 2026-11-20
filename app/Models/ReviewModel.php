<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table         = 'reviews';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['author_name', 'city', 'product_tag', 'rating', 'quote', 'sort_order', 'is_active'];
}
