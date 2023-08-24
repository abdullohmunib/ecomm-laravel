@extends('layouts.app')
@section('title', 'Tentang')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Tentang Tentang
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-tentang">
                        @csrf
                        <div class="form-group">
                            <label for="judul_website">Judul Website</label>
                            <input type="text" class="form-control" name="judul_website" id="judul_website"
                                placeholder="nama tentang" required value="{{ $about->judul_website }}">
                        </div>
                        <img src="/uploads/{{ $about->logo }}" alt="" width="200">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" name="logo" placeholder="logo" id="logo">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control" placeholder="deskripsi">{{ $about->deskripsi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" placeholder="alamat"
                                required>{{ $about->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="email" class="form-control" name="email" placeholder="email" id="email"
                                required value="{{ $about->email }}">
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control" name="telepon" placeholder="telepon" id="telepon"
                                required value="{{ $about->telepon }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(function() {
                // create/store/add
                $('.form-tentang').submit(function(e) {
                    e.preventDefault();
                    const token = localStorage.getItem('token');
                    const frmdata = new FormData(this);
                    $.ajax({
                        url: `/tentang/` + {{ $about->id }},
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
                                alert('Item berhasil Diubah!');
                                location.reload();
                            }
                        }
                    })
                })
            });
        </script>
    @endpush

@endsection
