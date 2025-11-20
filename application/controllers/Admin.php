<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Admin_model', 'Affiliate_model', 'Lead_model', 'Commission_model', 'Click_model', 'Settings_model']);
        
        // Don't check authentication for login and logout methods
        $current_method = $this->uri->segment(2);
        $allowed_methods = array('login', 'logout');
        
        if (!in_array($current_method, $allowed_methods)) {
            if (!$this->session->userdata('admin_id')) {
                redirect('admin/login');
            }
        }
    }

    // Dashboard
    public function dashboard() {
        $from_date = $this->input->get('from') ?: date('Y-m-01');
        $to_date = $this->input->get('to') ?: date('Y-m-t');
        
        $data = [
            'total_affiliates' => count($this->Affiliate_model->get_all(['status' => 'active'])),
            'pending_affiliates' => count($this->Affiliate_model->get_all(['status' => 'pending'])),
            'total_clicks' => $this->Click_model->count(null, $from_date, $to_date),
            'total_leads' => $this->Lead_model->count([], $from_date, $to_date),
            'confirmed_leads' => $this->Lead_model->count(['status' => 'confirmed'], $from_date, $to_date),
            'from_date' => $from_date,
            'to_date' => $to_date
        ];
        
        $this->load->view('admin/dashboard', $data);
    }

    // Affiliates List
    public function affiliates() {
        // Get filters and clean empty values
        $filters = [];
        
        $status = $this->input->get('status');
        if (!empty($status)) {
            $filters['status'] = $status;
        }
        
        $search = $this->input->get('search');
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        
        $from_date = $this->input->get('from_date');
        if (!empty($from_date)) {
            $filters['from_date'] = $from_date;
        }
        
        $to_date = $this->input->get('to_date');
        if (!empty($to_date)) {
            $filters['to_date'] = $to_date;
        }
        
        $affiliates = $this->Affiliate_model->get_all($filters);
        
        // Prepare filters for view (with all keys for form)
        $view_filters = [
            'status' => $status ?: '',
            'search' => $search ?: '',
            'from_date' => $from_date ?: date('Y-m-01'),
            'to_date' => $to_date ?: date('Y-m-t')
        ];
        
        $data = [
            'affiliates' => $affiliates,
            'filters' => $view_filters
        ];
        
        $this->load->view('admin/affiliates', $data);
    }

    // Approve/Reject Affiliate
    public function approve_affiliate($id) {
        $status = $this->input->post('status');
        if ($status && in_array($status, ['active', 'inactive', 'pending'])) {
            $this->Affiliate_model->update($id, ['status' => $status]);
            $this->session->set_flashdata('success', 'Affiliate status updated');
        }
        redirect('admin/affiliates');
    }

    // View Affiliate Detail
    public function affiliate_detail($id) {
        $affiliate = $this->Affiliate_model->get_by_id($id);
        
        if ($this->input->post()) {
            $update_data = [
                'full_name' => $this->input->post('full_name'),
                'status' => $this->input->post('status'),
                'website' => $this->input->post('website'),
                'is_special' => $this->input->post('is_special') ? 1 : 0
            ];
            
            // Handle discount limits (can be empty to use global settings)
            $discount_min = $this->input->post('discount_min');
            $discount_max = $this->input->post('discount_max');
            
            // Only update if fields are present in form (even if empty)
            if ($discount_min !== false) {
                if ($discount_min !== '' && $discount_min !== null) {
                    $update_data['discount_min'] = floatval($discount_min);
                } else {
                    $update_data['discount_min'] = null; // Use global setting
                }
            }
            
            if ($discount_max !== false) {
                if ($discount_max !== '' && $discount_max !== null) {
                    $update_data['discount_max'] = floatval($discount_max);
                } else {
                    $update_data['discount_max'] = null; // Use global setting
                }
            }
            
            // Update slug if provided
            $new_slug = trim($this->input->post('slug'));
            if (!empty($new_slug)) {
                // Clean slug (lowercase, replace spaces with dashes, remove special chars)
                $new_slug = strtolower($new_slug);
                $new_slug = preg_replace('/[^a-z0-9-]+/', '-', $new_slug);
                $new_slug = preg_replace('/-+/', '-', $new_slug);
                $new_slug = trim($new_slug, '-');
                
                if (strlen($new_slug) >= 3) {
                    // Check if slug is unique (excluding current affiliate)
                    $existing = $this->Affiliate_model->get_by_slug($new_slug);
                    if (!$existing || $existing->id == $id) {
                        $update_data['slug'] = $new_slug;
                    } else {
                        $this->session->set_flashdata('error', 'Slug already exists. Please choose a different one.');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Slug must be at least 3 characters long.');
                }
            }
            
            // Handle profile picture upload
            if (!empty($_FILES['profile_picture']['name'])) {
                $upload_path = FCPATH . 'uploads/profile/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }
                
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('profile_picture')) {
                    $upload_data = $this->upload->data();
                    $update_data['profile_picture'] = 'uploads/profile/' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Profile picture upload failed: ' . $this->upload->display_errors());
                }
            }
            
            // Handle cover/banner image upload
            if (!empty($_FILES['cover_image']['name'])) {
                $upload_path = FCPATH . 'uploads/cover/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }
                
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 3072; // 3MB for banner
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('cover_image')) {
                    $upload_data = $this->upload->data();
                    $update_data['cover_image'] = 'uploads/cover/' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Banner image upload failed: ' . $this->upload->display_errors());
                }
            }
            
            // Update password if provided
            $new_password = $this->input->post('password');
            if (!empty($new_password)) {
                if (strlen($new_password) >= 6) {
                    // Pass plain password - model will hash it
                    $update_data['password'] = $new_password;
                } else {
                    $this->session->set_flashdata('error', 'Password must be at least 6 characters long.');
                    redirect('admin/affiliate_detail/' . $id);
                    return;
                }
            }
            
            // Remove empty string values but keep null values (for discount limits)
            $update_data = array_filter($update_data, function($value, $key) {
                // Keep null values (for discount limits to reset to global)
                if ($value === null) {
                    return true;
                }
                // Remove empty strings
                return $value !== '';
            }, ARRAY_FILTER_USE_BOTH);
            
            // Always include is_special (default 0 if not set)
            if (!isset($update_data['is_special'])) {
                $update_data['is_special'] = 0;
            }
            
            if (!empty($update_data)) {
                if ($this->Affiliate_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Affiliate updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update affiliate. Please check database connection and column exists.');
                }
            } else {
                $this->session->set_flashdata('error', 'No data to update');
            }
            
            redirect('admin/affiliate_detail/' . $id);
        }
        
        $stats = $this->Affiliate_model->get_stats($id);
        
        $data = [
            'affiliate' => $affiliate,
            'stats' => $stats
        ];
        
        $this->load->view('admin/affiliate_detail', $data);
    }

    // Leads List
    public function leads() {
        // Get filters and clean empty values
        $filters = [];
        
        $affiliate_id = $this->input->get('affiliate_id');
        if (!empty($affiliate_id)) {
            $filters['affiliate_id'] = $affiliate_id;
        }
        
        $status = $this->input->get('status');
        if (!empty($status)) {
            $filters['status'] = $status;
        }
        
        $from_date = $this->input->get('from_date');
        if (!empty($from_date)) {
            $filters['from_date'] = $from_date;
        }
        
        $to_date = $this->input->get('to_date');
        if (!empty($to_date)) {
            $filters['to_date'] = $to_date;
        }
        
        $page = $this->input->get('page') ?: 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        
        $leads = $this->Lead_model->get_all($filters, $per_page, $offset);
        $total = $this->Lead_model->count($filters);
        
        // Prepare filters for view (with all keys for form)
        $view_filters = [
            'affiliate_id' => $affiliate_id ?: '',
            'status' => $status ?: '',
            'from_date' => $from_date ?: '',
            'to_date' => $to_date ?: ''
        ];
        
        $data = [
            'leads' => $leads,
            'filters' => $view_filters,
            'pagination' => [
                'total' => $total,
                'per_page' => $per_page,
                'current_page' => $page
            ],
            'affiliates' => $this->Affiliate_model->get_all()
        ];
        
        $this->load->view('admin/leads', $data);
    }

    // Confirm Lead
    public function confirm_lead($id) {
        if ($this->input->post()) {
            $sale_amount = $this->input->post('sale_amount');
            $feedback = $this->input->post('feedback');
            
            // First confirm the lead
            if ($this->Lead_model->confirm($id, $sale_amount, $feedback)) {
                // Process commissions (will be created with 'confirmed' status)
                $this->Commission_model->process_commissions_by_lead($id, $sale_amount);
                
                // Also update any existing commissions for this lead to 'confirmed'
                $this->Commission_model->update_status_by_lead($id, 'pending');
                
                $this->session->set_flashdata('success', 'Lead confirmed and commissions processed');
            } else {
                $this->session->set_flashdata('error', 'Failed to confirm lead');
            }
        }
        redirect('admin/leads');
    }

    // Commissions List
    public function commissions() {
        $filters = [
            'affiliate_id' => $this->input->get('affiliate_id'),
            'status' => $this->input->get('status'),
            'from_date' => $this->input->get('from_date'),
            'to_date' => $this->input->get('to_date')
        ];
        
        $commissions = $this->Commission_model->get_all($filters);
        
        $data = [
            'commissions' => $commissions,
            'filters' => $filters,
            'affiliates' => $this->Affiliate_model->get_all()
        ];
        
        $this->load->view('admin/commissions', $data);
    }

    // Admin Login
    public function login() {
        if ($this->session->userdata('admin_id')) {
            redirect('admin/dashboard');
        }
        
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $admin = $this->Admin_model->verify_login($username, $password);
            
            if ($admin) {
                $this->session->set_userdata([
                    'admin_id' => $admin->id,
                    'admin_name' => $admin->full_name,
                    'admin_username' => $admin->username
                ]);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid credentials');
            }
        }
        
        $this->load->view('admin/login');
    }

    // Admin Logout
    public function logout() {
        $this->session->unset_userdata(['admin_id', 'admin_name', 'admin_username']);
        redirect('admin/login');
    }
    
    // Change Password
    public function change_password() {
        $admin_id = $this->session->userdata('admin_id');
        
        if ($this->input->post()) {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            
            $admin = $this->Admin_model->get_by_id($admin_id);
            
            if (md5($current_password) !== $admin->password) {
                $this->session->set_flashdata('error', 'Current password is incorrect');
            } elseif ($new_password !== $confirm_password) {
                $this->session->set_flashdata('error', 'New passwords do not match');
            } elseif (strlen($new_password) < 6) {
                $this->session->set_flashdata('error', 'Password must be at least 6 characters');
            } else {
                $this->Admin_model->update($admin_id, ['password' => md5($new_password)]);
                $this->session->set_flashdata('success', 'Password changed successfully!');
            }
            
            redirect('admin/change_password');
        }
        
        $this->load->view('admin/change_password');
    }

    // Settings
    public function settings() {
        $tab = $this->input->get('tab') ?: 'general';
        
        // Check if settings table exists
        $table_exists = $this->db->table_exists('settings');
        
        if ($this->input->post()) {
            if (!$table_exists) {
                $this->session->set_flashdata('error', 'Settings table does not exist. Please run the create_settings_table.php script first.');
                redirect('admin/settings?tab=' . $tab);
                return;
            }
            
            $settings_data = $this->input->post();
            
            // Remove submit button from data
            unset($settings_data['submit']);
            
            // Update settings
            if ($this->Settings_model->update_batch($settings_data)) {
                $this->session->set_flashdata('success', 'Settings updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update settings');
            }
            
            redirect('admin/settings?tab=' . $tab);
        }
        
        // Get all settings
        $settings = $this->Settings_model->get_all();
        
        $data = [
            'settings' => $settings,
            'active_tab' => $tab,
            'table_exists' => $table_exists
        ];
        
        $this->load->view('admin/settings', $data);
    }
}

