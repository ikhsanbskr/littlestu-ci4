<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php
$isEdit        = $product !== null;
$action        = $isEdit ? base_url('admin/products/update/' . $product['id']) : base_url('admin/products/store');
$selectedCats  = explode(' ', (string) ($product['category'] ?? 'girls tops'));
$selectedSizes = explode(',', (string) ($product['sizes_available'] ?? 'S,M,L,2L,3L,4L'));
$galleryArr    = json_decode((string) ($product['gallery_images'] ?? '[]'), true) ?: [];
$colorsArr     = json_decode((string) ($product['colors'] ?? '[]'), true) ?: [['name' => 'Krem', 'hex' => '#d8c5ad', 'image' => '']];
$pairArr       = json_decode((string) ($product['pair_slugs'] ?? '[]'), true) ?: [];
$fallback      = base_url('images/placeholder.svg');
$primaryPath   = $product['primary_image'] ?? 'images/alicia2.jpeg';
$secondaryPath = $product['secondary_image'] ?? '';
?>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="productForm">
  <?= csrf_field() ?>

  <div class="form-layout-with-preview">
    <!-- Kolom Kiri: Form Terstruktur -->
    <div>
      <!-- 1. Informasi Dasar -->
      <div class="card">
        <h2 class="form-section-title">1. Informasi Dasar &amp; Harga Otomatis</h2>
        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label for="name">Nama Produk *</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= esc($product['name'] ?? '') ?>" placeholder="Contoh: Alicia Set" required />
          </div>
          <div class="form-group">
            <label for="category_label">Jenis Pakaian</label>
            <select id="category_label" name="category_label" class="form-control">
              <?php foreach (['Setelan', 'Kemeja', 'Atasan', 'Denim', 'Celana', 'Skort', 'Overall', 'Dress'] as $lbl): ?>
                <option value="<?= $lbl ?>" <?= ($product['category_label'] ?? 'Setelan') === $lbl ? 'selected' : '' ?>><?= $lbl ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <input type="hidden" name="slug" value="<?= esc($product['slug'] ?? '') ?>" />

        <div class="form-group">
          <label>Kategori Katalog (Centang yang Sesuai)</label>
          <div class="check-group">
            <?php foreach (['girls' => 'Girls', 'boys' => 'Boys / Unisex', 'tops' => 'Atasan (Tops)', 'bottoms' => 'Bawahan (Bottoms)', 'setelan' => 'Setelan / Overall'] as $val => $lbl): ?>
              <label class="check-chip">
                <input type="checkbox" name="categories[]" value="<?= $val ?>" <?= in_array($val, $selectedCats, true) ? 'checked' : '' ?> />
                <span><?= $lbl ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label for="price_min">Harga Mulai (Rp) *</label>
            <input type="number" id="price_min" name="price_min" class="form-control" value="<?= (int) ($product['price_min'] ?? 98000) ?>" step="1000" required />
          </div>
          <div class="form-group">
            <label for="price_max">Harga Tertinggi (Rp, opsional)</label>
            <input type="number" id="price_max" class="form-control" placeholder="Kosongkan jika 1 harga" step="1000" />
          </div>
        </div>

        <div class="form-group">
          <label for="price_label">Teks Harga Tampil (Otomatis Terformat)</label>
          <input type="text" id="price_label" name="price_label" class="form-control" value="<?= esc($product['price_label'] ?? 'Rp98.000') ?>" required />
          <span class="form-hint">Otomatis berubah saat angka Harga Mulai/Tertinggi diisi, namun tetap bisa disunting jika perlu.</span>
        </div>

        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label for="badge">Label Badge (Opsional)</label>
            <input type="text" id="badge" name="badge" class="form-control" value="<?= esc($product['badge'] ?? '') ?>" placeholder="Best Seller / Unisex / New Arrival" />
          </div>
          <div class="form-group">
            <label for="badge_style">Gaya Warna Badge</label>
            <select id="badge_style" name="badge_style" class="form-control">
              <option value="default" <?= ($product['badge_style'] ?? '') === 'default' ? 'selected' : '' ?>>Espresso Gelap</option>
              <option value="sage" <?= ($product['badge_style'] ?? '') === 'sage' ? 'selected' : '' ?>>Earthy Sage (Unisex)</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="description">Deskripsi Produk</label>
          <textarea id="description" name="description" class="form-control" placeholder="Jelaskan bahan, potongan, dan kenyamanan pakaian…"><?= esc($product['description'] ?? '') ?></textarea>
        </div>
      </div>

      <!-- 2. Foto & Galeri (Visual Picker — Tanpa Ketik Path Manual!) -->
      <div class="card">
        <h2 class="form-section-title">2. Foto Produk &amp; Galeri Visual</h2>

        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label>Foto Utama Kartu *</label>
            <div class="image-picker-box">
              <img src="<?= base_url($primaryPath) ?>" alt="Pratinjau foto utama" class="image-picker-preview" id="primaryPreview" onerror="this.src='<?= $fallback ?>'" />
              <div class="image-picker-controls">
                <span class="image-picker-filename" id="primaryFileLabel"><?= esc(basename($primaryPath)) ?></span>
                <div class="image-picker-btns">
                  <button type="button" class="btn btn-outline btn-sm" id="btnPickPrimary">Pilih dari Galeri</button>
                  <label class="btn btn-primary btn-sm" style="cursor:pointer;">
                    Unggah Baru
                    <input type="file" name="primary_upload" id="primaryUploadInput" accept="image/*" hidden />
                  </label>
                </div>
              </div>
              <input type="hidden" name="primary_image" id="primaryImageInput" value="<?= esc($primaryPath) ?>" />
            </div>
          </div>

          <div class="form-group">
            <label>Foto Kedua (Efek Hover)</label>
            <div class="image-picker-box">
              <img src="<?= $secondaryPath ? base_url($secondaryPath) : $fallback ?>" alt="Pratinjau foto kedua" class="image-picker-preview" id="secondaryPreview" onerror="this.src='<?= $fallback ?>'" />
              <div class="image-picker-controls">
                <span class="image-picker-filename" id="secondaryFileLabel"><?= $secondaryPath ? esc(basename($secondaryPath)) : 'Belum dipilih (opsional)' ?></span>
                <div class="image-picker-btns">
                  <button type="button" class="btn btn-outline btn-sm" id="btnPickSecondary">Pilih Galeri</button>
                  <label class="btn btn-outline btn-sm" style="cursor:pointer;">
                    Unggah
                    <input type="file" name="secondary_upload" id="secondaryUploadInput" accept="image/*" hidden />
                  </label>
                </div>
              </div>
              <input type="hidden" name="secondary_image" id="secondaryImageInput" value="<?= esc($secondaryPath) ?>" />
            </div>
          </div>
        </div>

        <div class="form-group" style="margin-top:8px;">
          <label>Galeri Foto Tambahan (Slider Detail Produk)</label>
          <div class="gallery-strip" id="galleryStrip"></div>
          <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <button type="button" class="btn btn-outline btn-sm" id="btnAddGalleryPick">+ Tambah dari Galeri</button>
            <label class="btn btn-outline btn-sm" style="cursor:pointer;">
              + Unggah Banyak Foto
              <input type="file" name="gallery_uploads[]" id="galleryUploadsInput" accept="image/*" multiple hidden />
            </label>
          </div>
          <textarea name="gallery_images" id="galleryImagesInput" hidden><?= esc(implode("\n", $galleryArr)) ?></textarea>
        </div>
      </div>

      <!-- 3. Varian Warna, Ukuran, Mix & Match, Tautan -->
      <div class="card">
        <h2 class="form-section-title">3. Varian Warna, Ukuran &amp; Tautan Belanja</h2>

        <div class="form-group">
          <label>Ukuran Tersedia (Otomatis Mengisi Label Rentang Ukuran)</label>
          <div class="check-group" id="sizesCheckGroup">
            <?php foreach (['S', 'M', 'L', '2L', '3L', '4L', '5L'] as $sz): ?>
              <label class="check-chip">
                <input type="checkbox" name="sizes[]" value="<?= $sz ?>" <?= in_array($sz, $selectedSizes, true) ? 'checked' : '' ?> />
                <span><?= $sz ?></span>
              </label>
            <?php endforeach; ?>
          </div>
          <input type="hidden" name="size_note" id="sizeNoteInput" value="<?= esc($product['size_note'] ?? 'Tersedia dalam ukuran S–4L') ?>" />
        </div>

        <div class="form-group">
          <label>Varian Warna (Swatch)</label>
          <div id="colorRows" style="display:flex;flex-direction:column;gap:8px;">
            <?php foreach ($colorsArr as $c): ?>
              <div class="js-color-row" style="display:grid;grid-template-columns:1fr 56px auto auto;gap:8px;align-items:center;">
                <input type="text" name="color_name[]" class="form-control js-color-name" placeholder="Nama Warna (mis. Biru)" value="<?= esc($c['name'] ?? '') ?>" />
                <input type="color" name="color_hex[]" class="form-control js-color-hex" style="padding:3px;height:41px;" value="<?= esc($c['hex'] ?? '#8b6f52') ?>" />
                <input type="hidden" name="color_image[]" class="js-color-img" value="<?= esc($c['image'] ?? '') ?>" />
                <button type="button" class="btn btn-outline btn-sm js-pick-color-img">Foto Warna</button>
                <button type="button" class="btn btn-danger btn-sm js-remove-color" title="Hapus warna">✕</button>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" id="addColorRow" class="btn btn-outline btn-sm" style="margin-top:8px;align-self:flex-start;">+ Tambah Varian Warna</button>
        </div>

        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label for="shopee_url">Tautan Produk Shopee</label>
            <input type="url" id="shopee_url" name="shopee_url" class="form-control" value="<?= esc($product['shopee_url'] ?? '') ?>" placeholder="https://shopee.co.id/..." />
          </div>
          <div class="form-group">
            <label for="tiktok_url">Tautan TikTok Shop</label>
            <input type="url" id="tiktok_url" name="tiktok_url" class="form-control" value="<?= esc($product['tiktok_url'] ?? 'https://www.tiktok.com/@littlestu.kidswear') ?>" />
          </div>
        </div>

        <div class="form-group">
          <label>Rekomendasi Padu Padan (Mix &amp; Match — Pilih hingga 2 Produk)</label>
          <div class="check-group" style="max-height:130px;overflow-y:auto;padding:10px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--bg);">
            <?php foreach ($allProducts as $other): ?>
              <label class="check-chip">
                <input type="checkbox" name="pair_slugs[]" value="<?= esc($other['slug']) ?>" <?= in_array($other['slug'], $pairArr, true) ? 'checked' : '' ?> />
                <span><?= esc($other['name']) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label for="sort_order">Urutan Tampil di Katalog</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int) ($product['sort_order'] ?? 10) ?>" />
          </div>
          <div class="form-group" style="justify-content:center;">
            <label class="check-chip" style="margin-top:16px;">
              <input type="checkbox" name="is_active" value="1" <?= (int) ($product['is_active'] ?? 1) === 1 ? 'checked' : '' ?> />
              <span>Tampilkan di Katalog Publik</span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Sticky Live Product Card Preview -->
    <aside class="live-preview-sticky">
      <div class="card">
        <div class="card-head" style="margin-bottom:14px;padding-bottom:10px;">
          <div>
            <h2>Pratinjau Langsung</h2>
            <p class="card-subtitle">Tampilan kartu di halaman katalog</p>
          </div>
        </div>

        <div class="preview-frame">
          <div class="preview-card">
            <div class="preview-media">
              <span class="preview-badge" id="liveBadge" style="display:<?= ! empty($product['badge']) ? 'inline-block' : 'none' ?>;">
                <?= esc($product['badge'] ?? '') ?>
              </span>
              <img src="<?= base_url($primaryPath) ?>" alt="Pratinjau kartu" id="liveCardImg" onerror="this.src='<?= $fallback ?>'" />
            </div>
            <div class="preview-info">
              <span class="preview-cat" id="liveCat"><?= esc(($product['category_label'] ?? 'Setelan') . ' · ' . ($product['size_note'] ?? 'Ukuran S–4L')) ?></span>
              <h3 id="liveTitle"><?= esc($product['name'] ?? 'Nama Produk Baru') ?></h3>
              <p class="preview-price" id="livePrice"><?= esc($product['price_label'] ?? 'Rp98.000') ?></p>
              <div class="preview-dots" id="liveDots"></div>
            </div>
          </div>
        </div>

        <div style="margin-top:18px;display:flex;flex-direction:column;gap:8px;">
          <button type="submit" class="btn btn-primary" style="width:100%;">
            <?= $isEdit ? '✓ Simpan Perubahan Produk' : '+ Terbitkan ke Katalog' ?>
          </button>
          <a href="<?= base_url('admin/products') ?>" class="btn btn-outline" style="width:100%;">Batal &amp; Kembali</a>
        </div>
      </div>
    </aside>
  </div>
