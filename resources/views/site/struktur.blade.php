@extends('site.menu')

@section('content')
<section id="struktur">
    <h2>Struktur Organisasi</h2>
    <div class="struktur-berita">
        <div class="struktur-card">
            <img src="{{ asset('image/Direktur-RSHP.webp') }}" alt="Direktur RSHP" class="struktur-foto">
            <div class="struktur-info">
                <h3>Direktur</h3>
                <p>Dr. Ira Sari Yudaniayanti, M.P., drh.</p>
            </div>
        </div>
        
        <div class="struktur-card">
            <img src="{{ asset('image/wakildirektur1.jpeg') }}" alt="Wakil Direktur 1 RSHP" class="struktur-foto">
            <div class="struktur-info">
                <h3>Wakil Direktur 1</h3>
                <p>Dr. Nusidanto Triakso, M.P., drh.</p>
            </div>
        </div>
        
        <div class="struktur-card">
            <img src="{{ asset('image/wakildirektur2.jpeg') }}" alt="Wakil Direktur 2 RSHP" class="struktur-foto">
            <div class="struktur-info">
                <h3>Wakil Direktur 2</h3>
                <p>Dr. Milyua Soneta S, M.Vet., drh.</p>
            </div>
        </div>
    </div>
</section>
@endsection

