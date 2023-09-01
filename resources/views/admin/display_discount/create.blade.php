@extends('layouts.admin.main')
@section('master_data', 'menu-open')
@section('display_discount', 'active')
@section('title', 'Create Display  Discount')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create Display Discount</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item"><a href="#">Display Discount</a></li>
            <li class="breadcrumb-item active">Create Display Discount</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                <a href="{{ route('displayDiscount.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Back</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('displayDiscount.store') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Discount</label>
                    <input name="name" type="text" value="{{ old('name') }}" required class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama Discount">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Periode Discount</label>
                    <input name="periode" type="text" value="{{ old('periode') }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Periode Discount">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi Singkat</label>
                    <input name="excerpt" type="text" value="{{ old('excerpt') }}" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Deskripsi Singkat">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi</label>
                    <textarea class="form-control" required name="desc" value="{{ old('desc') }}" rows="5" placeholder="Masukkan Deskripsi Discount"></textarea>
                  </div>
                  
                  <img id="img" src="{{ url('img/uploadGambar.jpg')}}" width="100px" height="100px"/>
                  <div class="mb-3">
                    <label for="formFile" class="form-label">Pilih Gambar</label>
                    <input name="filefoto" class="form-control" type="file" id="filefoto">
                  </div>
      
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                  </div>
                  
                </form>
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

@endpush

@push('script')
<script src="{{ asset('bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
  $(function () {

    bsCustomFileInput.init();

    $('#filefoto').change(function(){
      var input = this;
      var url = $(this).val();
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
      {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('#img').attr('src', e.target.result);
          }
        reader.readAsDataURL(input.files[0]);
      }
    })
  });
</script>
@endpush