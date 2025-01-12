<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('cus_id'); // ID khách hàng (liên kết với bảng `customer`)
            $table->dateTime('date_order'); // Ngày đặt hàng
            $table->decimal('total', 10, 2); // Tổng tiền
            $table->text('note')->nullable(); // Ghi chú hóa đơn
            $table->timestamps(); // created_at và updated_at

            // Liên kết khóa ngoại với bảng `customer`
            $table->foreign('cus_id')->references('id')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
