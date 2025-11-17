<?php
/**
 * Create Upload Folders with Proper Permissions
 * Run this file once to create upload directories
 * Access: http://localhost/affliate/create_upload_folders.php
 */

echo "<h2>📁 Creating Upload Folders</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0; }
    .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; margin: 10px 0; }
</style>";

$base_dir = __DIR__;
$folders = [
    'uploads',
    'uploads/profile',
    'uploads/cover'
];

$success_count = 0;
$error_count = 0;

foreach ($folders as $folder) {
    $full_path = $base_dir . '/' . $folder;
    
    if (is_dir($full_path)) {
        echo "<div class='info'>ℹ️ Folder already exists: <strong>$folder</strong></div>";
        
        // Check and fix permissions
        if (is_writable($full_path)) {
            echo "<div class='success'>✅ Folder is writable: <strong>$folder</strong></div>";
        } else {
            if (chmod($full_path, 0755)) {
                echo "<div class='success'>✅ Fixed permissions for: <strong>$folder</strong></div>";
                $success_count++;
            } else {
                echo "<div class='error'>❌ Could not fix permissions for: <strong>$folder</strong></div>";
                $error_count++;
            }
        }
    } else {
        // Create directory with proper permissions
        if (mkdir($full_path, 0755, true)) {
            echo "<div class='success'>✅ Created folder: <strong>$folder</strong></div>";
            $success_count++;
        } else {
            echo "<div class='error'>❌ Failed to create folder: <strong>$folder</strong></div>";
            $error_count++;
        }
    }
}

// Create .htaccess file to protect uploads
$htaccess_path = $base_dir . '/uploads/.htaccess';
if (!file_exists($htaccess_path)) {
    $htaccess_content = "Options -Indexes\n";
    $htaccess_content .= "<FilesMatch \"\\.(php|php3|php4|php5|phtml|pl|py|jsp|asp|sh|cgi)$\">\n";
    $htaccess_content .= "    Order Allow,Deny\n";
    $htaccess_content .= "    Deny from all\n";
    $htaccess_content .= "</FilesMatch>\n";
    
    if (file_put_contents($htaccess_path, $htaccess_content)) {
        echo "<div class='success'>✅ Created .htaccess file for security</div>";
        $success_count++;
    } else {
        echo "<div class='error'>❌ Could not create .htaccess file</div>";
        $error_count++;
    }
} else {
    echo "<div class='info'>ℹ️ .htaccess file already exists</div>";
}

echo "<hr>";
if ($error_count == 0) {
    echo "<div class='success'><strong>🎉 All folders created successfully!</strong></div>";
    echo "<p>You can now upload images from the admin panel.</p>";
} else {
    echo "<div class='error'><strong>⚠️ Some errors occurred. Please check folder permissions manually.</strong></div>";
    echo "<p><strong>Manual Fix:</strong> Run these commands in terminal:</p>";
    echo "<pre style='background: #f0f0f0; padding: 10px; border-radius: 5px;'>";
    echo "cd " . $base_dir . "\n";
    echo "mkdir -p uploads/profile uploads/cover\n";
    echo "chmod -R 755 uploads\n";
    echo "</pre>";
}

