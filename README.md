### SIAP-STTD App

## Installation

1. Buka Terminal
```bash
git clone https://github.com/rajahariadi/siap-sttd.git
```
2. Buka folder hasil clone
```bash
cd siap-sttd
```
3. Jalankan Composer Install
```bash
composer install
``` 
4. Jalankan perintah untuk copy .env
```bash
cp .env.example .env
```
5. Jalankan perintah untuk melakukan generate key
```bash
php artisan key generate
```
6. Jalankan perintah untuk melakukan generate migration
```bash
php artisan migrate
```
7. Install npm dependency
```bash
npm install
```
8. Jalankan Laravel
```bash
php artisan serve
```
