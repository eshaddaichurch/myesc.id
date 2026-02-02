<?php
echo "<h2>Test File Existence</h2>";

// Path ke folder foto
$basePath = realpath(__DIR__ . '/../admin/uploads/jemaat/') . DIRECTORY_SEPARATOR;

echo "<p><strong>Base Path:</strong> " . $basePath . "</p>";
echo "<p><strong>Directory exists:</strong> " . (is_dir($basePath) ? 'YES ✓' : 'NO ✗') . "</p>";

// Test file spesifik
$filesToTest = [
    'Agam_Suteja.jpg',
    'Screenshot_2026-01-22_095740.png'
];

foreach ($filesToTest as $filename) {
    $filePath = $basePath . $filename;
    echo "<hr>";
    echo "<p><strong>File:</strong> " . $filename . "</p>";
    echo "<p><strong>Full Path:</strong> " . $filePath . "</p>";
    echo "<p><strong>Exists:</strong> " . (file_exists($filePath) ? '<span style="color:green">YES ✓</span>' : '<span style="color:red">NO ✗</span>') . "</p>";
    echo "<p><strong>Is File:</strong> " . (is_file($filePath) ? '<span style="color:green">YES ✓</span>' : '<span style="color:red">NO ✗</span>') . "</p>";
    echo "<p><strong>Size:</strong> " . (file_exists($filePath) ? filesize($filePath) . " bytes" : 'N/A') . "</p>";
    
    if (file_exists($filePath)) {
        echo "<p><strong>Direct URL:</strong> <a href='/admin/uploads/jemaat/" . $filename . "' target='_blank'>/admin/uploads/jemaat/" . $filename . "</a></p>";
    }
}

// List semua file di folder
echo "<hr><h3>All Files in Directory:</h3>";
if (is_dir($basePath)) {
    $files = array_diff(scandir($basePath), array('.', '..'));
    echo "<pre>";
    print_r($files);
    echo "</pre>";
} else {
    echo "<p style='color:red'>Directory not found!</p>";
}
?>