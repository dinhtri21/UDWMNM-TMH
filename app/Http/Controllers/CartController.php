<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\ProductModel;
use App\CustomerModel;
use App\BillModel;
use App\BillDetailModel;

class CartController extends Controller
{
    // Hiển thị danh sách tất cả sản phẩm
    public function index()
    {
        $products = ProductModel::all(); // Lấy tất cả sản phẩm từ database
        return view('cart', compact('products')); // Trả về view giỏ hàng
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addProductToCart($id)
    {
        $product = ProductModel::find($id); // Tìm sản phẩm theo ID
        if ($product) {
            // Sử dụng package Cart để thêm sản phẩm vào giỏ
            \Cart::add(array(
                'id' => $id,
                'name' => $product->product_name,
                'qty' => 1, // Số lượng mặc định là 1
                'price' => $product->product_price, // Giá sản phẩm
                'weight' => 100 // Trọng lượng sản phẩm
            ));
            return redirect()->back(); // Quay lại trang trước đó
        }
        // Nếu cần, có thể thêm logic tăng số lượng sản phẩm tại đây
    }

    // Hiển thị danh sách sản phẩm trong giỏ hàng và cho phép tăng/giảm số lượng
    public function listCartProduct($id = null)
    {
        $product = ProductModel::find($id); // Tìm sản phẩm (nếu cần)
        $products = \Cart::content(); // Lấy danh sách sản phẩm trong giỏ
        $viewData = [
            'products' => $products // Truyền dữ liệu giỏ hàng vào view
        ];

        // Xử lý tăng số lượng sản phẩm
        if (Request::get('id') && (Request::get('increment')) == 1) {
            $rows = \Cart::search(function ($key, $value) {
                return $key->id == Request::get('id'); // Tìm sản phẩm theo ID
            });
            $product = $rows->first(); // Lấy sản phẩm đầu tiên từ kết quả
            \Cart::update($product->rowId, $product->qty + 1); // Tăng số lượng sản phẩm
        }

        // Xử lý giảm số lượng sản phẩm
        if (Request::get('id') && (Request::get('decrease')) == 1) {
            $rows = \Cart::search(function ($key, $value) {
                return $key->id == Request::get('id'); // Tìm sản phẩm theo ID
            });
            $product = $rows->first(); // Lấy sản phẩm đầu tiên từ kết quả
            \Cart::update($product->rowId, $product->qty - 1); // Giảm số lượng sản phẩm
        }

        return view('cart', $viewData); // Trả về view giỏ hàng
    }

    // Trang checkout
    public function getCheckOut()
    {
        $this->data['title'] = 'Check out'; // Tiêu đề trang
        $this->data['cart'] = \Cart::content(); // Lấy danh sách sản phẩm trong giỏ
        $this->data['total'] = \Cart::total(); // Tổng tiền trong giỏ
        return view('checkout', $this->data); // Trả về view checkout
    }

    // Xử lý thông tin thanh toán khi khách hàng checkout
    public function postCheckOut(Request $request)
    {
        $cartInfor = \Cart::content(); // Lấy thông tin giỏ hàng

        try {
            // Lưu thông tin khách hàng
            $customer = new CustomerModel;
            $customer->cus_name = Request::get('fullName'); // Lấy tên khách hàng từ form
            $customer->cus_email = Request::get('email'); // Email khách hàng
            $customer->cus_address = Request::get('address'); // Địa chỉ
            $customer->cus_phone = Request::get('phoneNumber'); // Số điện thoại
            $customer->cus_note = Request::get('note'); // Ghi chú (nếu có)
            $customer->save();

            // Lưu thông tin hóa đơn
            $bill = new BillModel;
            $bill->cus_id = $customer->id; // ID khách hàng
            $bill->date_order = date('Y-m-d H:i:s'); // Ngày đặt hàng
            $bill->total = str_replace(',', '', \Cart::total()); // Tổng tiền (loại bỏ dấu phẩy)
            $bill->note = Request::get('note'); // Ghi chú hóa đơn
            $bill->save();

            // Lưu thông tin chi tiết hóa đơn
            if (count($cartInfor) > 0) {
                foreach ($cartInfor as $key => $item) {
                    $billDetail = new BillDetailModel;
                    $billDetail->bill_id = $bill->id; // ID hóa đơn
                    $billDetail->product_id = $item->id; // ID sản phẩm
                    $billDetail->quantily = $item->qty; // Số lượng
                    $billDetail->price = $item->price; // Giá sản phẩm
                    $billDetail->save();
                }
            }

            // Xóa toàn bộ giỏ hàng sau khi hoàn tất
            \Cart::destroy();

        } catch (Exception $e) {
            echo $e->getMessage(); // Hiển thị lỗi nếu có
        }

        return redirect()->back()->with('alert', 'Purchase complete! Thanks for choosing our website ;)');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        \Cart::remove($id); // Xóa sản phẩm theo ID khỏi giỏ hàng
        return back(); // Quay lại trang trước đó
    }
}
