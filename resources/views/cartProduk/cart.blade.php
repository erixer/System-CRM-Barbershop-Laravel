@extends('component.navbarLogin')



@section('content')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">    

        <a href="/" class="btn btn-dark mb-3"><i class="bi bi-arrow-left"></i> Back</a>

      <div class="card">
        <form action="">
          <div class="card-header bg-dark text-light">List Keranjang</div>
          <div class="card-body">
            <div>
              @if($cart)
                <div class="d-inline">{{ $cart->count() }} Produk</div>
              @endif
            </div>
            
            
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>Produk</th>
                  <th>Price</th>
                  <th>QTY</th>
                  <th>Sub Total</th>
                </tr>
              </thead>
             
            @foreach ($cart as $item)
                  
                  <tr>
                    <td>
                        <img id="img" src="{{ url('img/produk/')}}/{{ $item->produkss->images }}" width="50px"/>
                    </td>
                    <td>{{ $item->produkss->name }}</td>
                    <td>{{ $item->produkss->price }} K</td>
                    <td>
                      <div style="display: flex; align-items: center;">
                        <!-- min -->
                        <form type='hidden' action="{{ route('carts.destroy', $item->id_produk) }}" method="post">
                          @csrf
                          @method('DELETE')
                          
                        </form>
                        <form action="{{ route('carts.destroy', $item->id_produk) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none;"><i class="bi bi-dash cart"></i></button>
                        </form>
                        
                        <span>{{ $item->qty }}</span>

                        <!-- plus -->
                        <form action="{{ route('carts.store') }}" method="post">
                            @csrf
                            @method('POST')
                           
                            <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" style="border: none;"><i class="bi bi-plus cart"></i></button>
                        </form>
                    </div>
                   </td>
                    <td>{{ $item->price * $item->qty }}</td>
                  </tr>    
                      
            @endforeach
            </table>
          </div>
          <div class="card-footer bg-dark">
            <div class="row">
              <div class="col-md-6">
                  <span class="text-light">TOTAL : Rp. {{ number_format($totalHarga) }}</span>
              </div>
              <div class="col-md-6">
                <a href="{{ route('carts.create') }}" type="submit" class="btn btn-light w-100">NEXT</a>
              </div>
            </div>
          </div>
        </form>
      </div>

      </div>
    </div>
  </div>

@endsection

@push('script')
<script>
  $(document).ready(function(){

    // $('.quantity').on('click', function() {
      $(".update-cartProduks").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: '{{ url('update-cartProduks') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("datas"), qty: ele.parents("tr").find(".qty").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
    // });

  });
</script>
@endpush