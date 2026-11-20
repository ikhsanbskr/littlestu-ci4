<?php
$fallbackImg = base_url('images/placeholder.svg');
$waNumber    = esc($settings['whatsapp_number'] ?? '6281288107710');
$shopeeUrl   = esc($settings['shopee_url'] ?? 'https://id.shp.ee/84ng9Z7B');
$tiktokUrl   = esc($settings['tiktok_url'] ?? 'https://www.tiktok.com/@littlestu.kidswear');
$igUrl       = esc($settings['instagram_url'] ?? 'https://www.instagram.com/littlestu.id');

$imgUrl = static function (?string $path) use ($fallbackImg): string {
    if (! $path) {
        return $fallbackImg;
    }
    if (str_starts_with($path, 'http')) {
        return esc($path);
    }
    return base_url($path);
};
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LITTLESTU — Little Style, Big Personality</title>
    <meta
      name="description"
      content="Katalog pakaian anak pilihan LITTLESTU. Bahan katun lembut, potongan nyaman ukuran S–5L, kalkulator ukuran anak, dan pengiriman ke seluruh Indonesia."
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,600&family=Manrope:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
  </head>
  <body>
    <a class="skip-link" href="#main-content">Langsung ke konten</a>

    <!-- ============ TOP ANNOUNCEMENT BAR ============ -->
    <div class="topbar" role="region" aria-label="Informasi toko">
      <div class="topbar-inner">
        <p class="topbar-text">
          <span class="topbar-dot" aria-hidden="true"></span>
          <?= esc($settings['topbar_text'] ?? 'Koleksi Pakaian Anak Ukuran S–5L • Pengiriman Seluruh Indonesia') ?>
        </p>
        <div class="topbar-links">
          <a href="<?= $shopeeUrl ?>" target="_blank" rel="noopener">Shopee Resmi</a>
          <span aria-hidden="true">·</span>
          <a href="<?= $tiktokUrl ?>" target="_blank" rel="noopener">TikTok Shop</a>
          <span aria-hidden="true">·</span>
          <a href="#size-guide">Kalkulator Ukuran</a>
        </div>
      </div>
    </div>

    <!-- ============ HEADER ============ -->
    <header class="site-header" id="siteHeader">
      <div class="header-inner">
        <a href="#hero" class="logo" aria-label="LITTLESTU beranda">
          <span class="logo-mark">LITTLESTU</span>
          <span class="logo-tag">Kidswear Studio</span>
        </a>

        <nav class="main-nav" id="mainNav" aria-label="Navigasi utama">
          <ul>
            <li><a href="#hero">Beranda</a></li>
            <li><a href="#collection">Lookbook</a></li>
            <li><a href="#new-arrivals">Katalog</a></li>
            <li><a href="#size-guide">Cek Ukuran</a></li>
            <li><a href="#reviews-faq">Ulasan &amp; FAQ</a></li>
            <li><a href="#about">Cerita Kami</a></li>
          </ul>
        </nav>

        <div class="header-actions">
          <button class="icon-btn" id="searchToggle" aria-label="Buka pencarian" aria-expanded="false" aria-controls="searchPanel">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8" />
              <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
          </button>
          <button class="icon-btn" id="favToggle" aria-label="Filter produk favorit (0 item)" aria-pressed="false" title="Lihat produk favorit">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M12 20.5s-7.5-4.6-10-9.4C.5 7.6 2.4 4 6 4c2.1 0 3.6 1.1 4.5 2.3l1.5 2 1.5-2C14.4 5.1 15.9 4 18 4c3.6 0 5.5 3.6 4 7.1-2.5 4.8-10 9.4-10 9.4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
            </svg>
            <span class="fav-count" id="favCount" hidden>0</span>
          </button>
          <a href="<?= $shopeeUrl ?>" target="_blank" rel="noopener" class="btn btn-primary btn-header-cta">
            Belanja Shopee
          </a>
          <button class="icon-btn menu-toggle" id="menuToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="mobileDrawer">
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
          </button>
        </div>
      </div>

      <div class="search-panel" id="searchPanel" hidden>
        <div class="search-panel-inner">
          <label class="visually-hidden" for="searchInput">Cari produk</label>
          <input type="search" id="searchInput" placeholder="Cari nama produk, mis. 'Alicia', 'Jeans', 'Kemeja'…" autocomplete="off" />
          <button class="icon-btn" id="searchClose" aria-label="Tutup pencarian">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <line x1="5" y1="5" x2="19" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
              <line x1="19" y1="5" x2="5" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
          </button>
        </div>
        <p class="search-hint" id="searchResultCount" aria-live="polite"></p>
      </div>
    </header>

    <!-- Mobile drawer -->
    <div class="drawer-backdrop" id="drawerBackdrop" hidden></div>
    <div class="mobile-drawer" id="mobileDrawer" aria-hidden="true">
      <div class="drawer-head">
        <div>
          <span class="logo-mark">LITTLESTU</span>
          <span class="logo-tag">Kidswear Studio</span>
        </div>
        <button class="icon-btn" id="drawerClose" aria-label="Tutup menu">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <line x1="5" y1="5" x2="19" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <line x1="19" y1="5" x2="5" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <nav aria-label="Navigasi mobile">
        <ul>
          <li><a href="#hero">Beranda</a></li>
          <li><a href="#collection">Lookbook &amp; Shop the Look</a></li>
          <li><a href="#categories">Kategori Koleksi</a></li>
          <li><a href="#new-arrivals">Katalog Produk</a></li>
          <li><a href="#size-guide">Kalkulator &amp; Panduan Ukuran</a></li>
          <li><a href="#reviews-faq">Ulasan &amp; Tanya Jawab</a></li>
          <li><a href="#about">Tentang LITTLESTU</a></li>
        </ul>
      </nav>
      <div class="drawer-cta">
        <a href="<?= $shopeeUrl ?>" class="btn btn-primary" target="_blank" rel="noopener">Belanja di Shopee</a>
        <a href="https://wa.me/<?= $waNumber ?>" class="btn btn-outline" target="_blank" rel="noopener">Chat WhatsApp</a>
      </div>
    </div>

    <main id="main-content">
      <!-- ============ HERO EDITORIAL ============ -->
      <section class="hero" id="hero" aria-label="Koleksi terbaru">
        <svg class="hero-deco" viewBox="0 0 600 600" aria-hidden="true">
          <path d="M50,300 C50,150 150,50 300,50 C450,50 550,150 550,300 C550,450 450,550 300,550" fill="none" stroke="currentColor" stroke-width="1" />
          <circle cx="300" cy="300" r="190" fill="none" stroke="currentColor" stroke-width="0.75" stroke-dasharray="4 6" />
        </svg>

        <div class="hero-inner">
          <div class="hero-text reveal">
            <div class="hero-eyebrow">
              <span class="eyebrow-badge"><?= esc($settings['hero_badge'] ?? 'Koleksi Pilihan 2026') ?></span>
              <span class="eyebrow-note"><?= esc($settings['hero_note'] ?? 'Edisi Harian & Akhir Pekan') ?></span>
            </div>

            <h1 class="hero-title">
              Little Style,<br />
              <em>Big Personality.</em>
            </h1>

            <p class="hero-sub">
              <?= esc($settings['hero_subtitle'] ?? '') ?>
            </p>

            <div class="hero-actions">
              <a href="#new-arrivals" class="btn btn-primary">
                Lihat Katalog
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
              <a href="#size-guide" class="btn btn-ghost">Cek Ukuran Anak</a>
            </div>

            <dl class="hero-metrics" aria-label="Ringkasan koleksi LITTLESTU">
              <div class="hero-metric">
                <dt>Rentang Ukuran</dt>
                <dd>S – 5L</dd>
              </div>
              <div class="hero-metric">
                <dt>Penilaian Pembeli</dt>
                <dd>★ 4.9 / 5.0</dd>
              </div>
              <div class="hero-metric">
                <dt>Koleksi Aktif</dt>
                <dd><?= count($products) ?> Model</dd>
              </div>
            </dl>
          </div>

          <div class="hero-stage reveal">
            <div class="hero-media-main">
              <img
                src="<?= $imgUrl($settings['hero_image'] ?? 'images/zula3.jpeg') ?>"
                alt="Anak mengenakan koleksi pakaian terbaru LITTLESTU"
                width="640"
                height="760"
                onerror="this.src='<?= $fallbackImg ?>'"
              />
              <button type="button" class="hero-photo-tag js-open-by-id" data-target-id="zula-tops">
                <span class="photo-tag-kicker">Featured Look · Klik Detail</span>
                <strong>Zula &amp; Kania Series →</strong>
              </button>
            </div>

            <?php if ($heroFloatProduct): ?>
            <button type="button" class="hero-media-float js-open-by-id" data-target-id="<?= esc($heroFloatProduct['slug']) ?>">
              <img
                src="<?= $imgUrl($heroFloatProduct['secondary_image'] ?: $heroFloatProduct['primary_image']) ?>"
                alt="<?= esc($heroFloatProduct['name']) ?>"
                width="320"
                height="320"
                onerror="this.src='<?= $fallbackImg ?>'"
              />
              <div class="float-caption">
                <span><?= esc($heroFloatProduct['name']) ?></span>
                <strong>Rp<?= number_format((int) $heroFloatProduct['price_min'], 0, ',', '.') ?></strong>
              </div>
            </button>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <!-- ============ KEUNGGULAN ============ -->
      <section class="perks" aria-label="Keunggulan LITTLESTU">
        <div class="perks-wrap">
          <ul class="perks-list">
            <li class="perk-item reveal">
              <div class="perk-top">
                <span class="perk-num">01 / MATERIAL</span>
                <span class="perk-icon">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 3c4.5 3.5 7 7.2 7 11a7 7 0 0 1-14 0c0-3.8 2.5-7.5 7-11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                  </svg>
                </span>
              </div>
              <div>
                <h3>Bahan Katun &amp; Denim Ringan</h3>
                <p>Lembut, menyerap keringat, dan aman untuk kulit sensitif anak saat beraktivitas di dalam maupun luar ruangan.</p>
              </div>
            </li>
            <li class="perk-item reveal">
              <div class="perk-top">
                <span class="perk-num">02 / SILUET</span>
                <span class="perk-icon">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 3l2.4 5.3L20 9l-4 3.9.9 5.6-4.9-2.7-4.9 2.7.9-5.6-4-3.9 5.6-.7L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                  </svg>
                </span>
              </div>
              <div>
                <h3>Potongan Timeless &amp; Mudah Dipadukan</h3>
                <p>Warna hangat dan desain minimalis ala Korea yang mudah dipadupadankan untuk gaya kasual hingga acara keluarga.</p>
              </div>
            </li>
            <li class="perk-item reveal">
              <div class="perk-top">
                <span class="perk-num">03 / LAYANAN</span>
                <span class="perk-icon">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M3 7h11v9H3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                    <path d="M14 10h4l3 3v3h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                    <circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6" />
                    <circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6" />
                  </svg>
                </span>
              </div>
              <div>
                <h3>Pengiriman Cepat ke Seluruh Indonesia</h3>
                <p>Dikemas rapi dan tersedia melalui Shopee, TikTok Shop, serta pemesanan maupun konsultasi ukuran lewat WhatsApp.</p>
              </div>
            </li>
          </ul>
        </div>
      </section>

      <!-- ============ KATEGORI KOLEKSI ============ -->
      <section class="categories" id="categories" aria-label="Kategori produk">
        <div class="section-head">
          <div>
            <p class="section-eyebrow">Eksplorasi Gaya</p>
            <h2>Pilih Berdasarkan Kategori</h2>
          </div>
          <p class="section-note">Klik kategori untuk menyaring katalog di bawah</p>
        </div>

        <ul class="category-scroll" id="categoryScroll">
          <li>
            <button class="category-item" data-filter="all" aria-pressed="true">
              <span class="category-ring"><img src="<?= base_url('images/littlestu.jpeg') ?>" alt="Semua" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" /></span>
              <span class="category-label">Semua</span>
              <span class="category-sub"><?= count($products) ?> Koleksi</span>
            </button>
          </li>
          <li>
            <button class="category-item" data-filter="girls" aria-pressed="false">
              <span class="category-ring"><img src="<?= base_url('images/alicia.jpeg') ?>" alt="Girls" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" /></span>
              <span class="category-label">Girls</span>
              <span class="category-sub">Atasan &amp; Set</span>
            </button>
          </li>
          <li>
            <button class="category-item" data-filter="boys" aria-pressed="false">
              <span class="category-ring"><img src="<?= base_url('images/kania3.jpeg') ?>" alt="Boys & Unisex" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" /></span>
              <span class="category-label">Boys &amp; Unisex</span>
              <span class="category-sub">Kemeja &amp; Denim</span>
            </button>
          </li>
          <li>
            <button class="category-item" data-filter="tops" aria-pressed="false">
              <span class="category-ring"><img src="<?= base_url('images/jiwoo2.jpeg') ?>" alt="Tops" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" /></span>
              <span class="category-label">Tops</span>
              <span class="category-sub">Kemeja &amp; Blus</span>
            </button>
          </li>
          <li>
            <button class="category-item" data-filter="bottoms" aria-pressed="false">
              <span class="category-ring"><img src="<?= base_url('images/haenim2.jpeg') ?>" alt="Bottoms" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" /></span>
              <span class="category-label">Bottoms</span>
              <span class="category-sub">Jeans &amp; Skort</span>
            </button>
          </li>
          <li>
            <button class="category-item" data-filter="setelan" aria-pressed="false">
              <span class="category-ring"><img src="<?= base_url('images/maruset.jpeg') ?>" alt="Setelan" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" /></span>
              <span class="category-label">Setelan</span>
              <span class="category-sub">One-Set &amp; Overall</span>
            </button>
          </li>
        </ul>
      </section>

      <!-- ============ EDITORIAL LOOKBOOK (SHOP THE LOOK HOTSPOTS) ============ -->
      <?php if (! empty($slides)): ?>
      <section class="featured" id="collection" aria-label="Lookbook pilihan">
        <div class="section-head">
          <div>
            <p class="section-eyebrow">Editorial Lookbook · Shop The Look</p>
            <h2>Inspirasi Padu Padan Si Kecil</h2>
          </div>
          <p class="section-note">Klik titik <strong>+</strong> pada foto untuk melihat produk yang dikenakan</p>
        </div>

        <div class="featured-bento">
          <div class="featured-slider" id="featuredSlider">
            <div class="featured-track">
              <?php foreach ($slides as $slide): ?>
                <?php $hotspots = json_decode($slide['hotspots'] ?? '[]', true) ?: []; ?>
                <div class="featured-slide">
                  <img
                    src="<?= $imgUrl($slide['image']) ?>"
                    alt="<?= esc($slide['title']) ?>"
                    width="900"
                    height="700"
                    onerror="this.src='<?= $fallbackImg ?>'"
                  />
                  <?php foreach ($hotspots as $hs): ?>
                    <button
                      type="button"
                      class="hotspot-pin js-open-by-id"
                      style="top: <?= (int) ($hs['top'] ?? 40) ?>%; left: <?= (int) ($hs['left'] ?? 50) ?>%"
                      data-target-id="<?= esc($hs['slug'] ?? '') ?>"
                      aria-label="Lihat produk <?= esc($hs['label'] ?? '') ?>"
                    >
                      <span class="hotspot-plus">+</span>
                      <span class="hotspot-label"><?= esc($hs['label'] ?? '') ?></span>
                    </button>
                  <?php endforeach; ?>

                  <div class="featured-content">
                    <span class="featured-pill"><?= esc($slide['pill_label']) ?></span>
                    <h3><?= esc($slide['title']) ?></h3>
                    <p><?= esc($slide['description']) ?></p>
                    <?php if (! empty($hotspots)): ?>
                      <div class="featured-look-items">
                        <?php foreach ($hotspots as $hs): ?>
                          <button type="button" class="look-chip js-open-by-id" data-target-id="<?= esc($hs['slug'] ?? '') ?>">
                            <?= esc(explode('·', (string) ($hs['label'] ?? ''))[0]) ?> →
                          </button>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <button type="button" class="featured-arrow featured-arrow--prev" aria-label="Slide sebelumnya">‹</button>
            <button type="button" class="featured-arrow featured-arrow--next" aria-label="Slide berikutnya">›</button>

            <div class="featured-dots" role="tablist" aria-label="Navigasi slide lookbook">
              <?php foreach ($slides as $idx => $s): ?>
                <button type="button" class="<?= $idx === 0 ? 'active' : '' ?>" aria-label="Buka slide <?= $idx + 1 ?>"></button>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="featured-side">
            <article class="lookbook-card reveal">
              <img src="<?= base_url('images/alicia4.jpeg') ?>" alt="Alicia Knit & Pleated Set" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" />
              <div class="lookbook-card-overlay">
                <span class="lookbook-tag">Setelan Favorit</span>
                <h3>Alicia Knit &amp; Pleated Skirt</h3>
                <p>Rp108.000 – Rp138.000 · Ukuran S–4L</p>
                <button type="button" class="lookbook-btn js-open-by-id" data-target-id="alicia-set">Lihat Detail Setelan →</button>
              </div>
            </article>

            <article class="lookbook-card reveal">
              <img src="<?= base_url('images/clarisa2.jpeg') ?>" alt="Clarisa Top & Skort Pairing" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" />
              <div class="lookbook-card-overlay">
                <span class="lookbook-tag">Monochrome Chic</span>
                <h3>Clarisa Top &amp; Skort Pairing</h3>
                <p>Rp169.000 · Bahan Adem &amp; Ringan</p>
                <button type="button" class="lookbook-btn js-open-by-id" data-target-id="clarisa-top">Lihat Detail Atasan →</button>
              </div>
            </article>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <!-- ============ PRODUK PILIHAN (KATALOG UTAMA) ============ -->
      <section class="products" id="new-arrivals" aria-label="Katalog produk">
        <div class="section-head products-head">
          <div>
            <p class="section-eyebrow">Katalog Lengkap</p>
            <h2>Koleksi Pilihan LITTLESTU</h2>
          </div>
          <p class="section-note" id="filterNote" aria-live="polite">
            Menampilkan semua produk (<?= count($products) ?> koleksi)
          </p>
        </div>

        <div class="catalog-toolbar" role="toolbar" aria-label="Penyaring dan pengurutan katalog">
          <div class="filter-pills" id="filterPills">
            <button type="button" class="filter-pill is-active" data-pill="all">Semua Koleksi</button>
            <button type="button" class="filter-pill" data-pill="setelan">Setelan &amp; Jumpsuit</button>
            <button type="button" class="filter-pill" data-pill="tops">Atasan &amp; Kemeja</button>
            <button type="button" class="filter-pill" data-pill="bottoms">Celana &amp; Rok</button>
            <button type="button" class="filter-pill" data-pill="boys">Boys &amp; Unisex</button>
            <button type="button" class="filter-pill filter-pill--fav" data-pill="favorites" id="favFilterPill">♥ Favorit Saya</button>
          </div>

          <div class="catalog-sort">
            <label for="sortSelect" class="sort-label">Urutkan:</label>
            <select id="sortSelect" class="sort-select" aria-label="Urutkan daftar produk">
              <option value="default">Pilihan Utama</option>
              <option value="price-asc">Harga: Terendah – Tertinggi</option>
              <option value="price-desc">Harga: Tertinggi – Terendah</option>
              <option value="name-asc">Nama Produk: A – Z</option>
            </select>
          </div>
        </div>

        <div class="product-grid" id="productGrid">
          <?php foreach ($products as $index => $p): ?>
            <?php
              $colors  = json_decode($p['colors'] ?? '[]', true) ?: [];
              $gallery = json_decode($p['gallery_images'] ?? '[]', true) ?: [$p['primary_image']];
              $galleryUrls = array_map(static fn ($g) => $imgUrl($g), $gallery);
              $colorsWithUrl = array_map(static function ($c) use ($imgUrl) {
                  $c['image'] = $imgUrl($c['image'] ?? '');
                  return $c;
              }, $colors);
            ?>
            <article
              class="product-card"
              data-id="<?= esc($p['slug']) ?>"
              data-order="<?= $index + 1 ?>"
              data-price-num="<?= (int) $p['price_min'] ?>"
              data-pair-slugs='<?= esc($p['pair_slugs'] ?? '[]', 'attr') ?>'
              data-category="<?= esc($p['category']) ?>"
              data-name="<?= esc(strtolower($p['name'] . ' ' . $p['category_label'])) ?>"
            >
              <div class="product-media">
                <?php if (! empty($p['badge'])): ?>
                  <span class="product-badge <?= $p['badge_style'] === 'sage' ? 'product-badge--sage' : '' ?>">
                    <?= esc($p['badge']) ?>
                  </span>
                <?php endif; ?>

                <img
                  class="img-primary"
                  src="<?= $imgUrl($p['primary_image']) ?>"
                  alt="<?= esc($p['name']) ?>"
                  loading="lazy"
                  width="500"
                  height="620"
                  onerror="this.src='<?= $fallbackImg ?>'"
                />
                <?php if (! empty($p['secondary_image'])): ?>
                  <img
                    class="img-secondary"
                    src="<?= $imgUrl($p['secondary_image']) ?>"
                    alt=""
                    loading="lazy"
                    width="500"
                    height="620"
                    aria-hidden="true"
                    onerror="this.style.display='none'"
                  />
                <?php endif; ?>

                <button class="fav-btn" aria-label="Tambahkan <?= esc($p['name']) ?> ke favorit" aria-pressed="false">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 20.5s-7.5-4.6-10-9.4C.5 7.6 2.4 4 6 4c2.1 0 3.6 1.1 4.5 2.3l1.5 2 1.5-2C14.4 5.1 15.9 4 18 4c3.6 0 5.5 3.6 4 7.1-2.5 4.8-10 9.4-10 9.4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                  </svg>
                </button>
              </div>

              <div class="product-info">
                <div class="product-meta">
                  <span class="product-cat"><?= esc($p['category_label']) ?> · <?= esc($p['size_note']) ?></span>
                </div>
                <h3><?= esc($p['name']) ?></h3>
                <p class="product-price"><?= esc($p['price_label']) ?></p>

                <div class="product-footer">
                  <div class="color-dots" role="group" aria-label="Pilihan warna <?= esc($p['name']) ?>">
                    <?php foreach ($colorsWithUrl as $cIdx => $c): ?>
                      <button
                        type="button"
                        class="dot <?= $cIdx === 0 ? 'is-active' : '' ?>"
                        style="--dot: <?= esc($c['hex']) ?>"
                        title="<?= esc($c['name']) ?>"
                        aria-label="Pilih warna <?= esc($c['name']) ?>"
                        data-swatch-img="<?= esc($c['image']) ?>"
                      ></button>
                    <?php endforeach; ?>
                  </div>
                  <a
                    href="#"
                    class="btn btn-outline btn-sm js-product-detail"
                    data-id="<?= esc($p['slug']) ?>"
                    data-name="<?= esc($p['name']) ?>"
                    data-price="<?= esc($p['price_label']) ?>"
                    data-images='<?= esc(json_encode($galleryUrls), 'attr') ?>'
                    data-colors='<?= esc(json_encode($colorsWithUrl), 'attr') ?>'
                    data-size="<?= esc($p['size_note']) ?>"
                    data-sizes="<?= esc($p['sizes_available']) ?>"
                    data-desc="<?= esc($p['description']) ?>"
                    data-shopee="<?= esc($p['shopee_url'] ?: $shopeeUrl) ?>"
                    data-tiktok="<?= esc($p['tiktok_url'] ?: $tiktokUrl) ?>"
                  >Lihat Detail</a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <div class="no-results" id="noResults" hidden>
          <p class="no-results-title">Koleksi belum ditemukan</p>
          <p class="no-results-sub">Coba kata kunci lain atau tampilkan kembali seluruh katalog.</p>
          <button type="button" class="btn btn-outline" id="resetFilterBtn">Tampilkan Semua Produk</button>
        </div>
      </section>

      <!-- ============ PROMO EDITORIAL BANNER ============ -->
      <section class="promo reveal" aria-label="Penawaran spesial">
        <div class="promo-grid">
          <div class="promo-copy">
            <span class="promo-kicker"><?= esc($settings['promo_kicker'] ?? 'Penawaran Toko Resmi') ?></span>
            <h2><?= esc($settings['promo_title'] ?? 'Voucher & Harga Spesial di Marketplace Resmi') ?></h2>
            <p><?= esc($settings['promo_desc'] ?? '') ?></p>
            <div class="promo-actions">
              <a href="<?= $shopeeUrl ?>" target="_blank" rel="noopener" class="btn btn-primary">Kunjungi Shopee</a>
              <a href="<?= $tiktokUrl ?>" target="_blank" rel="noopener" class="btn btn-ghost-light">Buka TikTok Shop</a>
            </div>
          </div>

          <div class="promo-visual" aria-hidden="true">
            <img src="<?= base_url('images/zula2.jpeg') ?>" alt="" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" />
            <img src="<?= base_url('images/jiwoo2.jpeg') ?>" alt="" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" />
          </div>
        </div>
      </section>

      <!-- ============ KALKULATOR & PANDUAN UKURAN ============ -->
      <section class="size-guide" id="size-guide" aria-label="Kalkulator dan panduan ukuran anak">
        <div class="section-head">
          <div>
            <p class="section-eyebrow">Smart Size Finder</p>
            <h2>Kalkulator &amp; Panduan Ukuran Anak</h2>
          </div>
          <p class="section-note">Masukkan tinggi dan berat badan si kecil untuk rekomendasi instan</p>
        </div>

        <div class="size-guide-inner">
          <div class="size-calc-card reveal">
            <div class="size-calc-head">
              <span class="calc-badge">Rekomendasi Otomatis</span>
              <h3>Cek Ukuran Terbaik Si Kecil</h3>
              <p>Sesuaikan dengan postur anak agar nyaman dipakai bergerak seharian.</p>
            </div>

            <form id="sizeCalcForm" class="size-calc-form" novalidate>
              <div class="calc-row">
                <div class="calc-field">
                  <label for="calcAge">Usia Anak (Tahun)</label>
                  <input type="number" id="calcAge" min="1" max="14" step="1" value="4" />
                </div>
                <div class="calc-field">
                  <label for="calcWeight">Berat Badan (kg)</label>
                  <input type="number" id="calcWeight" min="8" max="45" step="0.5" value="17" />
                </div>
                <div class="calc-field">
                  <label for="calcHeight">Tinggi Badan (cm)</label>
                  <input type="number" id="calcHeight" min="75" max="155" step="1" value="104" />
                </div>
              </div>

              <div class="calc-fit-row" role="radiogroup" aria-label="Preferensi potongan pakaian">
                <span class="calc-fit-label">Preferensi Potongan:</span>
                <div class="calc-fit-options">
                  <label class="fit-chip">
                    <input type="radio" name="fitPref" value="regular" checked />
                    <span>Pas di Badan (Regular)</span>
                  </label>
                  <label class="fit-chip">
                    <input type="radio" name="fitPref" value="loose" />
                    <span>Agak Longgar (+1 Size)</span>
                  </label>
                </div>
              </div>
            </form>

            <div class="size-calc-result" id="sizeCalcResult" aria-live="polite">
              <div class="result-badge-wrap">
                <span class="result-kicker">Rekomendasi Kami</span>
                <strong class="result-size" id="calcResultSize">Ukuran L</strong>
              </div>
              <div class="result-body">
                <p class="result-desc" id="calcResultDesc"></p>
                <a href="https://wa.me/<?= $waNumber ?>" target="_blank" rel="noopener" class="result-wa-link" id="calcWaLink">
                  Konsultasikan ukuran ini via WhatsApp →
                </a>
              </div>
            </div>
          </div>

          <div class="size-table-card reveal">
            <div class="size-table-wrap">
              <table class="size-table">
                <caption>Tabel Referensi Standar LITTLESTU (S – 5L)</caption>
                <thead>
                  <tr>
                    <th scope="col">Ukuran</th>
                    <th scope="col">Estimasi Usia</th>
                    <th scope="col">Tinggi Badan</th>
                    <th scope="col">Berat Badan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sizeGuides as $sg): ?>
                    <tr data-size-row="<?= esc($sg['size_code']) ?>">
                      <td><strong><?= esc($sg['size_code']) ?></strong></td>
                      <td><?= esc($sg['age_range']) ?></td>
                      <td><?= esc($sg['height_range']) ?></td>
                      <td><?= esc($sg['weight_range']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <p class="size-table-note">*Baris yang disorot menyesuaikan hasil kalkulator di samping. Toleransi jahitan 1–2 cm.</p>
          </div>
        </div>
      </section>

      <!-- ============ ULASAN & FAQ ============ -->
      <section class="reviews-faq" id="reviews-faq" aria-label="Ulasan pelanggan dan tanya jawab">
        <div class="reviews-faq-inner">
          <div class="reviews-block reveal">
            <p class="section-eyebrow">Kata Orang Tua · ★ 4.9/5.0</p>
            <h2>Dipercaya Ibu &amp; Si Kecil</h2>
            <p class="reviews-intro">Ulasan asli dari orang tua yang telah berbelanja melalui toko resmi LITTLESTU.</p>

            <div class="reviews-list">
              <?php foreach ($reviews as $rev): ?>
                <article class="review-card">
                  <div class="review-top">
                    <span class="review-stars" aria-label="Rating <?= (int) $rev['rating'] ?> dari 5"><?= str_repeat('★', (int) $rev['rating']) ?></span>
                    <span class="review-tag"><?= esc($rev['product_tag']) ?></span>
                  </div>
                  <p class="review-quote">“<?= esc($rev['quote']) ?>”</p>
                  <footer class="review-author">
                    <strong><?= esc($rev['author_name']) ?></strong> · <?= esc($rev['city']) ?>
                  </footer>
                </article>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="faq-block reveal" id="faq">
            <p class="section-eyebrow">Tanya Jawab (FAQ)</p>
            <h2>Informasi Pemesanan &amp; Perawatan</h2>
            <p class="reviews-intro">Jawaban singkat untuk pertanyaan yang paling sering diajukan sebelum memesan.</p>

            <div class="faq-list">
              <?php foreach ($faqs as $fIdx => $faq): ?>
                <div class="faq-item">
                  <button type="button" class="faq-question" aria-expanded="<?= $fIdx === 0 ? 'true' : 'false' ?>">
                    <span><?= esc($faq['question']) ?></span>
                    <span class="faq-icon" aria-hidden="true"><?= $fIdx === 0 ? '–' : '+' ?></span>
                  </button>
                  <div class="faq-answer <?= $fIdx === 0 ? 'is-open' : '' ?>">
                    <p><?= esc($faq['answer']) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>

      <!-- ============ TENTANG BRAND ============ -->
      <section class="about" id="about" aria-label="Tentang LITTLESTU">
        <div class="about-inner">
          <div class="about-collage reveal">
            <div class="about-photo-main">
              <img src="<?= base_url('images/alicia.jpeg') ?>" alt="Koleksi pakaian LITTLESTU" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" />
            </div>
            <div class="about-photo-sub" aria-hidden="true">
              <img src="<?= base_url('images/littlestu.jpeg') ?>" alt="" loading="lazy" onerror="this.src='<?= $fallbackImg ?>'" />
            </div>
          </div>

          <div class="about-text reveal">
            <p class="section-eyebrow">Cerita LITTLESTU</p>
            <h2><?= esc($settings['about_title'] ?? 'Dibuat untuk Anak yang Aktif Bergerak') ?></h2>
            <blockquote class="about-quote"><?= esc($settings['about_quote'] ?? '') ?></blockquote>
            <p><?= esc($settings['about_desc'] ?? '') ?></p>
            <div class="about-links">
              <a href="<?= $igUrl ?>" target="_blank" rel="noopener" class="btn btn-outline">Ikuti @littlestu.id</a>
              <a href="<?= $tiktokUrl ?>" target="_blank" rel="noopener" class="btn btn-ghost">TikTok @littlestu.kidswear</a>
            </div>
          </div>
        </div>
      </section>

      <!-- ============ NEWSLETTER ============ -->
      <section class="newsletter reveal" aria-label="Berlangganan kabar terbaru">
        <div class="newsletter-inner">
          <span class="section-eyebrow">Kabar Koleksi Baru</span>
          <h2>Join Our Little Family</h2>
          <p>Daftarkan email kamu untuk mendapatkan info rilis koleksi baru dan penawaran eksklusif lebih dulu.</p>
          <form id="newsletterForm" novalidate>
            <div class="newsletter-field">
              <label class="visually-hidden" for="newsletterEmail">Alamat email</label>
              <input type="email" id="newsletterEmail" name="email" placeholder="Masukkan alamat email kamu…" autocomplete="email" required />
              <button type="submit" class="btn btn-primary">Berlangganan</button>
            </div>
            <p class="form-message" id="newsletterMessage" role="alert" aria-live="polite"></p>
          </form>
        </div>
      </section>
    </main>

    <!-- ============ FOOTER ============ -->
    <footer class="site-footer" id="footer">
      <div class="footer-top">
        <div class="footer-brand">
          <span class="logo-mark">LITTLESTU</span>
          <p>Pakaian anak pilihan yang nyaman, lembut di kulit, dan penuh karakter untuk menemani tumbuh kembang si kecil.</p>
          <div class="footer-social" aria-label="Media sosial LITTLESTU">
            <a href="<?= $igUrl ?>" aria-label="Instagram LITTLESTU" target="_blank" rel="noopener">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.5" /><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" /><circle cx="17.2" cy="6.8" r="1" fill="currentColor" /></svg>
            </a>
            <a href="<?= $tiktokUrl ?>" aria-label="TikTok LITTLESTU" target="_blank" rel="noopener">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M14 4v10.2a3.2 3.2 0 1 1-2.4-3.1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><path d="M14 4c.4 2 2 3.5 4 3.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /></svg>
            </a>
            <a href="https://wa.me/<?= $waNumber ?>" aria-label="WhatsApp LITTLESTU" target="_blank" rel="noopener">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 20l1.3-3.8A8 8 0 1 1 8.8 19L4 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" /></svg>
            </a>
          </div>
        </div>

        <div class="footer-col">
          <button class="footer-col-toggle" aria-expanded="false">Kategori Koleksi</button>
          <ul class="footer-col-list">
            <li><a href="#new-arrivals" data-footer-filter="girls">Girls Collection</a></li>
            <li><a href="#new-arrivals" data-footer-filter="boys">Boys &amp; Unisex</a></li>
            <li><a href="#new-arrivals" data-footer-filter="tops">Atasan &amp; Kemeja</a></li>
            <li><a href="#new-arrivals" data-footer-filter="bottoms">Celana &amp; Skort</a></li>
            <li><a href="#new-arrivals" data-footer-filter="setelan">Setelan &amp; Jumpsuit</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <button class="footer-col-toggle" aria-expanded="false">Bantuan Pelanggan</button>
          <ul class="footer-col-list">
            <li><a href="https://wa.me/<?= $waNumber ?>" target="_blank" rel="noopener">Chat WhatsApp</a></li>
            <li><a href="#size-guide">Kalkulator Ukuran (S–5L)</a></li>
            <li><a href="#reviews-faq">Ulasan &amp; Tanya Jawab</a></li>
            <li><a href="#collection">Lookbook Padu Padan</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <button class="footer-col-toggle" aria-expanded="false">Toko Resmi</button>
          <ul class="footer-col-list">
            <li><a href="<?= $shopeeUrl ?>" target="_blank" rel="noopener">Shopee Official</a></li>
            <li><a href="<?= $tiktokUrl ?>" target="_blank" rel="noopener">TikTok Shop</a></li>
            <li><a href="<?= $igUrl ?>" target="_blank" rel="noopener">Instagram @littlestu.id</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <p>
          © <span id="footerYear"></span> LITTLESTU. Semua hak dilindungi.
          <a href="<?= base_url('admin') ?>" class="footer-admin-link">Admin</a>
        </p>
      </div>
    </footer>

    <button class="back-to-top" id="backToTop" aria-label="Kembali ke atas" hidden>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 19V5M6 11l6-6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" /></svg>
    </button>

    <div class="toast" id="toast" role="status" aria-live="polite" hidden></div>

    <!-- ============ PRODUCT DETAIL MODAL ============ -->
    <div class="product-modal-overlay" id="productModalOverlay" hidden></div>
    <div class="product-modal" id="productModal" role="dialog" aria-modal="true" aria-labelledby="productModalTitle" aria-hidden="true" hidden>
      <div class="product-modal-sheet">
        <button type="button" class="product-modal-close" id="productModalClose" aria-label="Tutup detail produk">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <line x1="5" y1="5" x2="19" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <line x1="19" y1="5" x2="5" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
          </svg>
        </button>

        <div class="product-modal-layout">
          <div class="product-modal-slider" id="productModalSlider">
            <div class="product-modal-track" id="productModalTrack"></div>
            <button type="button" class="slider-arrow slider-arrow--prev" id="sliderPrev" aria-label="Foto sebelumnya">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M14.5 5 8 12l6.5 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
            </button>
            <button type="button" class="slider-arrow slider-arrow--next" id="sliderNext" aria-label="Foto berikutnya">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9.5 5 16 12l-6.5 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
            </button>
            <div class="slider-dots" id="sliderDots" role="tablist" aria-label="Pilih foto produk"></div>
          </div>

          <div class="product-modal-body">
            <span class="modal-kicker">Detail Koleksi LITTLESTU</span>
            <h2 class="product-modal-title" id="productModalTitle"></h2>
            <p class="product-modal-price" id="productModalPrice"></p>

            <div class="modal-option-group">
              <span class="modal-option-label">Pilih Warna:</span>
              <div class="product-modal-colors" id="productModalColors" role="group" aria-label="Warna tersedia"></div>
            </div>

            <div class="modal-option-group">
              <div class="modal-option-head">
                <span class="modal-option-label">Pilih Ukuran:</span>
                <span class="product-modal-size" id="productModalSize"></span>
              </div>
              <div class="product-modal-sizes" id="productModalSizes" role="group" aria-label="Ukuran tersedia"></div>
            </div>

            <p class="product-modal-desc" id="productModalDesc"></p>

            <div class="modal-pair-box" id="modalPairBox" hidden>
              <span class="modal-option-label">Cocok Dipadukan Dengan (Mix &amp; Match):</span>
              <div class="modal-pair-list" id="modalPairList"></div>
            </div>

            <div class="product-modal-actions">
              <div class="modal-actions-row">
                <a href="#" class="btn btn-primary" id="productModalShopee" target="_blank" rel="noopener noreferrer">Beli di Shopee</a>
                <a href="#" class="btn btn-outline" id="productModalTiktok" target="_blank" rel="noopener noreferrer">TikTok Shop</a>
              </div>
              <a href="#" class="btn btn-wa" id="productModalWa" target="_blank" rel="noopener noreferrer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 20l1.3-3.8A8 8 0 1 1 8.8 19L4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" /></svg>
                <span id="productModalWaText">Pesan / Tanya Stok via WhatsApp</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      window.LITTLESTU_CONFIG = {
        baseUrl: <?= json_encode(rtrim(base_url(), '/') . '/') ?>,
        whatsappNumber: <?= json_encode($waNumber) ?>,
        shopeeUrl: <?= json_encode($shopeeUrl) ?>,
        tiktokUrl: <?= json_encode($tiktokUrl) ?>,
        fallbackImg: <?= json_encode($fallbackImg) ?>,
      };
      window.LITTLESTU_SIZE_TIERS = <?= json_encode(array_map(static fn ($sg) => [
          'code'      => $sg['size_code'],
          'ageLabel'  => $sg['age_range'],
          'maxHeight' => (int) $sg['max_height'],
          'maxWeight' => (int) $sg['max_weight'],
          'maxAge'    => (int) $sg['max_age'],
      ], $sizeGuides)) ?>;
    </script>
    <script src="<?= base_url('js/script.js') ?>"></script>
  </body>
</html>
