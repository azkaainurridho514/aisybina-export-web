const BOOTSTRAP_ICON_OPTIONS = [
    // =========================
    // GLOBAL / INTERNATIONAL TRADE
    // =========================
    { value: "bi-globe", label: "Global / International" },
    { value: "bi-globe2", label: "World" },
    { value: "bi-globe-americas", label: "Global Americas" },
    { value: "bi-globe-asia-australia", label: "Asia Australia" },
    { value: "bi-globe-europe-africa", label: "Europe Africa" },
    { value: "bi-map", label: "Map" },
    { value: "bi-map-fill", label: "Map Fill" },
    { value: "bi-geo-alt", label: "Location" },
    { value: "bi-geo-alt-fill", label: "Location Fill" },
    { value: "bi-pin-map", label: "Destination" },
    { value: "bi-pin-map-fill", label: "Destination Fill" },
    { value: "bi-compass", label: "Compass" },

    // =========================
    // EXPORT / SHIPPING
    // =========================
    { value: "bi-box-seam", label: "Export Package" },
    { value: "bi-box-seam-fill", label: "Export Package Fill" },
    { value: "bi-box", label: "Package" },
    { value: "bi-box-fill", label: "Package Fill" },
    { value: "bi-boxes", label: "Multiple Packages" },
    { value: "bi-truck", label: "Truck / Land Shipping" },
    { value: "bi-truck-front", label: "Truck Front" },
    { value: "bi-truck-front-fill", label: "Truck Front Fill" },
    { value: "bi-ship", label: "Sea Freight" },
    { value: "bi-ship-fill", label: "Sea Freight Fill" },
    { value: "bi-airplane", label: "Air Freight" },
    { value: "bi-airplane-fill", label: "Air Freight Fill" },
    { value: "bi-airplane-engines", label: "Air Cargo" },
    { value: "bi-send", label: "Shipping / Send" },
    { value: "bi-send-fill", label: "Shipping / Send Fill" },
    { value: "bi-box-arrow-up", label: "Export / Outbound" },
    { value: "bi-box-arrow-down", label: "Import / Inbound" },
    { value: "bi-arrow-up-right", label: "Export Direction" },
    { value: "bi-arrow-down-left", label: "Import Direction" },
    { value: "bi-signpost", label: "Route" },
    { value: "bi-signpost-2", label: "Route 2" },

    // =========================
    // PRODUCTS / GOODS
    // =========================
    { value: "bi-box", label: "Product" },
    { value: "bi-bag", label: "Goods / Products" },
    { value: "bi-bag-fill", label: "Goods Fill" },
    { value: "bi-basket", label: "Products Basket" },
    { value: "bi-basket-fill", label: "Products Basket Fill" },
    { value: "bi-cart", label: "Order" },
    { value: "bi-cart-fill", label: "Order Fill" },
    { value: "bi-cart-check", label: "Order Confirmed" },
    { value: "bi-shop", label: "Marketplace / Supplier" },
    { value: "bi-shop-window", label: "Store" },
    { value: "bi-tags", label: "Product Categories" },
    { value: "bi-tags-fill", label: "Product Categories Fill" },
    { value: "bi-tag", label: "Product Tag" },
    { value: "bi-tag-fill", label: "Product Tag Fill" },

    // =========================
    // COMPANY / SUPPLIER / FACTORY
    // =========================
    { value: "bi-building", label: "Company" },
    { value: "bi-buildings", label: "Companies" },
    { value: "bi-building-fill", label: "Company Fill" },
    { value: "bi-shop", label: "Supplier" },
    { value: "bi-briefcase", label: "Business" },
    { value: "bi-briefcase-fill", label: "Business Fill" },
    { value: "bi-people", label: "Business Partners" },
    { value: "bi-people-fill", label: "Business Partners Fill" },
    { value: "bi-person", label: "Customer / Buyer" },
    { value: "bi-person-check", label: "Verified Customer" },
    { value: "bi-person-plus", label: "New Partner" },
    { value: "bi-diagram-3", label: "Business Network" },
    { value: "bi-diagram-3-fill", label: "Business Network Fill" },
    { value: "bi-diagram-2", label: "Supply Chain" },
    { value: "bi-diagram-2-fill", label: "Supply Chain Fill" },
    { value: "bi-gear", label: "Production" },
    { value: "bi-gear-fill", label: "Production Fill" },
    { value: "bi-tools", label: "Manufacturing" },
    { value: "bi-wrench", label: "Equipment" },

    // =========================
    // QUALITY / CERTIFICATION
    // =========================
    { value: "bi-award", label: "Quality / Award" },
    { value: "bi-award-fill", label: "Quality Award Fill" },
    { value: "bi-patch-check", label: "Certified" },
    { value: "bi-patch-check-fill", label: "Certified Fill" },
    { value: "bi-check-circle", label: "Quality Check" },
    { value: "bi-check-circle-fill", label: "Quality Check Fill" },
    { value: "bi-shield-check", label: "Quality Assurance" },
    { value: "bi-shield-check-fill", label: "Quality Assurance Fill" },
    { value: "bi-star", label: "Quality / Rating" },
    { value: "bi-star-fill", label: "Quality Rating Fill" },
    { value: "bi-trophy", label: "Achievement" },
    { value: "bi-medal", label: "Certification / Medal" },

    // =========================
    // DOCUMENTS / EXPORT PAPERWORK
    // =========================
    { value: "bi-file", label: "Document" },
    { value: "bi-file-fill", label: "Document Fill" },
    { value: "bi-file-text", label: "Document Text" },
    { value: "bi-file-text-fill", label: "Document Text Fill" },
    { value: "bi-file-earmark", label: "File" },
    { value: "bi-file-earmark-text", label: "File Document" },
    { value: "bi-journal", label: "Records" },
    { value: "bi-journal-text", label: "Records Text" },
    { value: "bi-clipboard", label: "Checklist" },
    { value: "bi-clipboard-check", label: "Verified Document" },
    { value: "bi-receipt", label: "Invoice / Receipt" },
    { value: "bi-receipt-cutoff", label: "Invoice" },
    { value: "bi-folder", label: "Documents Folder" },
    { value: "bi-folder-fill", label: "Documents Folder Fill" },
    { value: "bi-bookmark", label: "Reference" },
    { value: "bi-bookmark-fill", label: "Reference Fill" },

    // =========================
    // PAYMENT / FINANCE
    // =========================
    { value: "bi-cash", label: "Payment" },
    { value: "bi-cash-stack", label: "Money / Payment" },
    { value: "bi-wallet", label: "Wallet" },
    { value: "bi-wallet-fill", label: "Wallet Fill" },
    { value: "bi-credit-card", label: "Payment Card" },
    { value: "bi-credit-card-fill", label: "Payment Card Fill" },
    { value: "bi-bank", label: "Bank" },
    { value: "bi-currency-dollar", label: "USD / Dollar" },
    { value: "bi-currency-euro", label: "EUR / Euro" },
    { value: "bi-currency-pound", label: "GBP / Pound" },
    { value: "bi-currency-yen", label: "JPY / Yen" },
    { value: "bi-percent", label: "Percentage" },
    { value: "bi-calculator", label: "Price Calculator" },

    // =========================
    // COMMUNICATION / INQUIRY
    // =========================
    { value: "bi-envelope", label: "Email" },
    { value: "bi-envelope-fill", label: "Email Fill" },
    { value: "bi-envelope-open", label: "Open Email" },
    { value: "bi-chat", label: "Inquiry / Chat" },
    { value: "bi-chat-fill", label: "Chat Fill" },
    { value: "bi-chat-dots", label: "Inquiry" },
    { value: "bi-chat-dots-fill", label: "Inquiry Fill" },
    { value: "bi-telephone", label: "Telephone" },
    { value: "bi-telephone-fill", label: "Telephone Fill" },
    { value: "bi-phone", label: "Phone" },
    { value: "bi-whatsapp", label: "WhatsApp" },
    { value: "bi-send", label: "Send Inquiry" },
    { value: "bi-megaphone", label: "Announcement" },

    // =========================
    // CUSTOMER / TRUST
    // =========================
    { value: "bi-person-check", label: "Verified Buyer" },
    { value: "bi-people", label: "Customers" },
    { value: "bi-handshake", label: "Partnership" },
    { value: "bi-hand-thumbs-up", label: "Customer Satisfaction" },
    { value: "bi-heart", label: "Customer Care" },
    { value: "bi-star", label: "Customer Rating" },
    { value: "bi-shield-check", label: "Trust / Security" },
    { value: "bi-lock", label: "Secure" },
    { value: "bi-key", label: "Access / Security" },

    // =========================
    // LOGISTICS / WAREHOUSE
    // =========================
    { value: "bi-boxes", label: "Warehouse" },
    { value: "bi-box-seam", label: "Packaging" },
    { value: "bi-truck", label: "Delivery" },
    { value: "bi-clock", label: "Delivery Time" },
    { value: "bi-stopwatch", label: "Fast Delivery" },
    { value: "bi-speedometer", label: "Shipping Speed" },
    { value: "bi-geo-alt", label: "Delivery Location" },
    { value: "bi-pin-map", label: "Destination" },
    { value: "bi-signpost", label: "Shipping Route" },

    // =========================
    // INDONESIA / ORIGIN
    // =========================
    { value: "bi-flag", label: "Country" },
    { value: "bi-flag-fill", label: "Country Fill" },
    { value: "bi-globe", label: "Indonesia / Global" },
    { value: "bi-house", label: "Origin" },
    { value: "bi-geo-alt", label: "Origin Location" },
    { value: "bi-pin-map", label: "Product Origin" },

    // =========================
    // CONTACT / COMPANY INFO
    // =========================
    { value: "bi-info-circle", label: "Information" },
    { value: "bi-info-circle-fill", label: "Information Fill" },
    { value: "bi-question-circle", label: "FAQ / Help" },
    { value: "bi-question-circle-fill", label: "FAQ Fill" },
    { value: "bi-clock", label: "Business Hours" },
    { value: "bi-calendar", label: "Schedule" },
    { value: "bi-geo-alt", label: "Office Location" },
    { value: "bi-envelope", label: "Business Email" },
    { value: "bi-telephone", label: "Business Phone" },

    // =========================
    // WEBSITE / DIGITAL
    // =========================
    { value: "bi-globe", label: "Website" },
    { value: "bi-link", label: "Website Link" },
    { value: "bi-link-45deg", label: "External Link" },
    { value: "bi-search", label: "Search" },
    { value: "bi-filter", label: "Filter" },
    { value: "bi-grid", label: "Products Grid" },
    { value: "bi-list", label: "Products List" },
    { value: "bi-download", label: "Download Catalog" },
    { value: "bi-cloud-arrow-down", label: "Download File" },

    // =========================
    // GENERAL BUSINESS
    // =========================
    { value: "bi-lightbulb", label: "Innovation" },
    { value: "bi-lightbulb-fill", label: "Innovation Fill" },
    { value: "bi-rocket", label: "Growth" },
    { value: "bi-rocket-fill", label: "Growth Fill" },
    { value: "bi-graph-up", label: "Business Growth" },
    { value: "bi-graph-up-arrow", label: "Growth Up" },
    { value: "bi-bar-chart", label: "Statistics" },
    { value: "bi-bar-chart-fill", label: "Statistics Fill" },
    { value: "bi-pie-chart", label: "Business Data" },
    { value: "bi-pie-chart-fill", label: "Business Data Fill" },
    { value: "bi-trophy", label: "Achievement" },
    { value: "bi-award", label: "Achievement Award" },
    { value: "bi-star", label: "Featured" },
    { value: "bi-star-fill", label: "Featured Fill" }
];




/**
 * Asset Library
 *
 * Menyimpan daftar asset yang dapat dipilih
 * melalui asset picker pada form admin.
 */
var ASSET_LIBRARY = {
    site: [
        {
            value: "/images/logo.png",
            label: "Logo"
        },
        {
            value: "/images/hero.jpg",
            label: "Hero"
        },
        {
            value: "/images/about.jpg",
            label: "About"
        }
    ],

    global_reach: [
        {
            value: "/images/global-reach.jpg",
            label: "Global Reach"
        },
        {
            value: "/images/global-reach-1.jpg",
            label: "Global Reach 1"
        },
        {
            value: "/images/global-reach-2.jpg",
            label: "Global Reach 2"
        },
        {
            value: "/images/global-reach-3.jpg",
            label: "Global Reach 3"
        }
    ],

    products: [
        {
            value: "/images/product-placeholder.jpg",
            label: "Product Placeholder"
        }
    ]
};