@extends('layouts.app')
@section('title', 'Data Pesanan Baru')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Data Pesanan Baru
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
                            <th>Aksi</th>
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
                    url: '/api/pesanan/baru',
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
                                    <td>
                                        <a class="btn btn-success btn-aksi" href="#" data-id="${val.id}">Konfirmasi</a>
                                    </td>
                                </tr>
                            `;
                        });
                        $('tbody').append(row);
                    }
                });

                // button aksi
                $(document).on('click', '.btn-aksi', function(e) {
                    e.preventDefault();
                    const id = $(this).data('id');
                    $.ajax({
                        url: '/api/pesanan/ubah_status/' + id,
                        type: 'POST',
                        data: {
                            status: 'Dikonfirmasi',
                        },
                        headers: {
                            "Authorization": "Bearer" + token,
                        },
                        success: function(data) {
                            if (data.success) {
                                alert('Item berhasil diubah!');
                                location.reload();
                            }
                        }
                    })
                })
            });
        </script>
    @endpush
@endsection
