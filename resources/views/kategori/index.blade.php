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
                <a href="/kategori/create" class="btn btn-primary">Tambah</a>
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
                                        <a data-toggle="modal" class="btn btn-warning" href="#modal-form" data-id="${val.id}">Edit</a>
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
                                "Authorization": token
                            },
                            success: function(data) {
                                if (data.message == 'success') {
                                    alert('Item berhasil dihapus!');
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush


@endsection
