@extends('component.navbarLogin')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home"
                            type="button" role="tab" aria-controls="pills-home" aria-selected="true">Testimoni</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile"
                            type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Keluhan</button>
                    </li>
                    <li class="nav-item" >
                        <button class="nav-link"
                            type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Point : {{ Auth::user()->point }}</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Isi</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Tanggapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($testimoni as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $item->isi }}</td>
                                        <td>{{ $item->tgl_tanggapan }}</td>
                                        <td>{{ $item->tanggapan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Isi</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Tanggapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($keluhan as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $item->isi }}</td>
                                        <td>{{ $item->tgl_tanggapan }}</td>
                                        <td>{{ $item->tanggapan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
</script>
@endsection