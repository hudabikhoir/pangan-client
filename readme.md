# PANGAN API CLIENT

Pangan service merupakan Sistem Informasi guna memperoleh data ketersediaan pangan oleh petani dan jumlah permintaan konsumen agar adanya kestabilan harga pasar 

## Instalasi

- download repository pangan-service

``git clone https://github.com/hudabikhoir/pangan-service.git``

- download package yang diperlukan melalui composer

``composer install`` 

``composer update``

- setting .env sesuaikan dengan host anda

- jalankan perintah migration lumen

``php artisan migrate``

- run pangan-service kamu

``php -S localhost:8080 -t public``
