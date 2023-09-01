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
        <p>Data Keluhan dari {{ $start_date }} sampai dengan {{ $end_date }}</p>
    @endif
    <table id="example1" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Isi Tanggapan</th>
                <th>Tanggapan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keluhan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->isi }}</td>
                    <td>{{ $item->tanggapan }}</td>
                    <td>{{ $item->tanggal }}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
    <footer>
        <strong>
            <h3 style="text-align: center">Laporan Keluhan dan Tanggapan Admin</h2>
        </strong>
    </footer>
</body>
