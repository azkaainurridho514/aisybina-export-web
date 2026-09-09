<footer class="bg-forest site-footer pt-5 pb-4">
    <div class="container">
        <div class="row gy-4">
        <div class="col-lg-5">
            <div class="footer-brand" id="footerBrand"></div>
            <p class="text-on-forest" id="footerDescription"></p>
            <ul class="footer-social list-inline" id="footerSocial"></ul>
        </div>
        <div class="col-lg-3 col-6">
            <h4>Links</h4>
            <ul><li><a href="/">Home</a></li><li><a href="/products">Products</a></li><li><a href="/contact">Contact</a></li></ul>
        </div>
        <div class="col-lg-4 col-6">
            <h4>Contact</h4>
            <ul id="footerContactList">
              <!-- email, whatsapp, location di-generate di sini -->
            </ul>
        </div>
        </div>
        <div class="footer-bottom text-center text-on-forest">&copy; <span id="footerYear">2026</span> <span id="footerBrandBottom">Aisy Bina Exports</span>. All rights reserved.</div>
    </div>
</footer>


@push('scripts')
    <script>
        function renderFooter(master, contact) {
            master = master || {};
            contact = contact || {};

            // Brand & description
            if (master.website_name) {
                $("#footerBrand").html(master.website_name + ".");
                $("#footerBrandBottom").text(master.website_name);
            }
            $("#footerDescription").text( master.website_slug);

            let contactHtml = "";

            if (contact.email) {
            contactHtml += `
                <li>Email<br><a href="mailto:${contact.email}">${contact.email}</a></li>`;
            }

            if (contact.whatsapp) {
            const waNumber = contact.whatsapp.replace(/[^0-9]/g, "");
            contactHtml += `
                <li>WhatsApp<br><a href="https://wa.me/${waNumber}" target="_blank" rel="noopener">${contact.whatsapp}</a></li>`;
            }

            if (contact.location) {
            contactHtml += `
                <li>Location<br>${contact.location}</li>`;
            }

            $("#footerContactList").html(contactHtml);

            // ===== Social media icons — tampil hanya kalau ada isinya =====
            const socials = [
            { key: "instagram", icon: "bi-instagram", label: "Instagram" },
            { key: "facebook",  icon: "bi-facebook",  label: "Facebook" },
            { key: "tiktok",    icon: "bi-tiktok",    label: "TikTok" },
            { key: "youtube",   icon: "bi-youtube",   label: "YouTube" },
            ];

            let socialHtml = "";
            socials.forEach(function (s) {
            if (contact[s.key]) {
                socialHtml += `
                <li class="list-inline-item">
                    <a href="${contact[s.key]}" target="_blank" rel="noopener" aria-label="${s.label}">
                    <i class="bi ${s.icon}"></i>
                    </a>
                </li>`;
            }
            });
            $("#footerSocial").html(socialHtml);

            // Tahun otomatis
            $("#footerYear").text(new Date().getFullYear());
        }
    </script>
@endpush