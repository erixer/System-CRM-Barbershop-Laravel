@extends('layouts.admin.main')
@section('order', 'active')
@section('title', 'Create Order')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create Order</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item"><a href="#">Order</a></li>
            <li class="breadcrumb-item active">Create Order</li>
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
          @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ $message }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          <!-- Default box -->
          <div class="card">
              <div class="card-header">
                <a href="{{ route('order.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Back</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('order.store') }}" method="post">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Select Service</label>
                    <div class="col-sm-10" id="accordion">

                      @foreach($categories as $category)
                        <div class="card card-primary card-outline">
                          <a class="d-block w-100" data-toggle="collapse" href="#collapse{{ $category->id }}">
                              <div class="card-header">
                                  <h4 class="card-title w-100">
                                      {{ $category->name }}
                                  </h4>
                              </div>
                          </a>
                          <div id="collapse{{ $category->id }}" class="collapse" data-parent="#accordion">
                              <div class="card-body">
                                <table class="table table-sm table-striped">
                                  @foreach($category->services as $service)
                                    <tr>
                                      <td>
                                        <span>{{ $service->name }}</span><br>
                                        <span class="form-check-label text-muted" for="flexCheckDefault">
                                            {{ $service->duration }} {{ $service->time }}
                                        </span> |
                                        <span class="form-check-label text-primary" for="flexCheckDefault">
                                            <strong>{{ $service->price }} K</strong>
                                        </span>
                                      </td>
                                      <td><a href="{{ route('addToCart', $service->id) }}" class="btn btn-secondary">Add</a></td>
                                    </tr>
                                  @endforeach
                                </table>
                              </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                  @php $total = 0; @endphp
                  @if(session('cart'))
                  <hr>
                  <table class="table table-sm table-striped">
                    <tr>
                      <th>Service</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Sub Total</th>
                      <th>Action</th>
                    </tr>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                      @php $total += $details['price'] * $details['quantity'] @endphp
                      <tr>
                        <td>{{ $details['name'] }}</td>
                        <td>{{ $details['price'] }} K</td>
                        <td>
                          <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                        </td>
                        <td>{{ $details['price'] * $details['quantity'] }} K</td>
                        <td>
                          <button class="btn btn-info btn-sm update-service d-inline" data-id="{{ $id }}"><i class="fas fa-sync-alt"></i></button>
                          <a href="{{ route('deleteService', $id) }}" class="btn btn-sm btn-danger d-inline"><i class="fas fa-trash"></i></a>
                        </td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td></td>
                      <td>Total</td>
                      <td>{{ $total }}</td>
                      <td></td>
                    </tr>
                  </table>
                  @endif
                  <hr>
                  
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Booking Note</label>
                    <div class="col-sm-10">
                      <textarea name="note" class="form-control" placeholder="Booking Note"></textarea>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Select Capster</label>
                    <div class="col-sm-10">
                      <select required name="staff" class="form-control">
                        <option selected disabled value="">Select Capster</option>
                        @foreach($staffs as $staff)
                          <option value="{{ $staff->id }}">{{ $staff->first_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Select Location</label>
                    <div class="col-sm-10">
                      <select required name="location" class="form-control">
                        <option selected disabled value="">Select Location</option>
                        @foreach($locations as $location)
                          <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Select Payment</label>
                    <div class="col-sm-10">
                      <select required name="payment" class="form-control">
                        <option selected disabled value="">Select Payment</option>
                        @foreach($payments as $payment)
                          <option value="{{ $payment->id }}">{{ $payment->bank }} | {{ $payment->an }} | {{ $payment->norek }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Select Date</label>
                    <div class="col-sm-10">
                      <input type="date" required class="form-control" name="date">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Select Time</label>
                    <div class="col-sm-10">
                      <select required name="time" class="form-control">
                        <option selected disabled value="">Select Time</option>
                        @foreach($times as $time)
                          <option value="{{ $time->id }}">{{ $time->jam }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="box-body">
                    <div style="margin-bottom: 15px">
                        <button type="button" class="discount-btn btn-primary" data-discount="0">0% off</button>
                        <button type="button" class="discount-btn btn-primary" data-discount="5">5% off</button>
                        <button type="button" class="discount-btn btn-primary" data-discount="10">10% off</button>
                        <button type="button" class="discount-btn btn-primary" data-discount="15">15% off</button>
                        <button type="button" class="discount-btn btn-primary" data-discount="25">25% off</button>
                        <button type="button" class="discount-btn btn-primary" data-discount="50">50% off</button>
                        <button type="button" class="discount-btn btn-primary" data-discount="75">75% off</button>
                        <button type="button" class="discount-btn btn-primary" data-discount="100">100% off</button>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                        <label>Total harga:</label>
                        <input type="text" class="form-control" id="total" name="harga" value="{{ $total }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>Masukan No Telp Pembeli Untuk Mendapatkan Discount</label>
                        <input type="text" name="no_hp" id="no_telp" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="hidden" readonly name="users_id" id="users_id" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Customer</label>
                        <input type="text" readonly name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alamat Customer</label>
                        <textarea name="alamat" readonly class="form-control" id="alamat" cols="10" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Total Kunjungan</label>
                        <input type="number" class="form-control" id="kunjungan" readonly>
                    </div>
                    <div class="form-group">
                        <label>Point</label>
                        <input type="number" name="point" class="form-control" id="point" readonly>
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <input type="text" class="form-control" id="discount1" name="discount" readonly>
                    </div>
                    <div class="form-group">
                        <label>Total harga setelah Discount:</label>
                        <input type="text" class="form-control" id="total1" name="harga_discount" value="0"  readonly>
                    </div>
                </div><!-- /.box-body -->


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
<script>
  $(document).ready(function(){

    // $('.quantity').on('click', function() {
      $(".update-service").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: '{{ url('update-service') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
    // });

  });


  $(document).ready(function() {
            $(".discount-btn").click(function() {
                var discount = $(this).data("discount");
                var totalHarga = parseInt($("#total").val());
                var hargaDiskon = totalHarga * discount / 100;
                var hargaSetelahDiskon = totalHarga - hargaDiskon;
                $("#total1").val(hargaSetelahDiskon);
                $("#discount1").val(discount);
                $(".discount-btn").attr("disabled", true).addClass("disabled");
            });
        });
        $(document).ready(function() {
            $("#form_calc input[type='checkbox']").change(function() {
                var totalPrice = 0;
                $("#form_calc input[type='text']").each(function() {
                    totalPrice += parseInt($(this).data("harga"));
                });

                $("#total").val(totalPrice);

                var no_hp = $("#no_telp").val();
                $.ajax({
                    url: "/admin/user/" + no_hp,
                    success: function(data) {
                        if (data && data.first_name) {
                            // var diskon = Math.floor(Math.random() * 20) + 1;
                            // var totalHarga = parseInt($("#total").val());
                            // var hargaDiskon = totalHarga * diskon / 100;
                            // var hargaSetelahDiskon = totalHarga - hargaDiskon;
                            // console.log("Data ditemukan!");
                            // console.log("Diskon: " + diskon + "%");
                            // console.log("Harga setelah diskon: " + hargaSetelahDiskon);
                            // $("#total1").val(hargaSetelahDiskon);
                            // $("#total_discount").val(diskon + "%");
                        } else {
                            console.log("Data tidak ditemukan!");
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan saat mengambil data pengguna dengan nomor handphone " +
                            no_hp + ".");
                    }
                });
            });

            $("#no_telp").on("input", function() {
                var no_hp = $("#no_telp").val();
                $.ajax({
                    url: "/admin/user/" + no_hp,
                    success: function(data) {
                        if (data && data.first_name) {
                            if (typeof discount !== 'undefined') {
                                var totalHarga = parseInt($("#total").val());
                                
                            }
                            $("#total1").val(totalHarga);
                            $("#users_id").val(data.id);
                            $("#nama").val(data.first_name);
                            $("#alamat").val(data.address);
                            $("#kunjungan").val(data.kunjungan);
                            $("#point").val(data.point);

                            // $("#total_discount").val(diskon + "%");

                        } else {
                            console.log("Data tidak ditemukan!");
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan saat mengambil data pengguna dengan nomor handphone " +
                            no_hp + ".");
                    }
                });
            });

            $('.jumlah').val('0');

            $('.btn-tambah').click(function() {
                var harga = parseInt($(this).data('harga'));
                var jumlah = parseInt($(this).siblings('.jumlah').val()) + 1;
                $(this).siblings('.jumlah').val(jumlah);
                var totalHarga = parseInt($('#total').val()) + harga;
                $('#total').val(totalHarga);
            });

            $('.btn-kurang').click(function() {
                var harga = parseInt($(this).data('harga'));
                var jumlah = parseInt($(this).siblings('.jumlah').val()) - 1;
                if (jumlah < 0) {
                    jumlah = 0;
                }
                $(this).siblings('.jumlah').val(jumlah);
                var totalHarga = parseInt($('#total').val()) - harga;
                if (totalHarga < 0) {
                    totalHarga = 0;
                }
                $('#total').val(totalHarga);
            });
        });




</script>
@endpush