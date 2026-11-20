<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php
$sumClicks = max(1, (int) $totalClicks);
$pctShopee = round(((int) $totalShopee / $sumClicks) * 100);
$pctTiktok = round(((int) $totalTiktok / $sumClicks) * 100);
$pctWa     = max(0, 100 - $pctShopee - $pctTiktok);

// SVG Donut stroke-dasharray (keliling = 2 * pi * 42 ≈ 263.9)
$circ = 263.9;
$lenShopee = ($pctShopee / 100) * $circ;
$lenTiktok = ($pctTiktok / 100) * $circ;
$lenWa     = ($pctWa / 100) * $circ;
?>

<!-- Welcome Editorial Banner -->
<section class="welcome-banner" aria-label="Sambutan Admin">
  <div>
    <span class="welcome-kicker">✦ LITTLESTU Kidswear Studio · <?= date('d M Y, H:i') ?> WIB</span>
    <h2>Selamat datang, <?= esc(session()->get('admin_name') ?? 'Admin') ?></h2>
    <p>
      Pantau performa koleksi pakaian anak, ubah <em>lookbook</em> secara visual, dan kelola tautan Shopee, TikTok Shop, serta WhatsApp dari satu panel terpadu.
    </p>
  </div>
  <div class="welcome-actions">
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-cream">+ Tambah Koleksi</a>
    <a href="<?= base_url('admin/lookbook') ?>" class="btn btn-glass">Atur Lookbook</a>
  </div>
</section>

<!-- KPI Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon kpi-icon--warm">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      </div>
      <span class="kpi-pill"><?= (int) $activeCount ?> Aktif</span>
    </div>
    <div>
      <span class="kpi-label">Total Koleksi</span>
      <div class="kpi-value"><?= (int) $totalProducts ?></div>
      <p class="kpi-sub"><?= (int) $multiPhotoCount ?> produk punya foto <em>hover</em></p>
    </div>
  </div>

  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon kpi-icon--sky">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
      </div>
      <span class="kpi-pill">Interaksi</span>
    </div>
    <div>
      <span class="kpi-label">Detail Produk Dilihat</span>
      <div class="kpi-value"><?= number_format((int) $totalViews) ?></div>
      <p class="kpi-sub">Total pembukaan modal produk</p>
    </div>
  </div>

  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon kpi-icon--sage">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
      </div>
      <span class="kpi-pill">CTR <?= esc($ctr) ?>%</span>
    </div>
    <div>
      <span class="kpi-label">Total Klik Beli &amp; WA</span>
      <div class="kpi-value"><?= number_format((int) $totalClicks) ?></div>
      <p class="kpi-sub">Konversi ke Shopee, TikTok &amp; WA</p>
    </div>
  </div>

  <div class="kpi-card">
    <div class="kpi-top">
      <div class="kpi-icon kpi-icon--terra">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
      </div>
      <span class="kpi-pill">Komunitas</span>
    </div>
    <div>
      <span class="kpi-label">Pelanggan Newsletter</span>
      <div class="kpi-value"><?= number_format((int) $subscriberCount) ?></div>
      <p class="kpi-sub">Siap ekspor ke CSV / Excel</p>
    </div>
  </div>
</div>

