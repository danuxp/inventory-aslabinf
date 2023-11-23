@extends('layout.main')

@section('content')

{{-- modal tambah data --}}
<div class="modal fade bs-example-modal-md" id="modal-tambah" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="/tambah-kode" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Pilih Asisten</label>
                        <select class="custom-select2 form-control" name="bio_id" style="width: 100%; height: 38px;"
                            required>
                            @foreach ($biodata as $bio)
                            <option value="{{ $bio->id_bio }}">{{ $bio->nim . ' - ' . $bio->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kode Asisten</label>
                        <input class="form-control" type="text" placeholder="Masukkan Kode Asisten" name="kode_asisten"
                            required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- edit modal --}}
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Pemberitahun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="/edit-kode" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nama Asisten</label>
                        <input class="form-control" type="text" name="nama_asisten" id="nama_asisten" disabled required>
                    </div>

                    <div class="form-group">
                        <label>Kode Asisten</label>
                        <input class="form-control" type="text" name="edit_kode" id="edit_kode" required>
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
                <button type="submit" class="btn btn-danger">Ya</button>
            </div>
            </form>
        </div>
    </div>
</div>

<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-tambah"><i
        class="fa fa-plus"></i> Tambah Data</button>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Tabel Kode Asisten</h4>
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-notif" role="alert">
            <ol type="1">
                @foreach ($errors->all() as $error)
                <li>
                    <strong>{{ $error }}</strong>
                </li>
                @endforeach
            </ol>
            <strong></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">#</th>
                    <th>Kode Asisten</th>
                    <th>Nim</th>
                    <th>Nama</th>
                    <th>No Wa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)

                <tr>
                    <td class="table-plus">{{ $loop->iteration }}</td>
                    <td>{{ $row->kd_asisten }}</td>
                    <td>{{ $row->nim }}</td>
                    <td>{{ $row->nama_lengkap }}</td>
                    <td>{{ $row->no_wa }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-edit" id="{{ $row->id }}"
                            data-toggle="toggle" title="Edit" data-placement="bottom"><i class="icon-copy fa fa-edit"
                                aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-toggle="toggle" title="Hapus"
                            id="{{ $row->id }}"><i class=" icon-copy fa fa-trash" aria-hidden="true"
                                data-toggle="tooltip" title="Hapus" data-placement="bottom"></i></button>
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
    $('.btn-edit').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            method: "POST",
            url: "/getIdKode",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'

            },
            success: function(res) {
                $('#nama_asisten').val(res.data.nama_lengkap);
                $('#edit_kode').val(res.data.kd_asisten);
                $('#id_kode').val(res.data.id);

                $('#edit-modal').modal('show');
            }
        })
    });

    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $('#id_hapus').val(id);
        $('#hapus-modal').modal('show');
    })
</script>
@endsection