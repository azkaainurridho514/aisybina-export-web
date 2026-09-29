<footer class="bg-forest site-footer pt-5 pb-4">
    <div class="container">
        <div class="row gy-4">
        <div class="col-lg-5">
            <div class="footer-brand">
                {{ $master->website_name ?? '' }}@if (!empty($master->website_name)).@endif
            </div>
            {{-- CATATAN: JS lama menaruh "website_slug" di sini sebagai deskripsi
                 (bukan "website_description"). Sepertinya kurang tepat — cek lagi,
                 kalau memang mau pakai deskripsi asli tinggal ganti ke
                 $master->website_description. Untuk sekarang saya samakan
                 persis dengan perilaku lama supaya tidak diam-diam saya ubah. --}}
            <p class="text-on-forest">{{ $master->website_slug ?? '' }}</p>

            @php
                $socials = [
                    'instagram' => 'bi-instagram',
                    'facebook' => 'bi-facebook',
                    'tiktok' => 'bi-tiktok',
                    'youtube' => 'bi-youtube',
                ];
            @endphp
            <ul class="footer-social list-inline">
                @foreach ($socials as $key => $icon)
                    @if (!empty($contact->$key))
                        <li class="list-inline-item">
                            <a href="{{ $contact->$key }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($key) }}">
                                <i class="bi {{ $icon }}"></i>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="col-lg-3 col-6">
            <h4>Links</h4>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/products">Products</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
        <div class="col-lg-4 col-6">
            <h4>Contact</h4>
            <ul>
                @if (!empty($contact->email))
                    <li>Email<br><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></li>
                @endif
                @if (!empty($contact->whatsapp))
                    <li>WhatsApp<br><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->whatsapp) }}" target="_blank" rel="noopener">{{ $contact->whatsapp }}</a></li>
                @endif
                @if (!empty($contact->location))
                    <li>Location<br>{{ $contact->location }}</li>
                @endif
            </ul>
        </div>
        </div>
        <div class="footer-bottom text-center text-on-forest">&copy; {{ date('Y') }} {{ $master->website_name ?? 'Aisy Bina Exports' }}. All rights reserved.</div>
    </div>
</footer>
