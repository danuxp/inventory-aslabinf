@extends('layout.main')

@section('content')

<style>
    [data-wysihtml5-command="createLink"] {
        display: none;
    }

    [data-wysihtml5-action="change_view"] {
        display: none;
    }

    [data-wysihtml5-command="insertImage"] {
        display: none;
    }
</style>

{{-- edit modal --}}
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="/edit-kode" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col-6">
                            <label>Tanggal Rapat</label>
                            <input class="form-control" placeholder="Masukkan Tanggal" type="date" name="tanggal">
                        </div>

                        <div class="col-6">
                            <label>Jenis Rapat</label>
                            <select class="custom-select col-12" name="jenis">
                                <option selected="selected" disabled>Pilih...</option>
                                <option>Rapat Mingguan</option>
                                <option>Rapat Bulanan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="html-editor">
                            <label>Catatan Rapat</label>
                            <textarea class="form-control border-radius-0 edit_textarea_editor"
                                placeholder="Enter text ..." name="catatan"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="id" id="id_kode">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="edit_btn">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- hapus modal --}}
<div class="modal fade" id="hapus-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Peringatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="/hapus-kode" method="post">
                    @csrf
                    <p>Apakah anda yakin ingin menghapus ?</p>
                    <input type="hidden" name="id" id="id_hapus">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-primary">Ya</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- view catatan modal --}}
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Peringatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p class="view-catatan"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-primary">Ya</button>
            </div>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <h4 class="h4 text-blue">Form Tambah Laporan</h4>
    <form action="/tambah-lap-rapat" method="post">
        @csrf
        <div class="form-row">
            <div class="col-6">
                <label>Tanggal Rapat</label>
                <input class="form-control" placeholder="Masukkan Tanggal" type="date" name="tanggal" required>
                @error('tanggal')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label>Jenis Rapat</label>
                <select class="custom-select col-12" name="jenis" required>
                    <option selected="selected" disabled>Pilih...</option>
                    <option>Rapat Mingguan</option>
                    <option>Rapat Bulanan</option>
                </select>
                @error('jenis')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group mt-4">
            <div class="html-editor">
                <label>Catatan Rapat</label>
                <textarea class="form-control border-radius-0 textarea_editor" placeholder="Enter text ..."
                    name="catatan" required></textarea>
                @error('catatan')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg">Simpan</button>
        </div>
    </form>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Tabel Laporan Rapat</h4>
    </div>

    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">#</th>
                    <th>Tanggal</th>
                    <th>Jenis Rapat</th>
                    <th>Catatan Rapat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->jenis }}</td>
                    <td><button type="button" class="btn btn-sm btn-warning btn-view" id="{{ $row->id }}"
                            data-toggle="toggle" title="Lihat" data-placement="bottom"><i class="icon-copy fa fa-eye"
                                aria-hidden="true"></i></button></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-edit" id="" data-toggle="toggle"
                            title="Edit" data-placement="bottom"><i class="icon-copy fa fa-edit"
                                aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-toggle="toggle" title="Hapus"
                            id=""><i class=" icon-copy fa fa-trash" aria-hidden="true" data-toggle="tooltip"
                                title="Hapus" data-placement="bottom"></i></button>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
<script>
    $('.edit_textarea_editor').wysihtml5();

    $('.btn-view').on('click', function(e){
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            method: "POST",
            url: "/getIdLapRapat",
            data: {
                id:id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                $('.view-catatan').html(htmlspecialchars_decode(res.data['catatan']));
                $('#view-modal').modal('show');
            }
        })
    })

    $('.btn-edit').on('click', function(e) {
        e.preventDefault();
        // let id = $(this).attr('id');
        // $.ajax({
        //     method: "POST",
        //     url: "/getIdKode",
        //     data: {
        //         id: id,
        //         _token: '{{ csrf_token() }}'

        //     },
        //     success: function(res) {
        //         $.each(res.data, function(key, data) {
        //             $('#nama_asisten').val(data['nama_lengkap']);
        //             $('#edit_kode').val(data['kd_asisten']);
        //             $('#id_kode').val(data['id']);
        //         });

        //         $('#edit-modal').modal('show');

        //     }
        // })
        $('#edit-modal').modal('show');

    });

    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        // let id = $(this).attr('id');
        // $.ajax({
        //     method: "POST",
        //     url: "/getIdKode",
        //     data:{
        //         id: id,
        //         _token: '{{ csrf_token() }}'
        //     }
        //     ,
        //     success: function(res) {
        //         $.each(res.data, function(key, data) {
        //             $('#id_hapus').val(data['id']);
        //         })
        //         $('#hapus-modal').modal('show');
        //     },   
        // })
        $('#hapus-modal').modal('show');

    })
</script>
@endsection