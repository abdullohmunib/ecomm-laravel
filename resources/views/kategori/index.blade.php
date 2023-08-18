@extends('layouts.app')
@section('title', 'Data Kategori')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Data Kategori
            </h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end align-items-end mb-4">
                <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover-table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
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
                    <h5 class="modal-title">Form Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-kategori">
                                <div class="form-group">
                                    <label for="nama_kategori">Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama_kategori" id="nama_kategori"
                                        placeholder="nama kategori" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Nama Kategori</label>
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control" placeholder="deskripsi"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" class="form-control" name="gambar" placeholder="gambar"
                                        id="gambar" required>
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
                $.ajax({
                    url: 'api/categories',
                    success: function({
                        data
                    }) {
                        let row;
                        data.map(function(val, index) {
                            row += `
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${val.nama_kategori}</td>
                                    <td>${val.deskripsi}</td>
                                    <td>
                                        <img src="/uploads/${val.gambar}" width="150">
                                    </td>
                                    <td>
                                        <a data-toggle="modal" class="btn btn-warning modal-ubah" href="#modal-form" data-id="${val.id}">Edit</a>
                                        <a class="btn btn-danger btn-hapus" href="#" data-id="${val.id}">Hapus</a>
                                    </td>
                                </tr>
                            `;
                        });
                        $('tbody').append(row);
                    }
                });

                $(document).on('click', '.btn-hapus', function() {
                    const id = $(this).data('id');
                    const token = localStorage.getItem('token');

                    confirm_dialog = confirm('Apakah anda yakin?');

                    if (confirm_dialog) {
                        $.ajax({
                            url: '/api/categories/' + id,
                            type: 'DELETE',
                            headers: {
                                "Authorization": "Bearer" + token
                            },
                            success: function(data) {
                                if (data.success) {
                                    alert('Item berhasil dihapus!');
                                    location.reload();
                                }
                            }
                        });
                    }
                });

                $('.modal-tambah').click(function() {
                    $('#modal-form').modal('show');

                    $('.form-kategori').submit(function(e) {
                        e.preventDefault();
                        const token = localStorage.getItem('token');
                        const frmdata = new FormData(this);

                        $.ajax({
                            url: 'api/categories',
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
                                    alert('Item berhasil ditambah!');
                                    location.reload();
                                }
                            }
                        })
                    })
                });

                $(document).on('click', '.modal-ubah', function() {
                    $('#modal-form').modal('show');
                });
            });
        </script>
    @endpush


@endsection
