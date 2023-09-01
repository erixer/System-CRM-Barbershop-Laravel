@extends('layouts.admin.main')
@section('master_data', 'menu-open')
@section('display_discount', 'active')
@section('title', 'Display Discount')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Display Discount</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Display Discount</li>
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
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                <a href="{{ route('displayDiscount.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Create Produk</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-sm table-striped">
                  <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Periode</th>
                    <th>Excerpt</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($display_discount as $discount)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                      @if($discount->images)
                      <a href="#" data-toggle="modal" data-target="#modal-default{{ $discount->id }}">
                      <img id="img" src="{{ url('img/display_discount/')}}/{{ $discount->images }}" width="50px"/>
                    </a>
                    @else
                      tidak Ada Gambar
                    @endif
                    </td>
                    <td>{{ $discount->name }}</td>
                    <td>{{ $discount->periode }}</td>
                    <td>{{ $discount->excerpt }}</td>
                    <td>{{ $discount->desc }}</td>
                    <td class="text-center">
                      <form action="{{ route('displayDiscount.destroy', $discount->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="loc">
                        <a href="{{ route('displayDiscount.edit', $discount->id) }}" class="btn btn-warning btn-sm">edit</a>
                        <button type="submit" class="btn btn-danger btn-sm">delete</button>
                      </form>
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
@foreach($display_discount as $item)
<div class="modal fade" id="modal-default{{ $item->id }}">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Display Discount</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center">
          <img id="img" src="{{ url('img/display_discount/')}}/{{ $item->images }}" width="250px"/>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endforeach

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