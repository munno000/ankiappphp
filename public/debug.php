<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<h2>PHP Version</h2>';
echo PHP_VERSION;

echo '<h2>Extensions</h2>';
$required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo'];
foreach ($required as $ext) {
    $ok = extension_loaded($ext);
    echo ($ok ? '✅' : '❌') . ' ' . $ext . '<br>';
}

echo '<h2>Directory Permissions</h2>';
$dirs = [
    __DIR__ . '/../storage/logs',
    __DIR__ . '/../storage/framework/sessions',
    __DIR__ . '/../storage/framework/cache',
    __DIR__ . '/../storage/framework/views',
    __DIR__ . '/../bootstrap/cache',
];
foreach ($dirs as $dir) {
    $exists = is_dir($dir);
    $writable = is_writable($dir);
    echo ($exists && $writable ? '✅' : '❌') . ' ' . basename(dirname($dir)) . '/' . basename($dir)
        . ' (exists:' . ($exists ? 'yes' : 'no') . ' writable:' . ($writable ? 'yes' : 'no') . ')<br>';
}

echo '<h2>Laravel Bootstrap Test</h2>';
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo '✅ vendor/autoload.php OK<br>';
} catch (Throwable $e) {
    echo '❌ ' . $e->getMessage() . '<br>';
}

try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    echo '✅ bootstrap/app.php OK<br>';
} catch (Throwable $e) {
    echo '❌ ' . $e->getMessage() . '<br>';
}
