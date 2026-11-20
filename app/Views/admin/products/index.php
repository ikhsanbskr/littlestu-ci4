<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="view-toolbar">
    <div class="status-tabs">
      <a href="<?= base_url('admin/products') ?>" class="status-tab <?= ($statusF ?? '') === '' ? 'is-active' : '' ?>">Semua (<?= count($products) ?>)</a>
      <a href="<?= base_url('admin/products?status=active') ?>" class="status-tab <?= ($statusF ?? '') === 'active' ? 'is-active' : '' ?>">Aktif</a>
      <a href="<?= base_url('admin/products?status=hidden') ?>" class="status-tab <?= ($statusF ?? '') === 'hidden' ? 'is-active' : '' ?>">Disembunyikan</a>
    </div>

    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
      <form method="get" action="<?= base_url('admin/products') ?>" style="display:flex;gap:6px;">
        <?php if (! empty($statusF)): ?><input type="hidden" name="status" value="<?= esc($statusF) ?>" /><?php endif; ?>
        <input type="search" name="q" class="form-control" style="width:210px;padding:7px 14px;" placeholder="Cari koleksi…" value="<?= esc($searchQ ?? '') ?>" />
        <button type="submit" class="btn btn-outline btn-sm">Cari</button>
      </form>

      <div class="view-switch" role="group" aria-label="Pilih mode tampilan">
        <button type="button" id="btnViewGrid" class="is-active">Kartu</button>
        <button type="button" id="btnViewTable">Tabel</button>
      </div>
    </div>
  </div>

  <!-- Mode Kartu Visual (Default) -->
  <div class="admin-product-grid" id="adminProductGrid">
    <?php foreach ($products as $p): ?>
      <article class="admin-pcard">
        <div class="admin-pcard-media">
          <?php if (! empty($p['badge'])): ?>
            <span class="admin-pcard-badge"><?= esc($p['badge']) ?></span>
          <?php endif; ?>
          <form action="<?= base_url('admin/products/toggle/' . $p['id']) ?>" method="post" class="admin-pcard-status">
            <?= csrf_field() ?>
            <button type="submit" class="badge <?= (int) $p['is_active'] === 1 ? 'badge-sage' : 'badge-muted' ?>" style="border:0;cursor:pointer;" title="Klik untuk ubah status">
              <?= (int) $p['is_active'] === 1 ? '● Aktif' : '○ Sembunyi' ?>
            </button>
          </form>
          <img src="<?= base_url($p['primary_image']) ?>" alt="<?= esc($p['name']) ?>" loading="lazy" onerror="this.src='<?= base_url('images/placeholder.svg') ?>'" />
        </div>
        <div class="admin-pcard-body">
          <span style="font-size:0.72rem;color:var(--muted);font-weight:600;"><?= esc($p['category_label']) ?> · <?= esc($p['size_note']) ?></span>
          <h3><?= esc($p['name']) ?></h3>
          <p class="admin-pcard-price"><?= esc($p['price_label']) ?></p>
          <div class="admin-pcard-stats">
            <span>👁 <?= (int) $p['views_count'] ?></span>
            <span>🛍 <?= (int) $p['clicks_shopee'] ?></span>
            <span>💬 <?= (int) $p['clicks_wa'] ?></span>
          </div>
          <div class="admin-pcard-actions">
            <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>" class="btn btn-outline btn-sm">Ubah</a>
            <form action="<?= base_url('admin/products/delete/' . $p['id']) ?>" method="post" onsubmit="return confirm('Hapus produk <?= esc($p['name']) ?>?');" style="flex:0 0 auto;">
              <?= csrf_field() ?>
              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <!-- Mode Tabel Ringkas -->
  <div class="table-wrap" id="adminProductTable" hidden>
    <table class="admin-table">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Status</th>
          <th>Statistik</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $p): ?>
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:12px;">
                <img src="<?= base_url($p['primary_image']) ?>" alt="" class="thumb" onerror="this.src='<?= base_url('images/placeholder.svg') ?>'" />
                <div>
                  <strong><?= esc($p['name']) ?></strong>
                  <div style="font-size:0.75rem;color:var(--muted);"><?= esc($p['size_note']) ?></div>
                </div>
              </div>
            </td>
            <td><strong><?= esc($p['category_label']) ?></strong></td>
            <td><?= esc($p['price_label']) ?></td>
            <td>
              <form action="<?= base_url('admin/products/toggle/' . $p['id']) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="badge <?= (int) $p['is_active'] === 1 ? 'badge-sage' : 'badge-muted' ?>" style="border:0;cursor:pointer;">
                  <?= (int) $p['is_active'] === 1 ? 'Aktif' : 'Disembunyikan' ?>
                </button>
              </form>
            </td>
            <td style="font-size:0.78rem;color:var(--muted);">
              👁 <?= (int) $p['views_count'] ?> · 🛍 <?= (int) $p['clicks_shopee'] ?> · 💬 <?= (int) $p['clicks_wa'] ?>
            </td>
            <td>
              <div style="display:flex;gap:6px;">
                <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>" class="btn btn-outline btn-sm">Ubah</a>
                <form action="<?= base_url('admin/products/delete/' . $p['id']) ?>" method="post" onsubmit="return confirm('Hapus produk <?= esc($p['name']) ?>?');">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
  const btnGrid = document.getElementById('btnViewGrid');
  const btnTable = document.getElementById('btnViewTable');
  const gridEl = document.getElementById('adminProductGrid');
  const tableEl = document.getElementById('adminProductTable');

  btnGrid?.addEventListener('click', () => {
    gridEl.hidden = false; tableEl.hidden = true;
    btnGrid.classList.add('is-active'); btnTable.classList.remove('is-active');
  });
  btnTable?.addEventListener('click', () => {
    gridEl.hidden = true; tableEl.hidden = false;
    btnTable.classList.add('is-active'); btnGrid.classList.remove('is-active');
  });
</script>
<?= $this->endSection() ?>
