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
                <form action="/hapus-pj-lab" method="post">
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

{{-- nonaktif modal --}}
<div class="modal fade" id="nonaktif-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Peringatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="/nonaktif-pj-lab" method="post">
                    @csrf
                    <p>Apakah anda yakin ingin menonaktifkan pj lab ?</p>
                    <input type="hidden" name="id" id="id_nonaktif">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-warning">Ya</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <h4 class="h4 text-blue">Form Pj Lab</h4>

    <form action="{{ url('/pj-lab') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="id">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Pilih Asisten</label>
                    <select class="custom-select2 form-control" multiple="multiple" name="bio_id[]"
                        style="width: 100%; height: 38px;" id="bio_id" required>
                        @foreach ($asisten as $row)
                        <option value="{{ $row->id_bio }}">{{ $row->nim . ' - ' . $row->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Pilih Laboratorium</label>
                    <select class="custom-select2 form-control @error('namalab') form-control-danger @enderror" name="namalab" id="namalab" style="width: 100%; height: 38px;"
                        required>
                        <option value="" selected disabled>Pilih</option>
                        @foreach ($nama_lab as $row)
                        <option value="{{ $row->id }}">{{ $row->nama }}</option>
                        @endforeach
                    </select>
        
                    @error('namalab')
                    <div class="form-control-feedback has-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" id="btn-form"></button>
    </form>
</div>


<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Tabel Kode Asisten</h4>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">#</th>
                    <th>Nama Lab</th>
                    <th>Nama Asisten</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $key => $item)    
                <tr>
                    <td class="table-plus">{{ $loop->iteration }}</td>
                    <td>{{ $item['nama_lab'] }}</td>
                    <td>
                        <ul>
                        @foreach ($item['asisten'] as $row)
                                <li>{{ $row['nim'] .' - ' . $row['nama'] }}</li>
                                @endforeach
                            </ul>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-edit" id="{{ $key }}" data-toggle="toggle"
                            title="Edit" data-placement="bottom"><i class="icon-copy fa fa-edit"
                                aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-toggle="toggle" title="Hapus"
                            id="{{ $key }}"><i class=" icon-copy fa fa-trash" aria-hidden="true" data-toggle="tooltip"
                                title="Hapus" data-placement="bottom"></i></button>

                        <button type="button" class="btn btn-sm btn-warning btn-nonaktif" data-toggle="toggle" title="Nonaktif"
                            id="{{ $key }}"><i class=" icon-copy fa fa-warning" aria-hidden="true" data-toggle="tooltip"
                                title="Nonaktif" data-placement="bottom"></i></button>
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
    $('#btn-form').text('Simpan');
    $('.btn-edit').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            method: "POST",
            url: "/getIdPjLab",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'

            },
            success: function(res) {
                let bio_id = JSON.parse(res.bio_id);
                $('#bio_id').val(bio_id).change();
                $('#namalab').val(res.lab_id).change();
                $('#id').val(res.id);
                $('#btn-form').text('Edit');

            }
        })
    });

    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $('#id_hapus').val(id);
        $('#hapus-modal').modal('show');
    })

    $('.btn-nonaktif').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $('#id_nonaktif').val(id);
        $('#nonaktif-modal').modal('show');
    })
</script>
@endsection