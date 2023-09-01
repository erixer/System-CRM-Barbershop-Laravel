@extends('component.navbarLogin')

@section('content')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">

      @if($order->lunas == 'Order')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          Silahkan lakukan transfer pembayaran dan upload pukti pembayarannya di bawah ini!
        </div>
      @elseif($order->lunas == 'Payment')
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          <strong>Dimohon untuk berada di lokasi minimal 5 menit sebelumnya.</strong>
          <br>
          <strong class="text-danger">Jika sudah terlewat jamnya maka dianggap hangus.</strong>
          <br>
          Jika sudah upload bukti transfer silahkan tunggu persetujuan admin atau bisa langsung kontak admin pada tombol Whatsapp di bawah. 
        </div>
      @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Terima kasih! silahkan pesan dan datang kembali.
        </div>
      @endif

      <div class="card">
        <form action="{{ route('uploadBukti', $order->id) }}" method="post" enctype="multipart/form-data">
          @method('PUT')
          @csrf
          <div class="card-header bg-dark text-light">Booking Detail</div>
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <input type="text" id="myInput" readonly class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ $order->code }}">
                  <button class="btn btn-secondary" type="button" onclick="myFunction()" id="button-addon2">Copy Code</button>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <input type="text" id="myInput2" readonly class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ route('detail_payment', $order->code) }}">
                  <button class="btn btn-secondary" onclick="myFunction2()" type="button" id="button-addon2">Copy Link</button>
                </div>
              </div>
            </div>

          <table class="table table-striped">
              <tr>
                <th>SERVICE</th>
                <th>DURATION</th>
              </tr>
                @foreach($order->service as $service)
                  <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->duration }} {{ $service->time }}</td>
                  </tr>
                @endforeach
              <tr>
                <th>Capster</th>
                <td>{{ $order->employee->first_name }}</td>
              </tr>
              <tr>
                <th>Date</th>
                <td>{{ $order->date->format('d F Y') }} {{ $order->time->jam }}</td>
              </tr>
              <tr>
                <th>Place</th>
                <td>{{ $order->lokasi->name }}</td>
              </tr>
              <tr>
                <th>Net Total</th>
                <td>Rp. {{ $order->net }}.000,-</td>
              </tr>
              <tr>
                <th>Transfer Bank</th>
                <td>{{ $order->payment->bank }}</td>
              </tr>
              <tr>
                <th>No Rekening</th>
                <td>{{ $order->payment->norek }}</td>
              </tr>
              <tr>
                <th>Atas Nama</th>
                <td>{{ $order->payment->an }}</td>
              </tr>
              <tr>
                <th>Booking Note</th>
                <td>{{ $order->note }}</td>
              </tr>
          </table>

          @if($order->lunas != 'Approved')

          <div class="form-group mt-5">
            @if($order->images)
              <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Lihat Bukti Transfer
              </button> <br>
              <img id="img" src="{{ url('img/bukti_transfer/'.$order->images)}}" width="100px" height="100px"/>
            @else
              <img id="img" src="{{ url('img/bukti_transfer/bukti.jpg')}}" width="100px" height="100px"/>
            @endif
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Pilih Bukti Transfer</label>
            <input name="filefoto" class="form-control" type="file" id="filefoto">
          </div>

          <div>
            <button type="submit" class="btn btn-primary w-100">Upload File</button>
          </div>
          @else
          <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Lihat Bukti Transfer
          </button> <br>
          <img id="img" src="{{ url('img/bukti_transfer/'.$order->images)}}" width="100px" height="100px"/>
          @endif

          </div>
        </form>
      </div>

      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Bukti Transfer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img id="img" class="img-fluid" src="{{ url('img/bukti_transfer/'.$order->images)}}" height="80%"/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <a class='fixed-whatsapp' href="http://wa.me/{{ $wa->hp }}" rel='nofollow noopener' target='_blank' title='Konfirmasi Admin Barber' />


@endsection

@push('script')
<!-- bs-custom-file-input -->
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
<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the code: " + copyText.value);
}
function myFunction2() {
  var copyText = document.getElementById("myInput2");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the link: " + copyText.value);
}
</script>
@endpush