<?php
// =========================================================
// 🚫 Block Singapore traffic (allow Google crawlers / adsbot)
// =========================================================
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
if (strpos($userAgent, 'googlebot') === false && strpos($userAgent, 'adsbot-google') === false) {

    function getClientIP() {
        foreach (['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'] as $key) {
            if (!empty($_SERVER[$key])) {
                $ipList = explode(',', $_SERVER[$key]);
                return trim($ipList[0]);
            }
        }
        return '0.0.0.0';
    }

    $ip = getClientIP();
    $cacheFile = sys_get_temp_dir() . "/geo_{$ip}.json";

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
// 🌐 Keyword selection
// =========================================================
$domain = "https://tempmessage.com/";
$keywordsFile = __DIR__ . '/keywords.txt';
$keywordsList = file_exists($keywordsFile)
  ? file($keywordsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
  : [];

if (isset($_GET['q']) && trim($_GET['q']) !== '') {
    $keyword = trim($_GET['q']);
} elseif (!empty($keywordsList)) {
    $daySeed = date('Ymd');
    srand(crc32($daySeed));
    $keyword = $keywordsList[array_rand($keywordsList)];
} else {
    $keyword = 'Temporary Message Creator';
}

$keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');

// =========================================================
// 🧠 UNIQUE CONTENT GENERATOR (1,000,000+ variations)
// =========================================================

// Spintax Engine
function spinx($text) {
    return preg_replace_callback('/\{([^{}]+)\}/', function($m) {
        $parts = explode('|', $m[1]);
        return $parts[array_rand($parts)];
    }, $text);
}

// Mega Paragraph Generator
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

    // Pick 3–6 random templates
    $slice = array_slice($templates, 0, rand(3, 6));
    $joined = implode(" ", $slice);

    // Apply spintax
    return spinx($joined);
}

// Dynamic FAQ Builder
function buildFAQ($keyword) {
    $faqs = [
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

    return $faqs;
}

// Generate programmatic SEO elements
$paragraph1 = megaUnique($keyword);
$paragraph2 = megaUnique($keyword);
$paragraph3 = megaUnique($keyword);

$faqList = buildFAQ($keyword);

$metaDescription = spinx(
    "{Get|Generate|Create} a {temporary email|disposable inbox|secure one-time email} with $keyword. ".
    "Fast, private, and fully anonymous."
);

$title = "$keyword — Free Temporary Email Service";

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo $keyword; ?></title>
  <meta name="description" content="<?php echo $description; ?>" />
  <meta name="keywords" content="temporary message, secret message, encrypted message, self-destructing message, anonymous message, private message, one-time link, secure message sharing, tempmessage, private note, burn after reading" />
  <meta property="og:title" content="<?php echo $keyword; ?> — Secure & Private Messaging" />
  <meta property="og:description" content="<?php echo $description; ?>" />
  <meta property="og:url" content="<?php echo $domain; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="<?php echo $domain; ?>assets/preview.jpg" />
  <link rel="canonical" href="<?php echo $domain . '?q=' . urlencode($keyword); ?>" />
  <link rel="stylesheet" href="assets/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script id="tailwind-config">
 <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#137fec",
            "background-light": "#f6f7f8",
            "background-dark": "#101922",
            "card-light": "#ffffff",
            "card-dark": "#192734",
            "text-light-primary": "#101922",
            "text-dark-primary": "#f6f7f8",
            "text-light-secondary": "#4c739a",
            "text-dark-secondary": "#a0b3c6",
            "border-light": "#e7edf3",
            "border-dark": "#2d3f50",
          },
          fontFamily: {
            "display": ["Inter", "sans-serif"]
          },
          borderRadius: {
            "DEFAULT": "0.25rem",
            "lg": "0.5rem",
            "xl": "0.75rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135" crossorigin="anonymous"></script>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "<?php echo $keyword; ?>",
    "url": "<?php echo $domain; ?>",
    "applicationCategory": "UtilityApplication",
    "operatingSystem": "All",
    "description": "<?php echo $description; ?>",
    "offers": {
      "@type": "Offer",
      "price": "0",
      "priceCurrency": "USD"
    }
  }
  </script>
    <script>
if(!sessionStorage.getItem('verified')){
  const token = btoa(Date.now());
  fetch('/verify?token='+token).then(()=> {
    sessionStorage.setItem('verified', token);
    location.reload();
  });
}
</script>



  
      
  </head> 
<body class="bg-background-light dark:bg-background-dark font-display text-text-light-primary dark:text-text-dark-primary">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<div class="flex flex-1 justify-center">
<div class="layout-content-container flex w-full flex-col max-w-[960px] flex-1">
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-light dark:border-border-dark px-4 py-3 sticky top-0 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm z-10">
<div class="flex items-center gap-2 text-text-light-primary dark:text-text-dark-primary">
<div class="size-5 text-primary">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-base font-bold leading-tight tracking-[-0.015em]">Temp Message</h2>
</div>
<button class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-9 w-9 bg-background-light dark:bg-card-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold leading-normal tracking-[0.015em]">
<span class="material-symbols-outlined !text-2xl">menu</span>
</button>
</header>
<main class="p-4 flex flex-col gap-6">
<div class="flex flex-wrap justify-between gap-3 text-center">
<div class="flex w-full flex-col gap-1">
<h1 class="text-text-light-primary dark:text-text-dark-primary text-xl font-black leading-tight tracking-[-0.033em]"></h1class><?php echo $keyword; ?></h1>

</div>
</div>
<div> <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135"
     crossorigin="anonymous"></script>
<!-- Slot1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2885050972904135"
     data-ad-slot="6059490978"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
<div class="p-0">
<div class="flex flex-col items-stretch justify-start rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)] dark:shadow-[0_4px_12px_rgba(0,0,0,0.2)] bg-card-light dark:bg-card-dark p-4 gap-3">
<div class="flex w-full min-w-0 grow flex-col items-stretch justify-center gap-2">
<p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">Your temporary email address</p>
<div class="flex items-center gap-3 justify-between flex-wrap">
<p class="text-text-light-primary dark:text-text-dark-primary text-base font-bold leading-tight tracking-[-0.015em] break-all"></p>
<button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-8 px-2.5 bg-primary text-white text-xs font-medium leading-normal gap-1">
<span class="material-symbols-outlined !text-sm !leading-none">content_copy</span>
<span class="truncate">Copy</span>
</button>
</div>
</div>
<div class="flex flex-1 gap-2 flex-wrap">
<button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-8 px-2.5 bg-primary/10 dark:bg-primary/20 text-primary text-xs font-bold leading-normal tracking-[0.015em] grow gap-1">
<span class="material-symbols-outlined !text-sm !leading-none">refresh</span>
<span class="truncate">New Address</span>
</button>
<button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-8 px-2.5 bg-background-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-xs font-bold leading-normal tracking-[0.015em] grow gap-1">
<span class="material-symbols-outlined !text-sm !leading-none">delete</span>
<span class="truncate">Delete</span>
</button>
</div>
</div>
</div>
<div class="flex flex-col gap-4">
<div>
<div class="flex justify-between items-center border-b border-border-light dark:border-border-dark">
<a class="flex flex-col items-center justify-center border-b-[3px] border-primary text-text-light-primary dark:text-text-dark-primary pb-3 pt-3 flex-1" href="#">
<p class="text-sm font-bold leading-normal tracking-[0.015em]">Inbox</p>
</a>
<button class="flex items-center justify-center size-8 rounded-full text-text-light-secondary dark:text-text-dark-secondary hover:bg-black/5 dark:hover:bg-white/5 active:bg-black/10 dark:active:bg-white/10 transition-colors">
<span class="material-symbols-outlined !text-xl">refresh</span>
</button>
</div>
</div>
<div id="inboxBox" class="flex flex-col items-center justify-center text-center gap-3 p-6 bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark">
<div class="flex items-center justify-center size-10 bg-primary/10 dark:bg-primary/20 rounded-full text-primary">
<span class="material-symbols-outlined !text-2xl">inbox</span>
</div>
<h3 class="text-base font-bold text-text-light-primary dark:text-text-dark-primary">Your is Empty</h3>
<p class="text-text-light-secondary dark:text-text-dark-secondary text-xs max-w-xs">Waiting for incoming emails. Messages will appear here automatically.</p>
</div>
<div><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-2885050972904135"
     data-ad-slot="4864052707"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
<div class="flex items-start gap-3 p-3 rounded-xl bg-card-light dark:bg-card-dark">
<div class="text-primary mt-0.5"><span class="material-symbols-outlined !text-xl">verified_user</span></div>
<div>
<h3 class="font-bold text-sm text-text-light-primary dark:text-text-dark-primary">Privacy Focused</h3>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary">Keep your real inbox safe from spam and phishing.</p>
</div>
</div>
<div class="flex items-start gap-3 p-3 rounded-xl bg-card-light dark:bg-card-dark">
<div class="text-primary mt-0.5"><span class="material-symbols-outlined !text-xl">block</span></div>
<div>
<h3 class="font-bold text-sm text-text-light-primary dark:text-text-dark-primary">Spam Free</h3>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary">Use a disposable address for sign-ups and newsletters.</p>
</div>
</div>
<div class="flex items-start gap-3 p-3 rounded-xl bg-card-light dark:bg-card-dark">
<div class="text-primary mt-0.5"><span class="material-symbols-outlined !text-xl">rocket_launch</span></div>
<div>
<h3 class="font-bold text-sm text-text-light-primary dark:text-text-dark-primary">Instant Setup</h3>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary">No registration, no passwords. Just instant email.</p>
</div>
</div>
<div class="flex items-start gap-3 p-3 rounded-xl bg-card-light dark:bg-card-dark">
<div class="text-primary mt-0.5"><span class="material-symbols-outlined !text-xl">schedule</span></div>
<div>
<h3 class="font-bold text-sm text-text-light-primary dark:text-text-dark-primary">Auto-Deletion</h3>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary">Emails are automatically deleted for your security.</p>
</div>
</div>
</div>
<div> <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-2885050972904135"
     data-ad-slot="5929722366"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
<div class="flex flex-col gap-3 text-center">
<h2 class="text-xl font-bold tracking-tight text-text-light-primary dark:text-text-dark-primary">Simple as 1-2-3</h2>
<div class="flex flex-col md:flex-row gap-3">
<div class="flex-1 p-4 bg-card-light dark:bg-card-dark rounded-xl flex flex-col items-center gap-2">
<div class="flex items-center justify-center size-10 bg-primary text-white rounded-full font-bold text-lg">1</div>
<h3 class="font-bold mt-1 text-sm text-text-light-primary dark:text-text-dark-primary">Generate</h3>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary">Instantly get a new temporary email address.</p>
</div>
<div class="flex-1 p-4 bg-card-light dark:bg-card-dark rounded-xl flex flex-col items-center gap-2">
<div class="flex items-center justify-center size-10 bg-primary text-white rounded-full font-bold text-lg">2</div>
<h3 class="font-bold mt-1 text-sm text-text-light-primary dark:text-text-dark-primary">Use</h3>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary">Use it for any online service or sign-up form.</p>
</div>
<div class="flex-1 p-4 bg-card-light dark:bg-card-dark rounded-xl flex flex-col items-center gap-2">
<div class="flex items-center justify-center size-10 bg-primary text-white rounded-full font-bold text-lg">3</div>
<h3 class="font-bold mt-1 text-sm text-text-light-primary dark:text-text-dark-primary">Discard</h3>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary">Forget about the address. It will self-destruct.</p>
</div>
</div>
</div>
<div class="flex flex-col gap-3 rounded-xl bg-card-light dark:bg-card-dark p-4">
<h2 class="text-xl font-bold tracking-tight text-text-light-primary dark:text-text-dark-primary"><?php echo $keyword; ?></h2>
<p class="text-text-light-secondary dark:text-text-dark-secondary text-sm leading-relaxed"><?php echo $paragraph1; ?><?php echo $paragraph2; ?><?php echo $paragraph3; ?></p>
</div>
<div><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135"
     crossorigin="anonymous"></script>
<!-- Display 1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2885050972904135"
     data-ad-slot="9044746964"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
<div class="flex flex-col gap-3">
<h2 class="text-xl font-bold tracking-tight text-text-light-primary dark:text-text-dark-primary text-center">When to Use a Temp Email</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
<div class="flex flex-col gap-2 p-3 rounded-xl bg-card-light dark:bg-card-dark">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary !text-xl">shopping_cart</span>
<h3 class="font-bold text-sm text-text-light-primary dark:text-text-dark-primary">Online Shopping</h3>
</div>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary"> <?php echo $keyword; ?> Sign up for store loyalty cards or one-time purchases without getting endless promotional emails.</p>
</div>
<div class="flex flex-col gap-2 p-3 rounded-xl bg-card-light dark:bg-card-dark">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary !text-xl">wifi</span>
<h3 class="font-bold text-sm text-text-light-primary dark:text-text-dark-primary">Public Wi-Fi</h3>
</div>
<p class="text-xs text-text-light-secondary dark:text-text-dark-secondary"><?php echo $keyword; ?> Access free Wi-Fi that requires an email address without giving away your personal contact info.</p>
</div>
<div class="flex flex-col gap-2 p-3 rounded-xl bg-card-light dark:bg-card-dark">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary !text-xl">forum</span>
<h3 class="font-bold text-sm text-text-ligh
