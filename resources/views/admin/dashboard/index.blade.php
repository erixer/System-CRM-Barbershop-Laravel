@extends('layouts.admin.main')
@section('dashboard', 'active')
@section('title', 'Dashboard')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       <div class="col-md-3 col-6">
          
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $produk->count() }}</h3>

              <p>Produk</p>
            </div>
            <div class="icon">
              <i class="bi bi-inboxes-fill" style="font-size: 65px"></i>
            </div>
          </div>
          
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-6">
          <!-- small box -->
          <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{ $keluhan->count() }}</h3>

              <p>Keluhan</p>
            </div>
            <div class="icon">
              <i class="fas fa-id-card"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $members->count() }}</h3>

              <p>Pelanggan</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-tie"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-6">
          <!-- small box -->
          <div class="small-box bg-default">
            <div class="inner">
              <h3>{{ $testimoni->count() }}</h3>

              <p>Testimoni</p>
            </div>
            <div class="icon">
              <i class="fas fa-id-card"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-md-3 col-6">
          <!-- small box -->
          <div class="small-box bg-dark">
            <div class="inner">
              <h3>{{ $services->count() }}</h3>

              <p>Services</p>
            </div>
            <div class="icon">
              <i class="fas fa-chair"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $orderServices->count() }}</h3>

              <p>Booking Hari ini</p>
            </div>
            <div class="icon">
              <i class="fas fa-chair"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{ $orderProduks->count() }}</h3>

              <p>Order Produk Hari ini</p>
            </div>
            <div class="icon" >
              <i class="bi bi-bag-fill" style="font-size: 65px"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $totalPendapatan }} K</h3>

              <p>Pendapatan Hari Ini</p>
            </div>
            <div class="icon">
              <i class="fas fa-money-bill-wave"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>


      

      <div class="row">
        <div class="col-12">
          <!-- DONUT CHART -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Top Customer</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>No Hp</th>
                            <th>Total Kunjungan</th>
                            <th>Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topCustomers as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->first_name }}</td>
                                <td>{{ $item->hp }}</td>
                                <td>{{ $item->kunjungan }}</td>
                                <td>{{ $item->point }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>No Hp</th>
                            <th>Total Kunjungan</th>
                            <th>Point</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->






          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Produk Terpopuler</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Deskripsi Singkat</th>
                            <th>Harga</th>
                            <th>Produk Terbeli</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topProduk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> @if($item->images)
                                  <!--<a href="#" data-toggle="modal" data-target="#modal-default">-->
                                  <img id="img" src="{{ url('img/produk/')}}/{{ $item->images }}" width="50px"/>
                                </a>
                                @else
                                  tidak Ada Gambar
                                @endif</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>Rp. {{ number_format($item->price,3,'.','') }}</td>
                                <td>{{ $item->total_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Gambar</th>
                          <th>Nama Produk</th>
                          <th>Deskripsi Singkat</th>
                          <th>Harga</th>
                          <th>Produk Terbeli</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

@endsection

@push('script')
<!-- ChartJS -->
<script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
<!-- FLOT CHARTS -->
<script src="{{ asset('admin/plugins/flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ asset('admin/plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('admin/plugins/flot/plugins/jquery.flot.pie.js') }}"></script>
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
        @foreach($locations as $location)
          '{{ $location->name }}',
        @endforeach
      ],
      datasets: [
        {
          data: [
            @foreach($locations as $location)
            {{ $location->orders->count() }},
            @endforeach
            ],
          backgroundColor : [
            @foreach($locations as $location)
            '{{ $location->color }}',
            @endforeach
            ],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var revenueData        = {
      labels: [
        @foreach($locations as $location)
          '{{ $location->name }}',
        @endforeach
      ],
      datasets: [
        {
          data: [
            @foreach($locations as $location)
            {{ $location->orders->sum('gross') }},
            @endforeach
            ],
          backgroundColor : [
            @foreach($locations as $location)
            '{{ $location->color }}',
            @endforeach
            ],
        }
      ]
    }
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = revenueData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
      data : [
        @foreach($locations as $location)
          [{{ $loop->iteration }},{{ $staff->where('location_id', $location->id)->count() }}],
        @endforeach
        ],
      bars: { show: true }
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [
          @foreach($locations as $location)
            [{{ $loop->iteration }},'{{ $location->name }}'],
          @endforeach
          ]
      }
    })
    /* END BAR CHART */

  })
</script>
@endpush