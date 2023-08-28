@extends('layouts.home')
@section('title', 'Checkout')

@section('content')
    <!-- Checkout -->
    <section class="section-wrap checkout pb-70">
        <div class="container relative">
            <div class="row">

                <div class="ecommerce col-xs-12">

                    <form name="checkout" class="checkout ecommerce-checkout row" method="POST" action="/payments">
                        @csrf
                        <input type="hidden" name="id_order" id="id_order" value="{{ $orders->id }}">
                        <div class="col-md-8" id="customer_details">
                            <div>
                                <h2 class="heading uppercase bottom-line full-grey mb-30">billing address</h2>
                                <p class="form-row form-row-wide">
                                    <label for="billing_first_name">Provinsi
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <select name="provinsi" id="provinsi" class="provinsi input-text">
                                        <option value="">Select Provinsi</option>
                                        @foreach ($provinsi->rajaongkir->results as $prov)
                                            <option value="{{ $prov->province_id }}">{{ $prov->province }}</option>
                                        @endforeach
                                    </select>
                                </p>

                                <p class="form-row form-row-wide">
                                    <label for="billing_first_name">Kabupaten
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <select name="kabupaten" id="kabupaten" class="kabupaten">
                                    </select>
                                </p>

                                <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                    id="billing_first_name_field">
                                    <label for="billing_first_name">Detail Alamat
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <input type="text" class="input-text" placeholder value name="detail_alamat"
                                        id="billing_first_name">
                                </p>

                                <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                    id="billing_first_name_field">
                                    <label for="billing_first_name">Atas Nama
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <input type="text" class="input-text" placeholder value name="atas_nama"
                                        id="billing_first_name">
                                </p>

                                <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                    id="billing_first_name_field">
                                    <label for="billing_first_name">Nomor Rekening
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <input type="text" class="input-text" placeholder value name="no_rekening"
                                        id="billing_first_name">
                                </p>

                                <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                    id="billing_first_name_field">
                                    <label for="billing_first_name">Nominal Transfer
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <input type="text" class="input-text" placeholder name="jumlah"
                                        id="billing_first_name">
                                </p>
                                <div class="clear"></div>
                            </div>

                            <div class="clear"></div>

                        </div> <!-- end col -->

                        <!-- Your Order -->
                        <div class="col-md-4">
                            <div class="order-review-wrap ecommerce-checkout-review-order" id="order_review">
                                <h2 class="heading uppercase bottom-line full-grey">Your Order</h2>
                                <table class="table shop_table ecommerce-checkout-review-order-table">
                                    <tbody>
                                        <tr class="order-total">
                                            <th><strong>Order Total</strong></th>
                                            <td>
                                                <strong><span class="amount">Rp.
                                                        {{ number_format($orders->grand_total) }}</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="payment" class="ecommerce-checkout-payment">
                                    <h2 class="heading uppercase bottom-line full-grey">Payment Method</h2>
                                    <ul class="payment_methods methods">
                                        <li class="payment_method_bacs">
                                            <input id="payment_method_bacs" type="radio" class="input-radio"
                                                name="payment_method" value="bacs" checked="checked">
                                            <label for="payment_method_bacs">Direct Bank Transfer</label>
                                            <div class="payment_box payment_method_bacs">
                                                <p> Make your payment directly into our bank account. Please use your Order
                                                    ID as the payment reference. Your order wont be shipped until the funds
                                                    have cleared in our account.
                                                </p>
                                                <p>Atas Nama : {{ $about->atas_nama }}</p>
                                                <p>Nomor Rekening : {{ $about->no_rekening }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="form-row place-order">
                                        <input type="submit" name="ecommerce_checkout_place_order"
                                            class="btn btn-lg btn-dark" id="place_order" value="Place order">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end order review -->
                    </form>

                </div> <!-- end ecommerce -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </section> <!-- end checkout -->
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

        });
    </script>
@endpush
