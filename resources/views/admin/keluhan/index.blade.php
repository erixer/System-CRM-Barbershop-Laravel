@extends('layouts.admin.main')
@section('keluhan', 'active')
@section('title', 'Testimoni')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Tabel Keluhan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Keluhan</li>
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
                  <a href="{{ route('laporan.exportPDFKeluhan', ['start_date' => $start_date, 'end_date' => $end_date]) }}" class="btn btn-danger">PDF</a>
                </div>
                @if ($start_date && $end_date)
                    <p>Data Keluhan dari {{ $start_date }} sampai dengan {{ $end_date }}</p>
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
                    <th>Kategori</th>
                    <th>Isi Tanggapan</th>
                    <th>Tanggal</th>
                    <th>Tanggapan</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($keluhan as $item)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->isi }}</td>
                    <td>{{ $item->tanggal_tanggapan }}</td>
                    <td>{{ $item->tanggapan }}</td>
                    <td>
                        @if ($item->status == 0)
                            <small class="label bg-yellow">Belum di-Tanggapi</small>
                        @elseif($item->status == 1)
                            <small class="label bg-green">Sudah di-Tanggapi</small>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('keluhans.edit', $item->id) }}" class="btn btn-success btn-sm">edit</a>
                    </td>
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