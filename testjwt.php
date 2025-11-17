<?php
require __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (class_exists('Firebase\JWT\JWT') && class_exists('Firebase\JWT\Key')) {
    echo "✅ JWT dan Key dikenali oleh PHP!";
} else {
    echo "❌ PHP tidak bisa menemukan JWT class.";
}
