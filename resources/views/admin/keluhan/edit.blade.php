@extends('layouts.admin.main')
@section('keluhan', 'active')
@section('title', 'Keluhan')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Keluhan</h1>
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
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <a href="{{ route('keluhans.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <br><!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="{{ route('keluhans.update', $keluhan->id) }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="tgl_tanggapan" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="tanggal" value="{{ $keluhan->tanggal }}">
            <div class="box-body">
                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="hidden" name="id" value="{{ $keluhan->id }}" class="form-control">
                    <input type="text" name="nama" readonly value="{{ $keluhan->nama }}" class="form-control">
                </div>
                <label>Keluhan Customer</label>
                <textarea class="form-control" name="isi" readonly rows="5">{{ $keluhan->isi }}</textarea>
                <label style="margin-top: 15px">Isi Tanggapan Admin</label>
                <textarea class="form-control" name="tanggapan" rows="5">{{ $keluhan->tanggapan }}</textarea>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" required value="1" name="status"> Check me out
                    </label>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
            <a href="{{ url('https://api.whatsapp.com/send/?phone=' . $keluhan->no_hp . '&text=Hi%20' . $keluhan->nama . '%0A%0ATanggapan%20kamu%20sudah%20dibalas%20oleh%20admin%2C%20untuk%20mengecek%20tanggapan%20silahkan%20pergi%20ke%20menu%20profile.%0ATerimakasih%20sudah%20mengunjungi.&type=custom_url&app_absent=0') }}" target="_blank" class="btn btn-success">WhatsApp</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    </div>
  </section>
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