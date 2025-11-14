<?php
// =========================================================
// 🛡 ALWAYS ALLOW SEARCH ENGINE BOTS (Google safe)
// =========================================================
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$allowedBots = ['googlebot','bingbot','duckduckbot','yandexbot','adsbot-google'];
$isBot = false;
foreach ($allowedBots as $bot) {
    if (strpos($userAgent, $bot) !== false) { 
        $isBot = true; 
        break; 
    }
}

// Function to get real IP (used both in SG block + Tier1 block)
function getClientIP() {
    foreach (['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'] as $key) {
        if (!empty($_SERVER[$key])) {
            $ipList = explode(',', $_SERVER[$key]);
            return trim($ipList[0]);
        }
    }
    return '0.0.0.0';
}

// =========================================================
// 🚫 BLOCK SINGAPORE TRAFFIC (non-bot)
// =========================================================
if (!$isBot) {

    $ip = getClientIP();
    $cacheFile = sys_get_temp_dir() . "/geo_{$ip}_sg.json";

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 86400) {
        $data = json_decode(file_get_contents($cacheFile), true);
    } else {
        $resp = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,countryCode");
        $data = $resp ? json_decode($resp, true) : null;
        if ($data) file_put_contents($cacheFile, json_encode($data));
    }

    if (($data['countryCode'] ?? null) === 'SG') {
        http_response_code(403);
        echo "<h1 style='text-align:center;margin-top:20vh;font-family:sans-serif;color:#444;'>Access Restricted</h1>
        <p style='text-align:center;font-family:sans-serif;'>Sorry, TempMessage.com is not available in your region.</p>";
        exit;
    }
}

// =========================================================
// 🌍 NEW FEATURE: TIER-1 ONLY TRAFFIC BOOSTER
// =========================================================
if (!$isBot) {

    $ip = getClientIP();
    $cacheFile = sys_get_temp_dir() . "/geo_{$ip}_tier1.json";

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 1800) { // 30 min cache
        $geo = json_decode(file_get_contents($cacheFile), true);
    } else {
        $resp = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,countryCode");
        $geo = $resp ? json_decode($resp, true) : null;
        if ($geo) file_put_contents($cacheFile, json_encode($geo));
    }

    // Allowed Tier-1 countries
    $tier1 = ['US','GB','CA','AU','DE'];

    // ❌ Non-Tier-1 users → LITE MODE page (Google safe)
    if (!in_array($geo['countryCode'] ?? 'XX', $tier1)) {

        echo "<!DOCTYPE html><html><head>
        <meta name='robots' content='noindex,nofollow'>
        <title>Temporary Email</title></head>
        <body style='font-family:sans-serif;text-align:center;margin-top:15vh'>
        <h1>Temporary Email Service</h1>
        <p>Fast private inbox.</p>
        <p>Full features are not available in your region.</p>
        </body></html>";
        exit;
    }
}

// =========================================================
// 🧩 Slug converter
// =========================================================
function makeSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

// =========================================================
// 🌐 Programmatic SEO Keyword System
// =========================================================
$domain = "https://tempmessage.com/";
$keywordsFile = __DIR__ . '/keywords.txt';

$keywordsList = file_exists($keywordsFile)
    ? file($keywordsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
    : [];

// =========================================================
// 📌 Extract slug from URL path
// =========================================================
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uriParts = explode('/', $uri);
$pathSlug = isset($uriParts[0]) ? $uriParts[0] : "";

// =========================================================
// 🌐 Keyword Selection
// =========================================================
if ($pathSlug !== "" && $pathSlug !== "index.php") {

    $slug = $pathSlug;
    $keyword = str_replace('-', ' ', $slug);

} else {

    if (!empty($keywordsList)) {
        $daySeed = date('Ymd');
        srand(crc32($daySeed));
        $keyword = $keywordsList[array_rand($keywordsList)];
    } else {
        $keyword = "Temporary Message Creator";
    }

    $slug = makeSlug($keyword);
}

$keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');

// =========================================================
// 📌 Canonical Tag Logic
// =========================================================
if ($pathSlug !== "" && $pathSlug !== "index.php") {
    $canonical = $domain . $slug . '/';
} else {
    $canonical = $domain;
}

// =========================================================
// 🧠 UNIQUE CONTENT GENERATOR (Spintax Engine)
// =========================================================
function spinx($text) {
    return preg_replace_callback('/\{([^{}]+)\}/', function($m) {
        $parts = explode('|', $m[1]);
        return $parts[array_rand($parts)];
    }, $text);
}

function megaUnique($keyword) {
    $templates = [
        "{Using|With|Through} $keyword you {stay private|avoid spam|protect your identity|hide your inbox}.",
        "$keyword {autodeletes all emails|stores nothing|removes messages instantly|keeps no logs}.",
        "{Perfect|Ideal|Great|Useful} for {signups|OTP attempts|anonymous browsing|quick verification}.",
        "{No registration needed|Instant access|Zero setup|Completely anonymous} when using $keyword.",
        "$keyword is {fast|instant|quick|lightning-fast} and {secure|safe|private|encrypted}.",
        "{Temporary email|Disposable inbox|One-time email} with $keyword helps you stay {hidden|protected|off the radar}.",
        "{You can use|People rely on|Millions prefer} $keyword for {privacy|quick tasks|secure usage}.",
    ];

    shuffle($templates);
    $slice = array_slice($templates, 0, rand(3, 6));
    return spinx(implode(" ", $slice));
}

function buildFAQ($keyword) {
    return [
        [
            "q" => spinx("Is {it safe|it secure|it trusted} to use $keyword?"),
            "a" => spinx("$keyword is completely {safe|secure|private}. All emails are deleted {automatically|instantly|after use}.")
        ],
        [
            "q" => spinx("Can I use $keyword for {signups|verification|OTP}?"),
            "a" => spinx("Some platforms accept $keyword for OTP, while others {block temp mail|restrict disposable addresses}.")
        ],
        [
            "q" => spinx("How long do messages stay in $keyword?"),
            "a" => spinx("Messages remain {until refreshed|until session expires|for a short duration}.")
        ],
        [
            "q" => spinx("Do I need an account to use $keyword?"),
            "a" => spinx("No account is needed. $keyword is {anonymous|instant|registration-free}.")
        ]
    ];
}

$paragraph1 = megaUnique($keyword);
$paragraph2 = megaUnique($keyword);
$paragraph3 = megaUnique($keyword);
$faqList = buildFAQ($keyword);

// =========================================================
// 📝 Meta Tags
// =========================================================
$metaDescription = spinx(
    "{Get|Generate|Create} a {temporary email|disposable inbox|secure one-time email} with $keyword. ".
    "Fast, private, and fully anonymous."
);

$title = "$keyword — Free Temporary Email Service";

?>
