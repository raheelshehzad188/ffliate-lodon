<?php
/**
 * Add Discount Column to Leads Table
 * Run this file once to add discount_percent column
 * Access: http://localhost/affliate/database_update_lead_discount.php
 */

// Database configuration - Update these if needed
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // XAMPP default is empty
$db_name = 'affiliate_db'; // Change if your database name is different

echo "<h2>🔄 Adding Discount Column to Leads Table</h2>";
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
$result = $conn->query("SHOW TABLES LIKE 'leads'");
if ($result->num_rows == 0) {
    echo "<div class='error'>❌ Error: 'leads' table does not exist!</div>";
    $conn->close();
    exit;
}

echo "<div class='info'>✅ 'leads' table found.</div>";

// Check if column already exists
$columns = [];
$result = $conn->query("SHOW COLUMNS FROM `leads`");
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$has_discount_percent = in_array('discount_percent', $columns);

if ($has_discount_percent) {
    echo "<div class='success'>✅ Column 'discount_percent' already exists in 'leads' table.</div>";
    echo "<p>No changes needed. You can close this page.</p>";
    $conn->close();
    exit;
}

// Add column
$sql = "ALTER TABLE `leads` 
        ADD COLUMN `discount_percent` decimal(5,2) DEFAULT NULL 
        COMMENT 'Discount percentage applied for this lead'";

if ($conn->query($sql)) {
    echo "<div class='success'>✅ Added column 'discount_percent' successfully.</div>";
    echo "<div class='success'><strong>🎉 Migration completed successfully!</strong></div>";
    echo "<p>You can now see discount percentage in leads list.</p>";
    echo "<p><a href='admin/leads'>Go to Leads</a></p>";
} else {
    echo "<div class='error'>❌ Error adding 'discount_percent': " . $conn->error . "</div>";
}

$conn->close();

