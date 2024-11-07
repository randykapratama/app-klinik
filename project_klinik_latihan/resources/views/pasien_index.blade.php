@extends('layouts.app_modern')

@section('content')
<div class="card">
    <div class="card-body">
        <h3>Data Pasien</h3>
        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari pasien..." onkeyup="filterTable()">
                    <button class="btn btn-secondary btn-md" onclick="refreshTable()">Refresh</button>
                </div>
            </div>
        </div>
        <table class="table table-striped" id="patientTable">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO PASIEN</th>
                    <th>NAMA</th>
                    <th>UMUR</th>
                    <th>JENIS KELAMIN</th>
                    <th>TANGGAL BUAT</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasiens as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_pasien }}</td>
                    <td>
                        @if ($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" width="50" />
                        @endif
                        {{ $item->nama }}
                    </td>
                    <td>{{ $item->umur }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="/pasien/{{ $item->id }}/edit" class="btn btn-warning btn-sm ml-2">Edit</a>
                        <form action="/pasien/{{ $item->id }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm ml-2" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $pasiens->links() !!}
    </div>
</div>

<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("patientTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) { // Mulai dari 1 untuk melewati header
            const td = tr[i].getElementsByTagName("td");
            let found = false;

            for (let j = 0; j < td.length - 1; j++) { // Kecualikan kolom aksi
                if (td[j].textContent.toLowerCase().includes(filter)) {
                    found = true;
                    break;
                }
            }

            tr[i].style.display = found ? "" : "none"; // Tampilkan atau sembunyikan baris
        }
    }

    function refreshTable() {
        document.getElementById("searchInput").value = ""; // Bersihkan input pencarian
        filterTable(); // Segarkan tabel untuk menampilkan semua entri
    }
</script>
@endsection
