@extends('layouts.app')
@section('title', 'Data Barang')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Data Barang
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
                            <th>Nama Barang</th>
                            <th>Nama Kategori</th>
                            <th>Nama Subkategori</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Bahan</th>
                            <th>Tags</th>
                            <th>SKU</th>
                            <th>Ukuran</th>
                            <th>Warna</th>
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
                    <h5 class="modal-title">Form Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-barang">
                                @csrf
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang" id="nama_barang"
                                        placeholder="nama barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="id_kategori">Nama Kategori</label>
                                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                                        <option value="" selected>select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_subkategori">Nama Subkategori</label>
                                    <select name="id_subkategori" id="id_subkategori" class="form-control" required>
                                        <option value="" selected>select category</option>
                                        @foreach ($subcategories as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->nama_subkategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control" placeholder="deskripsi"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" name="harga" id="harga"
                                        placeholder="harga" required>
                                </div>
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <input type="number" class="form-control" name="diskon" id="diskon"
                                        placeholder="diskon" required>
                                </div>
                                <div class="form-group">
                                    <label for="bahan">Bahan</label>
                                    <input type="text" class="form-control" name="bahan" id="bahan"
                                        placeholder="bahan" required>
                                </div>
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" class="form-control" name="tags" id="tags"
                                        placeholder="tags" required>
                                </div>
                                <div class="form-group">
                                    <label for="SKU">SKU</label>
                                    <input type="text" class="form-control" name="sku" id="SKU"
                                        placeholder="SKU" required>
                                </div>
                                <div class="form-group">
                                    <label for="ukuran">ukuran</label>
                                    <input type="text" class="form-control" name="ukuran" id="ukuran"
                                        placeholder="ukuran" required>
                                </div>
                                <div class="form-group">
                                    <label for="warna">warna</label>
                                    <input type="text" class="form-control" name="warna" id="warna"
                                        placeholder="warna" required>
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
                    url: 'api/products',
                    success: function({
                        data
                    }) {
                        let row;
                        data.map(function(val, index) {
                            row += `
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${val.nama_barang}</td>
                                    <td>${val.category.nama_kategori}</td>
                                    <td>${val.subcategory.nama_subkategori}</td>
                                    <td>${val.deskripsi}</td>
                                    <td>${val.harga}</td>
                                    <td>${val.diskon}</td>
                                    <td>${val.bahan}</td>
                                    <td>${val.tags}</td>
                                    <td>${val.sku}</td>
                                    <td>${val.ukuran}</td>
                                    <td>${val.warna}</td>
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
                            url: '/api/products/' + id,
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
                    $('input[name="nama_barang"]').val('');
                    $('select[name="id_kategori"]').val('');
                    $('select[name="id_subkategori"]').val('');
                    $('textarea[name="deskripsi"]').val('');
                    $('input[name="harga"]').val('');
                    $('input[name="diskon"]').val('');
                    $('input[name="bahan"]').val('');
                    $('input[name="tags"]').val('');
                    $('input[name="sku"]').val('');
                    $('input[name="ukuran"]').val('');
                    $('input[name="warna"]').val('');
                    $('input[name="gambar"]').val('');
                    $('.form-barang').submit(function(e) {
                        e.preventDefault();
                        const token = localStorage.getItem('token');
                        const frmdata = new FormData(this);
                        $.ajax({
                            url: 'api/products',
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
                    $.get('/api/products/' + id, function({
                        data
                    }) {
                        $('input[name="nama_barang"]').val(data.nama_barang);
                        $('select[name="id_kategori"]').val(data.id_kategori);
                        $('select[name="id_subkategori"]').val(data.id_subkategori);
                        $('textarea[name="deskripsi"]').val(data.deskripsi);
                        $('input[name="harga"]').val(data.harga);
                        $('input[name="diskon"]').val(data.diskon);
                        $('input[name="bahan"]').val(data.bahan);
                        $('input[name="tags"]').val(data.tags);
                        $('input[name="sku"]').val(data.sku);
                        $('input[name="ukuran"]').val(data.ukuran);
                        $('input[name="warna"]').val(data.warna);
                        $('input[name="gambar"]').val(data.gambar);
                    });
                    $('.form-barang').submit(function(e) {
                        e.preventDefault();
                        const token = localStorage.getItem('token');
                        const frmdata = new FormData(this);
                        $.ajax({
                            url: `api/products/${id}?_method=PUT`,
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
