<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php
$heroImgPath = $settings['hero_image'] ?? 'images/zula3.jpeg';
$fallback    = base_url('images/placeholder.svg');
?>

<div class="card">
  <div class="card-head">
    <div>
      <h2>Pengaturan Tampilan &amp; Kontak Toko</h2>
      <p class="card-subtitle">Ubah teks promosi, foto Hero, dan tautan marketplace resmi secara instan</p>
    </div>
  </div>

  <form action="<?= base_url('admin/settings/save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="form-grid form-grid-2">
      <div>
        <h3 class="form-section-title">Banner &amp; Hero Depan</h3>
        <div class="form-group">
          <label for="topbar_text">Teks Topbar Pengumuman</label>
          <input type="text" id="topbar_text" name="topbar_text" class="form-control" value="<?= esc($settings['topbar_text'] ?? '') ?>" />
        </div>
        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label for="hero_badge">Badge Hero</label>
            <input type="text" id="hero_badge" name="hero_badge" class="form-control" value="<?= esc($settings['hero_badge'] ?? '') ?>" />
          </div>
          <div class="form-group">
            <label for="hero_note">Catatan Kecil Hero</label>
            <input type="text" id="hero_note" name="hero_note" class="form-control" value="<?= esc($settings['hero_note'] ?? '') ?>" />
          </div>
        </div>
        <div class="form-group">
          <label for="hero_subtitle">Subjudul Hero</label>
          <textarea id="hero_subtitle" name="hero_subtitle" class="form-control"><?= esc($settings['hero_subtitle'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <label>Foto Utama Hero</label>
          <div class="image-picker-box">
            <img src="<?= base_url($heroImgPath) ?>" alt="Foto Hero" class="image-picker-preview" id="heroImgPreview" onerror="this.src='<?= $fallback ?>'" />
            <div class="image-picker-controls">
              <span class="image-picker-filename" id="heroImgLabel"><?= esc(basename($heroImgPath)) ?></span>
              <div class="image-picker-btns">
                <button type="button" class="btn btn-outline btn-sm" id="btnPickHero">Pilih dari Galeri</button>
                <label class="btn btn-primary btn-sm" style="cursor:pointer;">
                  Unggah Foto
                  <input type="file" name="hero_upload" id="heroUploadInput" accept="image/*" hidden />
                </label>
              </div>
            </div>
            <input type="hidden" name="hero_image" id="heroImgInput" value="<?= esc($heroImgPath) ?>" />
          </div>
        </div>

        <div class="form-group">
          <label for="hero_float_slug">Produk Kartu Mengambang di Hero</label>
          <select id="hero_float_slug" name="hero_float_slug" class="form-control">
            <?php foreach ($products as $p): ?>
              <option value="<?= esc($p['slug']) ?>" <?= ($settings['hero_float_slug'] ?? '') === $p['slug'] ? 'selected' : '' ?>>
                <?= esc($p['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div>
        <h3 class="form-section-title">Kontak Resmi &amp; Marketplace</h3>
        <div class="form-group">
          <label for="whatsapp_number">Nomor WhatsApp Admin (diawali 62)</label>
          <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control" value="<?= esc($settings['whatsapp_number'] ?? '') ?>" />
        </div>
        <div class="form-group">
          <label for="shopee_url">Link Toko Shopee</label>
          <input type="url" id="shopee_url" name="shopee_url" class="form-control" value="<?= esc($settings['shopee_url'] ?? '') ?>" />
        </div>
        <div class="form-group">
          <label for="tiktok_url">Link TikTok Shop</label>
          <input type="url" id="tiktok_url" name="tiktok_url" class="form-control" value="<?= esc($settings['tiktok_url'] ?? '') ?>" />
        </div>
        <div class="form-group">
          <label for="instagram_url">Link Instagram</label>
          <input type="url" id="instagram_url" name="instagram_url" class="form-control" value="<?= esc($settings['instagram_url'] ?? '') ?>" />
        </div>

        <h3 class="form-section-title" style="margin-top:22px;">Promo &amp; Cerita Brand</h3>
        <div class="form-group">
          <label for="promo_title">Judul Banner Promo</label>
          <input type="text" id="promo_title" name="promo_title" class="form-control" value="<?= esc($settings['promo_title'] ?? '') ?>" />
        </div>
        <div class="form-group">
          <label for="promo_desc">Deskripsi Banner Promo</label>
          <textarea id="promo_desc" name="promo_desc" class="form-control" style="min-height:70px;"><?= esc($settings['promo_desc'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
          <label for="about_quote">Kutipan Cerita Brand</label>
          <textarea id="about_quote" name="about_quote" class="form-control" style="min-height:70px;"><?= esc($settings['about_quote'] ?? '') ?></textarea>
        </div>
      </div>
    </div>

    <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border);text-align:right;">
      <button type="submit" class="btn btn-primary">✓ Simpan Pengaturan Toko</button>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
  document.getElementById('btnPickHero')?.addEventListener('click', () => {
    window.openMediaPicker((file) => {
      document.getElementById('heroImgInput').value = file.path;
      document.getElementById('heroImgPreview').src = file.url;
      document.getElementById('heroImgLabel').textContent = file.name;
    });
  });
  document.getElementById('heroUploadInput')?.addEventListener('change', (e) => {
    const f = e.target.files?.[0];
    if (!f) return;
    document.getElementById('heroImgPreview').src = URL.createObjectURL(f);
    document.getElementById('heroImgLabel').textContent = f.name + ' (unggah baru)';
  });
</script>
<?= $this->endSection() ?>
