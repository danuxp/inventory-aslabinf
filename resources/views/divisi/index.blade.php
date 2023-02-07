@extends('layout.main')

@section('content')

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
                <form action="/edit-divisi" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Divisi</label>
                        <input class="form-control" type="text" name="edit_divisi" id="edit_divisi" required>
                    </div>

                    <input type="hidden" name="id" id="id_divisi">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="edit_btn">Simpan</button>
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
                <form action="/hapus-divisi" method="post">
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


<div class="pd-20 card-box mb-30">
    <form action="/tambah-divisi" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Divisi</label>
            <input class="form-control @error('divisi') form-control-danger @enderror" type="text"
                placeholder="Masukkan Nama Divisi" name="divisi" required>

            @error('divisi')
            <div class="form-control-feedback has-danger">{{ $message }}</div>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>


<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Tabel Divisi</h4>
        @error('edit-divisi')
        <div class="alert alert-danger alert-dismissible fade show alert-notif" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @enderror

    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">#</th>
                    <th>Kode Divisi</th>
                    <th>Nama Divisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($divisi as $row)
                <tr>
                    <td class="table-plus">{{ $loop->iteration }}</td>
                    <td>{{ $row->kd_divisi }}</td>
                    <td>{{ $row->nama_divisi }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-edit" id="{{ $row->id_divisi }}"
                            data-toggle="toggle" title="Edit" data-placement="bottom"><i class="icon-copy fa fa-edit"
                                aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-toggle="toggle" title="Hapus"
                            id="{{ $row->id_divisi }}"><i class=" icon-copy fa fa-trash" aria-hidden="true"
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
            url: "/getIdDivisi",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'

            },
            success: function(res) {
                console.log(res);
                $('#edit_divisi').val(res.data['nama_divisi']);
                $('#id_divisi').val(res.data['id_divisi']);

                $('#edit-modal').modal('show');

            }
        })

    });

    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            method: "POST",
            url: "/getIdDivisi",
            data:{
                id: id,
                _token: '{{ csrf_token() }}'
            }
            ,
            success: function(res) {
                $('#id_hapus').val(res.data['id_divisi']);
                $('#hapus-modal').modal('show');
            },   
        })
    })

</script>
@endsection