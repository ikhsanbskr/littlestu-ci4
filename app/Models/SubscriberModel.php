<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriberModel extends Model
{
    protected $table         = 'newsletter_subscribers';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['email', 'created_at'];
}
