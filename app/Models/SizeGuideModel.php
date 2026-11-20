<?php

namespace App\Models;

use CodeIgniter\Model;

class SizeGuideModel extends Model
{
    protected $table         = 'size_guides';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['size_code', 'age_range', 'height_range', 'weight_range', 'max_height', 'max_weight', 'max_age', 'sort_order'];
}
