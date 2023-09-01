<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>

<body>
    <h2 style="text-align: center"> COOL-GUY BARBERSHOP</h2>
    <h5 style="text-align: center">
        Depan BPJSketenagakerjaan Depok, Jl. Sersan Anning No.3, Kota Depok, Jawa Barat 16431 
    </h5>
    @if ($start_date && $end_date)
        <p>Data Laporan Pendapatan Produk dari {{ $start_date }} sampai dengan {{ $end_date }}</p>
    @endif
    <table id="example1" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Produk</th>
                <th>Harga Normal</th>
                <th>Harga Discount</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order_produk as $items)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                            {{ ($items->client->first_name) }}
                      
                    </td>
                    <td>
                        @foreach ($items->produk as $item)
                            <small class="label bg-yellow" style="margin: 2px; padding: 2px 9px 2px 9px; border-radius:4px; font-size: 12px;"> {{ $item->pivot->qty }}</small> 
                            <small class="label bg-primary" style="margin: 2px; padding: 2px 9px 2px 9px; border-radius:4px; font-size: 12px;">{{ $item->name }} </small><br>
                        @endforeach
                        
                    </td>
                    <td> Rp.&nbsp;{{ number_format($items->net,3,'.','') }}</td>
                    <td>  
                      @if ($items->gross != null)
                           Rp.&nbsp;{{ number_format($items->gross,3,'.','') }}
                          <span class="label btn-primary" style="margin: 2px; padding: 2px 9px 2px 9px; border-radius:4px; font-size: 12px;">{{ $items->discount }}%</span>
                      @else
                          Rp.&nbsp;{{ number_format($items->net,3,'.','') }}
                          <span class="label btn-danger" style="margin: 2px; padding: 2px 9px 2px 9px; border-radius:4px; font-size: 12px;">0%</span>

                      @endif
                    </td>
                    <td> {{ $items->tanggal }}</td>
                  </tr>
                  @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Jumlah Total Pendapatan</th>
                <th>  
                    @foreach($order as $item)
                        Rp. {{ number_format($item->total_harga,3,'.','') }}
                    @endforeach
                </th>
            </tr>
        </tfoot>
    </table>

    <footer>
        <strong>
            <h3 style="text-align: center">Laporan Pendapatan Pembelian Product</h2>
        </strong>
    </footer>
</body>
