@extends('layouts.home')
@section('title', 'Cart')
@section('content')
    <!-- Cart -->
    <section class="section-wrap shopping-cart">
        <div class="container relative">

            <form class="form-cart">
                @csrf
                <input type="hidden" name="id_member" value="{{ Auth::guard('webmember')->user()->id }}">
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
                                        <input type="hidden" value="{{ $cart->product->id }}" name="id_produk[]"
                                            class="id_produk">
                                        <input type="hidden" value="{{ $cart->jumlah }}" name="jumlah[]" class="jumalh">
                                        <input type="hidden" value="{{ $cart->ukuran }}" name="ukuran[]" class="ukuran">
                                        <input type="hidden" value="{{ $cart->warna }}" name="warna[]" class="warna">
                                        <input type="hidden" value="{{ $cart->total }}" name="total[]" class="total">
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
                            {{-- <div class="col-md-5 col-sm-12">
                                <div class="coupon">
                                    <input type="text" name="coupon_code" id="coupon_code"
                                        class="input-text form-control" value placeholder="Coupon code">
                                    <input type="submit" name="apply_coupon" class="btn btn-lg btn-stroke" value="Apply">
                                </div>
                            </div> --}}

                            <div class="col-md-7">
                                <div class="actions">
                                    <input type="submit" name="update_cart" value="Update Cart"
                                        class="btn btn-lg btn-stroke">
                                    <div class="wc-proceed-to-checkout">
                                        <a href="#" id="checkout" class="btn btn-lg btn-dark checkout disabled">
                                            <span>proceed to checkout</span>
                                        </a>
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
                        </p>
                        <p class="form-row form-row-wide">
                            <select name="kabupaten" id="kabupaten" class="kabupaten">
                            </select>
                        </p>
                        <p class="form-row form-row-wide">
                            <input type="text" class="input-text berat" value placeholder="example: 1000" name="berat"
                                id="berat">
                        </p>
                        <p>
                            <a href="#" name="calc_shipping"
                                class="btn btn-lg btn-stroke mt-10 mb-mdm-40 update-shipping"
                                style="padding: 20px 40px">Update Totals
                            </a>
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
                                            <span class="amount cart-subtotal">{{ $carts_subtotal }}</span>
                                        </td>
                                    </tr>
                                    <tr class="shipping">
                                        <th>Shipping</th>
                                        <td>
                                            <span class="shipping-cost">0</span>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Order Total</th>
                                        <td>
                                            <input type="hidden" name="grand_total" class="grand_total">
                                            <strong><span class="amount cart-grand-total">0</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div> <!-- end col cart totals -->
                </div> <!-- end row -->
            </form>
        </div> <!-- end container -->
    </section> <!-- end cart -->
@endsection

@push('js')
    <script>
        $(function() {
            $('.provinsi').change(function() {
                $id_province = $(this).val();
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

            $('.update-shipping').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/get_ongkir/' + $('.kabupaten').val() + '/' + $('.berat').val(),
                    success: function(data) {
                        data = JSON.parse(data)
                        grandTotal = parseInt(data.rajaongkir.results[0].costs[0].cost[0]
                            .value) + {{ $carts_subtotal }}

                        $('.shipping-cost').text(data.rajaongkir.results[0].costs[0].cost[0]
                            .value)
                        $('.cart-grand-total').text(grandTotal)
                        // add value at class cart-grand-total for submit data grand-total to checkout
                        $('.grand_total').val(grandTotal)
                        var element = document.getElementById("checkout");
                        element.classList.remove("disabled");
                    }
                });
            })

            $('.checkout').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/checkout_orders',
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    data: $('.form-cart').serialize(),
                    success: function() {
                        location.href = '/checkout'
                    }
                });
            });
        });
    </script>
@endpush
