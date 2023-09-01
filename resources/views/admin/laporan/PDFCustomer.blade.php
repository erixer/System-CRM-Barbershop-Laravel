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
    <br>
    
    <table id="example1" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Kunjungan</th>
                <th>Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->first_name }}</td>
                    <td>{{ $item->hp }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->kunjungan }}</td>
                    <td>{{ $item->point }}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>

    <footer>
        <strong>
            <h3 style="text-align: center">Laporan Data Customer</h2>
        </strong>
    </footer>
</body>
