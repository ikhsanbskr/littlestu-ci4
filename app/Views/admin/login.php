<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk Admin — LITTLESTU</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('css/admin.css') ?>" />
</head>
<body>
  <div class="login-shell">
    <div class="login-card">
      <div class="login-brand">
        <strong>LITTLESTU</strong>
        <span>Admin</span>
      </div>
      <h1>Masuk ke Dashboard</h1>
      <p class="login-sub">Kelola katalog pakaian anak, *lookbook*, dan statistik toko dari satu tempat.</p>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>

      <form action="<?= base_url('admin/login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
          <label for="identity">Username atau Email</label>
          <input type="text" id="identity" name="identity" class="form-control" value="<?= old('identity', 'littlestu') ?>" placeholder="littlestu" required autofocus />
        </div>
        <div class="form-group">
          <label for="password">Kata Sandi</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required />
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; margin-top: 6px;">Masuk Dashboard</button>
      </form>

      <p style="margin-top: 20px; text-align: center; font-size: 0.82rem; color: var(--muted);">
        <a href="<?= base_url('/') ?>" style="text-decoration: underline;">← Kembali ke Halaman Katalog</a>
      </p>
    </div>
  </div>
</body>
</html>
