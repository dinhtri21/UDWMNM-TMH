@extends('layout.master')
<title>Danh Sách Đơn Hàng</title>
@section('content')

<body>

    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info"> {{ Session::get('message') }}</div>
        @endif
        <div class="row">
            <div style="margin-top:20px;">
                <div>
                    <div class="col-sm-6" style="margin-bottom:20px;">
                        <p> <a href="{{route('order')}}">
                                <h3>Danh sách đơn hàng: </h3>
                            </a></p>
                    </div>
                    <form action="{{route('bill_search')}}" role="search">
                        <div class="col-sm-6" style="width:300px; float:right; display: flex;">
                            <input type="search" name="bill_search" value="" class="form-control">
                            <button class="btn btn-default btn-circle"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Makeup -->
        <div style="margin-top:20px;" class="table-responsive">
            <table class="table table-hover">
                <thead style="background-color: #DDDDDD;">
                    <tr>
                        <th style="width:5%">STT</th>
                        <th style="width:15%">Mã KH</th>
                        <th style="width:20%">Ngày đặt</th>
                        <th style="width:20%">Tổng tiền</th>
                        <th style="width:20%">Ghi chú</th>
                        <th style="width:10%">Action</th>
                        <th style="width:10%">Xoá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bills as $bill)
                        <tr>
                            <td style="width:5%">{{ $bill->id }}</td>
                            <td style="width:15%">{{ $bill->cus_id }}</td> <!-- Hiển thị ID khách hàng -->
                            <td style="width:20%">{{ $bill->date_order }}</td>
                            <td style="width:20%">{{ $bill->total }}</td>
                            <td style="width:20%">{{ $bill->note }}</td>
                            <td style="width:10%">
                                <a href="{{ route('bill_detail', $bill->id) }}" style="color:gray; font-size:12px;">Chi
                                    tiết</a>
                            </td>
                            <td style="width:10%">
                                <a href="{{ route('bill_destroy', $bill->id) }}"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div align="right">{{ $bills->links() }}</div>
    </div>

    @endsection