</form>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
  (function () {
    const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
    const fallback = <?= json_encode($fallback) ?>;

    // 1. Auto-format Harga & Live Preview
    const nameIn = document.getElementById('name');
    const catIn = document.getElementById('category_label');
    const priceMinIn = document.getElementById('price_min');
    const priceMaxIn = document.getElementById('price_max');
    const priceLabelIn = document.getElementById('price_label');
    const badgeIn = document.getElementById('badge');
    const badgeStyleIn = document.getElementById('badge_style');
    const sizeNoteIn = document.getElementById('sizeNoteInput');

    function formatRp(num) {
      const n = parseInt(num, 10);
      return isNaN(n) || n <= 0 ? '' : 'Rp' + n.toLocaleString('id-ID');
    }

    function autoFormatPrice() {
      const minStr = formatRp(priceMinIn.value);
      const maxStr = formatRp(priceMaxIn.value);
      if (minStr && maxStr && parseInt(priceMaxIn.value, 10) > parseInt(priceMinIn.value, 10)) {
        priceLabelIn.value = `${minStr} – ${maxStr}`;
      } else if (minStr) {
        priceLabelIn.value = minStr;
      }
      syncLivePreview();
    }
    priceMinIn?.addEventListener('input', autoFormatPrice);
    priceMaxIn?.addEventListener('input', autoFormatPrice);

    function syncSizeNote() {
      const checked = Array.from(document.querySelectorAll('#sizesCheckGroup input:checked')).map((i) => i.value);
      if (checked.length > 1) {
        sizeNoteIn.value = `Tersedia dalam ukuran ${checked[0]}–${checked[checked.length - 1]}`;
      } else if (checked.length === 1) {
        sizeNoteIn.value = `Tersedia ukuran ${checked[0]}`;
      }
      syncLivePreview();
    }
    document.querySelectorAll('#sizesCheckGroup input').forEach((cb) => cb.addEventListener('change', syncSizeNote));

    function syncLivePreview() {
      document.getElementById('liveTitle').textContent = nameIn.value.trim() || 'Nama Produk Baru';
      document.getElementById('livePrice').textContent = priceLabelIn.value.trim() || 'Rp0';
      document.getElementById('liveCat').textContent = `${catIn.value} · ${sizeNoteIn.value.replace('Tersedia dalam ', '')}`;

      const liveBadge = document.getElementById('liveBadge');
      const bVal = badgeIn.value.trim();
      liveBadge.style.display = bVal ? 'inline-block' : 'none';
      liveBadge.textContent = bVal;
      liveBadge.classList.toggle('is-sage', badgeStyleIn.value === 'sage');

      const liveDots = document.getElementById('liveDots');
      liveDots.innerHTML = '';
      document.querySelectorAll('.js-color-hex').forEach((hex) => {
        const dot = document.createElement('span');
        dot.className = 'preview-dot';
        dot.style.background = hex.value;
        liveDots.appendChild(dot);
      });
    }

    [nameIn, catIn, priceLabelIn, badgeIn, badgeStyleIn].forEach((el) => el?.addEventListener('input', syncLivePreview));
    syncLivePreview();

    // 2. Visual Image Pickers (Primary & Secondary)
    const primaryPreview = document.getElementById('primaryPreview');
    const liveCardImg = document.getElementById('liveCardImg');
    const primaryInput = document.getElementById('primaryImageInput');
    const primaryLabel = document.getElementById('primaryFileLabel');

    document.getElementById('btnPickPrimary')?.addEventListener('click', () => {
      window.openMediaPicker((file) => {
        primaryInput.value = file.path;
        primaryPreview.src = file.url;
        liveCardImg.src = file.url;
        primaryLabel.textContent = file.name;
      });
    });
    document.getElementById('primaryUploadInput')?.addEventListener('change', (e) => {
      const f = e.target.files?.[0];
      if (!f) return;
      const url = URL.createObjectURL(f);
      primaryPreview.src = url;
      liveCardImg.src = url;
      primaryLabel.textContent = f.name + ' (unggah baru)';
    });

    const secPreview = document.getElementById('secondaryPreview');
    const secInput = document.getElementById('secondaryImageInput');
    const secLabel = document.getElementById('secondaryFileLabel');

    document.getElementById('btnPickSecondary')?.addEventListener('click', () => {
      window.openMediaPicker((file) => {
        secInput.value = file.path;
        secPreview.src = file.url;
        secLabel.textContent = file.name;
      });
    });
    document.getElementById('secondaryUploadInput')?.addEventListener('change', (e) => {
      const f = e.target.files?.[0];
      if (!f) return;
      secPreview.src = URL.createObjectURL(f);
      secLabel.textContent = f.name + ' (unggah baru)';
    });

    // 3. Visual Gallery Strip
    const galleryStrip = document.getElementById('galleryStrip');
    const galleryTextarea = document.getElementById('galleryImagesInput');
    let galleryPaths = galleryTextarea.value.split(/\r?\n/).map((s) => s.trim()).filter(Boolean);

    function renderGalleryStrip() {
      galleryStrip.innerHTML = '';
      galleryPaths.forEach((p, idx) => {
        const item = document.createElement('div');
        item.className = 'gallery-thumb-item';
        const src = p.startsWith('http') ? p : baseUrl + p;
        item.innerHTML = `<img src="${src}" onerror="this.src='${fallback}'" /><button type="button" class="gallery-thumb-remove" title="Hapus">✕</button>`;
        item.querySelector('button').addEventListener('click', () => {
          galleryPaths.splice(idx, 1);
          renderGalleryStrip();
        });
        galleryStrip.appendChild(item);
      });
      galleryTextarea.value = galleryPaths.join('\n');
    }
    renderGalleryStrip();

    document.getElementById('btnAddGalleryPick')?.addEventListener('click', () => {
      window.openMediaPicker((file) => {
        if (!galleryPaths.includes(file.path)) {
          galleryPaths.push(file.path);
          renderGalleryStrip();
        }
      });
    });

    // 4. Color Swatch Rows with Visual Image Picker
    function bindColorRow(row) {
      row.querySelector('.js-pick-color-img')?.addEventListener('click', () => {
        window.openMediaPicker((file) => {
          row.querySelector('.js-color-img').value = file.path;
          row.querySelector('.js-pick-color-img').textContent = '✓ ' + file.name.slice(0, 12);
        });
      });
      row.querySelector('.js-remove-color')?.addEventListener('click', () => {
        if (document.querySelectorAll('.js-color-row').length > 1) {
          row.remove();
          syncLivePreview();
        }
      });
      row.querySelector('.js-color-hex')?.addEventListener('input', syncLivePreview);
    }

    document.querySelectorAll('.js-color-row').forEach(bindColorRow);
    document.getElementById('addColorRow')?.addEventListener('click', () => {
      const row = document.createElement('div');
      row.className = 'js-color-row';
      row.style.cssText = 'display:grid;grid-template-columns:1fr 56px auto auto;gap:8px;align-items:center;';
      row.innerHTML = `
        <input type="text" name="color_name[]" class="form-control js-color-name" placeholder="Nama Warna" />
        <input type="color" name="color_hex[]" class="form-control js-color-hex" style="padding:3px;height:41px;" value="#8b6f52" />
        <input type="hidden" name="color_image[]" class="js-color-img" value="" />
        <button type="button" class="btn btn-outline btn-sm js-pick-color-img">Foto Warna</button>
        <button type="button" class="btn btn-danger btn-sm js-remove-color" title="Hapus warna">✕</button>
      `;
      document.getElementById('colorRows').appendChild(row);
      bindColorRow(row);
      syncLivePreview();
    });
  })();
</script>
<?= $this->endSection() ?>
