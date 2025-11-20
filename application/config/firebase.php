<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Firebase Configuration
|--------------------------------------------------------------------------
|
| Firebase API credentials for Phone Authentication (OTP)
|
*/

// Detect server environment
$server_ip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'localhost';
$is_localhost = ($server_ip === '127.0.0.1' || $server_ip === '::1' || $server_ip === 'localhost');
$is_local_network = (strpos($server_ip, '192.168.') === 0);

if ($is_localhost || $is_local_network) {
	// Local/Development Firebase Config
	$config['firebase_api_key'] = 'AIzaSyDNKU12gUR1Bs5U69NbQPpjDRcXyGquVaM';
	$config['firebase_auth_domain'] = 'apnacrowdfun.firebaseapp.com';
	$config['firebase_project_id'] = 'apnacrowdfun';
	$config['firebase_storage_bucket'] = 'apnacrowdfun.appspot.com';
	$config['firebase_messaging_sender_id'] = '51698495382';
	$config['firebase_app_id'] = '1:51698495382:web:04de6ac85e94c10d9f7b7';
} else {
	// Production Firebase Config
	$config['firebase_api_key'] = 'AIzaSyDNKU12gUR1Bs5U69NbQPpjDRcXyGquVaM';
	$config['firebase_auth_domain'] = 'apnacrowdfun.firebaseapp.com';
	$config['firebase_project_id'] = 'apnacrowdfun';
	$config['firebase_storage_bucket'] = 'apnacrowdfun.appspot.com';
	$config['firebase_messaging_sender_id'] = '51698495382';
	$config['firebase_app_id'] = '1:51698495382:web:04de6ac85e94c10d9f7b7';
}

// Firebase Web API Key (for REST API calls)
$config['firebase_web_api_key'] = $config['firebase_api_key'];

// Firebase REST API Endpoint
$config['firebase_rest_api_url'] = 'https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode?key=' . $config['firebase_web_api_key'];

