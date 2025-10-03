# SKPD REST API (Laravel + Sanctum)

A token-protected RESTful API for managing **Jabatan (Positions)**, **SKPD**, **Unit Kerja (Work Units)**, and **Pegawai (Employees)** built with Laravel 11+ and Sanctum (Bearer tokens).

---

## ✨ Features
- Laravel 11+ (PHP 8.2+)
- **Bearer Token** authentication via **Laravel Sanctum**
- CRUD for: `jabatan`, `skpd`, `unit_kerja`, `pegawai`
- SQLite (default, zero-config) or MySQL
- Postman collection & environment included
- Clean, predictable JSON responses

---

## 🧰 Prerequisites
- **PHP 8.2+** with extensions: `openssl`, `mbstring`, `curl`, `fileinfo`, `pdo_sqlite` (or `pdo_mysql`), `sqlite3` (if using SQLite), `zip`
- **Composer** 2.x
- **Git**
- (Optional) **MySQL/MariaDB** if you prefer MySQL over SQLite

> **Windows (Scoop PHP users):** edit `C:\Users\<you>\scoop\apps\php\current\cli\php.ini` and ensure:
> ```ini
> extension_dir="C:\Users\<you>\scoop\apps\php\current\ext"
> extension=openssl
> extension=mbstring
> extension=curl
> extension=fileinfo
> extension=pdo_sqlite
> extension=sqlite3
> ; if using MySQL instead:
> ; extension=pdo_mysql
> extension=zip
> date.timezone=Asia/Jakarta
> ```

---

## 🚀 Quick Start

### 1) Clone and install
```bash
git clone https://github.com/<YOUR_USERNAME>/skpd-api.git
cd skpd-api
composer install
```

### 2) Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

#### Use **SQLite** (recommended for local dev)
```bash
# Create DB file (Linux/macOS)
mkdir -p storage/database && : > storage/database/database.sqlite

# Windows PowerShell
mkdir storage\database -Force
type NUL > storage\database\database.sqlite
```
`.env` should contain:
```
DB_CONNECTION=sqlite
DB_DATABASE=storage/database/database.sqlite
```

#### Or use **MySQL**
Update `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skpd
DB_USERNAME=root
DB_PASSWORD=
```

### 3) Migrate
```bash
php artisan migrate
```

### 4) Run the server
```bash
php artisan serve
```
Visit: **http://127.0.0.1:8000**

---

## 🔐 Authentication (Bearer Token with Sanctum)

### Register
**POST** `/api/auth/register`
```json
{
  "name": "Admin",
  "email": "admin@example.com",
  "password": "secret123",
  "password_confirmation": "secret123"
}
```
**Response**
```json
{ "user": { ... }, "token": "YOUR_TOKEN" }
```

### Login
**POST** `/api/auth/login`
```json
{ "email": "admin@example.com", "password": "secret123" }
```
**Response**
```json
{ "token": "YOUR_TOKEN" }
```

