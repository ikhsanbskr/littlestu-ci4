<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteSettingModel extends Model
{
    protected $table         = 'site_settings';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['setting_key', 'setting_value', 'updated_at'];

    public function getAllAssoc(): array
    {
        $rows = $this->findAll();
        $map  = [];
        foreach ($rows as $row) {
            $map[$row['setting_key']] = $row['setting_value'];
        }
        return $map;
    }

    public function setMany(array $data): void
    {
        $now = date('Y-m-d H:i:s');
        foreach ($data as $key => $value) {
            $existing = $this->where('setting_key', $key)->first();
            if ($existing) {
                $this->update($existing['id'], [
                    'setting_value' => $value,
                    'updated_at'    => $now,
                ]);
            } else {
                $this->insert([
                    'setting_key'   => $key,
                    'setting_value' => $value,
                    'updated_at'    => $now,
                ]);
            }
        }
    }
}
