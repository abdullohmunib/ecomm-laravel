@extends('layouts.home')
@section('title', 'Checkout')
@section('content')
    <section class="section-wrap checkout pb-70">
        <div class="container relative">
            <div class="row">
                <div class="ecommerce col-xs-12">

                    <h2>My Payment</h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nominal Transfer</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach ($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td>Rp. {{ number_format($payment->jumlah) }}</td>
                                    <td>{{ $payment->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h2>My Orders</h2>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>Rp. {{ number_format($order->grand_total) }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <form action="/pesanan_selesai/{{ $order->id }}" method="POST">
                                            @csrf
                                            <button type="sumbit" class="btn btn-success">Selesai</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
