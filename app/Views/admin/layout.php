<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($pageTitle ?? 'Dashboard') ?> — LITTLESTU Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>" />
</head>
<body>
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
  <div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Menu Admin">
      <div class="sidebar-logo">
        <div>
          <strong>LITTLESTU</strong>
          <span>Admin</span>
        </div>
      </div>

      <nav class="sidebar-nav">
        <span class="nav-section-label">Utama</span>
        <a href="<?= base_url('admin') ?>" class="nav-link <?= ($activeNav ?? '') === 'dashboard' ? 'is-active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="9" rx="2"/><rect x="14" y="3" width="7" height="5" rx="2"/><rect x="14" y="12" width="7" height="9" rx="2"/><rect x="3" y="16" width="7" height="5" rx="2"/></svg>
          Ringkasan Toko
        </a>
        <a href="<?= base_url('admin/products') ?>" class="nav-link <?= ($activeNav ?? '') === 'products' ? 'is-active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
          Katalog Produk
        </a>

        <span class="nav-section-label">Visual &amp; Konten</span>
        <a href="<?= base_url('admin/lookbook') ?>" class="nav-link <?= ($activeNav ?? '') === 'lookbook' ? 'is-active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/></svg>
          Lookbook &amp; Hotspot
        </a>
        <a href="<?= base_url('admin/content') ?>" class="nav-link <?= ($activeNav ?? '') === 'content' ? 'is-active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          Ulasan, FAQ &amp; Ukuran
        </a>

        <span class="nav-section-label">Pelanggan &amp; Toko</span>
        <a href="<?= base_url('admin/subscribers') ?>" class="nav-link <?= ($activeNav ?? '') === 'subscribers' ? 'is-active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          Pelanggan Newsletter
        </a>
        <a href="<?= base_url('admin/settings') ?>" class="nav-link <?= ($activeNav ?? '') === 'settings' ? 'is-active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.26.604.852.997 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          Pengaturan Toko
        </a>
      </nav>

      <div class="sidebar-footer">
        <div class="sidebar-user-card">
          <div class="user-avatar"><?= strtoupper(substr((string) (session()->get('admin_username') ?? 'L'), 0, 1)) ?></div>
          <div class="sidebar-user-info">
            <strong><?= esc(session()->get('admin_name') ?? 'Admin') ?></strong>
            <span>@<?= esc(session()->get('admin_username') ?? 'littlestu') ?></span>
          </div>
        </div>
        <a href="<?= base_url('/') ?>" target="_blank" rel="noopener" class="nav-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          Lihat Katalog Publik
        </a>
        <a href="<?= base_url('admin/logout') ?>" class="nav-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Keluar
        </a>
      </div>
    </aside>

    <div class="admin-main">
      <header class="admin-topbar">
        <div class="topbar-left">
          <button type="button" class="menu-btn" id="adminMenuBtn" aria-label="Buka menu navigasi">☰</button>
          <div>
            <span class="topbar-breadcrumb">LITTLESTU Admin</span>
            <h1><?= esc($pageTitle ?? 'Dashboard') ?></h1>
          </div>
        </div>
        <div class="topbar-actions">
          <a href="<?= base_url('/') ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm">Lihat Toko ↗</a>
          <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary btn-sm">+ Tambah Produk</a>
        </div>
      </header>

      <main class="admin-content">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success" role="status">✓ <?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-error" role="alert">! <?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>

  <?php if (! empty($mediaFiles)): ?>
  <!-- Reusable Visual Media Picker Modal -->
  <div class="media-modal-overlay" id="mediaModalOverlay" role="dialog" aria-modal="true" aria-label="Pilih foto dari galeri">
    <div class="media-modal">
      <div class="media-modal-head">
        <div>
          <h3>Pilih Foto dari Galeri</h3>
          <p style="font-size:0.8rem;color:var(--muted);">Klik salah satu foto di bawah — tanpa perlu mengetik nama berkas manual.</p>
        </div>
        <button type="button" class="btn btn-outline btn-sm" id="mediaModalClose">Tutup ✕</button>
      </div>
      <div class="media-modal-body">
        <input type="search" id="mediaSearchInput" class="form-control" placeholder="Cari nama foto, mis. 'alicia', 'jiwoo', 'zula'…" />
        <div class="media-grid" id="mediaGrid">
          <?php foreach ($mediaFiles as $mf): ?>
            <button
              type="button"
              class="media-item js-media-pick"
              data-path="<?= esc($mf['path']) ?>"
              data-url="<?= esc($mf['url']) ?>"
              data-name="<?= esc(strtolower($mf['name'])) ?>"
            >
              <img src="<?= esc($mf['url']) ?>" alt="<?= esc($mf['name']) ?>" loading="lazy" />
              <span><?= esc($mf['name']) ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <script>
    (function () {
      const btn = document.getElementById('adminMenuBtn');
      const sidebar = document.getElementById('adminSidebar');
      const backdrop = document.getElementById('sidebarBackdrop');
      function toggle() {
        sidebar?.classList.toggle('is-open');
        backdrop?.classList.toggle('is-open');
      }
      btn?.addEventListener('click', toggle);
      backdrop?.addEventListener('click', toggle);

      // Global Visual Media Picker Helper
      const overlay = document.getElementById('mediaModalOverlay');
      const closeBtn = document.getElementById('mediaModalClose');
      const searchIn = document.getElementById('mediaSearchInput');
      let onMediaSelect = null;

      window.openMediaPicker = function (callback) {
        if (!overlay) return;
        onMediaSelect = callback;
        overlay.classList.add('is-open');
        if (searchIn) { searchIn.value = ''; filterMedia(''); searchIn.focus(); }
      };

      function closeMediaPicker() {
        overlay?.classList.remove('is-open');
        onMediaSelect = null;
      }
      function filterMedia(q) {
        const term = (q || '').trim().toLowerCase();
        document.querySelectorAll('.js-media-pick').forEach((item) => {
          item.style.display = (!term || item.dataset.name.includes(term)) ? '' : 'none';
        });
      }
      closeBtn?.addEventListener('click', closeMediaPicker);
      overlay?.addEventListener('click', (e) => { if (e.target === overlay) closeMediaPicker(); });
      searchIn?.addEventListener('input', (e) => filterMedia(e.target.value));
      document.querySelectorAll('.js-media-pick').forEach((item) => {
        item.addEventListener('click', () => {
          if (typeof onMediaSelect === 'function') {
            onMediaSelect({ path: item.dataset.path, url: item.dataset.url, name: item.dataset.name });
          }
          closeMediaPicker();
        });
      });
    })();
  </script>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
