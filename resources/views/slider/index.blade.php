@extends('layouts.app')
@section('title', 'Data slider')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Data Slider
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
                            <th>Nama Slider</th>
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
                    <h5 class="modal-title">Form Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-slider">
                                <div class="form-group">
                                    <label for="nama_slider">Nama Slider</label>
                                    <input type="text" class="form-control" name="nama_slider" id="nama_slider"
                                        placeholder="nama Slider" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
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
                // read
                $.ajax({
                    url: 'api/sliders',
                    success: function({
                        data
                    }) {
                        let row;
                        data.map(function(val, index) {
                            row += `
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${val.nama_slider}</td>
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

                // destroy
                $(document).on('click', '.btn-hapus', function() {
                    const id = $(this).data('id');
                    const token = localStorage.getItem('token');
                    confirm_dialog = confirm('Apakah anda yakin?');
                    if (confirm_dialog) {
                        $.ajax({
                            url: '/api/sliders/' + id,
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

                // create/store/add
                $('.modal-tambah').click(function() {
                    $('#modal-form').modal('show');
                    $('input[name="nama_slider"]').val('');
                    $('textarea[name="deskripsi"]').val('');
                    $('.form-slider').submit(function(e) {
                        e.preventDefault();
                        const token = localStorage.getItem('token');
                        const frmdata = new FormData(this);
                        $.ajax({
                            url: 'api/sliders',
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

                // update
                $(document).on('click', '.modal-ubah', function() {
                    $('#modal-form').modal('show');
                    const id = $(this).data('id');
                    $.get('/api/sliders/' + id, function({
                        data
                    }) {
                        $('input[name="nama_slider"]').val(data.nama_slider);
                        $('textarea[name="deskripsi"]').val(data.deskripsi);
                    });
                    $('.form-slider').submit(function(e) {
                        e.preventDefault();
                        const token = localStorage.getItem('token');
                        const frmdata = new FormData(this);
                        $.ajax({
                            url: `api/sliders/${id}?_method=PUT`,
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
