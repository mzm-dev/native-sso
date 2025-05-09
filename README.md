# mzm/phpsso

**PHP SSO Client Integration for Pure PHP (Sanctum-based Authentication)**

`mzm/phpsso` ialah pakej PHP ringkas yang membolehkan integrasi Single Sign-On (SSO) antara sistem client (contoh: `sistem-a.example.com`) dengan pelayan SSO berasaskan Laravel Sanctum (contoh: `sso.example.com`). Direka khas untuk sistem **tanpa framework** (Pure PHP).

---

## ✨ Ciri-ciri

- Integrasi mudah dengan pelayan Laravel Sanctum SSO.
- Penyemakan token `Bearer` melalui `cURL`.
- Carian pengguna tempatan secara automatik (melalui `email`, `username`, dll).
- Menyimpan `$_SESSION` selepas pengesahan berjaya.
- Komponen UI (butang login SSO).
- Middleware untuk lindungi laluan.
- Logging harian secara automatik (rotating log).
- Sistem `Enum` dan `QueryTemplate` yang boleh dikonfigurasi.

---

## 📦 Pemasangan

```bash
composer require mzm/phpsso
