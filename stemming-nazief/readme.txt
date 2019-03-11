Cara Menjalankan Project Crawl dengan Stemming: 

1. Letakkan project ini di dalam folder xampp/htdocs atau var/www/ 
    sehingga menjadi xampp/htdocs/febri_crawl_nazief atau var/www/febri_crawl/nazief.
2. Project ini berjalan menggunakan PHP versi 7.2.7 dengan MySQL versi 5.0.12. Jika terjadi error,
    pastikan setidaknya versi PHP dan MySQL pada komputer yang dijalankan 
    memiliki versi di atas versi tersebut.
3. Jika anda memiliki proxy, ubahlah value variable $proxy pada file index.php line ke-71.
    Setelah itu, hapus tanda komentar pada file index.php line ke-27. Jika proxy anda
    memiliki password, hapus tanda komentar pada file index.php line ke-29, lalu hapus
    variable $proxy_userpwd menjadi password proxy anda.
4. Setelah itu, pada file index.php line ke-8 terdapat instruksi mengenai user agent.
    User agent berbeda untuk setiap browser bahkan PC. Sehingga kunjungi link tersebut,
    lalu copy value dari agent anda dan ubah value dari $agent menjadi agent anda sendiri.
5. Pada file connect.php, terdapat konfigurasi database. Ubahlah host, username, dan password sesuai 
    dengan database anda sendiri.
6. Pada folder sql, terdapat file sql untuk keperluan project ini. Buatlah database baru di mysql
    bernama 'dbstbi' ataupun bebas namun nanti perlu konfigurasi lagi di file connect.php dan ubah
    variable database sesuai nama database yang baru dibuat. Lalu import file dbstbi.sql (berada 
    di dalam folder sql) ke dalam database yang baru anda buat tersebut.
7. Lalu untuk menjalankan project ini, jika menggunakan Windows, aktifkan terlebih dahulu
    Apache dan MySQL pada XAMPP (jika menggunakan XAMPP). Lalu kunjungi url berikut: 
    'http://localhost/febri_crawl_nazief/' atau sesuai path yang anda tentukan sebelumnya.

Library yang digunakan: 
1. HTML_DOM_PARSER (http://simplehtmldom.sourceforge.net/) untuk melakukan crawling.
2. Algoritma Stemming Nazief Adriani (https://github.com/ilhamdp10/algoritma-stemming-nazief-adriani) untuk 
    melakukan stemming.