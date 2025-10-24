<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pet</th>
            <th>Jenis Kelamin</th>
            <th>Usia</th>
            <th>Jenis/Ras</th>
            <th>Pemilik</th>
            <th>Warna/Tanda</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pet as $index => $item)
            <tr>
                <td>{{ $item->idpet }}</td>
                <td>{{ $item->nama }}</td>
                
                {{-- Memanggil Accessor dari Model --}}
                <td>{{ $item->jenis_kelamin_text }}</td> 
                
                {{-- Memanggil Accessor dari Model --}}
                <td>{{ $item->usia }}</td> 

                {{-- Mengambil dari nested relationship --}}
                <td>
                    {{ $item->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }} / 
                    {{ $item->rasHewan->nama_ras ?? 'N/A' }}
                </td>

                {{-- Mengambil dari nested relationship --}}
                <td>{{ $item->pemilik->user->nama ?? 'N/A' }}</td>

                <td>{{ $item->warna_tanda }}</td>
            </tr>
        @endforeach
    </tbody>
</table>