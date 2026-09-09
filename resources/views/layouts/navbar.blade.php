
<header>
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
        <a class="navbar-brand" href="/" id="navbarBrand">Aisy Bina<span class="brand-dot">.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
            <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
            <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
            <li class="nav-item ms-lg-3 mt-2 mt-lg-0"><a class="btn btn-forest" href="/contact">Get in Touch</a></li>
            </ul>
        </div>
        </div>
    </nav>
</header>

@push('scripts')
    <script>
        function renderNavbarBrand(master) {
            if (master && master.website_name) {
            $("#navbarBrand").html(master.website_name + '<span class="brand-dot">.</span>');
            }
        }
    </script>
@endpush