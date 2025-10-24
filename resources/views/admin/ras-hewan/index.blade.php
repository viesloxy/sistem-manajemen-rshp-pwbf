<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Ras Hewan</th>
            <th>Jenis Hewan</th>
        </tr>
    </thead>
    <tbody>
        {{-- Loop ini sama dengan @foreach ($pemilik as $index => $item) --}}
        @foreach ($rasHewan as $index => $ras)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $ras->nama_ras }}</td>
                {{-- Ini sama dengan <td>{{ $item->user->nama }}</td> --}}
                <td>{{ $ras->jenisHewan->nama_jenis_hewan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>