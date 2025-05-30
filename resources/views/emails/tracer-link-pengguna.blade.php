<x-mail::message>
# Halo {{ $pengguna->nama }}

Kami mengundang Anda untuk mengisi kuisioner performa alumni POLINEMA.

Silakan klik tombol di bawah ini untuk mengisi formulir:

<x-mail::button :url="$link">
Isi Formulir
</x-mail::button>

Terima kasih atas partisipasi Anda.<br>
Salam,<br>
{{ config('app.name') }}
</x-mail::message>
