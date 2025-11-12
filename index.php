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
    $country = $data['countryCode'] ?? null;
    if ($country === 'SG') {
        http_response_code(403);
        echo "<h1 style='text-align:center;margin-top:20vh;font-family:sans-serif;color:#444;'>Access Restricted</h1>
        <p style='text-align:center;font-family:sans-serif;'>Sorry, TempMessage.com is not available in your region.</p>";
        exit;
    }
}

// =========================================================
// 🌐 Page Setup and Dynamic SEO Variables
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
$description = "$keyword — Create and share self-destructing messages online with TempMessage.com. End-to-end encryption ensures total privacy — no data stored, no accounts needed.";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo $keyword; ?> — Send Self-Destructing Private Messages Online</title>
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
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#137fec",
              "background-light": "#f6f7f8",
              "background-dark": "#101922",
              "surface-light": "#ffffff",
              "surface-dark": "#18232e",
              "text-primary-light": "#111418",
              "text-primary-dark": "#f0f2f4",
              "text-secondary-light": "#617589",
              "text-secondary-dark": "#a0b0c1",
              "border-light": "#e5e7eb",
              "border-dark": "#343e4a"
            },
            fontFamily: {
              "display": ["Inter"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
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
<style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>


<body>
  
      
  </head> 
<body class="bg-background-light dark:bg-background-dark font-display">
<div class="relative mx-auto flex h-auto min-h-screen w-full max-w-md flex-col overflow-x-hidden group/design-root">
<div class="sticky top-0 z-10 flex flex-col gap-2 bg-background-light dark:bg-background-dark p-4 pb-3 border-b border-border-light dark:border-border-dark">
<div class="flex items-center h-12 justify-between">
<button class="flex items-center justify-center rounded-full size-10 text-text-primary-light dark:text-text-primary-dark hover:bg-black/5 dark:hover:bg-white/5">
<span class="material-symbols-outlined text-2xl">refresh</span>
</button>
<div class="flex items-center justify-end">
<button class="flex items-center justify-center rounded-full size-10 text-text-primary-light dark:text-text-primary-dark hover:bg-black/5 dark:hover:bg-white/5">
<span class="material-symbols-outlined text-2xl">add_box</span>
</button>
</div>
</div>
<h1 class="text-text-primary-light dark:text-text-primary-dark tracking-tight text-[28px] font-bold leading-tight"></h1class><?php echo $keyword; ?></h1> 
</div>
<div>
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-gw-3+1f-3d+2z"
     data-ad-client="ca-pub-2885050972904135"
     data-ad-slot="2474333714"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-format="fluid"
         data-ad-layout-key="-gw-3+1f-3d+2z"
         data-ad-client="ca-pub-2885050972904135"
         data-ad-slot="2474333714"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>

</div>
<div class="flex flex-col gap-3 p-4 bg-background-light dark:bg-background-dark pt-1">
<p class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-normal leading-normal text-center">Your temporary email address is:</p>
<div class="flex items-center justify-between gap-4 rounded-xl bg-surface-light dark:bg-surface-dark px-4 py-3 min-h-14 border border-border-light dark:border-border-dark">
<div class="flex items-center gap-4 flex-1 min-w-0">
<span class="material-symbols-outlined text-text-secondary-light dark:text-text-secondary-dark text-2xl">inbox</span>
<p class="text-text-primary-light dark:text-text-primary-dark text-base font-medium leading-normal flex-1 truncate">random.name123@domain.com</p>
</div>
<button class="shrink-0 flex items-center justify-center size-9 rounded-full text-primary bg-primary/10 dark:bg-primary/20 hover:bg-primary/20 dark:hover:bg-primary/30">
<span class="material-symbols-outlined text-xl">content_copy</span>
</button>
</div>
</div>
<div class="px-4 py-2">
<div class="w-full h-px bg-border-light dark:bg-border-dark"></div>
</div>
<div class="flex flex-col">
<div class="px-4 py-6 bg-surface-light dark:bg-surface-dark border-b border-border-light dark:border-border-dark">
<div class="flex flex-col gap-3">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-2xl">security</span>
<h2 class="text-xl font-bold text-text-primary-light dark:text-text-primary-dark">Why Use a Temporary Email?</h2>
</div>
<p class="text-text-secondary-light dark:text-text-secondary-dark leading-relaxed">Protect your online privacy with a <span class="font-semibold text-text-primary-light dark:text-text-primary-dark">free, disposable email address</span>. Avoid spam, marketing emails, and phishing attempts in your primary inbox. A <span class="font-semibold text-text-primary-light dark:text-text-primary-dark">temp mail</span> service is the perfect solution for signing up for new services, forums, and newsletters without revealing your real email. Stay anonymous and secure.</p>
</div>
</div>
<div class="px-4 py-6 bg-background-light dark:bg-background-dark">
<div class="flex items-center justify-center gap-2 rounded-lg bg-surface-light dark:bg-surface-dark p-4 border border-border-light dark:border-border-dark">
<div class="flex flex-col flex-1">
<div class="flex items-center gap-1.5">

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-2885050972904135"
     data-ad-slot="6877161897"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
      <ins class="adsbygoogle"
           style="display:block; text-align:center;"
           data-ad-layout="in-article"
           data-ad-format="fluid"
           data-ad-client="ca-pub-2885050972904135"
           data-ad-slot="6877161897"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>


</div>
<div class="px-4 py-6 bg-surface-light dark:bg-surface-dark border-b border-border-light dark:border-border-dark">
<div class="flex flex-col gap-3">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-2xl">shield</span>
<h2 class="text-xl font-bold text-text-primary-light dark:text-text-primary-dark">Secure &amp; Anonymous Email Generator</h2>
</div>
<p class="text-text-secondary-light dark:text-text-secondary-dark leading-relaxed">Our <span class="font-semibold text-text-primary-light dark:text-text-primary-dark">temporary mail generator</span> provides a secure and anonymous way to receive emails. All messages are automatically deleted after a short period, ensuring your data is never stored long-term. Use a <span class="font-semibold text-text-primary-light dark:text-text-primary-dark">fake email address</span> to protect your digital identity online and keep your personal information safe from data breaches.</p>
</div>
</div>
<div class="px-4 py-6 bg-background-light dark:bg-background-dark">
<div class="flex h-28 items-center justify-center rounded-lg bg-surface-light dark:bg-surface-dark p-4 border border-border-light dark:border-border-dark relative">
<span class="absolute top-1.5 left-2 text-xs font-semibold uppercase tracking-wider text-text-secondary-light dark:text-text-secondary-dark">AD</span>
<p class="text-text-secondary-light dark:text-text-secondary-dark">Advertisement Banner</p>
</div>
</div>
<div class="px-4 py-6 bg-surface-light dark:bg-surface-dark border-b border-border-light dark:border-border-dark">
<div class="flex flex-col gap-3">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-2xl">verified_user</span>
<h2 class="text-xl font-bold text-text-primary-light dark:text-text-primary-dark">Benefits of a Disposable Email</h2>
</div>
<ul class="list-disc list-inside space-y-2 text-text-secondary-light dark:text-text-secondary-dark">
<li><span class="font-semibold text-text-primary-light dark:text-text-primary-dark">Instant Setup:</span> Generate a new email address in seconds.</li>
<li><span class="font-semibold text-text-primary-light dark:text-text-primary-dark">No Registration:</span> No need to provide personal details.</li>
<li><span class="font-semibold text-text-primary-light dark:text-text-primary-dark">Spam Protection:</span> Keep your main inbox clean and clutter-free.</li>
<li><span class="font-semibold text-text-primary-light dark:text-text-primary-dark">Enhanced Privacy:</span> Sign up for services without tracking.</li>
</ul>
</div>
</div>
<div class="px-4 py-6 bg-background-light dark:bg-background-dark">
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2885050972904135"
     crossorigin="anonymous"></script>
<!-- advest -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2885050972904135"
     data-ad-slot="9730555949"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
      <ins class="adsbygoogle"
           style="display:block"
           data-ad-client="ca-pub-2885050972904135"
           data-ad-slot="9730555949"
           data-ad-format="auto"
           data-full-width-responsive="true"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>


</div>
<div class="w-20 h-20 rounded-lg bg-gray-200 dark:bg-gray-700 flex-shrink-0"></div>
</div>
</div>
<div class="px-4 py-6 bg-surface-light dark:bg-surface-dark border-b border-border-light dark:border-border-dark">
<div class="flex flex-col gap-3">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-2xl">help_outline</span>
<h2 class="text-xl font-bold text-text-primary-light dark:text-text-primary-dark">Frequently Asked Questions</h2>
</div>
<div class="space-y-3 mt-2">
<div>
<h3 class="font-semibold text-text-primary-light dark:text-text-primary-dark">What is a temporary email address?</h3>
<p class="text-text-secondary-light dark:text-text-secondary-dark text-sm">A temporary, or disposable, email address is a short-term inbox that expires after a certain period. It’s used to receive emails without giving away your personal email.</p>
</div>
<div>
<h3 class="font-semibold text-text-primary-light dark:text-text-primary-dark">Is it free to use?</h3>
<p class="text-text-secondary-light dark:text-text-secondary-dark text-sm">Yes, our temporary email service is completely free. You can generate as many <span class="font-semibold">disposable email</span> addresses as you need.</p>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div></body></html>
