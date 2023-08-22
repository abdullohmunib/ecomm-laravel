@extends('layouts.app')
@section('title', 'Laporan Pesanan')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Laporan Pesanan
            </h4>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <form action="">
                        <div class="form-group">
                            <label for="dari">Dari</label>
                            <input type="date" class="form-control" id="dari" name="dari" required
                                value="{{ request()->input('dari') }}">
                        </div>
                        <div class="form-group">
                            <label for="sampai">Sampai</label>
                            <input type="date" class="form-control" id="sampai" name="sampai" required
                                value="{{ request()->input('sampai') }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            @if (request()->input('dari'))
                <div class="table-responsive">
                    <table class="table table-bordered table-hover-table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Dibeli</th>
                                <th>Harga</th>
                                <th>Total Qty</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="text-center"></tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @push('js')
        <script>
            $(function() {
                const token = localStorage.getItem('token');
                const dari = '{{ request()->input('dari') }}'
                const sampai = '{{ request()->input('sampai') }}'

                function rupiah(angka) {
                    let rupiahFormat = new Intl.NumberFormat('id-ID', {
                        style: "currency",
                        currency: "IDR"
                    }).format(angka);
                    return rupiahFormat;
                }
                // read
                $.ajax({
                    url: `/api/reports?dari=${dari}&sampai=${sampai}`,
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
                                    <td>${val.nama_barang}</td>
                                    <td>${val.jumlah_dibeli}</td>
                                    <td>${rupiah(val.harga)}</td>
                                    <td>${val.total_qty}</td>
                                    <td>${rupiah(val.pendapatan)}</td>
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
