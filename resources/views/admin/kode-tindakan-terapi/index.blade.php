<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Kategori Klinis</th>
        </tr>
    </thead>
    <tbody>
        {{-- Loop ini sama dengan @foreach ($pemilik as $index => $item) --}}
        @foreach ($kodeTindakanTerapi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->deskripsi_tindakan_terapi }}</td>
                
                {{-- Ini sama dengan <td>{{ $item->user->nama }}</td> --}}
                {{-- Kita cek dulu apakah relasinya ada, untuk menghindari error --}}
                <td>{{ $item->kategori ? $item->kategori->nama_kategori : 'N/A' }}</td>
                <td>{{ $item->kategoriKlinis ? $item->kategoriKlinis->nama_kategori_klinis : 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>