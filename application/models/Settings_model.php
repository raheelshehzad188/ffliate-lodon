<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all settings
    public function get_all() {
        // Check if table exists
        if (!$this->db->table_exists('settings')) {
            return [];
        }
        
        $settings = $this->db->get('settings')->result();
        $result = [];
        if ($settings) {
            foreach ($settings as $setting) {
                $result[$setting->setting_key] = $setting->setting_value;
            }
        }
        return $result;
    }

    // Get setting by key
    public function get($key, $default = '') {
        // Check if table exists
        if (!$this->db->table_exists('settings')) {
            return $default;
        }
        
        $setting = $this->db->where('setting_key', $key)->get('settings')->row();
        return $setting ? $setting->setting_value : $default;
    }

    // Set/Update setting
    public function set($key, $value) {
        // Check if table exists
        if (!$this->db->table_exists('settings')) {
            return false;
        }
        
        $exists = $this->db->where('setting_key', $key)->get('settings')->row();
        
        if ($exists) {
            return $this->db->where('setting_key', $key)->update('settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->db->insert('settings', [
                'setting_key' => $key,
                'setting_value' => $value,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    // Update multiple settings
    public function update_batch($data) {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
        return true;
    }

    // Get settings by category
    public function get_by_category($category) {
        // Check if table exists
        if (!$this->db->table_exists('settings')) {
            return [];
        }
        
        $settings = $this->db->where('category', $category)->get('settings')->result();
        $result = [];
        if ($settings) {
            foreach ($settings as $setting) {
                $result[$setting->setting_key] = $setting->setting_value;
            }
        }
        return $result;
    }
}

