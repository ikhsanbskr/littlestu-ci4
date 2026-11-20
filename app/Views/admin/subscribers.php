<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-head">
    <h2>Daftar Email Newsletter (<?= count($subscribers) ?>)</h2>
    <a href="<?= base_url('admin/subscribers/export') ?>" class="btn btn-primary btn-sm">Unduh CSV / Excel</a>
  </div>

  <?php if (empty($subscribers)): ?>
    <p style="color:var(--muted);font-size:0.9rem;">Belum ada pelanggan yang mendaftarkan email melalui formulir *Join Our Little Family*.</p>
  <?php else: ?>
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Alamat Email</th>
            <th>Tanggal Daftar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($subscribers as $sub): ?>
            <tr>
              <td><?= (int) $sub['id'] ?></td>
              <td><strong><?= esc($sub['email']) ?></strong></td>
              <td><?= esc($sub['created_at']) ?></td>
              <td>
                <form action="<?= base_url('admin/subscribers/delete/' . $sub['id']) ?>" method="post" onsubmit="return confirm('Hapus email ini?');">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
