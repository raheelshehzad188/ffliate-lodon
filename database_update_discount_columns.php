<?php
/**
 * Add Discount Columns to Affiliates Table
 * Run this file once to add discount_min and discount_max columns
 * Access: http://localhost/affliate/database_update_discount_columns.php
 */

// Database configuration - Update these if needed
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // XAMPP default is empty
$db_name = 'affiliate_db'; // Change if your database name is different

echo "<h2>🔄 Adding Discount Columns to Affiliates Table</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .success { color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0; }
    .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0; }
    .info { color: #0c5460; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 5px; margin: 10px 0; }
    a { color: #007bff; text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>";

// Connect to MySQL
$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("<div class='error'>❌ Connection failed: " . $conn->connect_error . "</div>");
}

echo "<div class='info'>✅ Connected to database: <strong>$db_name</strong></div>";

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'affiliates'");
if ($result->num_rows == 0) {
    echo "<div class='error'>❌ Error: 'affiliates' table does not exist!</div>";
    $conn->close();
    exit;
}

echo "<div class='info'>✅ 'affiliates' table found.</div>";

// Check if columns already exist
$columns = [];
$result = $conn->query("SHOW COLUMNS FROM `affiliates`");
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$has_discount_min = in_array('discount_min', $columns);
$has_discount_max = in_array('discount_max', $columns);

if ($has_discount_min && $has_discount_max) {
    echo "<div class='success'>✅ Columns 'discount_min' and 'discount_max' already exist in 'affiliates' table.</div>";
    echo "<p>No changes needed. You can close this page.</p>";
    $conn->close();
    exit;
}

// Add columns
$errors = [];
$success = [];

// Add discount_min column
if (!$has_discount_min) {
    $sql = "ALTER TABLE `affiliates` 
            ADD COLUMN `discount_min` decimal(5,2) DEFAULT NULL 
            COMMENT 'Minimum discount % for this affiliate (NULL = use global setting)'";
    
    if ($conn->query($sql)) {
        $success[] = "discount_min";
        echo "<div class='success'>✅ Added column 'discount_min' successfully.</div>";
    } else {
        $errors[] = "discount_min: " . $conn->error;
        echo "<div class='error'>❌ Error adding 'discount_min': " . $conn->error . "</div>";
    }
} else {
    echo "<div class='info'>ℹ️ Column 'discount_min' already exists.</div>";
}

// Add discount_max column
if (!$has_discount_max) {
    $sql = "ALTER TABLE `affiliates` 
            ADD COLUMN `discount_max` decimal(5,2) DEFAULT NULL 
            COMMENT 'Maximum discount % for this affiliate (NULL = use global setting)'";
    
    if ($conn->query($sql)) {
        $success[] = "discount_max";
        echo "<div class='success'>✅ Added column 'discount_max' successfully.</div>";
    } else {
        $errors[] = "discount_max: " . $conn->error;
        echo "<div class='error'>❌ Error adding 'discount_max': " . $conn->error . "</div>";
    }
} else {
    echo "<div class='info'>ℹ️ Column 'discount_max' already exists.</div>";
}

// Summary
echo "<hr>";
if (count($success) > 0) {
    echo "<div class='success'><strong>✅ Successfully added columns:</strong> " . implode(', ', $success) . "</div>";
}

if (count($errors) > 0) {
    echo "<div class='error'><strong>❌ Errors:</strong><br>" . implode('<br>', $errors) . "</div>";
} else if (count($success) > 0) {
    echo "<div class='success'><strong>🎉 Migration completed successfully!</strong></div>";
    echo "<p>You can now use the discount limit feature in the admin panel.</p>";
    echo "<p><a href='admin/affiliates'>Go to Affiliates</a></p>";
}

$conn->close();

