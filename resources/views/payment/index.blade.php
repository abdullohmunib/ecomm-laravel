@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Pembayaran
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover-table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Order</th>
                            <th>Jumlah</th>
                            <th>Nomor Rekening</th>
                            <th>Atas Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center"></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal add data --}}
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-pembayaran">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="text" class="form-control" name="jumlah" placeholder="jumlah"
                                        id="jumlah" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="no_rekening">Nomor Rekening</label>
                                    <input type="text" class="form-control" name="no_rekening" placeholder="no_rekening"
                                        id="no_rekening" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="atas_nama">Atas Nama</label>
                                    <input type="text" class="form-control" name="atas_nama" placeholder="atas_nama"
                                        id="atas_nama" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" selected>SELECT STATUS</option>
                                        <option value="DITERIMA">DITERIMA</option>
                                        <option value="DITOLAK">DITOLAK</option>
                                        <option value="MENUNGGU">MENUNGGU</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
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

                // read
                $.ajax({
                    url: 'api/payments',
                    success: function({
                        data
                    }) {
                        let row;
                        data.map(function(val, index) {
                            row += `
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${date(val.created_at)}</td>
                                    <td>${val.order.id}</td>
                                    <td>${rupiah(val.jumlah)}</td>
                                    <td>${val.no_rekening}</td>
                                    <td>${val.atas_nama}</td>
                                    <td><strong>${val.status}</strong></td>
                                    <td>
                                        <a data-toggle="modal" class="btn btn-warning modal-ubah" href="#modal-form" data-id="${val.id}">Edit</a>
                                    </td>
                                </tr>
                            `;
                        });
                        $('tbody').append(row);
                    }
                });

                // update
                $(document).on('click', '.modal-ubah', function() {
                    $('#modal-form').modal('show');
                    const id = $(this).data('id');
                    $.get('/api/payments/' + id, function({
                        data
                    }) {
                        $('input[name="tanggal"]').val(date(data.created_at));
                        $('input[name="jumlah"]').val(rupiah(data.jumlah));
                        $('input[name="no_rekening"]').val(data.no_rekening);
                        $('input[name="atas_nama"]').val(data.atas_nama);
                        $('select[name="status"]').val(data.status);

                    });
                    $('.form-pembayaran').submit(function(e) {
                        e.preventDefault();
                        const token = localStorage.getItem('token');
                        const frmdata = new FormData(this);
                        $.ajax({
                            url: `api/payments/${id}?_method=PUT`,
                            type: 'POST',
                            data: frmdata,
                            cache: false,
                            contentType: false,
                            processData: false,
                            headers: {
                                "Authorization": "Bearer" + token
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
            });
        </script>
    @endpush
@endsection
