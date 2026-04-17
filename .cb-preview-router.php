<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$publicPath = __DIR__ . '/public';
$publicRealPath = realpath($publicPath) ?: $publicPath;
$requestedFile = realpath($publicPath . $uri);
if ($uri !== '/' && $requestedFile && str_starts_with($requestedFile, $publicRealPath) && is_file($requestedFile)) {
    return false;
}
require $publicPath . '/index.php';
