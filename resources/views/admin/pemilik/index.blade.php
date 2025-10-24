<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pemilik</th>
            <th>Email</th>
            <th>No WA</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemilik as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->user->nama }}</td>
            <td>{{ $item->user->email }}</td>
            <td>{{ $item->no_wa }}</td>
            <td>{{ $item->alamat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>