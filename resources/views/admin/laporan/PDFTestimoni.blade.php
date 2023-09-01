<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
<body>
    <h2 style="text-align: center"> COOL-GUY BARBERSHOP</h2>
    <h5 style="text-align: center">
        Depan BPJSketenagakerjaan Depok, Jl. Sersan Anning No.3, Kota Depok, Jawa Barat 16431 
    </h5>
    @if ($start_date && $end_date)
        <p>Data Testimoni dari {{ $start_date }} sampai dengan {{ $end_date }}</p>
    @endif
    <table id="example1" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Isi Testimoni</th>
                <th>Penilaian</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($testimoni as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_user }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->isi }}</td>
                    <td>{{ $item->penilaian }}</td>
                    <td>{{ $item->tanggal }}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>

    <footer>
        <strong>
            <h3 style="text-align: center">Laporan Testimoni dan Rating</h2>
        </strong>
    </footer>
</body>
