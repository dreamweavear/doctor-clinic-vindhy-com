<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * SettingModel
 *
 * Key-value store for application settings.
 */
class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['setting_key', 'setting_value'];

    /**
     * Get a setting value by key.
     */
    public function get(string $key, $default = null)
    {
        $row = $this->where('setting_key', $key)->first();
        return $row ? $row['setting_value'] : $default;
    }

    /**
     * Set (insert or update) a setting.
     */
    public function set(string $key, $value): bool
    {
        $existing = $this->where('setting_key', $key)->first();
        if ($existing) {
            return $this->update($existing['id'], ['setting_value' => $value]);
        }
        return $this->insert(['setting_key' => $key, 'setting_value' => $value]) !== false;
    }

    /**
     * Get all settings as key => value array.
     */
    public function getAll(): array
    {
        $rows = $this->findAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['setting_key']] = $row['setting_value'];
        }
        return $result;
    }
}
