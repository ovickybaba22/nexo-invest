<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="color-scheme" content="dark" />
  <title>Nexo Invest — Smart Wealth Growth</title>
  <meta name="description" content="Nexo Invest: high‑performance investment plans with structured yield, live analytics, and transparent fees." />
  <link rel="canonical" href="/" />
  <meta name="theme-color" content="#0b0f11" />

  <!-- Open Graph / Twitter -->
  <meta property="og:title" content="Nexo Invest — Smart Wealth Growth" />
  <meta property="og:description" content="High‑performance investment programs powered by structured yield and real‑time analytics." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="/" />
  <meta property="og:site_name" content="Nexo Invest" />
  <meta property="og:image" content="{{ asset('img/og.jpg') }}" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Nexo Invest — Smart Wealth Growth" />
  <meta name="twitter:description" content="High‑performance investment programs powered by structured yield and real‑time analytics." />
  <meta name="twitter:image" content="{{ asset('img/og.jpg') }}" />

  <!-- Favicons -->
  <link rel="icon" type="image/png" href="{{ asset('img/logo_white.png') }}" />
  <script type="application/ld+json">
  {
    "@@context":"https://schema.org",
    "@@type":"Organization",
    "name":"Nexo Invest",
    "url":"https://nexo.com",
    "logo":"{{ asset('img/logo_white.png') }}"
  }
  </script>

  <style>html{scroll-behavior:smooth} #plan-detail{scroll-margin-top:120px}</style>
  <style>
    /* Ensure TradingView iframes fill their hosts and don't cause baseline misalignment */
    #tv-adv, #tv-mini { line-height: 0; }
    #tv-adv iframe, #tv-mini iframe { width: 100% !important; height: 100% !important; display: block; }
  </style>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
  <link rel="preload" as="image" href="{{ asset('img/nexo-bg.jpg') }}" fetchpriority="high" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white antialiased selection:bg-cyan-500/30">
  <!-- Sticky / Glass NAV -->
  <header class="fixed inset-x-0 top-0 z-30">
    <div class="mx-auto max-w-7xl px-6">
      <div class="mt-2 hidden items-center justify-between rounded-full border border-white/10 bg-black/40 px-3 py-1 text-[11px] text-gray-300 md:flex">
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center gap-1"><span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>Licensed</span>
          <span>•</span>
          <span>Cold storage</span>
          <span>•</span>
          <span>24/7 support</span>
        </div>
        <a href="#security" class="text-cyan-400 hover:text-cyan-300">Security →</a>
      </div>
    </div>
    <nav class="mx-auto max-w-7xl px-6">
      <div class="mt-4 flex items-center justify-between rounded-2xl border border-white/10 bg-black/30 px-5 py-3 backdrop-blur supports-[backdrop-filter]:bg-black/20">
        <a href="/" class="flex items-center gap-3">
          <img src="{{ asset('img/logo_white.png') }}" alt="Nexo Invest" class="h-11 md:h-12 lg:h-14 w-auto drop-shadow-sm" />
          <span class="text-white/90 font-semibold tracking-tight">NEXO INVEST</span>
        </a>
        <button id="menuOpen" class="md:hidden inline-flex items-center justify-center rounded-md border border-white/15 bg-white/5 px-3 py-2 text-sm text-white/90 hover:bg-white/10" aria-expanded="false" aria-controls="mobileNav">
          Menu
        </button>
        <div class="hidden md:flex items-center gap-6 text-sm text-gray-300">
          <a href="#how" class="hover:text-white">How it works</a>
          <a href="#why" class="hover:text-white">Why Nexo</a>
          <a href="#plans" class="hover:text-white">Plans</a>
          <a href="{{ route('login') }}" class="rounded-md border border-white/15 px-3 py-1.5 hover:bg-white/10">Sign in</a>
          <a href="{{ route('register') }}" class="rounded-md bg-cyan-500 px-3 py-1.5 font-semibold text-black hover:bg-cyan-400">Create account</a>
        </div>
      </div>
      <div id="mobileNav" class="md:hidden mt-3 hidden rounded-2xl border border-white/10 bg-black/90 p-4 backdrop-blur">
        <a href="#how" class="block py-2 text-gray-200 hover:text-white">How it works</a>
        <a href="#why" class="block py-2 text-gray-200 hover:text-white">Why Nexo</a>
        <a href="#plans" class="block py-2 text-gray-200 hover:text-white">Plans</a>
        <a href="{{ route('login') }}" class="block py-2 text-gray-200 hover:text-white">Sign in</a>
        <a href="{{ route('register') }}" class="block py-2 text-gray-200 hover:text-white">Create account</a>
      </div>
    </nav>
  </header>

  <main class="relative isolate">
    <!-- HERO -->
    <section class="relative min-h-[92vh] overflow-hidden bg-neutral-950">
      <!-- Background image -->
      <img decoding="async" src="{{ asset('img/nexo-bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-40" />
      <!-- Vignette + sweep -->
      <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/80"></div>
      <div class="pointer-events-none absolute inset-0 opacity-[0.04] [background-image:radial-gradient(1px_1px_at_20%_20%,_#fff_0,_transparent_1px)] [background-size:4px_4px]"></div>
      <div class="pointer-events-none absolute -top-32 -left-32 h-[500px] w-[500px] rounded-full bg-cyan-400/10 blur-3xl"></div>

      <!-- HERO CONTENT -->
      <div class="relative z-20 mx-auto max-w-7xl px-6 pt-32 pb-20 md:pt-44">
        <span class="inline-block rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs text-gray-200">Next-gen Wealth Platform</span>

        <h1 class="mt-6 max-w-3xl text-4xl font-extrabold tracking-tight leading-[1.05] sm:text-5xl md:text-6xl">
          <span class="bg-gradient-to-r from-white via-cyan-200 to-white bg-clip-text text-transparent">Grow Your Wealth</span>
          <br class="hidden sm:block" />
          <span class="text-white/90">with Nexo Invest</span>
        </h1>

        <p class="mt-5 max-w-2xl text-gray-300">
          High-performance investment programs powered by structured yield, dynamic portfolios, and real-time analytics — built for investors who want their money working 24/7.
        </p>

        <div class="mt-7 flex gap-3">
          <a href="#plans" class="rounded-md bg-cyan-500 px-5 py-3 font-semibold text-black shadow-lg shadow-cyan-500/20 hover:bg-cyan-400">Get Started</a>
          <a href="#plans" class="rounded-md border border-white/20 px-5 py-3 font-medium text-white hover:bg-white/10">Explore Plans</a>
        </div>

        <!-- Stats -->
        <div class="mt-10 grid max-w-3xl grid-cols-3 gap-6 text-gray-300">
          <div>
            <div class="text-2xl font-semibold text-white" data-count="8" data-suffix=".4%">0%</div>
            <div class="text-xs">Avg. annual yield</div>
          </div>
          <div>
            <div class="text-2xl font-semibold text-white" data-count="250" data-suffix="M+">0</div>
            <div class="text-xs">Assets monitored</div>
          </div>
          <div>
            <div class="text-2xl font-semibold text-white" data-count="120" data-suffix="k+">0</div>
            <div class="text-xs">Global investors</div>
          </div>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 text-xs text-gray-300">
          <span class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-2.5 py-1">99.98% on‑time payouts</span>
          <span class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-2.5 py-1">Institutional partners</span>
          <span class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-2.5 py-1">Audited reporting</span>
        </div>

        <!-- empty placeholder reserved for future hero art -->
      </div>
    </section>

    <!-- METRICS TICKER -->
    <section class="border-y border-white/10 bg-black/60">
      <style>
        @@keyframes marquee { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
      </style>
      <div class="relative overflow-hidden">
        <div class="flex whitespace-nowrap [animation:marquee_28s_linear_infinite]">
          <div class="flex items-center gap-8 px-6 py-3 text-sm text-gray-300">
            <span class="text-gray-400">Core</span><span class="text-emerald-400">+7.0% APY</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Growth</span><span class="text-emerald-400">+10.8% APY</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Balanced</span><span class="text-emerald-400">+8.9% APY</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Investors</span><span class="text-white">120k+</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">On-time payouts</span><span class="text-white">99.98%</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Assets monitored</span><span class="text-white">$250M+</span>
          </div>
          <div class="flex items-center gap-8 px-6 py-3 text-sm text-gray-300" aria-hidden="true">
            <span class="text-gray-400">Core</span><span class="text-emerald-400">+7.0% APY</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Growth</span><span class="text-emerald-400">+10.8% APY</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Balanced</span><span class="text-emerald-400">+8.9% APY</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Investors</span><span class="text-white">120k+</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">On-time payouts</span><span class="text-white">99.98%</span><span class="text-gray-600">•</span>
            <span class="text-gray-400">Assets monitored</span><span class="text-white">$250M+</span>
          </div>
        </div>
      </div>
    </section>

    <!-- TRUST BAR -->
    <section aria-label="Trusted by" class="bg-black/80 border-t border-white/10">
      <div class="mx-auto max-w-7xl px-6 py-10">
        <div class="text-center text-xs uppercase tracking-wider text-gray-400">Trusted by executives from</div>
        <div class="mt-5 grid grid-cols-2 items-center justify-items-center gap-8 grayscale md:grid-cols-6">
          <span class="text-gray-300/90 text-lg tracking-wide">BLOOMBERG</span>
          <span class="text-gray-300/90 text-lg tracking-wide">FORBES</span>
          <span class="text-gray-300/90 text-lg tracking-wide">WSJ</span>
          <span class="text-gray-300/90 text-lg tracking-wide">COINDESK</span>
          <span class="text-gray-300/90 text-lg tracking-wide">FINANCIAL TIMES</span>
          <span class="text-gray-300/90 text-lg tracking-wide">TECHCRUNCH</span>
        </div>
      </div>
    </section>

    <!-- WHY -->
    <section id="why" class="bg-[#0b0f11] py-20">
      <div class="mx-auto max-w-7xl px-6">
        <h2 class="text-2xl font-semibold text-white">Why Choose Nexo Invest?</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="rounded-xl border border-white/10 bg-white/5 p-6 transition hover:border-white/20 hover:bg-white/10">
            <div class="font-semibold text-white">Secure Investments</div>
            <p class="mt-2 text-sm text-gray-300">Capital protection with diversified strategies and institutional-grade partners.</p>
          </div>
          <div class="rounded-xl border border-white/10 bg-white/5 p-6 transition hover:border-white/20 hover:bg-white/10">
            <div class="font-semibold text-white">Expert Analysis</div>
            <p class="mt-2 text-sm text-gray-300">Deep financial insights and market‑leading analytics.</p>
          </div>
          <div class="rounded-xl border border-white/10 bg-white/5 p-6 transition hover:border-white/20 hover:bg-white/10">
            <div class="font-semibold text-white">High Growth Potential</div>
            <p class="mt-2 text-sm text-gray-300">Advanced wealth‑building strategies designed for performance.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how" class="bg-[#0b0f11] py-20">
      <div class="mx-auto max-w-7xl px-6">
        <h2 class="text-2xl font-semibold text-white">How Nexo Invest Works</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="opacity-0 translate-y-6 transition-all duration-700 rounded-xl border border-white/10 bg-white/5 p-6" data-animate>
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-500 text-black font-semibold">1</div>
            <h3 class="mt-4 font-semibold text-white">Create an account</h3>
            <p class="mt-2 text-sm text-gray-300">Verify KYC and add funds securely via bank transfer or stablecoins.</p>
          </div>
          <div class="opacity-0 translate-y-6 transition-all duration-700 delay-150 rounded-xl border border-white/10 bg-white/5 p-6" data-animate>
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-500 text-black font-semibold">2</div>
            <h3 class="mt-4 font-semibold text-white">Choose a plan</h3>
            <p class="mt-2 text-sm text-gray-300">Pick Core, Growth, or Balanced. Auto‑rebalancing keeps risk in check.</p>
          </div>
          <div class="opacity-0 translate-y-6 transition-all duration-700 delay-300 rounded-xl border border-white/10 bg-white/5 p-6" data-animate>
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-500 text-black font-semibold">3</div>
            <h3 class="mt-4 font-semibold text-white">Track & withdraw</h3>
            <p class="mt-2 text-sm text-gray-300">See real‑time analytics, receive monthly yield, and withdraw anytime.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- STRATEGIES / PRODUCTS -->
    <section class="bg-[#0b0f11] py-20">
      <div class="mx-auto max-w-7xl px-6">
        <div class="flex items-end justify-between">
          <h2 class="text-2xl font-semibold text-white">Portfolio Strategies</h2>
          <a href="#plans" class="text-sm text-cyan-400 hover:text-cyan-300">See all plans →</a>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <!-- Core Income -->
          <article class="opacity-0 translate-y-6 transition-all duration-700 rounded-2xl border border-white/10 bg-gradient-to-br from-white/5 to-white/0 p-6" data-animate>
            <div class="text-xs text-gray-300">Risk: Low</div>
            <h3 class="mt-2 text-xl font-semibold text-white">Core Income</h3>
            <div class="mt-3 text-4xl font-extrabold text-white">7.0% <span class="text-base font-semibold text-gray-300">APY</span></div>
            <ul class="mt-4 space-y-2 text-sm text-gray-300">
              <li>• High‑grade yield strategies</li>
              <li>• 30‑day liquidity window</li>
              <li>• Capital preservation focus</li>
            </ul>
            <a href="{{ route('register') }}" class="mt-6 inline-block rounded-md bg-cyan-500 px-4 py-2 font-semibold text-black hover:bg-cyan-400">Start</a>
          </article>
          <!-- Growth -->
          <article class="opacity-0 translate-y-6 transition-all duration-700 delay-150 rounded-2xl border border-white/10 bg-gradient-to-br from-cyan-500/10 to-white/0 p-6" data-animate>
            <div class="text-xs text-gray-300">Risk: Medium</div>
            <h3 class="mt-2 text-xl font-semibold text-white">Growth</h3>
            <div class="mt-3 text-4xl font-extrabold text-white">10.8% <span class="text-base font-semibold text-gray-300">APY</span></div>
            <ul class="mt-4 space-y-2 text-sm text-gray-300">
              <li>• Factor‑tilted baskets</li>
              <li>• Auto‑rebalancing weekly</li>
              <li>• Drawdown controls</li>
            </ul>
            <a href="{{ route('register') }}" class="mt-6 inline-block rounded-md border border-white/20 px-4 py-2 font-semibold text-white hover:bg-white/10">Start</a>
          </article>
          <!-- Balanced -->
          <article class="opacity-0 translate-y-6 transition-all duration-700 delay-300 rounded-2xl border border-white/10 bg-gradient-to-br from-emerald-500/10 to-white/0 p-6" data-animate>
            <div class="text-xs text-gray-300">Risk: Balanced</div>
            <h3 class="mt-2 text-xl font-semibold text-white">Balanced</h3>
            <div class="mt-3 text-4xl font-extrabold text-white">8.9% <span class="text-base font-semibold text-gray-300">APY</span></div>
            <ul class="mt-4 space-y-2 text-sm text-gray-300">
              <li>• Blend of Income & Growth</li>
              <li>• Monthly distributions</li>
              <li>• Tax‑efficient overlays</li>
            </ul>
            <a href="{{ route('register') }}" class="mt-6 inline-block rounded-md border border-white/20 px-4 py-2 font-semibold text-white hover:bg-white/10">Start</a>
          </article>
        </div>
      </div>
    </section>

    <!-- LIVE MARKETS -->
    <section id="markets" class="bg-[#0b0f11] py-20 border-t border-white/10">
      <div class="mx-auto max-w-7xl px-6">
        <div class="flex items-end justify-between">
          <h2 class="text-2xl font-semibold text-white">Live Markets</h2>
          <span class="text-sm text-gray-400">Powered by TradingView widgets</span>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2">
          <!-- BTC Advanced Chart -->
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4 overflow-hidden">
            <div class="tv-skel h-[360px] md:h-[520px] w-full animate-pulse rounded-lg bg-gradient-to-br from-white/10 to-white/5"></div>
            <div id="tv-adv" data-tv="advanced" class="h-[360px] md:h-[520px] w-full"></div>
          </div>

          <!-- ETH Mini Overview -->
          <div class="rounded-2xl border border-white/10 bg-white/5 p-4 overflow-hidden">
            <div class="tv-skel h-[360px] md:h-[420px] w-full animate-pulse rounded-lg bg-gradient-to-br from-white/10 to-white/5"></div>
            <div id="tv-mini" data-tv="mini" class="h-[360px] md:h-[420px] w-full"></div>
          </div>
        </div>
      </div>
    </section>
    @php
      $calculatorPlans = isset($plans) ? $plans->take(5) : collect();
    @endphp
    <!-- ROI CALCULATOR (APY only, simplified) -->
    <section id="calculator" class="bg-[#0b0f11] py-20">
      <div class="mx-auto max-w-7xl px-6">
        <h2 class="text-2xl font-semibold text-white">Projected Earnings <span class="text-gray-400 text-base font-normal">(estimates)</span></h2>
        <p class="mt-2 text-xs text-gray-400">Illustrative only — not guarantees. Capital is at risk. Outcomes vary with market conditions.</p>

        <div class="mt-8 grid gap-6 md:grid-cols-2">
          <div class="rounded-xl border border-white/10 bg-white/5 p-6">
            <label class="text-sm text-gray-300">Amount ($)</label>
            <input id="amt" type="range" min="1000" max="500000" step="1000" value="25000" class="mt-2 w-full accent-cyan-500" />
            <div class="mt-1 text-xs text-gray-400"><span id="amtLabel">$25,000</span></div>

            <div class="mt-6 grid grid-cols-2 gap-4">
              <div>
                <label class="text-sm text-gray-300 flex items-center justify-between">
                  <span>Months</span>
                  <span class="text-gray-500 text-[11px]">1–60</span>
                </label>
                <input id="months" type="range" min="1" max="60" step="1" value="3" class="mt-2 w-full accent-cyan-500" />
                <div class="mt-1 text-xs text-gray-400"><span id="monthsLabel">3</span> months</div>
              </div>
              <div>
                <label class="text-sm text-gray-300">Plan</label>
                <select id="apy" class="mt-2 w-full rounded-md border border-white/10 bg-black/60 px-3 py-2 text-sm text-white">
                  @forelse($calculatorPlans as $calcPlan)
                    @php
                      $apyValue = ($calcPlan->target_roi_percent ?? 0) / 100;
                      $apyLabel = number_format($calcPlan->target_roi_percent ?? 0, 2);
                    @endphp
                    <option value="{{ $apyValue }}" {{ $loop->first ? 'selected' : '' }}>
                      {{ $calcPlan->name }} ({{ $apyLabel }}% APY)
                    </option>
                  @empty
                    <option value="0.2" selected>Growth (20% APY)</option>
                    <option value="0.12">Balanced (12% APY)</option>
                  @endforelse
                </select>
              </div>
            </div>
          </div>

          <div class="rounded-xl border border-white/10 bg-white/5 p-6">
            <div class="text-sm text-gray-300">Result</div>
            <div class="mt-3 text-3xl font-extrabold text-white" id="final">$26,813</div>
            <div class="mt-1 text-emerald-400" id="earnings">+ $1,813 earnings</div>
            <div class="mt-6 text-xs text-gray-400">Formula: P × (1 + APY/12)<sup>months</sup></div>
            <a href="{{ route('register') }}" class="mt-6 inline-block rounded-md bg-cyan-500 px-4 py-2 font-semibold text-black hover:bg-cyan-400">Open account</a>
          </div>
        </div>
      </div>
    </section>

    <!-- PLANS -->
    <section id="plans" class="bg-[#0b0f11] pb-24">
      <div class="mx-auto max-w-7xl px-6">
        @php
          $money = fn($v) => is_null($v) ? '—' : '$'.number_format(((float)$v)/100, 0);
          $pct   = fn($v) => rtrim(rtrim(number_format((float)$v, 2, '.', ''), '0'), '.').'%';
          $plansCollection = isset($plans) ? $plans : collect();
        @endphp

        @if(isset($plans) && count($plans))
          <div class="grid gap-6 md:grid-cols-2">
            @foreach($plans as $plan)
              <article class="rounded-2xl border border-white/10 bg-[#050a13] p-6 shadow-[0_24px_70px_rgba(0,0,0,0.65)]">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">{{ $plan->risk_level ?? 'Core' }}</p>
                    <h3 class="mt-1 text-xl font-semibold text-white">{{ $plan->name }}</h3>
                    <p class="mt-2 text-sm text-gray-300">{{ $plan->description }}</p>
                  </div>
                  <span class="inline-flex items-center rounded-full border border-white/10 px-3 py-1 text-[11px] text-cyan-200">
                    Target ROI {{ $pct($plan->target_roi_percent) }}
                  </span>
                </div>

                <dl class="mt-5 space-y-2 text-sm text-gray-300">
                  <div class="flex justify-between">
                    <dt>Minimum deposit</dt>
                    <dd class="font-semibold text-white">${{ number_format(($plan->min_deposit_cents ?? $plan->min_deposit ?? 0) / 100, 2) }}</dd>
                  </div>
                  <div class="flex justify-between">
                    <dt>Maximum deposit</dt>
                    @php $maxDep = is_null($plan->max_deposit) ? 'No max' : '$'.number_format(($plan->max_deposit ?? 0)/100, 2); @endphp
                    <dd class="font-semibold text-white">{{ $maxDep }}</dd>
                  </div>
                  <div class="flex justify-between">
                    <dt>Term</dt>
                    <dd class="font-semibold text-white">{{ $plan->min_months }}–{{ $plan->max_months ?? '∞' }} months</dd>
                  </div>
                </dl>

                <ul class="mt-4 space-y-2 text-sm text-gray-300">
                  @php $features = is_array($plan->features) ? $plan->features : []; @endphp
                  @forelse($features as $f)
                    <li class="flex items-center gap-2">
                      <span class="h-[6px] w-[6px] rounded-full bg-cyan-400"></span>
                      <span>{{ is_array($f) ? ($f['value'] ?? '') : $f }}</span>
                    </li>
                  @empty
                    <li class="flex items-center gap-2 text-gray-500">
                      <span class="h-[6px] w-[6px] rounded-full bg-white/20"></span>
                      <span>No features listed.</span>
                    </li>
                  @endforelse
                </ul>

                <div class="mt-6 flex items-center justify-between">
                  <a href="{{ route('invest.start', $plan->slug) }}"
                     class="inline-flex items-center justify-center rounded-lg bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-cyan-300">
                    Start investment
                  </a>
                  <a href="{{ route('plans.index') }}" class="text-xs text-gray-400 hover:text-white">
                    View full details →
                  </a>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <p class="text-gray-400">No plans available yet — check back soon.</p>
        @endif
      </div>
    </section>
    <!-- PRICING COMPARISON -->
    <section id="pricing" class="bg-[#0b0f11] py-12 border-t border-white/10">
      <div class="mx-auto max-w-7xl px-6">
        <h3 class="text-xl font-semibold text-white">Compare plans</h3>
        @if ($plansCollection->isNotEmpty())
          <div class="mt-6 overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="text-gray-300">
                <tr class="border-b border-white/10">
                  <th class="py-3 text-left text-gray-400">Plan</th>
                  <th class="py-3">Min deposit</th>
                  <th class="py-3">Max deposit</th>
                  <th class="py-3">Term</th>
                  <th class="py-3">Target ROI</th>
                </tr>
              </thead>
              <tbody class="text-gray-300">
                @foreach ($plansCollection as $plan)
                  @php
                    $minDepositCents = $plan->min_deposit_cents ?? $plan->min_deposit ?? 0;
                    $maxDepositCents = $plan->max_deposit_cents ?? $plan->max_deposit;
                    $maxDeposit = is_null($maxDepositCents) ? 'No max' : '$'.number_format($maxDepositCents / 100, 0);
                  @endphp
                  <tr class="border-b border-white/10">
                    <td class="py-3 text-white font-semibold">{{ $plan->name }}</td>
                    <td class="py-3">{{ $money($minDepositCents) }}</td>
                    <td class="py-3">{{ $maxDeposit }}</td>
                    <td class="py-3">{{ $plan->min_months }}–{{ $plan->max_months ?? '∞' }} months</td>
                    <td class="py-3">{{ $pct($plan->target_roi_percent ?? 0) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <p class="text-gray-400 text-sm mt-3">No plans are available for comparison right now.</p>
        @endif
      </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="bg-[#0b0f11] py-20">
      <div class="mx-auto max-w-7xl px-6">
        <div class="flex items-end justify-between">
          <h2 class="text-2xl font-semibold text-white">What clients say</h2>
          <span class="text-sm text-gray-400">Real investors. Real outcomes.</span>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
          <blockquote class="opacity-0 translate-y-6 transition-all duration-700 rounded-2xl border border-white/10 bg-white/5 p-6" data-animate>
            <p class="text-gray-200">“I moved part of my treasury into Nexo Invest. The reporting and monthly yield have been rock‑solid.”</p>
            <footer class="mt-4 text-sm text-gray-400">— Ada O., Operations Lead</footer>
          </blockquote>
          <blockquote class="opacity-0 translate-y-6 transition-all duration-700 delay-150 rounded-2xl border border-white/10 bg-white/5 p-6" data-animate>
            <p class="text-gray-200">“The Balanced strategy gives me growth without sleepless nights. Love the transparency.”</p>
            <footer class="mt-4 text-sm text-gray-400">— David K., Private Investor</footer>
          </blockquote>
        </div>
      </div>
    </section>

    <!-- SECURITY & COMPLIANCE -->
    <section id="security" class="bg-[#0b0f11] py-20 border-t border-white/10">
      <div class="mx-auto max-w-7xl px-6">
        <h2 class="text-2xl font-semibold text-white">Security & Compliance</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div class="rounded-xl border border-white/10 bg-white/5 p-6">
            <div class="flex items-start gap-3">
              <svg class="mt-0.5 h-5 w-5 flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <div>
                <h3 class="font-semibold text-white">Cold + Hot Wallet Segregation</h3>
                <p class="mt-1 text-sm text-gray-300">Operational funds isolated from cold storage; withdrawal policies enforce multi‑sig approvals.</p>
              </div>
            </div>
          </div>
          <div class="rounded-xl border border-white/10 bg-white/5 p-6">
            <div class="flex items-start gap-3">
              <svg class="mt-0.5 h-5 w-5 flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <div>
                <h3 class="font-semibold text-white">Risk Limits & Monitoring</h3>
                <p class="mt-1 text-sm text-gray-300">Counterparty limits, VaR checks, and automated drawdown controls monitored 24/7.</p>
              </div>
            </div>
          </div>
          <div class="rounded-xl border border-white/10 bg-white/5 p-6">
            <div class="flex items-start gap-3">
              <svg class="mt-0.5 h-5 w-5 flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <div>
                <h3 class="font-semibold text-white">Audits & Reporting</h3>
                <p class="mt-1 text-sm text-gray-300">Independent audits, custodial attestations, and monthly investor statements.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- FAQ -->
    <section class="bg-[#0b0f11] py-20">
      <div class="mx-auto max-w-7xl px-6">
        <h2 class="text-2xl font-semibold text-white">FAQ</h2>
        <div class="mt-6 grid gap-4 md:grid-cols-2">
          <details class="rounded-lg border border-white/10 bg-white/5 p-4 open:bg-white/10">
            <summary class="cursor-pointer list-none font-medium text-white">How do withdrawals work?</summary>
            <p class="mt-2 text-sm text-gray-300">Requests are processed daily. Core offers a 30‑day liquidity window; Growth and Balanced within 3–5 business days.</p>
          </details>
          <details class="rounded-lg border border-white/10 bg-white/5 p-4 open:bg-white/10">
            <summary class="cursor-pointer list-none font-medium text-white">Is my capital protected?</summary>
            <p class="mt-2 text-sm text-gray-300">We prioritize capital preservation via diversified counterparties, risk limits, and real‑time monitoring.</p>
          </details>
          <details class="rounded-lg border border-white/10 bg-white/5 p-4 open:bg-white/10">
            <summary class="cursor-pointer list-none font-medium text-white">What fees do you charge?</summary>
            <p class="mt-2 text-sm text-gray-300">Management fees are embedded in APY quotes; no setup or performance fees for retail tiers.</p>
          </details>
          <details class="rounded-lg border border-white/10 bg-white/5 p-4 open:bg-white/10">
            <summary class="cursor-pointer list-none font-medium text-white">Do I keep custody?</summary>
            <p class="mt-2 text-sm text-gray-300">Assets are held with institutional‑grade partners with segregated accounts and audit trails.</p>
          </details>
        </div>
      </div>
    </section>

    <!-- FINAL CTA -->
    <section class="relative overflow-hidden bg-gradient-to-b from-cyan-500/10 via-cyan-500/5 to-transparent py-20">
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(34,211,238,0.12),transparent_60%)]"></div>
      <div class="relative mx-auto max-w-5xl rounded-2xl border border-white/10 bg-black/50 px-6 py-12 text-center backdrop-blur">
        <h2 class="text-3xl font-extrabold text-white">Make your money work—24/7</h2>
        <p class="mx-auto mt-3 max-w-2xl text-gray-300">Open an account in minutes and start earning yield with full transparency and control.</p>
        <div class="mt-6 flex items-center justify-center gap-3">
          <a href="{{ route('register') }}" class="rounded-md bg-cyan-500 px-5 py-3 font-semibold text-black hover:bg-cyan-400">Get Started</a>
          <a href="#plans" class="rounded-md border border-white/20 px-5 py-3 font-medium text-white hover:bg-white/10">Compare Plans</a>
        </div>
      </div>
    </section>

    <!-- Sticky CTA -->
    <div id="stickyCta" class="fixed inset-x-0 bottom-3 z-40 hidden justify-center">
      <div class="mx-auto flex max-w-3xl items-center justify-between gap-4 rounded-full border border-white/10 bg-black/70 px-4 py-3 text-sm backdrop-blur">
        <span class="text-gray-200">Ready to start earning? Compare plans and open an account in minutes.</span>
        <a href="#plans" class="rounded-md bg-cyan-500 px-4 py-2 font-semibold text-black hover:bg-cyan-400">View Plans</a>
      </div>
    </div>

    <!-- SUPPORT CHAT (UI only) -->
    <button id="chatOpen" class="fixed bottom-5 right-5 z-50 inline-flex h-12 w-12 items-center justify-center rounded-full bg-cyan-500 text-black shadow-lg hover:bg-cyan-400" aria-label="Open chat">💬</button>
    <div id="chatPanel" class="fixed bottom-20 right-5 z-50 hidden w-80 rounded-2xl border border-white/10 bg-black/80 p-4 backdrop-blur">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold">Live Chat</h3>
        <button id="chatClose" class="rounded-md bg-white/10 px-2 py-1 text-sm hover:bg-white/20">Close</button>
      </div>
      <p class="mt-2 text-xs text-gray-300">We usually reply in a few minutes.</p>
      <form class="mt-3 space-y-2">
        <input type="text" placeholder="Your name" class="w-full rounded-md border border-white/10 bg-black/60 px-3 py-2 text-sm" />
        <input type="email" placeholder="Email (optional)" class="w-full rounded-md border border-white/10 bg-black/60 px-3 py-2 text-sm" />
        <textarea rows="3" placeholder="Type your message..." class="w-full rounded-md border border-white/10 bg-black/60 px-3 py-2 text-sm"></textarea>
        <button type="button" class="w-full rounded-md bg-cyan-500 px-3 py-2 text-sm font-semibold text-black hover:bg-cyan-400">Send</button>
      </form>
    </div>
    <!-- NEWSLETTER CAPTURE -->
    <section class="bg-[#0b0f11] border-t border-white/10">
      <div class="mx-auto max-w-5xl px-6 py-16 text-center">
        <h3 class="text-2xl font-semibold text-white">Get updates from Nexo Invest</h3>
        <p class="mt-2 text-sm text-gray-400">Product launches, rates, and insights. No spam.</p>
        <form class="mx-auto mt-6 flex max-w-xl flex-col gap-3 sm:flex-row">
          <input type="email" required placeholder="you@company.com" class="flex-1 rounded-md border border-white/10 bg-black/60 px-4 py-3 text-sm text-white placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500" />
          <button type="submit" class="rounded-md bg-cyan-500 px-5 py-3 text-sm font-semibold text-black hover:bg-cyan-400">Subscribe</button>
        </form>
        <p class="mt-3 text-xs text-gray-500">By subscribing, you agree to our <a href="#" class="text-gray-400 underline hover:text-white">Privacy Policy</a>.</p>
      </div>
    </section>
    <!-- GLOBAL / MEGA FOOTER -->
    <footer class="bg-black/95 border-t border-white/10 text-gray-300">
      <div class="mx-auto max-w-7xl px-6">

        <!-- Top bar: logo + quick links -->
        <div class="flex flex-col items-start justify-between gap-6 py-6 md:flex-row md:items-center">
          <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('img/logo_white.png') }}" alt="Nexo" class="h-7 w-auto" />
            <span class="sr-only">Nexo Invest</span>
          </a>
          <nav class="flex flex-wrap gap-5 text-sm text-gray-300">
            <a href="#why" class="hover:text-white">Personal</a>
            <a href="#plans" class="hover:text-white">Business</a>
            <a href="#markets" class="hover:text-white">Markets</a>
            <a href="#security" class="hover:text-white">Company</a>
            <a href="{{ route('login') }}" class="rounded-md border border-white/15 px-3 py-1.5 hover:bg-white/10">Log in</a>
            <a href="{{ route('register') }}" class="rounded-md bg-white/90 px-3 py-1.5 font-medium text-black hover:bg-white">Sign up</a>
          </nav>
        </div>

        <hr class="border-white/10" />

        <!-- Link columns -->
        <div class="grid grid-cols-2 gap-8 py-10 md:grid-cols-5">
          <div>
            <h3 class="text-sm font-semibold text-white">Personal</h3>
            <ul class="mt-3 space-y-2 text-sm">
              <li><a class="hover:text-white" href="#">Flexible Savings</a></li>
              <li><a class="hover:text-white" href="#">Fixed-term Savings</a></li>
              <li><a class="hover:text-white" href="#">Credit Line</a></li>
              <li><a class="hover:text-white" href="#">Private Clients</a></li>
              <li><a class="hover:text-white" href="#">Tax Reporting</a></li>
            </ul>
          </div>

          <div>
            <h3 class="text-sm font-semibold text-white">Business</h3>
            <ul class="mt-3 space-y-2 text-sm">
              <li><a class="hover:text-white" href="#">Corporates</a></li>
              <li><a class="hover:text-white" href="#">Institutions</a></li>
              <li><a class="hover:text-white" href="#">White Label</a></li>
              <li><a class="hover:text-white" href="#">Ventures</a></li>
            </ul>
          </div>

          <div>
            <h3 class="text-sm font-semibold text-white">Company</h3>
            <ul class="mt-3 space-y-2 text-sm">
              <li><a class="hover:text-white" href="#">About</a></li>
              <li><a class="hover:text-white" href="#">Security</a></li>
              <li><a class="hover:text-white" href="#">Partnerships</a></li>
              <li><a class="hover:text-white" href="#">News &amp; Insights</a></li>
              <li><a class="hover:text-white" href="#">Help Center</a></li>
              <li><a class="hover:text-white" href="#">Contacts</a></li>
            </ul>
          </div>

          <div>
            <h3 class="text-sm font-semibold text-white">Legal</h3>
            <ul class="mt-3 space-y-2 text-sm">
              <li><a class="hover:text-white" href="#">Privacy Policy</a></li>
              <li><a class="hover:text-white" href="#">Cookies Policy</a></li>
              <li><a class="hover:text-white" href="#">Exchange Terms</a></li>
              <li><a class="hover:text-white" href="#">Services Terms</a></li>
              <li><a class="hover:text-white" href="#">Staking Terms</a></li>
              <li><a class="hover:text-white" href="#">Credit Terms</a></li>
            </ul>
          </div>

          <div>
            <h3 class="text-sm font-semibold text-white">Follow Nexo</h3>
            <div class="mt-3 flex gap-2">
              <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-white/15 hover:bg-white/10" aria-label="X">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M18.9 3H21l-6.5 7.4L22 21h-5.6l-4.4-5.7L6 21H3.9l6.9-7.8L2.5 3H8l4 5.3L18.9 3z"/></svg>
              </a>
              <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-white/15 hover:bg-white/10" aria-label="YouTube">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M23 7.1a4 4 0 0 0-2.8-2.8C18.4 3.8 12 3.8 12 3.8s-6.4 0-8.2.5A4 4 0 0 0 1 7.1 41.8 41.8 0 0 0 0 12a41.8 41.8 0 0 0 1 4.9 4 4 0 0 0 2.8 2.8c1.8.5 8.2.5 8.2.5s6.4 0 8.2-.5A4 4 0 0 0 23 16.9 41.8 41.8 0 0 0 24 12a41.8 41.8 0 0 0-1-4.9zM9.6 15.2V8.8L15.8 12l-6.2 3.2z"/></svg>
              </a>
              <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-white/15 hover:bg-white/10" aria-label="Instagram">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 5.8A4.2 4.2 0 1 0 16.2 12 4.2 4.2 0 0 0 12 7.8zm6-1.6a1.2 1.2 0 1 0 1.2 1.2A1.2 1.2 0 0 0 18 6.2zM12 9.2A2.8 2.8 0 1 1 9.2 12 2.8 2.8 0 0 1 12 9.2z"/></svg>
              </a>
            </div>

            <div class="mt-6 space-y-3">
              <label for="lang" class="block text-sm">Language</label>
              <select id="lang" class="w-full rounded-md border border-white/15 bg-black/60 px-3 py-2 text-sm">
                <option>English</option>
                <option>Deutsch</option>
                <option>Français</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Legal block -->
        <div class="border-t border-white/10 py-6 text-xs leading-relaxed text-gray-400">
          <p>
            All or part of the Nexo Invest services may be unavailable in certain jurisdictions. Nothing herein constitutes investment, tax, or legal advice.
            Performance figures are illustrative and not guaranteed. APY is variable and subject to strategy rules, risk limits, and market conditions.
            Capital is at risk. Please review the applicable terms before using any service.
          </p>
        </div>

        <!-- Bottom bar -->
        <div class="flex flex-col items-start justify-between gap-4 border-t border-white/10 py-6 text-xs text-gray-400 md:flex-row md:items-center">
          <span>© {{ date('Y') }} Nexo</span>
          <div class="flex flex-wrap gap-6">
            <a href="#" class="hover:text-white">Privacy</a>
            <a href="#" class="hover:text-white">Terms</a>
            <a href="#" class="hover:text-white">Cookies</a>
            <a href="#" class="hover:text-white">Sitemap</a>
          </div>
        </div>

      </div>
    </footer>
  </main>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            e.target.classList.remove('opacity-0','translate-y-6');
            e.target.classList.add('opacity-100','translate-y-0');
            observer.unobserve(e.target);
          }
        });
      }, { threshold: 0.15 });
      document.querySelectorAll('[data-animate]').forEach((el) => observer.observe(el));

      // Parallax tilt
      const preferReduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const p = document.querySelector('[data-parallax]');
      if (p && !preferReduce) {
        const onMove = (e) => {
          const r = p.getBoundingClientRect();
          const cx = (e.clientX - (r.left + r.width / 2)) / r.width;
          const cy = (e.clientY - (r.top + r.height / 2)) / r.height;
          p.style.transform = `rotateX(${-cy * 6}deg) rotateY(${cx * 6}deg) translateZ(0)`;
        };
        const reset = () => (p.style.transform = 'rotateX(0) rotateY(0)');
        window.addEventListener('mousemove', onMove);
        window.addEventListener('mouseleave', reset);
      }

      // Count-up for hero stats
      document.querySelectorAll('[data-count]').forEach(el=>{
        const target = Number(el.getAttribute('data-count'));
        const dur = 900, start = performance.now();
        const step = (t)=>{
          const p = Math.min(1, (t - start)/dur);
          el.textContent = (target * p).toLocaleString(undefined,{maximumFractionDigits:0}) + (el.dataset.suffix||'');
          if(p<1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
      });

      // ROI calculator
      const amt = document.getElementById('amt');
      const months = document.getElementById('months');
      const apy = document.getElementById('apy');
      const amtLabel = document.getElementById('amtLabel');
      const monthsLabel = document.getElementById('monthsLabel');
      const finalEl = document.getElementById('final');
      const earningsEl = document.getElementById('earnings');

      function fmt(n){ return n.toLocaleString(undefined,{maximumFractionDigits:0}); }
      function calc(){
        const P = Number(amt.value);
        const m = Number(months.value);
        const r = Number(apy.value);
        const F = P * Math.pow(1 + r/12, m);
        const E = F - P;
        finalEl.textContent = `$${fmt(F)}`;
        earningsEl.textContent = `+ $${fmt(E)} earnings`;
        amtLabel.textContent = `$${fmt(P)}`;
        monthsLabel.textContent = `${m}`;
      }
      [amt, months, apy].forEach(el => el && el.addEventListener('input', calc));
      if (amt && months && apy) calc();


      // Helper: hide skeleton when TV iframe is present
      function hideWhenReady(host, skel){
        if(!host || !skel) return;
        const mo = new MutationObserver(()=>{
          if(host.querySelector('iframe')){ skel.classList.add('hidden'); mo.disconnect(); }
        });
        mo.observe(host, { childList:true, subtree:true });
        // Fallback timeout
        setTimeout(()=> skel.classList.add('hidden'), 4000);
      }

      // Lazy embed TradingView when Markets enters view
      const tvLoaded = { adv:false, mini:false };
      const tvSection = document.querySelector('#markets');
      if (tvSection) {
        const tvObs = new IntersectionObserver((es)=>{
          if(!es[0].isIntersecting) return;
          if(!tvLoaded.adv){
            const s = document.createElement('script');
            s.src = "https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js";
            s.async = true;
            s.innerHTML = JSON.stringify({
              autosize:true, symbol:"COINBASE:BTCUSD", interval:"60", timezone:"Etc/UTC",
              theme:"dark", style:"1", locale:"en", enable_publishing:false,
              allow_symbol_change:true, hide_top_toolbar:false, hide_legend:false
            });
            const advHost = document.querySelector('#tv-adv');
            const advSkel = advHost?.previousElementSibling;
            advHost?.appendChild(s);
            hideWhenReady(advHost, advSkel);
            tvLoaded.adv = true;
          }
          if(!tvLoaded.mini){
            const s2 = document.createElement('script');
            s2.src = "https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js";
            s2.async = true;
            s2.innerHTML = JSON.stringify({
              symbol:"COINBASE:ETHUSD", width:"100%", height:"400", locale:"en",
              dateRange:"1D", colorTheme:"dark", isTransparent:true, autosize:true, largeChartUrl:""
            });
            const miniHost = document.querySelector('#tv-mini');
            const miniSkel = miniHost?.previousElementSibling;
            miniHost?.appendChild(s2);
            hideWhenReady(miniHost, miniSkel);
            tvLoaded.mini = true;
          }
          tvObs.disconnect();
        }, { threshold: 0.15 });
        tvObs.observe(tvSection);
      }

      // Sticky CTA reveal after 60% scroll
      const sticky = document.getElementById('stickyCta');
      const onScroll = () => {
        if (!sticky) return;
        const show = window.scrollY > window.innerHeight * 0.6;
        sticky.classList.toggle('hidden', !show);
        sticky.classList.toggle('flex', show);
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();

      // Support chat open/close
      const openBtn = document.getElementById('chatOpen');
      const panel = document.getElementById('chatPanel');
      const closeBtn = document.getElementById('chatClose');
      if (openBtn && panel && closeBtn) {
        openBtn.addEventListener('click', () => { panel.classList.remove('hidden'); });
        closeBtn.addEventListener('click', () => { panel.classList.add('hidden'); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') panel.classList.add('hidden'); });
      }

      // Mobile menu toggle
      const menuBtn = document.getElementById('menuOpen');
      const mobileNav = document.getElementById('mobileNav');
      if (menuBtn && mobileNav) {
        menuBtn.addEventListener('click', () => {
          const isOpen = !mobileNav.classList.contains('hidden');
          mobileNav.classList.toggle('hidden', isOpen);
          menuBtn.setAttribute('aria-expanded', String(!isOpen));
        });
        document.addEventListener('click', (e) => {
          if (!mobileNav.classList.contains('hidden')) {
            const within = mobileNav.contains(e.target) || menuBtn.contains(e.target);
            if (!within) mobileNav.classList.add('hidden');
          }
        });
      }

      // Header background on scroll
      const navWrap = document.querySelector('header nav > div');
      const onHdr = () => {
        const scrolled = window.scrollY > 10;
        navWrap?.classList.toggle('bg-black/60', scrolled);
        navWrap?.classList.toggle('border-white/10', scrolled);
      };
      window.addEventListener('scroll', onHdr, {passive:true}); onHdr();
    });
  </script>
</body>
</html>