<div class="panel-grid">
  <!-- Kolom Kiri: Produk Terpopuler & Kelengkapan Toko -->
  <div>
    <div class="card">
      <div class="card-head">
        <div>
          <h2>Koleksi Paling Diminati</h2>
          <p class="card-subtitle">Diurutkan berdasarkan jumlah detail produk yang dibuka pengunjung</p>
        </div>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline btn-sm">Semua Produk →</a>
      </div>
      <div class="table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Dilihat</th>
              <th>Shopee</th>
              <th>TikTok</th>
              <th>WhatsApp</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php $maxView = max(1, (int) ($topProducts[0]['views_count'] ?? 1)); ?>
            <?php foreach ($topProducts as $p): ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:12px;">
                    <img src="<?= base_url($p['primary_image']) ?>" alt="" class="thumb" onerror="this.src='<?= base_url('images/placeholder.svg') ?>'" />
                    <div style="min-width:130px;">
                      <strong><?= esc($p['name']) ?></strong>
                      <div style="font-size:0.76rem;color:var(--muted);"><?= esc($p['price_label']) ?></div>
                      <div class="bar-track" style="height:5px;width:110px;">
                        <div class="bar-fill" style="width:<?= round(((int) $p['views_count'] / $maxView) * 100) ?>%;"></div>
                      </div>
                    </div>
                  </div>
                </td>
                <td><strong><?= (int) $p['views_count'] ?></strong></td>
                <td><?= (int) $p['clicks_shopee'] ?></td>
                <td><?= (int) $p['clicks_tiktok'] ?></td>
                <td><span class="badge badge-sage"><?= (int) $p['clicks_wa'] ?></span></td>
                <td>
                  <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>" class="btn btn-outline btn-sm">Ubah</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <div>
          <h2>Kelengkapan Konten Toko</h2>
          <p class="card-subtitle">Ringkasan cepat aset dan konten aktif di halaman publik</p>
        </div>
      </div>
      <div class="form-grid form-grid-2">
        <a href="<?= base_url('admin/lookbook') ?>" style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg);display:flex;justify-content:space-between;align-items:center;">
          <div>
            <strong style="display:block;font-size:0.92rem;">Slide Lookbook &amp; Hotspot</strong>
            <span style="font-size:0.78rem;color:var(--muted);"><?= (int) $lookbookCount ?> slide aktif tampil di beranda</span>
          </div>
          <span class="badge badge-warm">Atur →</span>
        </a>
        <a href="<?= base_url('admin/content') ?>" style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg);display:flex;justify-content:space-between;align-items:center;">
          <div>
            <strong style="display:block;font-size:0.92rem;">Ulasan &amp; Tanya Jawab (FAQ)</strong>
            <span style="font-size:0.78rem;color:var(--muted);"><?= (int) $reviewCount ?> ulasan · <?= (int) $faqCount ?> pertanyaan FAQ</span>
          </div>
          <span class="badge badge-warm">Kelola →</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Grafik Distribusi Channel & Aktivitas -->
  <div>
    <div class="card">
      <div class="card-head">
        <div>
          <h2>Distribusi Klik Channel</h2>
          <p class="card-subtitle">Perbandingan minat beli per kanal</p>
        </div>
      </div>
      <div class="channel-wrap">
        <svg class="donut-svg" viewBox="0 0 110 110" aria-label="Grafik proporsi klik Shopee, TikTok, dan WhatsApp">
          <circle cx="55" cy="55" r="42" fill="none" stroke="#ece2d2" stroke-width="14" />
          <circle cx="55" cy="55" r="42" fill="none" stroke="#a9533b" stroke-width="14"
            stroke-dasharray="<?= $lenShopee ?> <?= $circ ?>" stroke-dashoffset="0" transform="rotate(-90 55 55)" />
          <circle cx="55" cy="55" r="42" fill="none" stroke="#36271c" stroke-width="14"
            stroke-dasharray="<?= $lenTiktok ?> <?= $circ ?>" stroke-dashoffset="-<?= $lenShopee ?>" transform="rotate(-90 55 55)" />
          <circle cx="55" cy="55" r="42" fill="none" stroke="#466140" stroke-width="14"
            stroke-dasharray="<?= $lenWa ?> <?= $circ ?>" stroke-dashoffset="-<?= $lenShopee + $lenTiktok ?>" transform="rotate(-90 55 55)" />
          <text x="55" y="53" text-anchor="middle" font-family="Fraunces, serif" font-size="18" font-weight="600" fill="#36271c"><?= (int) $totalClicks ?></text>
          <text x="55" y="68" text-anchor="middle" font-family="Manrope, sans-serif" font-size="9" font-weight="700" fill="#7a6c5d">TOTAL KLIK</text>
        </svg>

        <div class="channel-legend">
          <div class="legend-row">
            <span class="legend-left"><span class="legend-dot" style="background:#a9533b;"></span> Shopee</span>
            <span><strong><?= (int) $totalShopee ?></strong> (<?= $pctShopee ?>%)</span>
          </div>
          <div class="legend-row">
            <span class="legend-left"><span class="legend-dot" style="background:#36271c;"></span> TikTok Shop</span>
            <span><strong><?= (int) $totalTiktok ?></strong> (<?= $pctTiktok ?>%)</span>
          </div>
          <div class="legend-row">
            <span class="legend-left"><span class="legend-dot" style="background:#466140;"></span> WhatsApp</span>
            <span><strong><?= (int) $totalWa ?></strong> (<?= $pctWa ?>%)</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h2>Ukuran Populer (Kalkulator)</h2>
      </div>
      <?php if (empty($sizeStats)): ?>
        <p style="color:var(--muted);font-size:0.86rem;">Belum ada data pengecekan ukuran dari pengunjung.</p>
      <?php else: ?>
        <?php $maxSizeTotal = max(1, (int) $sizeStats[0]['total']); ?>
        <?php foreach ($sizeStats as $st): ?>
          <div style="margin-bottom:12px;">
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;font-weight:600;">
              <span>Ukuran <?= esc($st['meta']) ?></span>
              <span><?= (int) $st['total'] ?>x dicek</span>
            </div>
            <div class="bar-track">
              <div class="bar-fill" style="width:<?= round(((int) $st['total'] / $maxSizeTotal) * 100) ?>%;"></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="card">
      <div class="card-head">
        <h2>Aktivitas Terbaru</h2>
      </div>
      <?php if (empty($recentEvents)): ?>
        <p style="color:var(--muted);font-size:0.86rem;">Belum ada aktivitas tercatat.</p>
      <?php else: ?>
        <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;">
          <?php
            $evLabels = [
              'product_view' => 'Lihat Produk',
              'click_shopee' => 'Klik Shopee',
              'click_tiktok' => 'Klik TikTok',
              'click_wa'     => 'Klik WhatsApp',
              'size_calc'    => 'Cek Ukuran',
            ];
          ?>
          <?php foreach ($recentEvents as $ev): ?>
            <li style="font-size:0.82rem;padding-bottom:8px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;gap:8px;">
              <span>
                <span class="badge badge-warm" style="margin-right:4px;"><?= esc($evLabels[$ev['event_type']] ?? $ev['event_type']) ?></span>
                <?= $ev['product_name'] ? esc($ev['product_name']) : '' ?>
                <?= $ev['meta'] ? ' (' . esc($ev['meta']) . ')' : '' ?>
              </span>
              <span style="color:var(--muted);white-space:nowrap;"><?= esc(substr((string) $ev['created_at'], 11, 5)) ?> WIB</span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
