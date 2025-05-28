@component('mail::message')
# Halo {{ $alumni->nama }}

Kami mohon partisipasi Anda untuk mengisi Form Tracer Study berikut:

@component('mail::button', ['url' => $link])
Isi Tracer Study
@endcomponent

Terima kasih telah meluangkan waktu Anda.

Salam hormat,
Tim Tracer Study POLINEMA
@endcomponent
