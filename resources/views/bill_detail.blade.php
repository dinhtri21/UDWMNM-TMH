@extends('layout.master')
<title>Chi Tiết Đơn Hàng</title>
@section('content')
<body>

    <div class="container">
        <h1>Chi tiết đơn hàng</h1>

        <div class="row">
            <div class="col-md-12">
                <!-- Thông tin khách hàng -->
                <div class="container123 col-md-6">
                    <h4>Thông tin khách hàng</h4>
                    <table class="table table-bordered">
                        <thead style="background-color: #DDDDDD;">
                            <tr>
                                <th class="col-md-4">Thông tin</th>
                                <th class="col-md-6">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tên khách hàng</td>
                                <td>{{ $customerInfo->cus_name }}</td>
                            </tr>
                            <tr>
                                <td>Ngày đặt hàng</td>
                                <td>{{ $customerInfo->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td>{{ $customerInfo->cus_phone }}</td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td>{{ $customerInfo->cus_address }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $customerInfo->cus_email }}</td>
                            </tr>
                            <tr>
                                <td>Ghi chú đơn hàng</td>
                                <td>{{ $customerInfo->note }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Thông tin chi tiết hóa đơn -->
                <table id="myTable" class="table table-bordered table-hover dataTable" role="grid">
                    <thead style="background-color: #DDDDDD;">
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billInfo as $key => $bill)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $bill->product_name }}</td>
                                <td>{{ $bill->quantily }}</td>
                                <td>{{ number_format($bill->product_price) }} VNĐ</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"><b style="font-size:25px;">Tổng tiền</b></td>
                            <td colspan="1">
                                <b class="text-red" style="font-size:25px;">{{ number_format($customerInfo->total) }} VNĐ</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
@endsection
