const BOOTSTRAP_ICON_OPTIONS = [

    // =========================================================
    // GLOBAL / INTERNATIONAL / LOCATION
    // =========================================================
    { value: "bi-globe", label: "Global / International" },
    { value: "bi-globe2", label: "World" },
    { value: "bi-globe-americas", label: "Americas" },
    { value: "bi-globe-asia-australia", label: "Asia / Australia" },
    { value: "bi-globe-europe-africa", label: "Europe / Africa" },
    { value: "bi-map", label: "Map" },
    { value: "bi-map-fill", label: "Map Fill" },
    { value: "bi-map-pin", label: "Map Pin" },
    { value: "bi-geo", label: "Geography" },
    { value: "bi-geo-fill", label: "Geography Fill" },
    { value: "bi-geo-alt", label: "Location" },
    { value: "bi-geo-alt-fill", label: "Location Fill" },
    { value: "bi-pin-map", label: "Destination" },
    { value: "bi-pin-map-fill", label: "Destination Fill" },
    { value: "bi-compass", label: "Compass" },
    { value: "bi-signpost", label: "Route" },
    { value: "bi-signpost-2", label: "Route 2" },
    { value: "bi-signpost-split", label: "Route Split" },
    { value: "bi-house", label: "Home / Origin" },
    { value: "bi-house-fill", label: "Home Fill" },


    // =========================================================
    // EXPORT / IMPORT / SHIPPING
    // =========================================================
    { value: "bi-box-arrow-up", label: "Export / Outbound" },
    { value: "bi-box-arrow-up-right", label: "Export / External" },
    { value: "bi-box-arrow-down", label: "Import / Inbound" },
    { value: "bi-box-arrow-down-left", label: "Import / Incoming" },
    { value: "bi-send", label: "Shipping / Send" },
    { value: "bi-send-fill", label: "Shipping / Send Fill" },
    { value: "bi-send-check", label: "Shipment Sent" },
    { value: "bi-send-check-fill", label: "Shipment Confirmed" },
    { value: "bi-truck", label: "Truck / Land Shipping" },
    { value: "bi-truck-front", label: "Truck Front" },
    { value: "bi-truck-front-fill", label: "Truck Front Fill" },
    { value: "bi-ship", label: "Sea Freight" },
    { value: "bi-ship-fill", label: "Sea Freight Fill" },
    { value: "bi-airplane", label: "Air Freight" },
    { value: "bi-airplane-fill", label: "Air Freight Fill" },
    { value: "bi-airplane-engines", label: "Air Cargo" },
    { value: "bi-airplane-engines-fill", label: "Air Cargo Fill" },
    { value: "bi-box-seam", label: "Export Package" },
    { value: "bi-box-seam-fill", label: "Export Package Fill" },
    { value: "bi-box", label: "Package" },
    { value: "bi-box-fill", label: "Package Fill" },
    { value: "bi-boxes", label: "Multiple Packages" },
    { value: "bi-arrow-up", label: "Outbound" },
    { value: "bi-arrow-up-right", label: "Export Direction" },
    { value: "bi-arrow-down", label: "Inbound" },
    { value: "bi-arrow-down-left", label: "Import Direction" },
    { value: "bi-arrow-repeat", label: "Logistics / Cycle" },
    { value: "bi-arrow-left-right", label: "Trade / Exchange" },


    // =========================================================
    // PRODUCTS / GOODS / CATALOG
    // =========================================================
    { value: "bi-box", label: "Product" },
    { value: "bi-box2", label: "Product Box" },
    { value: "bi-box2-fill", label: "Product Box Fill" },
    { value: "bi-box-seam", label: "Packaged Product" },
    { value: "bi-bag", label: "Goods / Products" },
    { value: "bi-bag-fill", label: "Goods Fill" },
    { value: "bi-bag-check", label: "Product Checked" },
    { value: "bi-bag-check-fill", label: "Product Checked Fill" },
    { value: "bi-basket", label: "Products Basket" },
    { value: "bi-basket-fill", label: "Products Basket Fill" },
    { value: "bi-cart", label: "Order / Cart" },
    { value: "bi-cart-fill", label: "Order Cart Fill" },
    { value: "bi-cart-check", label: "Order Confirmed" },
    { value: "bi-cart-check-fill", label: "Order Confirmed Fill" },
    { value: "bi-cart-plus", label: "Add Product" },
    { value: "bi-cart-plus-fill", label: "Add Product Fill" },
    { value: "bi-tags", label: "Product Categories" },
    { value: "bi-tags-fill", label: "Product Categories Fill" },
    { value: "bi-tag", label: "Product Tag" },
    { value: "bi-tag-fill", label: "Product Tag Fill" },
    { value: "bi-grid", label: "Product Grid" },
    { value: "bi-grid-3x3", label: "Product Catalog" },
    { value: "bi-list", label: "Product List" },
    { value: "bi-list-ul", label: "Product List Bullets" },
    { value: "bi-book", label: "Product Catalog / Book" },
    { value: "bi-journal", label: "Catalog / Records" },
    { value: "bi-journal-text", label: "Catalog Details" },


    // =========================================================
    // COMPANY / SUPPLIER / FACTORY
    // =========================================================
    { value: "bi-building", label: "Company" },
    { value: "bi-building-fill", label: "Company Fill" },
    { value: "bi-buildings", label: "Companies" },
    { value: "bi-buildings-fill", label: "Companies Fill" },
    { value: "bi-shop", label: "Supplier / Marketplace" },
    { value: "bi-shop-window", label: "Store / Supplier" },
    { value: "bi-store", label: "Store" },
    { value: "bi-store-fill", label: "Store Fill" },
    { value: "bi-briefcase", label: "Business" },
    { value: "bi-briefcase-fill", label: "Business Fill" },
    { value: "bi-briefcase-check", label: "Verified Business" },
    { value: "bi-briefcase-check-fill", label: "Verified Business Fill" },
    { value: "bi-person", label: "Customer / Buyer" },
    { value: "bi-person-fill", label: "Customer Fill" },
    { value: "bi-person-check", label: "Verified Customer" },
    { value: "bi-person-check-fill", label: "Verified Customer Fill" },
    { value: "bi-person-plus", label: "New Partner" },
    { value: "bi-person-plus-fill", label: "New Partner Fill" },
    { value: "bi-people", label: "Business Partners" },
    { value: "bi-people-fill", label: "Business Partners Fill" },
    { value: "bi-people-fill", label: "Team" },
    { value: "bi-diagram-2", label: "Supply Chain" },
    { value: "bi-diagram-2-fill", label: "Supply Chain Fill" },
    { value: "bi-diagram-3", label: "Business Network" },
    { value: "bi-diagram-3-fill", label: "Business Network Fill" },
    { value: "bi-diagram-3-fill", label: "Organization" },
    { value: "bi-gear", label: "Production" },
    { value: "bi-gear-fill", label: "Production Fill" },
    { value: "bi-tools", label: "Manufacturing" },
    { value: "bi-wrench", label: "Equipment" },
    { value: "bi-hammer", label: "Construction / Production" },
    { value: "bi-factory", label: "Factory" },


    // =========================================================
    // QUALITY / CERTIFICATION / VERIFICATION
    // =========================================================
    { value: "bi-award", label: "Quality / Award" },
    { value: "bi-award-fill", label: "Quality Award Fill" },
    { value: "bi-patch-check", label: "Certified" },
    { value: "bi-patch-check-fill", label: "Certified Fill" },
    { value: "bi-patch-exclamation", label: "Certification Warning" },
    { value: "bi-check-circle", label: "Quality Check" },
    { value: "bi-check-circle-fill", label: "Quality Check Fill" },
    { value: "bi-check2-circle", label: "Verified Check" },
    { value: "bi-check2-square", label: "Verified Checklist" },
    { value: "bi-check-square", label: "Approved" },
    { value: "bi-check-square-fill", label: "Approved Fill" },
    { value: "bi-shield-check", label: "Quality Assurance" },
    { value: "bi-shield-check-fill", label: "Quality Assurance Fill" },
    { value: "bi-shield", label: "Protection / Trust" },
    { value: "bi-shield-fill", label: "Protection Fill" },
    { value: "bi-star", label: "Quality / Rating" },
    { value: "bi-star-fill", label: "Quality Rating Fill" },
    { value: "bi-stars", label: "Premium Quality" },
    { value: "bi-trophy", label: "Achievement" },
    { value: "bi-trophy-fill", label: "Achievement Fill" },
    { value: "bi-medal", label: "Certification / Medal" },
    { value: "bi-medal-fill", label: "Certification Medal Fill" },


    // =========================================================
    // DOCUMENTS / EXPORT PAPERWORK
    // =========================================================
    { value: "bi-file", label: "Document" },
    { value: "bi-file-fill", label: "Document Fill" },
    { value: "bi-file-text", label: "Document Text" },
    { value: "bi-file-text-fill", label: "Document Text Fill" },
    { value: "bi-file-earmark", label: "File" },
    { value: "bi-file-earmark-fill", label: "File Fill" },
    { value: "bi-file-earmark-text", label: "File Document" },
    { value: "bi-file-earmark-text-fill", label: "File Document Fill" },
    { value: "bi-file-earmark-check", label: "Verified File" },
    { value: "bi-file-earmark-check-fill", label: "Verified File Fill" },
    { value: "bi-file-earmark-arrow-up", label: "Upload Document" },
    { value: "bi-file-earmark-arrow-down", label: "Download Document" },
    { value: "bi-folder", label: "Documents Folder" },
    { value: "bi-folder-fill", label: "Documents Folder Fill" },
    { value: "bi-folder2", label: "Folder" },
    { value: "bi-folder2-open", label: "Open Folder" },
    { value: "bi-journal", label: "Records" },
    { value: "bi-journal-text", label: "Records Text" },
    { value: "bi-clipboard", label: "Checklist" },
    { value: "bi-clipboard-check", label: "Verified Document" },
    { value: "bi-clipboard-data", label: "Document Data" },
    { value: "bi-receipt", label: "Invoice / Receipt" },
    { value: "bi-receipt-cutoff", label: "Invoice" },
    { value: "bi-bookmark", label: "Reference" },
    { value: "bi-bookmark-fill", label: "Reference Fill" },


    // =========================================================
    // PAYMENT / FINANCE / PRICING
    // =========================================================
    { value: "bi-cash", label: "Payment" },
    { value: "bi-cash-stack", label: "Money / Payment" },
    { value: "bi-wallet", label: "Wallet" },
    { value: "bi-wallet-fill", label: "Wallet Fill" },
    { value: "bi-credit-card", label: "Payment Card" },
    { value: "bi-credit-card-fill", label: "Payment Card Fill" },
    { value: "bi-credit-card-2-front", label: "Payment Card Front" },
    { value: "bi-bank", label: "Bank" },
    { value: "bi-bank2", label: "Bank 2" },
    { value: "bi-currency-dollar", label: "USD / Dollar" },
    { value: "bi-currency-euro", label: "EUR / Euro" },
    { value: "bi-currency-pound", label: "GBP / Pound" },
    { value: "bi-currency-yen", label: "JPY / Yen" },
    { value: "bi-currency-exchange", label: "Currency Exchange" },
    { value: "bi-percent", label: "Percentage / Discount" },
    { value: "bi-calculator", label: "Price Calculator" },
    { value: "bi-calculator-fill", label: "Calculator Fill" },
    { value: "bi-coin", label: "Coin / Price" },
    { value: "bi-piggy-bank", label: "Savings / Finance" },
    { value: "bi-piggy-bank-fill", label: "Savings Fill" },


    // =========================================================
    // COMMUNICATION / INQUIRY / CUSTOMER SERVICE
    // =========================================================
    { value: "bi-envelope", label: "Email" },
    { value: "bi-envelope-fill", label: "Email Fill" },
    { value: "bi-envelope-open", label: "Open Email" },
    { value: "bi-envelope-open-fill", label: "Open Email Fill" },
    { value: "bi-chat", label: "Inquiry / Chat" },
    { value: "bi-chat-fill", label: "Chat Fill" },
    { value: "bi-chat-dots", label: "Inquiry" },
    { value: "bi-chat-dots-fill", label: "Inquiry Fill" },
    { value: "bi-chat-left", label: "Message" },
    { value: "bi-chat-left-fill", label: "Message Fill" },
    { value: "bi-chat-square", label: "Conversation" },
    { value: "bi-chat-square-fill", label: "Conversation Fill" },
    { value: "bi-telephone", label: "Telephone" },
    { value: "bi-telephone-fill", label: "Telephone Fill" },
    { value: "bi-phone", label: "Phone" },
    { value: "bi-phone-fill", label: "Phone Fill" },
    { value: "bi-whatsapp", label: "WhatsApp" },
    { value: "bi-send", label: "Send Inquiry" },
    { value: "bi-megaphone", label: "Announcement" },
    { value: "bi-megaphone-fill", label: "Announcement Fill" },
    { value: "bi-headset", label: "Customer Support" },
    { value: "bi-headset-vr", label: "Support / Assistance" },


    // =========================================================
    // CUSTOMER / TRUST / PARTNERSHIP
    // =========================================================
    { value: "bi-handshake", label: "Partnership" },
    { value: "bi-hand-thumbs-up", label: "Customer Satisfaction" },
    { value: "bi-hand-thumbs-down", label: "Customer Feedback" },
    { value: "bi-heart", label: "Customer Care" },
    { value: "bi-heart-fill", label: "Customer Care Fill" },
    { value: "bi-person-heart", label: "Customer Care" },
    { value: "bi-person-check", label: "Verified Buyer" },
    { value: "bi-person-vcard", label: "Customer Profile" },
    { value: "bi-people", label: "Customers" },
    { value: "bi-people-fill", label: "Customer Group" },
    { value: "bi-shield-check", label: "Trust / Security" },
    { value: "bi-shield-lock", label: "Secure Partnership" },
    { value: "bi-lock", label: "Secure" },
    { value: "bi-lock-fill", label: "Secure Fill" },
    { value: "bi-key", label: "Access / Security" },
    { value: "bi-key-fill", label: "Access Fill" },
    { value: "bi-fingerprint", label: "Identity / Verification" },


    // =========================================================
    // LOGISTICS / WAREHOUSE / DELIVERY
    // =========================================================
    { value: "bi-boxes", label: "Warehouse" },
    { value: "bi-box-seam", label: "Packaging" },
    { value: "bi-box-seam-fill", label: "Packaging Fill" },
    { value: "bi-truck", label: "Delivery" },
    { value: "bi-truck-front", label: "Delivery Truck" },
    { value: "bi-truck-front-fill", label: "Delivery Truck Fill" },
    { value: "bi-clock", label: "Delivery Time" },
    { value: "bi-clock-fill", label: "Time Fill" },
    { value: "bi-stopwatch", label: "Fast Delivery" },
    { value: "bi-stopwatch-fill", label: "Fast Delivery Fill" },
    { value: "bi-speedometer", label: "Shipping Speed" },
    { value: "bi-speedometer2", label: "Performance / Speed" },
    { value: "bi-geo-alt", label: "Delivery Location" },
    { value: "bi-pin-map", label: "Destination" },
    { value: "bi-signpost", label: "Shipping Route" },
    { value: "bi-signpost-split", label: "Shipping Route Split" },
    { value: "bi-calendar-check", label: "Delivery Schedule" },
    { value: "bi-calendar-event", label: "Delivery Date" },


    // =========================================================
    // INDONESIA / ORIGIN / LOCAL SOURCING
    // =========================================================
    { value: "bi-flag", label: "Country" },
    { value: "bi-flag-fill", label: "Country Fill" },
    { value: "bi-globe-asia-australia", label: "Asia / Indonesia" },
    { value: "bi-globe", label: "Indonesia / Global" },
    { value: "bi-house", label: "Origin" },
    { value: "bi-house-fill", label: "Origin Fill" },
    { value: "bi-geo-alt", label: "Origin Location" },
    { value: "bi-pin-map", label: "Product Origin" },
    { value: "bi-tree", label: "Natural Resources" },
    { value: "bi-tree-fill", label: "Natural Resources Fill" },
    { value: "bi-flower1", label: "Nature / Local Products" },
    { value: "bi-flower2", label: "Nature / Agriculture" },
    { value: "bi-sun", label: "Tropical / Indonesia" },
    { value: "bi-water", label: "Ocean / Maritime" },
    { value: "bi-water", label: "Sea / Indonesia" },


    // =========================================================
    // AGRICULTURE / FOOD / NATURAL PRODUCTS
    // =========================================================
    { value: "bi-flower1", label: "Agriculture" },
    { value: "bi-flower2", label: "Plant / Agriculture" },
    { value: "bi-tree", label: "Natural Product" },
    { value: "bi-tree-fill", label: "Natural Product Fill" },
    { value: "bi-leaf", label: "Organic / Natural" },
    { value: "bi-leaf-fill", label: "Organic / Natural Fill" },
    { value: "bi-egg", label: "Food Product" },
    { value: "bi-egg-fill", label: "Food Product Fill" },
    { value: "bi-cup-hot", label: "Coffee / Beverage" },
    { value: "bi-cup-hot-fill", label: "Coffee / Beverage Fill" },
    { value: "bi-basket", label: "Agricultural Products" },
    { value: "bi-basket-fill", label: "Agricultural Products Fill" },
    { value: "bi-droplet", label: "Liquid Product" },
    { value: "bi-droplet-fill", label: "Liquid Product Fill" },


    // =========================================================
    // TIME / PROCESS / WORKFLOW
    // =========================================================
    { value: "bi-clock", label: "Time" },
    { value: "bi-clock-fill", label: "Time Fill" },
    { value: "bi-hourglass", label: "Process / Waiting" },
    { value: "bi-hourglass-split", label: "Process Progress" },
    { value: "bi-stopwatch", label: "Fast Process" },
    { value: "bi-calendar", label: "Schedule" },
    { value: "bi-calendar-check", label: "Completed Schedule" },
    { value: "bi-calendar-event", label: "Event / Date" },
    { value: "bi-arrow-repeat", label: "Recurring Process" },
    { value: "bi-arrow-clockwise", label: "Refresh / Process" },
    { value: "bi-list-check", label: "Process Checklist" },
    { value: "bi-check2-all", label: "Completed Process" },
    { value: "bi-diagram-3", label: "Workflow" },
    { value: "bi-kanban", label: "Workflow / Project" },


    // =========================================================
    // INNOVATION / TECHNOLOGY / DIGITAL
    // =========================================================
    { value: "bi-lightbulb", label: "Innovation" },
    { value: "bi-lightbulb-fill", label: "Innovation Fill" },
    { value: "bi-cpu", label: "Technology" },
    { value: "bi-cpu-fill", label: "Technology Fill" },
    { value: "bi-gear", label: "Technology / Process" },
    { value: "bi-code-slash", label: "Digital / Technology" },
    { value: "bi-laptop", label: "Digital Business" },
    { value: "bi-phone", label: "Mobile / Digital" },
    { value: "bi-display", label: "Website / Display" },
    { value: "bi-cloud", label: "Cloud" },
    { value: "bi-cloud-arrow-up", label: "Upload / Cloud" },
    { value: "bi-cloud-arrow-down", label: "Download / Cloud" },
    { value: "bi-wifi", label: "Connectivity" },
    { value: "bi-link", label: "Connection" },
    { value: "bi-link-45deg", label: "External Link" },
    { value: "bi-broadcast", label: "Broadcast / Communication" },


    // =========================================================
    // BUSINESS / GROWTH / PERFORMANCE
    // =========================================================
    { value: "bi-rocket", label: "Growth" },
    { value: "bi-rocket-fill", label: "Growth Fill" },
    { value: "bi-graph-up", label: "Business Growth" },
    { value: "bi-graph-up-arrow", label: "Growth Up" },
    { value: "bi-graph-down", label: "Business Decline" },
    { value: "bi-bar-chart", label: "Statistics" },
    { value: "bi-bar-chart-fill", label: "Statistics Fill" },
    { value: "bi-bar-chart-line", label: "Business Performance" },
    { value: "bi-pie-chart", label: "Business Data" },
    { value: "bi-pie-chart-fill", label: "Business Data Fill" },
    { value: "bi-activity", label: "Activity / Performance" },
    { value: "bi-speedometer", label: "Performance" },
    { value: "bi-trophy", label: "Achievement" },
    { value: "bi-trophy-fill", label: "Achievement Fill" },
    { value: "bi-award", label: "Achievement Award" },
    { value: "bi-award-fill", label: "Achievement Award Fill" },
    { value: "bi-star", label: "Featured" },
    { value: "bi-star-fill", label: "Featured Fill" },
    { value: "bi-stars", label: "Premium / Featured" },


    // =========================================================
    // WEBSITE / DIGITAL / UI
    // =========================================================
    { value: "bi-globe", label: "Website" },
    { value: "bi-link", label: "Website Link" },
    { value: "bi-link-45deg", label: "External Link" },
    { value: "bi-house", label: "Home" },
    { value: "bi-search", label: "Search" },
    { value: "bi-filter", label: "Filter" },
    { value: "bi-grid", label: "Grid" },
    { value: "bi-grid-3x3", label: "Grid 3x3" },
    { value: "bi-list", label: "List" },
    { value: "bi-menu-button", label: "Menu" },
    { value: "bi-three-dots", label: "More Options" },
    { value: "bi-three-dots-vertical", label: "More Options Vertical" },
    { value: "bi-eye", label: "View" },
    { value: "bi-eye-fill", label: "View Fill" },
    { value: "bi-download", label: "Download Catalog" },
    { value: "bi-upload", label: "Upload" },
    { value: "bi-cloud-arrow-down", label: "Download File" },
    { value: "bi-cloud-arrow-up", label: "Upload File" },
    { value: "bi-printer", label: "Print" },
    { value: "bi-share", label: "Share" },
    { value: "bi-share-fill", label: "Share Fill" },


    // =========================================================
    // CONTACT / COMPANY INFORMATION
    // =========================================================
    { value: "bi-info-circle", label: "Information" },
    { value: "bi-info-circle-fill", label: "Information Fill" },
    { value: "bi-question-circle", label: "FAQ / Help" },
    { value: "bi-question-circle-fill", label: "FAQ Fill" },
    { value: "bi-exclamation-circle", label: "Important Information" },
    { value: "bi-exclamation-triangle", label: "Warning" },
    { value: "bi-clock", label: "Business Hours" },
    { value: "bi-calendar", label: "Schedule" },
    { value: "bi-geo-alt", label: "Office Location" },
    { value: "bi-envelope", label: "Business Email" },
    { value: "bi-telephone", label: "Business Phone" },
    { value: "bi-phone", label: "Business Mobile" },
    { value: "bi-person-vcard", label: "Contact Person" },
    { value: "bi-card-text", label: "Company Information" },


    // =========================================================
    // SECURITY / PRIVACY
    // =========================================================
    { value: "bi-shield", label: "Security" },
    { value: "bi-shield-fill", label: "Security Fill" },
    { value: "bi-shield-check", label: "Verified Security" },
    { value: "bi-shield-check-fill", label: "Verified Security Fill" },
    { value: "bi-shield-lock", label: "Secure" },
    { value: "bi-shield-lock-fill", label: "Secure Fill" },
    { value: "bi-lock", label: "Locked / Secure" },
    { value: "bi-lock-fill", label: "Locked Fill" },
    { value: "bi-unlock", label: "Unlocked" },
    { value: "bi-key", label: "Security Key" },
    { value: "bi-key-fill", label: "Security Key Fill" },
    { value: "bi-fingerprint", label: "Verification" },
    { value: "bi-person-check", label: "Identity Verified" },


    // =========================================================
    // GENERAL / COMMON
    // =========================================================
    { value: "bi-check", label: "Check" },
    { value: "bi-check2", label: "Check 2" },
    { value: "bi-check-circle", label: "Success" },
    { value: "bi-check-circle-fill", label: "Success Fill" },
    { value: "bi-check2-circle", label: "Verified Check" },
    { value: "bi-x", label: "Close / Remove" },
    { value: "bi-x-circle", label: "Cancel" },
    { value: "bi-x-circle-fill", label: "Cancel Fill" },
    { value: "bi-plus", label: "Add" },
    { value: "bi-plus-circle", label: "Add Circle" },
    { value: "bi-dash", label: "Minus" },
    { value: "bi-dash-circle", label: "Minus Circle" },
    { value: "bi-arrow-right", label: "Next / Forward" },
    { value: "bi-arrow-left", label: "Back" },
    { value: "bi-arrow-up", label: "Up" },
    { value: "bi-arrow-down", label: "Down" },
    { value: "bi-arrow-up-right", label: "Open / Forward" },
    { value: "bi-chevron-right", label: "Chevron Right" },
    { value: "bi-chevron-left", label: "Chevron Left" },
    { value: "bi-chevron-up", label: "Chevron Up" },
    { value: "bi-chevron-down", label: "Chevron Down" },
    { value: "bi-lightning", label: "Fast / Power" },
    { value: "bi-lightning-fill", label: "Fast / Power Fill" },
    { value: "bi-fire", label: "Popular / Hot" },
    { value: "bi-bookmark", label: "Bookmark" },
    { value: "bi-bookmark-fill", label: "Bookmark Fill" },
    { value: "bi-heart", label: "Favorite" },
    { value: "bi-heart-fill", label: "Favorite Fill" },
    { value: "bi-star", label: "Star" },
    { value: "bi-star-fill", label: "Star Fill" },
    { value: "bi-question", label: "Question" },
    { value: "bi-exclamation", label: "Attention" },
    { value: "bi-info", label: "Information" },
    { value: "bi-sliders2", label: "Sliders 2" },
    { value: "bi-eyedropper", label: "Eye Dropper" },
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