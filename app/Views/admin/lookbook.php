<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php $fallback = base_url('images/placeholder.svg'); ?>

<div class="card">
  <div class="card-head">
    <div>
      <h2>Tambah Slide Lookbook Baru</h2>
      <p class="card-subtitle">Pilih foto dari galeri atau unggah foto baru — tanpa mengetik path berkas manual</p>
    </div>
  </div>
  <form action="<?= base_url('admin/lookbook/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form-grid form-grid-2">
      <div>
        <div class="form-group">
          <label>Label Pill (Mis. Look 04 / Weekend)</label>
          <input type="text" name="pill_label" class="form-control" placeholder="Look 04 / Playful Day" required />
        </div>
        <div class="form-group">
          <label>Judul Lookbook</label>
          <input type="text" name="title" class="form-control" placeholder="Judul padu padan" required />
        </div>
        <div class="form-group">
          <label>Deskripsi Singkat</label>
          <input type="text" name="description" class="form-control" placeholder="Ceritakan singkat gaya padu padan ini" />
        </div>
      </div>
      <div>
        <div class="form-group">
          <label>Foto Slide Lookbook</label>
          <div class="image-picker-box">
            <img src="<?= base_url('images/zula.jpeg') ?>" alt="" class="image-picker-preview" id="newSlidePreview" onerror="this.src='<?= $fallback ?>'" />
            <div class="image-picker-controls">
              <span class="image-picker-filename" id="newSlideLabel">zula.jpeg</span>
              <div class="image-picker-btns">
                <button type="button" class="btn btn-outline btn-sm" id="btnPickNewSlide">Pilih Galeri</button>
                <label class="btn btn-primary btn-sm" style="cursor:pointer;">
                  Unggah Foto
                  <input type="file" name="image_upload" id="newSlideUpload" accept="image/*" hidden />
                </label>
              </div>
            </div>
            <input type="hidden" name="image" id="newSlideInput" value="images/zula.jpeg" />
          </div>
        </div>
        <div class="form-grid form-grid-2">
          <div class="form-group">
            <label>Urutan Tampil</label>
            <input type="number" name="sort_order" class="form-control" value="<?= count($slides) + 1 ?>" />
          </div>
          <div class="form-group" style="justify-content:center;">
            <label class="check-chip" style="margin-top:16px;">
              <input type="checkbox" name="is_active" value="1" checked />
              <span>Aktifkan Slide</span>
            </label>
          </div>
        </div>
        <input type="hidden" name="hotspots_json" value="[]" />
      </div>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">+ Tambah Slide Lookbook</button>
  </form>
</div>

