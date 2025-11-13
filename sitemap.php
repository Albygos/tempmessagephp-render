<?php
// Prevent BOM/whitespace breaking XML
while (ob_get_level()) ob_end_clean();

ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');

header("Content-Type: application/xml; charset=utf-8");

$domain = "https://tempmessage.com/";
$keywordsFile = __DIR__ . '/keywords.txt';

function makeSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

// If no keywords file, add only homepage
if (!file_exists($keywordsFile)) {
    echo "  <url>\n";
    echo "    <loc>{$domain}</loc>\n";
    echo "    <lastmod>".date("Y-m-d")."</lastmod>\n";
    echo "  </url>\n";
    echo "</urlset>";
    exit;
}

$today = date('Y-m-d');
$lines = file($keywordsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Homepage
echo "  <url>\n";
echo "    <loc>{$domain}</loc>\n";
echo "    <lastmod>{$today}</lastmod>\n";
echo "    <changefreq>daily</changefreq>\n";
echo "    <priority>1.0</priority>\n";
echo "  </url>\n";

// Keyword pages
foreach ($lines as $kw) {

    if (!$kw) continue;

    // Prevent XML-breaking characters
    $kw = htmlspecialchars(trim($kw), ENT_QUOTES, 'UTF-8');

    $slug = makeSlug($kw);
    $url = $domain . $slug . "/";

    echo "  <url>\n";
    echo "    <loc>{$url}</loc>\n";
    echo "    <lastmod>{$today}</lastmod>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>0.8</priority>\n";
    echo "  </url>\n";
}

echo "</urlset>";
