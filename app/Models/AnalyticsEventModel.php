<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalyticsEventModel extends Model
{
    protected $table         = 'analytics_events';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['event_type', 'product_id', 'meta', 'created_at'];
}