<?php foreach ($slides as $slide): ?>
  <?php $hotspots = json_decode($slide['hotspots'] ?? '[]', true) ?: []; ?>
  <div class="card lookbook-editor-card" data-slide-id="<?= (int) $slide['id'] ?>">
    <div class="card-head">
      <div>
        <h2>Slide #<?= (int) $slide['sort_order'] ?>: <?= esc($slide['title']) ?></h2>
        <p class="card-subtitle">Pilih produk lalu klik langsung di atas foto untuk menempatkan titik Hotspot (+)</p>
      </div>
      <form action="<?= base_url('admin/lookbook/delete/' . $slide['id']) ?>" method="post" onsubmit="return confirm('Hapus slide ini?');">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger btn-sm">Hapus Slide</button>
      </form>
    </div>

    <form action="<?= base_url('admin/lookbook/update/' . $slide['id']) ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="form-grid form-grid-2">
        <div>
          <div class="hotspot-editor-stage js-hotspot-stage">
            <img src="<?= base_url($slide['image']) ?>" alt="<?= esc($slide['title']) ?>" class="js-stage-img" onerror="this.src='<?= $fallback ?>'" />
            <div class="js-pins-layer"></div>
          </div>

          <div style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap;align-items:center;">
            <select class="form-control js-hotspot-product" style="flex:1;min-width:180px;">
              <?php foreach ($products as $p): ?>
                <option value="<?= esc($p['slug']) ?>" data-label="<?= esc($p['name'] . ' · Rp' . number_format((int) $p['price_min'] / 1000, 0) . 'rb') ?>">
                  <?= esc($p['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="button" class="btn btn-outline btn-sm js-clear-pins">Hapus Semua Titik</button>
          </div>

          <div class="pin-chips-list js-pin-chips" aria-label="Daftar titik hotspot aktif"></div>
        </div>

        <div>
          <div class="form-group">
            <label>Label Pill</label>
            <input type="text" name="pill_label" class="form-control" value="<?= esc($slide['pill_label']) ?>" />
          </div>
          <div class="form-group">
            <label>Judul Slide</label>
            <input type="text" name="title" class="form-control" value="<?= esc($slide['title']) ?>" />
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" style="min-height:66px;"><?= esc($slide['description']) ?></textarea>
          </div>
          <div class="form-group">
            <label>Ganti Foto Slide</label>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
              <button type="button" class="btn btn-outline btn-sm js-pick-slide-img">Pilih dari Galeri</button>
              <label class="btn btn-outline btn-sm" style="cursor:pointer;">
                Unggah Baru
                <input type="file" name="image_upload" class="js-upload-slide-img" accept="image/*" hidden />
              </label>
            </div>
            <input type="hidden" name="image" class="js-slide-img-input" value="<?= esc($slide['image']) ?>" />
          </div>
          <div class="form-grid form-grid-2">
            <div class="form-group">
              <label>Urutan</label>
              <input type="number" name="sort_order" class="form-control" value="<?= (int) $slide['sort_order'] ?>" />
            </div>
            <div class="form-group" style="justify-content:center;">
              <label class="check-chip" style="margin-top:18px;">
                <input type="checkbox" name="is_active" value="1" <?= (int) $slide['is_active'] === 1 ? 'checked' : '' ?> />
                <span>Slide Aktif</span>
              </label>
            </div>
          </div>
          <input type="hidden" name="hotspots_json" class="js-hotspots-input" value='<?= esc($slide['hotspots'] ?? '[]', 'attr') ?>' />
          <button type="submit" class="btn btn-primary btn-sm" style="margin-top:8px;">✓ Simpan Perubahan Slide</button>
        </div>
      </div>
    </form>
  </div>
<?php endforeach; ?>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
  document.getElementById('btnPickNewSlide')?.addEventListener('click', () => {
    window.openMediaPicker((file) => {
      document.getElementById('newSlideInput').value = file.path;
      document.getElementById('newSlidePreview').src = file.url;
      document.getElementById('newSlideLabel').textContent = file.name;
    });
  });
  document.getElementById('newSlideUpload')?.addEventListener('change', (e) => {
    const f = e.target.files?.[0];
    if (!f) return;
    document.getElementById('newSlidePreview').src = URL.createObjectURL(f);
    document.getElementById('newSlideLabel').textContent = f.name + ' (unggah baru)';
  });

  document.querySelectorAll('.lookbook-editor-card').forEach(function (card) {
    const stage = card.querySelector('.js-hotspot-stage');
    const stageImg = card.querySelector('.js-stage-img');
    const layer = card.querySelector('.js-pins-layer');
    const chipsWrap = card.querySelector('.js-pin-chips');
    const select = card.querySelector('.js-hotspot-product');
    const input = card.querySelector('.js-hotspots-input');
    const clearBtn = card.querySelector('.js-clear-pins');

    let pins = [];
    try { pins = JSON.parse(input.value || '[]'); } catch (_) { pins = []; }

    function renderPins() {
      layer.innerHTML = '';
      chipsWrap.innerHTML = '';
      pins.forEach(function (p, idx) {
        const el = document.createElement('span');
        el.className = 'editor-pin';
        el.style.top = p.top + '%';
        el.style.left = p.left + '%';
        el.textContent = '+ ' + p.label;
        layer.appendChild(el);

        const chip = document.createElement('button');
        chip.type = 'button';
        chip.className = 'pin-chip-btn';
        chip.title = 'Klik untuk menghapus titik ini';
        chip.innerHTML = `<span>${p.label}</span> <span>✕</span>`;
        chip.addEventListener('click', () => {
          pins.splice(idx, 1);
          renderPins();
        });
        chipsWrap.appendChild(chip);
      });
      input.value = JSON.stringify(pins);
    }
    renderPins();

    stage.addEventListener('click', function (e) {
      const rect = stage.getBoundingClientRect();
      const left = Math.round(((e.clientX - rect.left) / rect.width) * 100);
      const top = Math.round(((e.clientY - rect.top) / rect.height) * 100);
      const opt = select.options[select.selectedIndex];
      const slug = opt.value;
      const label = opt.dataset.label || opt.textContent;
      pins = pins.filter((p) => p.slug !== slug);
      pins.push({ slug, label, top, left });
      renderPins();
    });

    clearBtn.addEventListener('click', function () {
      pins = [];
      renderPins();
    });

    card.querySelector('.js-pick-slide-img')?.addEventListener('click', () => {
      window.openMediaPicker((file) => {
        card.querySelector('.js-slide-img-input').value = file.path;
        stageImg.src = file.url;
      });
    });
    card.querySelector('.js-upload-slide-img')?.addEventListener('change', (e) => {
      const f = e.target.files?.[0];
      if (f) stageImg.src = URL.createObjectURL(f);
    });
  });
</script>
<?= $this->endSection() ?>
