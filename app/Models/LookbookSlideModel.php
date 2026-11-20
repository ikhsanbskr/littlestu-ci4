<?php

namespace App\Models;

use CodeIgniter\Model;

class LookbookSlideModel extends Model
{
    protected $table         = 'lookbook_slides';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['pill_label', 'title', 'description', 'image', 'hotspots', 'sort_order', 'is_active'];
}
