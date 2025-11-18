# Panduan Memperbaiki Koneksi MariaDB/MySQL di XAMPP

## Masalah
Error: `SQLSTATE[HY000] [1130] Host 'localhost' is not allowed to connect to this MariaDB server`

## Penyebab
MariaDB dikonfigurasi untuk tidak menerima koneksi dari localhost/127.0.0.1 karena konfigurasi user yang tidak tepat.

## Solusi 1: Menggunakan phpMyAdmin (Recommended)
1. Buka http://localhost/phpmyadmin di browser
2. Login dengan username: root (tanpa password jika default XAMPP)
3. Klik tab "User accounts"
4. Edit user "root"
5. Pastikan ada user root untuk host:
   - localhost
   - 127.0.0.1  
   - % (wildcard untuk semua host)
6. Berikan privilege "All privileges" untuk semua host tersebut

## Solusi 2: Menggunakan Command Line (Admin required)
Jalankan command berikut sebagai Administrator:

```bash
# Masuk ke directory XAMPP MySQL
cd C:\xampp\mysql\bin

# Stop MySQL service
net stop mysql

# Start MySQL dengan skip-grant-tables (bypass privilege system)
mysqld.exe --skip-grant-tables --skip-networking

# Di terminal baru, connect tanpa password
mysql.exe -u root

# Jalankan query untuk memperbaiki user
USE mysql;
UPDATE user SET Host='%' WHERE User='root' AND Host='localhost';
DELETE FROM user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '%');
INSERT INTO user (Host, User, authentication_string, ssl_cipher, x509_issuer, x509_subject) VALUES ('%', 'root', '', '', '', '');
INSERT INTO user (Host, User, authentication_string, ssl_cipher, x509_issuer, x509_subject) VALUES ('127.0.0.1', 'root', '', '', '', '');
FLUSH PRIVILEGES;
EXIT;

# Restart MySQL normally
# Stop mysqld process dan start ulai dari XAMPP Control Panel
```

## Solusi 3: Reset MySQL Password dan User (Nuclear option)
1. Stop MySQL dari XAMPP Control Panel
2. Rename folder C:\xampp\mysql\data ke C:\xampp\mysql\data_backup
3. Copy folder C:\xampp\mysql\backup ke C:\xampp\mysql\data
4. Start MySQL dari XAMPP Control Panel
5. Database akan reset dengan default users

## Solusi 4: Menggunakan SQLite (Solusi yang sedang digunakan)
Sudah dikonfigurasi di .env file:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Keuntungan SQLite:
- Tidak perlu server database terpisah
- File-based, mudah backup
- Cocok untuk development
- Performa baik untuk aplikasi kecil-menengah

## Rekomendasi
Untuk development, gunakan SQLite (sudah dikonfigurasi).
Untuk production, gunakan MySQL/MariaDB dengan konfigurasi user yang benar.

## Script PHP untuk Test Koneksi
Gunakan fix_database.php yang sudah dibuat untuk test berbagai konfigurasi koneksi.