<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID User</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Roles</th>
        </tr>
    </thead>
    <tbody>
        {{-- Loop utama adalah data 'users' yang dikirim dari controller --}}
        @foreach ($users as $index => $user)
            <tr>
                <td>{{ $user->iduser }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->email }}</td>
                
                {{-- Bagian untuk menampilkan Roles (sesuai screenshot) --}}
                <td>
                    {{-- Cek apakah user punya role --}}
                    @if ($user->roles->isNotEmpty())
                        <ul>
                            {{-- Loop di dalam relasi 'roles' milik user --}}
                            @foreach ($user->roles as $role)
                                <li>
                                    {{ $role->nama_role }} 
                                    
                                    {{-- Cek status dari tabel pivot (role_user) --}}
                                    {{-- 'pivot' adalah properti spesial untuk data tabel pivot --}}
                                    ({{ $role->pivot->status == 1 ? 'Aktif' : 'Non-Aktif' }})
                                </li>
                            @endforeach
                        </ul>
                    @else
                        - (Tidak ada role) -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
