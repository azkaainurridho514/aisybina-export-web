LOAD ORDER UNTUK admin.blade.php

1. 01-api.js
2. 02-entities.js
3. 03-crud.js
4. 04-product-detail.js
5. 05-inquiries.js
6. 06-settings.js
7. 07-data-layer.js
8. 08-dashboard.js
9. 09-navigation.js
10. 10-admin-events.js
11. 11-login.js
12. 12-common.js  <-- shared functions sengaja paling bawah

Semua file memakai global scope seperti script-admin.js lama, sehingga tidak
perlu mengubah kode menjadi ES Module/import. Pastikan urutan <script> sesuai.

Route yang dipakai:
GET    /admin/dashboard
GET    /admin/categories
GET    /admin/categories/{id}
POST   /admin/categories
PUT    /admin/categories/{id}
DELETE /admin/categories/{id}
GET    /admin/products
GET    /admin/products/{id}
POST   /admin/products
PUT    /admin/products/{id}
DELETE /admin/products/{id}
GET    /admin/inquiries
GET    /admin/inquiries/{id}
DELETE /admin/inquiries/{id}
GET    /admin/business-hours
GET    /admin/business-hours/{id}
POST   /admin/business-hours
PUT    /admin/business-hours/{id}
DELETE /admin/business-hours/{id}
GET    /admin/our-process
GET    /admin/our-process/{id}
POST   /admin/our-process
PUT    /admin/our-process/{id}
DELETE /admin/our-process/{id}
GET    /admin/choose-us
GET    /admin/choose-us/{id}
POST   /admin/choose-us
PUT    /admin/choose-us/{id}
DELETE /admin/choose-us/{id}
GET    /admin/about-items
GET    /admin/about-items/{id}
POST   /admin/about-items
PUT    /admin/about-items/{id}
DELETE /admin/about-items/{id}
GET    /admin/site-content/{table}
PUT    /admin/site-content/{table}
