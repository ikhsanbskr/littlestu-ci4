<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="panel-grid">
  <!-- Ulasan Pembeli -->
  <div class="card">
    <div class="card-head">
      <h2>Ulasan Pelanggan</h2>
    </div>
    <form action="<?= base_url('admin/content/review/store') ?>" method="post" style="margin-bottom:20px;padding-bottom:18px;border-bottom:1px solid var(--border);">
      <?= csrf_field() ?>
      <div class="form-grid form-grid-2">
        <div class="form-group">
          <label>Nama Pembeli</label>
          <input type="text" name="author_name" class="form-control" placeholder="Bunda Nadia" required />
        </div>
        <div class="form-group">
          <label>Kota</label>
          <input type="text" name="city" class="form-control" placeholder="Jakarta Selatan" required />
        </div>
      </div>
      <div class="form-grid form-grid-2">
        <div class="form-group">
          <label>Produk yang Dibeli</label>
          <input type="text" name="product_tag" class="form-control" placeholder="Alicia Set · Size L" required />
        </div>
        <div class="form-group">
          <label>Rating (1–5)</label>
          <input type="number" name="rating" class="form-control" min="1" max="5" value="5" />
        </div>
      </div>
      <div class="form-group">
        <label>Kutipan Ulasan</label>
        <textarea name="quote" class="form-control" style="min-height:68px;" required></textarea>
      </div>
      <input type="hidden" name="sort_order" value="<?= count($reviews) + 1 ?>" />
      <button type="submit" class="btn btn-primary btn-sm">+ Tambah Ulasan</button>
    </form>

    <div style="display:flex;flex-direction:column;gap:10px;">
      <?php foreach ($reviews as $rev): ?>
        <div style="padding:12px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--bg);display:flex;justify-content:space-between;gap:12px;align-items:flex-start;">
          <div>
            <strong><?= esc($rev['author_name']) ?></strong> · <span style="font-size:0.8rem;color:var(--muted);"><?= esc($rev['city']) ?> (<?= esc($rev['product_tag']) ?>)</span>
            <p style="font-size:0.86rem;margin-top:4px;">“<?= esc($rev['quote']) ?>”</p>
          </div>
          <form action="<?= base_url('admin/content/review/delete/' . $rev['id']) ?>" method="post" onsubmit="return confirm('Hapus ulasan ini?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- FAQ -->
  <div class="card">
    <div class="card-head">
      <h2>Tanya Jawab (FAQ)</h2>
    </div>
    <form action="<?= base_url('admin/content/faq/store') ?>" method="post" style="margin-bottom:20px;padding-bottom:18px;border-bottom:1px solid var(--border);">
      <?= csrf_field() ?>
      <div class="form-group">
        <label>Pertanyaan</label>
        <input type="text" name="question" class="form-control" required />
      </div>
      <div class="form-group">
        <label>Jawaban</label>
        <textarea name="answer" class="form-control" style="min-height:70px;" required></textarea>
      </div>
      <input type="hidden" name="sort_order" value="<?= count($faqs) + 1 ?>" />
      <button type="submit" class="btn btn-primary btn-sm">+ Tambah FAQ</button>
    </form>

    <div style="display:flex;flex-direction:column;gap:10px;">
      <?php foreach ($faqs as $faq): ?>
        <div style="padding:12px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--bg);display:flex;justify-content:space-between;gap:12px;align-items:flex-start;">
          <div>
            <strong style="font-size:0.9rem;"><?= esc($faq['question']) ?></strong>
            <p style="font-size:0.84rem;color:var(--muted);margin-top:4px;"><?= esc($faq['answer']) ?></p>
          </div>
          <form action="<?= base_url('admin/content/faq/delete/' . $faq['id']) ?>" method="post" onsubmit="return confirm('Hapus FAQ ini?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Tabel Panduan Ukuran -->
<div class="card">
  <div class="card-head">
    <h2>Tabel Panduan Ukuran Standar (S – 5L)</h2>
  </div>
  <form action="<?= base_url('admin/content/size/update') ?>" method="post">
    <?= csrf_field() ?>
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Ukuran</th>
            <th>Estimasi Usia</th>
            <th>Tinggi Badan</th>
            <th>Berat Badan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sizeGuides as $sg): ?>
            <tr>
              <td>
                <input type="hidden" name="id[]" value="<?= (int) $sg['id'] ?>" />
                <strong><?= esc($sg['size_code']) ?></strong>
              </td>
              <td><input type="text" name="age_range[]" class="form-control" value="<?= esc($sg['age_range']) ?>" /></td>
              <td><input type="text" name="height_range[]" class="form-control" value="<?= esc($sg['height_range']) ?>" /></td>
              <td><input type="text" name="weight_range[]" class="form-control" value="<?= esc($sg['weight_range']) ?>" /></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:16px;">Simpan Tabel Ukuran</button>
  </form>
</div>

<?= $this->endSection() ?>
