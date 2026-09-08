<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 — Halaman Tidak Ditemukan | Aisy Bina Exports</title>
  <meta name="robots" content="noindex, nofollow">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,500;0,600;1,400&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root {
      --cream: #faf6ec;
      --cream-dim: #f0e9d8;
      --white: #ffffff;
      --forest: #1f3b2e;
      --forest-soft: #52685c;
      --forest-dark: #16281f;
      --gold: #b98b3e;
      --gold-soft: #d9b978;
      --line: rgba(31, 59, 46, 0.14);
      --line-strong: rgba(31, 59, 46, 0.28);

      --font-display: "Fraunces", serif;
      --font-body: "Work Sans", sans-serif;
      --radius: 14px;
    }

    * { box-sizing: border-box; }

    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      font-family: var(--font-body);
      color: var(--forest);
      background-color: var(--cream-dim);
      background-image:
        radial-gradient(circle at 12% 18%, rgba(185, 139, 62, 0.14), transparent 42%),
        radial-gradient(circle at 88% 82%, rgba(31, 59, 46, 0.10), transparent 45%);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1.25rem;
      -webkit-font-smoothing: antialiased;
    }

    .notfound-wrap {
      max-width: 560px;
      width: 100%;
      text-align: center;
    }

    .notfound-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      padding: 0.4rem 0.9rem;
      border-radius: 999px;
      background-color: rgba(31, 59, 46, 0.06);
      border: 1px solid var(--line);
      color: var(--forest-soft);
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin-bottom: 1.75rem;
    }
    .notfound-badge i { color: var(--gold); }

    .notfound-number {
      font-family: var(--font-display);
      font-weight: 600;
      font-size: clamp(5rem, 18vw, 9rem);
      line-height: 1;
      color: var(--forest);
      margin: 0;
      letter-spacing: -0.02em;
      position: relative;
      display: inline-block;
    }

    .notfound-number .zero-wrap {
      display: inline-block;
      position: relative;
      width: 0.62em;
    }

    .notfound-number .zero-wrap i {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -54%);
      font-size: 0.34em;
      color: var(--gold);
      animation: float 2.6s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translate(-50%, -54%) rotate(0deg); }
      50% { transform: translate(-50%, -64%) rotate(6deg); }
    }

    .notfound-title {
      font-family: var(--font-display);
      font-weight: 500;
      font-size: 1.6rem;
      margin: 0.75rem 0 0.6rem;
      color: var(--forest);
    }

    .notfound-text {
      color: var(--forest-soft);
      font-size: 1rem;
      line-height: 1.65;
      margin: 0 auto 2.1rem;
      max-width: 440px;
    }

    .notfound-actions {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      flex-wrap: wrap;
      margin-bottom: 2.5rem;
    }

    .btn-notfound {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.92rem;
      text-decoration: none;
      border: 1px solid transparent;
      transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.15s ease;
    }
    .btn-notfound:active { transform: translateY(1px); }

    .btn-notfound-forest {
      background-color: var(--forest);
      color: var(--cream);
    }
    .btn-notfound-forest:hover { background-color: var(--forest-dark); color: var(--cream); }

    .btn-notfound-outline {
      background-color: transparent;
      border-color: var(--line-strong);
      color: var(--forest);
    }
    .btn-notfound-outline:hover { border-color: var(--forest); background-color: rgba(31, 59, 46, 0.05); }

    .notfound-divider {
      width: 64px;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold-soft), transparent);
      margin: 0 auto 1.6rem;
    }

    .notfound-search {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background-color: var(--white);
      border: 1px solid var(--line);
      border-radius: 999px;
      padding: 0.35rem 0.35rem 0.35rem 1.1rem;
      max-width: 380px;
      margin: 0 auto;
      box-shadow: 0 8px 24px rgba(31, 59, 46, 0.06);
    }
    .notfound-search i { color: var(--forest-soft); font-size: 0.95rem; }
    .notfound-search input {
      flex: 1;
      border: none;
      outline: none;
      background: transparent;
      font-family: var(--font-body);
      font-size: 0.9rem;
      color: var(--forest);
      padding: 0.5rem 0;
    }
    .notfound-search input::placeholder { color: var(--forest-soft); opacity: 0.7; }
    .notfound-search button {
      border: none;
      background-color: var(--gold);
      color: var(--white);
      border-radius: 999px;
      width: 38px;
      height: 38px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    .notfound-search button:hover { background-color: #a17a34; }

    .notfound-footer {
      margin-top: 2.75rem;
      font-size: 0.82rem;
      color: var(--forest-soft);
      opacity: 0.75;
    }

    @media (max-width: 420px) {
      .btn-notfound { width: 100%; justify-content: center; }
      .notfound-actions { flex-direction: column; }
    }
  </style>
</head>
<body>
  <div class="notfound-wrap">
    <span class="notfound-badge"><i class="bi bi-compass"></i> Page Notfound</span>
    <h1 class="notfound-number">4<span class="zero-wrap">0<i class="bi bi-flower1"></i></span>4</h1>
    <br><br><br>
    <div class="notfound-actions">
      <a href="/" class="btn-notfound btn-notfound-forest"><i class="bi bi-house-door"></i>Home</a>
      <a href="javascript:history.back()" class="btn-notfound btn-notfound-outline"><i class="bi bi-arrow-left"></i>Back</a>
    </div>
    <div class="notfound-divider"></div>
  </div>
</body>
</html>