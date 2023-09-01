@extends('component.navbarLogin')


@section('content')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <a href="/customer" class="btn btn-dark mb-3 btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        <a href="{{ route('carts.index') }}" class="btn btn-primary mb-3 btn-sm">Cart</a>
        <!--<a href="/customer" class="btn btn-danger mb-3 btn-sm">Change Customer</a>-->

      <div class="card">
        <form action="{{ route('paymentProduk') }}" method="post">
          @csrf
          <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
          <input type="hidden" name="no_hp" value="{{ Auth::user()->hp }}">
          <div class="card-header bg-dark text-light">Order Detail</div>
          <div class="card-body">


            <br>

            <table class="table table-striped">
                <tr>
                  <th>PRODUK</th>
                  <th>QUANTITY</th>
                </tr>
                @php $total = 0; @endphp
                @if($cart)
                  @foreach($cart as $list)
                  @php $total += $list->price * $list->qty @endphp
                    <tr>
                      <td>{{ $list->produkss->name }}</td>
                      <td>{{ $list->qty }}</td>
                    </tr>
                  @endforeach
                @endif
                </tr>
                <tr>
                  <th>Net Total</th>
                  <td>{{ number_format($totalHarga) }} K</td>
                </tr>
                <tr>
                  <th>Tax</th>
                  <td>0.0</td>
                </tr>
            </table>

            <div class="mb-3">
                <label for="">Note</label>
                <textarea name="note" class="form-control" rows="3" placeholder="Note"></textarea>
            </div>
            <div class="mb-3">
              <label for="">Alamat</label>
              <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat"></textarea>
          </div>

            <div>
              <label for="">Pilih Pembayaran</label>
              <select required name="payment" class="form-select" aria-label="Default select example">
                <option selected disabled value="">Pilih Pembayaran</option>
                @foreach($payments as $payment)
                  <option value="{{ $payment->id }}">{{ $payment->bank }} | {{ $payment->norek }} | a.n {{ $payment->an }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="card-footer bg-dark">
            <div class="row">
              <div class="col-md-6">
                @if($cart)
                  <span class="text-light">{{ $cart->count() }} Produk | Total {{ $total }}</span>
                @endif
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-light w-100">NEXT</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      </div>
    </div>
  </div>

@endsection