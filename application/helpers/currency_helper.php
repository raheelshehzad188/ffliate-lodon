<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Currency Helper
 * Format currency values with dynamic currency symbol from settings
 */

if (!function_exists('format_currency')) {
    /**
     * Format currency value with symbol from settings
     * 
     * @param float $amount The amount to format
     * @param int $decimals Number of decimal places (default: 2)
     * @return string Formatted currency string
     */
    function format_currency($amount, $decimals = 2) {
        $CI =& get_instance();
        $CI->load->model('Settings_model');
        
        // Get currency symbol from settings, default to $
        $currency_symbol = $CI->Settings_model->get('currency_symbol', '$');
        
        // Format the amount
        $formatted_amount = number_format((float)$amount, $decimals);
        
        // Return formatted currency
        return $currency_symbol . $formatted_amount;
    }
}

if (!function_exists('get_currency_symbol')) {
    /**
     * Get currency symbol from settings
     * 
     * @return string Currency symbol
     */
    function get_currency_symbol() {
        $CI =& get_instance();
        $CI->load->model('Settings_model');
        
        return $CI->Settings_model->get('currency_symbol', '$');
    }
}

if (!function_exists('get_currency_code')) {
    /**
     * Get currency code from settings (e.g., USD, GBP, EUR)
     * 
     * @return string Currency code
     */
    function get_currency_code() {
        $CI =& get_instance();
        $CI->load->model('Settings_model');
        
        return $CI->Settings_model->get('currency_code', 'USD');
    }
}

