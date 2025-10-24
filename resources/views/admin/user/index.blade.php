<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID User</th>
            <th>Nama</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <td>{{ $user->iduser }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>