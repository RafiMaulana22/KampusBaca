@component('mail::message')
# Halo, {{ $namaUser }}!

Selamat! Akun Anda di {{ config('app.name') }} telah berhasil diverifikasi.

Anda sekarang dapat login ke sistem menggunakan email dan password Anda.

@component('mail::button', ['url' => $urlLogin, 'color' => 'success'])
Login Sekarang
@endcomponent

Terima kasih,<br>
Tim {{ config('app.name') }}
@endcomponent
