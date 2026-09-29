@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Selamat datang kembali.</h1>
        <p>Ringkasan singkat konten dan aktivitas website Aisy Bina Exports.</p>
      </div>
    </div>

    <div class="row g-3 mb-4">
      @foreach ([
        ['bi-box-seam',      $stats['products'],   'Total Produk',    'admin.products.index'],
        ['bi-tag',           $stats['categories'], 'Total Kategori',  'admin.categories.index'],
        ['bi-envelope-open', $stats['inquiries'],  'Inquiry Masuk',   'admin.inquiries.index'],
        ['bi-signpost-split',$stats['process'],    'Langkah Proses',  'admin.our-process.index'],
      ] as [$icon, $value, $label, $route])
        <div class="col-6 col-lg-3">
          <a href="{{ route($route) }}" class="stat-card d-block text-decoration-none">
            <div class="stat-card-icon"><i class="bi {{ $icon }}"></i></div>
            <div class="stat-card-value">{{ number_format($value) }}</div>
            <div class="stat-card-label">{{ $label }}</div>
          </a>
        </div>
      @endforeach
    </div>

    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Cara pakai panel ini</h2>
      </div>
      <div class="admin-table-wrap" style="padding: 1.3rem;">
        <p class="mb-2"><strong>Site Content</strong> berisi teks singleton (hero, about, footer, contact) — cukup edit lalu simpan, tidak ada tambah/hapus baris.</p>
        <p class="mb-2"><strong>Categories, Products, Our Mission, Our Value, Export Process, Why Choose Us, About Items, Business Hours</strong> adalah data berbentuk daftar — bisa tambah, edit, dan hapus lewat tombol di tiap tabel.</p>
        <p class="mb-0"><strong>Inquiries</strong> bersifat baca-saja (data kiriman form kontak), dengan opsi hapus dan export Excel.</p>
      </div>
    </div>
  </section>
@endsection
