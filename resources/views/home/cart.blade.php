@extends('layouts.home')
@section('title', 'Cart')
@section('content')
    <!-- Cart -->
    <section class="section-wrap shopping-cart">
        <div class="container relative">
            <div class="row">

                <div class="col-md-12">
                    <div class="table-wrap mb-30">
                        <table class="shop_table cart table">
                            <thead>
                                <tr>
                                    <th class="product-name" colspan="2">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal" colspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr class="cart_item">
                                        <td class="product-thumbnail">
                                            <a href="#">
                                                <img src="/uploads/{{ $cart->product->gambar }}" alt="">
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <a href="#">{{ $cart->product->nama_barang }}</a>
                                            <ul>
                                                <li>Size: {{ $cart->ukuran }}</li>
                                                <li>Color: {{ $cart->warna }}</li>
                                            </ul>
                                        </td>
                                        <td class="product-price">
                                            <span class="amount">Rp. {{ number_format($cart->product->harga) }}</span>
                                        </td>
                                        <td class="product-quantity">
                                            {{-- <div class="quantity buttons_added">
                                                <input type="number" step="1" min="0"
                                                    value="{{ $cart->jumlah }}" title="Qty" class="input-text qty text">
                                                <div class="quantity-adjust">
                                                    <a href="#" class="plus">
                                                        <i class="fa fa-angle-up"></i>
                                                    </a>
                                                    <a href="#" class="minus">
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>
                                            </div> --}}
                                            <span class="qty text">{{ $cart->jumlah }}</span>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount">Rp. {{ number_format($cart->total) }}</span>
                                        </td>
                                        <td class="product-remove">
                                            <a href="/delete_from_cart/{{ $cart->id }}" class="remove"
                                                title="Remove this item">
                                                <i class="ui-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mb-50">
                        <div class="col-md-5 col-sm-12">
                            <div class="coupon">
                                <input type="text" name="coupon_code" id="coupon_code" class="input-text form-control"
                                    value placeholder="Coupon code">
                                <input type="submit" name="apply_coupon" class="btn btn-lg btn-stroke" value="Apply">
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="actions">
                                <input type="submit" name="update_cart" value="Update Cart" class="btn btn-lg btn-stroke">
                                <div class="wc-proceed-to-checkout">
                                    <a href="/checkout" class="btn btn-lg btn-dark"><span>proceed to checkout</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end col -->
            </div> <!-- end row -->

            <div class="row">
                <div class="col-md-6 shipping-calculator-form">
                    <h2 class="heading relative uppercase bottom-line full-grey mb-30">Calculate Shipping</h2>
                    <p class="form-row form-row-wide">
                        <select name="provinsi" id="provinsi" class="provinsi">
                            <option value="">Select Provinsi</option>
                            @foreach ($provinsi->rajaongkir->results as $prov)
                                <option value="{{ $prov->province_id }}">{{ $prov->province }}</option>
                            @endforeach
                        </select>
                        <select name="kabupaten" id="kabupaten" class="kabupaten">
                            <option value="">Select Kabupaten</option>
                        </select>
                    </p>

                    <div class="row row-10">
                        <div class="col-sm-12">
                            <p class="form-row form-row-wide">
                                <input type="text" class="input-text" value placeholder="Detail Alamat"
                                    name="detail_alamat" id="detail_alamat">
                            </p>
                        </div>
                    </div>

                    <p>
                        <input type="submit" name="calc_shipping" value="Update Totals"
                            class="btn btn-lg btn-stroke mt-10 mb-mdm-40">
                    </p>
                </div> <!-- end col shipping calculator -->

                <div class="col-md-6">
                    <div class="cart_totals">
                        <h2 class="heading relative bottom-line full-grey uppercase mb-30">Cart Totals</h2>

                        <table class="table shop_table">
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>Cart Subtotal</th>
                                    <td>
                                        <span class="amount">0</span>
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <th>Shipping</th>
                                    <td>
                                        <span>0</span>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Order Total</th>
                                    <td>
                                        <strong><span class="amount">0</span></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div> <!-- end col cart totals -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section> <!-- end cart -->
@endsection

@push('js')
    <script>
        $(function() {
            $('.provinsi').change(function() {
                $id_province = $(this).val();
                console.log($id_province);
                // do ajax
                $.ajax({
                    url: `/get_kabupaten/` + $id_province,
                    success: function(data) {
                        data = JSON.parse(data);
                        option = "",
                            data.rajaongkir.results.map(function(kabupaten) {
                                option +=
                                    `<option value=${kabupaten.city_id}>${kabupaten.city_name}</option>`
                            });
                        $('.kabupaten').html(option);
                    }
                })
            });
        });
    </script>
@endpush
