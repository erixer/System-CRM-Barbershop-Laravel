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
        <p>Data Order Produk dari {{ $start_date }} sampai dengan {{ $end_date }}</p>
    @endif
    <table id="example1" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Tanggal Order</th>
                <th>Pembayaran</th>
                <th>Harga Normal</th>
                <th>Harga Discount</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order_produk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->client->first_name }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->payment->bank }} a.n {{ $item->payment->an }}, {{ $item->payment->norek }}</td>
                    <td>Rp.&nbsp;{{ number_format($item->net,3,'.','') }}</td>
                    <td>
                        @if ($item->gross != null)
                            Rp.&nbsp;{{ number_format($item->gross,3,'.','') }}
                            <span class="label btn-primary" style="margin: 2px; padding: 2px 9px 2px 9px; border-radius:4px; font-size: 12px;">{{ $item->discount }}%</span>
                        @else
                            Rp.&nbsp;{{ number_format($item->net,3,'.','') }}
                            <span class="label btn-danger" style="margin: 2px; padding: 2px 9px 2px 9px; border-radius:4px; font-size: 12px;">0%</span>
                        @endif
                    </td>
                    <td>{{ $item->lunas }}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>

    <footer>
        <strong>
            <h3 style="text-align: center">Laporan Order Product</h2>
        </strong>
    </footer>
</body>
