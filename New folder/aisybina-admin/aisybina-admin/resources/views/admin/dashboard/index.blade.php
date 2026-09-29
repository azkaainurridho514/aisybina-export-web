@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
  @php
    $firstName = trim(explode(' ', trim(auth()->user()->name ?? ''))[0] ?? '');
    $cards = [
      ['bi-box-seam',     $stats['products'],   'Total Produk'],
      ['bi-tag',          $stats['categories'], 'Total Kategori'],
      ['bi-envelope-open', $stats['inquiries'], 'Inquiry Masuk'],
      ['bi-signpost-split', $stats['process'],  'Langkah Proses'],
    ];
  @endphp

  <section class="admin-section active">
    <div class="admin-section-head">
      <div>
        <h1>Selamat datang kembali{{ $firstName !== '' ? ', ' . $firstName : '' }}.</h1>
        <p>Ringkasan singkat konten dan aktivitas website Aisy Bina Exports.</p>
      </div>
    </div>

    <div class="row g-3 mb-4">
      @foreach ($cards as [$icon, $value, $label])
        <div class="col-6 col-lg-3">
          <div class="stat-card">
            <div class="stat-card-icon"><i class="bi {{ $icon }}"></i></div>
            <div class="stat-card-value">{{ number_format((int) $value) }}</div>
            <div class="stat-card-label">{{ $label }}</div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="admin-card">
      <div class="admin-card-head">
        <h2>Panduan singkat</h2>
      </div>
      <div class="admin-table-wrap" style="padding: 1.3rem;">
        <p class="mb-2"><strong>Site Content</strong> berisi teks tetap website (hero, about, footer, contact). Cukup ubah lalu simpan, tidak ada tambah atau hapus baris.</p>
        <p class="mb-2"><strong>Categories, Products, Export Process, Why Choose Us, About Items, dan Business Hours</strong> berbentuk daftar. Tambah, ubah, dan hapus lewat tombol di tiap halaman.</p>
        <p class="mb-2"><strong>Inquiries</strong> adalah kiriman form kontak dari pengunjung. Datanya hanya bisa dilihat, lalu dihapus setelah ditindaklanjuti.</p>
        <p class="mb-0 text-muted" style="font-size:.85rem;">Angka di atas diperbarui otomatis setiap beberapa menit, dan langsung diperbarui saat kategori atau produk diubah.</p>
      </div>
    </div>
  </section>
@endsection
