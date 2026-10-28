---
name: unsiq-academic-ui
description: Use when building or restyling UI for the UNSIQ academic website/portal (Laravel, Blade, Tailwind/Bootstrap, JS). Produces sober, credible, institution-grade interfaces and avoids generic "AI slop" styling.
---

# UNSIQ Academic UI

Tujuan: tampilan seperti situs perguruan tinggi yang kredibel (portal akademik, profil fakultas, berita, SIAKAD), bukan landing page startup.

## 1. Sebelum mengubah apa pun
1. Baca repo dulu: `resources/views/layouts`, `resources/css`, `tailwind.config.js` / `bootstrap` vars, `public/` (logo, warna resmi, favicon).
2. Deteksi stack yang SUDAH ada (Blade, Livewire, Inertia, Alpine, jQuery, Tailwind, Bootstrap). Pakai itu. Jangan menambah framework atau dependensi baru tanpa izin.
3. Ambil warna & logo resmi UNSIQ dari repo/aset yang ada. Jika tidak ada, tanya pemilik; jangan mengarang palet.

## 2. Anti "AI slop" (dilarang)
- Gradien ungu-biru/neon, glow, glassmorphism, blob dekoratif.
- Emoji sebagai ikon; gunakan satu set ikon konsisten (Heroicons/Lucide/Bootstrap Icons, ikut yang sudah dipakai).
- Hero generik ("Revolutionize...", "Empowering the future") dan 3 kartu fitur identik.
- Semua elemen bulat besar + bayangan tebal. Pakai radius kecil (2–6px), border tipis, bayangan minimal.
- Animasi berlebihan (bounce, parallax, fade-in di semua elemen). Transisi 150–200ms untuk hover/fokus saja.
- Teks placeholder/lorem, statistik palsu, testimoni palsu.
- Copy bergaya marketing. Gunakan bahasa Indonesia formal, singkat, jelas.

## 3. Arah visual akademis
- Warna: 1 warna utama institusi (biasanya hijau/biru tua), 1 aksen hemat, netral abu hangat/dingin. Kontras teks minimal WCAG AA (4.5:1).
- Tipografi: heading serif (mis. Source Serif 4 / Merriweather), isi sans (mis. Source Sans 3 / Noto Sans). Skala: 14–16px isi, 1.5–1.7 line-height, lebar baca maks ~70 karakter.
- Layout: grid rapi, margin konsisten (skala 4/8px), hirarki jelas: judul halaman, breadcrumb, konten, sidebar/tautan terkait.
- Header: logo + nama institusi, navigasi utama jelas (Profil, Akademik, Fakultas, Penelitian, Kemahasiswaan, Berita, Kontak). Footer berisi alamat, kontak, tautan penting, media sosial resmi.
- Padat informasi tapi terbaca: tabel jadwal/nilai/pengumuman dengan zebra tipis, header sticky, status berupa badge teks (bukan hanya warna).
- Foto: pakai aset asli kampus; beri `alt` bermakna dan rasio konsisten.

## 4. Pola komponen
- Form: label di atas input, bantuan di bawah, error via `@error` dengan pesan Bahasa Indonesia, fokus terlihat jelas, tombol utama satu per area.
- Tabel: pagination Laravel (`links()` di-style sesuai tema), pencarian/filter di atas, empty state yang informatif.
- Alert/flash: sukses, peringatan, galat; dapat ditutup dengan keyboard.
- Dashboard (mahasiswa/dosen/admin): kartu ringkas hanya jika datanya nyata; sisanya tabel dan daftar.
- Berita/pengumuman: tanggal format Indonesia (`Carbon::translatedFormat`), kategori, penulis, tautan baca selengkapnya.

## 5. Praktik Laravel + JS
- Pecah ke Blade components (`x-card`, `x-table`, `x-form.input`) dan layout bersama; hindari menyalin markup.
- Aset via `@vite`; warna/spasi lewat CSS variables atau token Tailwind, jangan hard-code hex berulang.
- Teks UI lewat `lang/id` bila proyek sudah memakai lokalisasi.
- JS secukupnya: progressive enhancement, tidak memblokir render, tidak ada konsol error. Hormati `prefers-reduced-motion`.
- Jangan menyentuh controller, route, atau migrasi bila tugasnya hanya tampilan.

## 6. Checklist selesai
- Tampil benar di 360px, 768px, 1280px; tidak ada scroll horizontal.
- Navigasi keyboard dan fokus terlihat; ada skip link; kontras lolos AA.
- Tidak ada dependensi baru tanpa persetujuan; diff kecil dan terfokus.
- Ringkas perubahan: file yang diubah dan alasan desainnya.
