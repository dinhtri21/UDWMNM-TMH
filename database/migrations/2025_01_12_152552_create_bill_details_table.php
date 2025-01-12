<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_details', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('bill_id'); // ID hóa đơn (liên kết với bảng `bills`)
            $table->integer('product_id'); // ID sản phẩm (liên kết với bảng `products`)
            $table->integer('quantily'); // Số lượng sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->timestamps(); // created_at và updated_at

            // Liên kết khóa ngoại với bảng `bills`
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            // Liên kết khóa ngoại với bảng `products` (bảng này phải có sẵn trong cơ sở dữ liệu)
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_details');
    }
}
