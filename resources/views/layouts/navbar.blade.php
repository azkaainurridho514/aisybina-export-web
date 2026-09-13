<header>
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center justify-content-center gap-2" href="/" id="navbarBrand">
                <img id="navbarLogo" src="" alt="" style="width: 35px; height: 35px; object-fit: contain;">
                <span id="navbarWebsiteName"></span>
                <span class="brand-dot">.</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-forest" href="/contact">Get in Touch</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

@push('scripts')
    <script>
       function renderNavbarBrand(master) {
            if (master) {
                $("#navbarWebsiteName").text(master.website_name || "");
                $("#navbarLogo").attr({
                    src: master.logo || "",
                    alt: master.website_name || ""
                });
            }
        }
    </script>
@endpush