@extends('layouts.app')
@section('title', 'Data Pesanan Dikonfirmasi')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Data Pesanan Dikonfirmasi
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
                    const date = new Date(tanggal);
                    const day = date.getDate();
                    const month = date.getMonth();
                    const year = date.getYear();
                    return `${day}-${month}-${year}`
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
                    url: '/api/pesanan/dikonfirmasi',
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
                                        <a class="btn btn-success btn-aksi" href="#" data-id="${val.id}">Dikemas</a>
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
                            status: 'Dikemas',
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
