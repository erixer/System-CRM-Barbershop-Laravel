@extends('component.navbarLogin')

@section('content')
    

<div class="container-fluid p-5" style="height: 100%;">
    <div>
        <h2 class="text-center text-white p-4" style="background-color :rgb(0, 0, 0);">Masukkan Testimoni</h2>

        <br>
        
        @if($testimoni->count() > 0 || $testimonis->count() > 0)
        <form action="{{ route('testimonis.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            <input type="hidden" name="nama_user" value="{{ Auth::user()->first_name }}">
            <div class="row mb-3">
                <label for="exampleInputEmail1" class="col-sm-2 col-form-label fw-bolder">Tanggal Testimoni</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" readonly name="tanggal" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-form-label fw-bolder">Pilih Kategori</label>
                <div class="col-sm-10">
                    <select name="category" required class="form-control">
                        <option selected disabled value="">Pilih Kategori</option>
                          <option value="Pelayanan">Pelayanan</option>
                          <option value="Tempat">Tempat</option>
                          <option value="Harga">Harga</option>
                          <option value="Produk">Produk</option>
                    </select>
                </div>   
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label fw-bolder">Isi Tesimoni</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="isi" rows="5"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label fw-bolder">Beri Nilai</label>
                <div class="col-sm-10">
                    <input type="radio" name="penilaian" value="1">
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <br>

                    <input type="radio" name="penilaian" value="2">
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <br>

                    <input type="radio" name="penilaian" value="3">
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <br>

                    <input type="radio" name="penilaian" value="4">
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <br>
                    <input type="radio" name="penilaian" value="5">
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                    <i class="bi bi-star-fill" style="color:orangered"></i>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-sm-5" style="display: flex;justify-content: flex-end;">
                    <button type="submit" name="tambah" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </form>
        @else
        <center>Anda harus Booking atau Order Produk terlebih dahulu untuk memberikan Testimoni</center>
        @endif

    </div>
</div>

@endsection