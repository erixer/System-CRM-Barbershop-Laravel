@extends('layouts.admin.main')
@section('master_data', 'menu-open')
@section('produk', 'active')
@section('title', 'Edit Produk')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item"><a href="#">Produk</a></li>
            <li class="breadcrumb-item active">Edit Produk</li>
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
                <a href="{{ route('produk.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Back</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('produk.update', $produk->id) }}" method="post" enctype="multipart/form-data">
                  @csrf
                  @method('put')
                  <div class="form-group">
                    <label for="exampleInputEmail1">Produk</label>
                    <input name="name" type="text" value="{{ $produk->name }}" required class="form-control" id="exampleInputEmail1" placeholder="Enter Service Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi Singkat</label>
                    <input name="slug" type="text" value="{{ $produk->slug }}" required class="form-control" id="exampleInputEmail1" placeholder="Masukkan Deskripsi Singkat">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deskripsi</label>
                    <input name="desc" type="text" value="{{ $produk->desc }}" required class="form-control" id="exampleInputEmail1" placeholder="Masukkan Deskripsi Produk">
                  </div>
                  <div class="form-group">
                    <label>Select Category</label>
                    <select name="category" required class="form-control">
                      <option selected disabled value="">Select Category</option>
                      @foreach($categoryProduk as $category)
                        <option value="{{ $category->id }}" {{ $produk->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input name="price" type="number" value="{{ $produk->price }}" required class="form-control">
                  </div>
                  
                  <img id="img" src="{{ url('img/bukti_transfer/uploadProduk.jpg')}}" width="100px" height="100px"/>
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