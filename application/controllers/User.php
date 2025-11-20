<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->config('firebase');
        $this->load->library('session');
    }

    /**
     * Send OTP to phone number
     * POST: /user/otp/send
     * Body: { "phone": "+923001234567" }
     */
    public function otp_send() {
        // Set JSON header
        header('Content-Type: application/json');
        
        // Only allow POST requests
        if ($this->input->method() !== 'post') {
            echo json_encode([
                'success' => false,
                'message' => 'Method not allowed. Use POST.'
            ]);
            return;
        }

        // Get phone number from request
        $phone = $this->input->post('phone');
        if (!$phone) {
            // Try JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            $phone = isset($input['phone']) ? $input['phone'] : null;
        }

        // Validate phone number
        if (empty($phone)) {
            echo json_encode([
                'success' => false,
                'message' => 'Phone number is required'
            ]);
            return;
        }

        // Format phone number (remove spaces, ensure + prefix)
        $phone = preg_replace('/\s+/', '', $phone);
        if (substr($phone, 0, 1) !== '+') {
            $phone = '+' . $phone;
        }

        // Get Firebase API key
        $api_key = $this->config->item('firebase_web_api_key');
        
        if (empty($api_key) || $api_key === 'YOUR_FIREBASE_API_KEY_HERE') {
            echo json_encode([
                'success' => false,
                'message' => 'Firebase API key not configured. Please set it in application/config/firebase.php'
            ]);
            return;
        }

        // Firebase REST API endpoint for sending OTP
        $url = 'https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode?key=' . $api_key;

        // Prepare request data
        $data = [
            'phoneNumber' => $phone,
            'requestType' => 'PHONE_SIGNIN'
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        // Execute request
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // Handle cURL errors
        if ($curl_error) {
            echo json_encode([
                'success' => false,
                'message' => 'Network error: ' . $curl_error
            ]);
            return;
        }

        // Decode response
        $result = json_decode($response, true);

        // Check response
        if ($http_code === 200 && isset($result['sessionInfo'])) {
            // Store session info in session for verification
            $this->session->set_userdata('otp_session_info', $result['sessionInfo']);
            $this->session->set_userdata('otp_phone', $phone);
            
            echo json_encode([
                'success' => true,
                'message' => 'OTP sent successfully',
                'sessionInfo' => $result['sessionInfo']
            ]);
        } else {
            // Handle Firebase errors
            $error_message = 'Failed to send OTP';
            $help_message = '';
            
            if (isset($result['error']['message'])) {
                $error_message = $result['error']['message'];
                
                // Provide specific help for common errors
                if (strpos($error_message, 'unregistered callers') !== false || 
                    strpos($error_message, 'API key') !== false ||
                    $http_code === 403) {
                    $help_message = 'Please enable Identity Toolkit API in Google Cloud Console and configure API key restrictions. See FIREBASE_SETUP.md for details.';
                } elseif (strpos($error_message, 'INVALID_PHONE_NUMBER') !== false) {
                    $help_message = 'Please check the phone number format. It should include country code (e.g., +923001234567)';
                } elseif (strpos($error_message, 'PHONE_AUTH_DISABLED') !== false) {
                    $help_message = 'Phone authentication is not enabled in Firebase Console. Enable it in Authentication > Sign-in method.';
                }
            } elseif (isset($result['error'])) {
                $error_message = is_string($result['error']) ? $result['error'] : json_encode($result['error']);
            }
            
            echo json_encode([
                'success' => false,
                'message' => $error_message,
                'help' => $help_message,
                'error_code' => $http_code,
                'error_details' => $result
            ]);
        }
    }

    /**
     * Verify OTP code
     * POST: /user/otp/verify
     * Body: { "code": "123456" }
     */
    public function otp_verify() {
        // Set JSON header
        header('Content-Type: application/json');
        
        // Only allow POST requests
        if ($this->input->method() !== 'post') {
            echo json_encode([
                'success' => false,
                'message' => 'Method not allowed. Use POST.'
            ]);
            return;
        }

        // Get OTP code from request
        $code = $this->input->post('code');
        if (!$code) {
            // Try JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            $code = isset($input['code']) ? $input['code'] : null;
        }

        // Validate code
        if (empty($code)) {
            echo json_encode([
                'success' => false,
                'message' => 'OTP code is required'
            ]);
            return;
        }

        // Get session info from session
        $session_info = $this->session->userdata('otp_session_info');
        if (empty($session_info)) {
            echo json_encode([
                'success' => false,
                'message' => 'Session expired. Please request a new OTP.'
            ]);
            return;
        }

        // Get Firebase API key
        $api_key = $this->config->item('firebase_web_api_key');
        
        if (empty($api_key) || $api_key === 'YOUR_FIREBASE_API_KEY_HERE') {
            echo json_encode([
                'success' => false,
                'message' => 'Firebase API key not configured'
            ]);
            return;
        }

        // Firebase REST API endpoint for verifying OTP
        $url = 'https://identitytoolkit.googleapis.com/v1/accounts:signInWithPhoneNumber?key=' . $api_key;

        // Prepare request data
        $data = [
            'sessionInfo' => $session_info,
            'code' => $code
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        // Execute request
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // Handle cURL errors
        if ($curl_error) {
            echo json_encode([
                'success' => false,
                'message' => 'Network error: ' . $curl_error
            ]);
            return;
        }

        // Decode response
        $result = json_decode($response, true);

        // Check response
        if ($http_code === 200 && isset($result['idToken'])) {
            // Clear session info
            $this->session->unset_userdata('otp_session_info');
            $phone = $this->session->userdata('otp_phone');
            
            echo json_encode([
                'success' => true,
                'message' => 'OTP verified successfully',
                'idToken' => $result['idToken'],
                'phone' => $phone
            ]);
        } else {
            // Handle Firebase errors
            $error_message = 'Invalid OTP code';
            if (isset($result['error']['message'])) {
                $error_message = $result['error']['message'];
            }
            
            echo json_encode([
                'success' => false,
                'message' => $error_message,
                'error_code' => $http_code,
                'error_details' => $result
            ]);
        }
    }
}

