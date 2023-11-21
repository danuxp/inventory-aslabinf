@extends('layout.main')

@section('content')

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
                <form action="/hapus-asisten" method="post">
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

<div class="pd-20 card-box mb-30">
    <h4 class="text-blue h4">Form Asisten</h4>
    <form action="/tambah-asisten" method="POST">
        @csrf
        <input class="form-control" type="hidden" name="id" id="id">

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Nim</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control @error('nim') form-control-danger @enderror" type="text"
                placeholder="Masukkan Nim" name="nim" id="nim">
                
                @error('nim')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Nama Lengkap</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control @error('namalengkap') form-control-danger @enderror" type="text"
                placeholder="Masukkan Nama Lengkap" name="namalengkap" id="namalengkap">
                
                @error('namalengkap')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Nama Cantik</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control @error('namacantik') form-control-danger @enderror" type="text"
                placeholder="Masukkan Nama Cantik" name="namacantik" id="namacantik">
                
                @error('namacantik')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Jenis Kelamin</label>
            <div class="jk col-md-10">
                <div class="custom-control custom-radio custom-control-inline pb-0">
                    <input type="radio" id="male" name="kelamin" value="L"
                        class="custom-control-input">
                    <label class="custom-control-label" for="male">Laki</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline pb-0">
                    <input type="radio" id="female" name="kelamin" value="P"
                        class="custom-control-input">
                    <label class="custom-control-label" for="female">Perempuan</label>
                </div>
                
                @error('kelamin')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Angkatan</label>
            <div class="col-sm-12 col-md-10">
                <select class="form-control selectpicker" title="Pilih Angkatan" name="angkatan" id="angkatan">
                    @foreach ($angkatan as $row)
                    <option value="{{ $row->angkatan_ke }}">{{ $row->angkatan_ke }}</option>
                    @endforeach
                </select>
                
                @error('angkatan')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        
    </form>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Tabel {{ $title }}</h4>
        @error('edit-divisi')
        <div class="alert alert-danger alert-dismissible fade show alert-notif" role="alert">
            <strong></strong>
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
                    <th class="table-plus datatable-nosort">No</th>
                    <th>Nim</th>
                    <th>Nama Lengkap</th>
                    <th>Nama Cantik</th>
                    <th>Jenis Kelamin</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    
                <tr>
                    <td class="table-plus"> {{ $loop->iteration }} </td>
                    <td> {{ $row->nim }} </td>
                    <td> {{ $row->nama_lengkap }} </td>
                    <td> {{ $row->nama_cantik }} </td>
                    <td> {{ $row->jenis_kelamin }} </td>
                    <td> {{ $row->angkatan }} </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-edit" id="{{ $row->id_bio }}"
                            data-toggle="toggle" title="Edit" data-placement="bottom"><i class="icon-copy fa fa-edit"></i></button>

                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-toggle="toggle" title="Hapus"
                            id="{{ $row->id_bio }}" data-toggle="tooltip" title="Hapus" data-placement="bottom"><i class="icon-copy fa fa-trash"></i></button>
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
            url: "/getIdBiodata",
            data:{
                id: id,
                _token: '{{ csrf_token() }}'
            }
            ,
            success: function(res) {
                console.log(res);
                $('#id').val(res.id_bio);
                $('#nim').val(res.nim).prop('readonly', true);
                $('#namalengkap').val(res.nama_lengkap);
                $('#namacantik').val(res.nama_cantik);
                $('input[name="kelamin"]').each(function() {
                if ($(this).val() === res.jenis_kelamin) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
                $('#angkatan').val(res.angkatan).change()
            });
                
               
            },   
        })
    })

    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $('#id_hapus').val(id);
        $('#hapus-modal').modal('show');
    })
</script>
@endsection