### Use the token
Send the header on protected routes:
```
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

### Logout
**POST** `/api/auth/logout`

---

## 📚 Endpoints

> All endpoints below are **protected** by Bearer token (except `auth/register` and `auth/login`).

### Jabatan (Positions)
| Method | Path                 | Description            |
|-------:|----------------------|------------------------|
| GET    | `/api/jabatan`       | List all               |
| GET    | `/api/jabatan/{id}`  | Get by ID              |
| POST   | `/api/jabatan`       | Create                 |
| PUT    | `/api/jabatan/{id}`  | Update                 |
| DELETE | `/api/jabatan/{id}`  | Delete                 |

**Create example**
```json
{ "jabatan": "Analis SDM Aparatur" }
```

---

### SKPD
| Method | Path              | Description  |
|-------:|-------------------|--------------|
| GET    | `/api/skpd`       | List all     |
| GET    | `/api/skpd/{id}`  | Get by ID    |
| POST   | `/api/skpd`       | Create       |
| PUT    | `/api/skpd/{id}`  | Update       |
| DELETE | `/api/skpd/{id}`  | Delete       |

**Create example**
```json
{ "skpd": "Dinas Pendidikan" }
```

---

### Unit Kerja (Work Units)
| Method | Path                      | Description       |
|-------:|---------------------------|-------------------|
| GET    | `/api/unit-kerja`         | List (+skpd)      |
| GET    | `/api/unit-kerja/{id}`    | Get by ID (+skpd) |
| POST   | `/api/unit-kerja`         | Create            |
| PUT    | `/api/unit-kerja/{id}`    | Update            |
| DELETE | `/api/unit-kerja/{id}`    | Delete            |

**Create example**
```json
{ "unit_kerja": "Subbagian Umum", "skpd_id": 1 }
```

---

### Pegawai (Employees)
| Method | Path                 | Description                              |
|-------:|----------------------|------------------------------------------|
| GET    | `/api/pegawai`       | List (paginated, with relations)         |
| GET    | `/api/pegawai/{id}`  | Get by ID (with relations)               |
| POST   | `/api/pegawai`       | Create                                   |
| PUT    | `/api/pegawai/{id}`  | Update                                   |
| DELETE | `/api/pegawai/{id}`  | Delete                                   |

**Create example**
```json
{
  "nip": 198706222019031001,
  "nama_lengkap": "Siti Rahmawati",
  "jenis_kelamin": "P",
  "jabatan_id": 1,
  "skpd_id": 1,
  "unit_kerja_id": 1,
  "nama_golongan": "III/b",
  "nama_pangkat": "Penata Muda Tingkat I",
  "alamat_lengkap": "Jl. Melati No. 10"
}
```

> **FK order tip:** Create `skpd` and `jabatan` first, then `unit_kerja` (needs `skpd_id`), then `pegawai` (needs all three IDs).

---

## 🧪 Quick Self-Test (2 minutes)

```bash
# Register → copy token
curl -X POST http://127.0.0.1:8000/api/auth/register \
  -H "Accept: application/json" -H "Content-Type: application/json" \
  -d '{ "name":"Admin","email":"admin@example.com","password":"secret123","password_confirmation":"secret123" }'

# With token (PowerShell example)
$TOKEN="paste"
curl http://127.0.0.1:8000/api/skpd -H "Accept: application/json" -H "Authorization: Bearer $TOKEN"  # should be 200

# Create SKPD
curl -X POST http://127.0.0.1:8000/api/skpd -H "Accept: application/json" -H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json" -d "{""skpd"":""Dinas Pendidikan""}"
```

---

## 🧪 Postman
This repo includes:
- `SKPD-Laravel-API.postman_collection.json`
- `SKPD-API-Local.postman_environment.json`

**Steps:**
1. Import both files.
2. Select environment **SKPD API Localhost**.
3. Register/Login to get a token; set `{{token}}` in the environment.
4. Run the CRUD requests in each folder.

> If these files are not yet in your repo, you can generate them from the earlier ChatGPT attachments and commit to the root.

---

## 🔧 Troubleshooting

- **401 Unauthenticated**: Missing/invalid Bearer token → login again and resend with `Authorization: Bearer <token>`.
- **500 during register/login**: Ensure `use Laravel\Sanctum\HasApiTokens;` and `use HasApiTokens, ...` on `app/Models/User.php`.
- **“could not find driver”**: Enable database driver extensions in `php.ini` (`pdo_sqlite/sqlite3` or `pdo_mysql`).
- **SQLite “readonly database”**: Place DB at `storage/database/database.sqlite` and ensure the path in `.env` matches.  
  Run `php artisan config:clear` after changes.
- **ZIP/unzip error on Composer create-project**: Enable `extension=zip` or install `7zip`/`unzip` in PATH.

---

## 🛡️ Security
- Do **not** commit `.env`.
- Use HTTPS in production.
- Rotate tokens periodically.
- Consider rate limiting & CORS settings (`config/cors.php`).

---

## 📄 License
MIT (or your preference)
