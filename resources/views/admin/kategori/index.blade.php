<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Kategori</th>
            <th>Nama Kategori</th>
        </tr>
    </thead>
    <tbody>
        {{-- Loop ini sama dengan @foreach ($jenisHewan as $index => $hewan) --}}
        @foreach ($kategori as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->idkategori }}</td>
                <td>{{ $item->nama_kategori }}</td>
            </tr>
        @endforeach
    </tbody>
</table>