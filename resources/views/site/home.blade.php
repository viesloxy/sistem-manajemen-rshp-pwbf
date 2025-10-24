@extends('site.menu')

@section('content')
<section id="tentang">
    <h2>Tentang RSHP</h2>
    <p>Rumah Sakit Hewan Pendidikan Universitas Airlangga berinovasi untuk selalu meningkatkan kualitas pelayanan, maka dari itu Rumah Sakit Hewan Pendidikan Universitas Airlangga mempunyai fitur pendaftaran online yang mempermudah untuk mendaftarkan hewan kesayangan anda.</p>

    <br>

    <h2>Berita Terkini</h2>
    <div class="struktur-berita">
        <div class="struktur-card">
            <img src="{{ asset('image/berita1_rshp.png') }}" alt="Berita 1" class="struktur-foto">
            <div class="struktur-info">
                <h3>Berita 1</h3>
                <p>RSHP Goes to Banyuwangi</p>
            </div>
        </div>
        <div class="struktur-card">
             <img src="{{ asset('image/berita2_rshp.png') }}" alt="Berita 2" class="struktur-foto">
             <div class="struktur-info">
                 <h3>Berita 2</h3>
                 <p>Seminar dan Workshop FIESTA UROLOGI</p>
             </div>
        </div>
        <div class="struktur-card">
             <img src="{{ asset('image/berita3_rshp.jpg') }}" alt="Berita 3" class="struktur-foto">
             <div class="struktur-info">
                 <h3>Berita 3</h3>
                 <p>Benchmarking RSHP Undana di RSHP Unair</p>
             </div>
        </div>
    </div>
</section>
@endsection