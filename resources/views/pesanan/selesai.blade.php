@extends('layouts.app')
@section('title', 'Data Pesanan Selesai')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Data Pesanan Selesai
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover-table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pesanan</th>
                            <th>Invoice</th>
                            <th>Member</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(function() {

                function date(tanggal) {
                    let create = new Date(tanggal)
                    let form_dt = create.getFullYear() + "-" + (create.getMonth() + 1) + "-" + create.getDate() +
                        " " + create.getHours() + ":" + create.getMinutes() + ":" + create.getSeconds();
                    return form_dt;
                }

                function rupiah(angka) {
                    let rupiahFormat = new Intl.NumberFormat('id-ID', {
                        style: "currency",
                        currency: "IDR"
                    }).format(angka);
                    return rupiahFormat;
                }
                const token = localStorage.getItem('token');
                // read
                $.ajax({
                    url: '/api/pesanan/selesai',
                    headers: {
                        "Authorization": "Bearer" + token,
                    },
                    success: function({
                        data
                    }) {
                        let row;
                        data.map(function(val, index) {
                            row += `
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${date(val.created_at)}</td>
                                    <td>${val.invoice}</td>
                                    <td>${val.member.nama_member}</td>
                                    <td>${rupiah(val.grand_total)}</td>
                                    <td>${val.status}</td>
                                </tr>
                            `;
                        });
                        $('tbody').append(row);
                    }
                });
            });
        </script>
    @endpush
@endsection
