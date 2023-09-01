@extends('layouts.admin.main')
@section('laporan', 'menu-open')
@section('pendapatanProduk', 'active')
@section('title', 'Testimoni')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Laporan Pendapatan Produk</h1>
            @foreach ($order as $item)
                <h5 class="label bg-primary">Total Pendapatan : Rp. {{ number_format($item->total_harga,3,'.','') }}</h5>
            @endforeach
        </div>
       
        
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Laporan Booking</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  
  <!-- Main content -->
  <section class="content">
    
    <div class="container-fluid">
      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif

    <form action="" method="GET">
        <div class="form-group">
            <label for="start_date">Pilih Tanggal Awal:</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
            <div class="form-group">
                <label for="end_date">Pilih Tanggal Akhir:</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-bottom: 15px">Tampilkan</button>
    </form>
    <div class="form-group">
        <a href="{{ route('laporan.exportPDFPendapatanProduk', ['start_date' => $start_date, 'end_date' => $end_date]) }}" class="btn btn-danger">PDF</a>
    </div>
        @if ($start_date && $end_date)
             <p>Data Pendapatan Produk dari {{ $start_date }} sampai dengan {{ $end_date }}</p>
        @endif

      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-sm table-striped">
                  <thead>
                  <tr class="text-center">
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
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

@endsection

@push('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('script')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endpush