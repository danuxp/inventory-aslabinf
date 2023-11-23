@extends('layout.main')

@section('content')

<style>
    #cke_24 {
        display: none;
    }

    #cke_26 {
        display: none;
    }

    #cke_33 {
        display: none;
    }

    #cke_46 {
        display: none;
    }
</style>


{{-- hapus modal --}}
<div class="modal fade" id="hapus-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Peringatan!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/lap-rapat-hapus') }}" method="post">
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
    <h4 class="h4 text-blue">Form Laporan</h4>
    <form action="/tambah-lap-rapat" method="post">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="form-row">
            <div class="col-6">
                <label>Tanggal Rapat</label>
                <input class="form-control tanggal" type="date" name="tanggal" id="tanggal" required>
                @error('tanggal')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label>Jenis Rapat</label>
                <select class="custom-select col-12" name="jenis_rapat" id="jenis_rapat" required>
                    <option selected="selected" disabled>Pilih...</option>
                    <option value="RM" {{ old('jenis_rapat')=="RM" ? 'selected' : '' }}>Rapat Mingguan</option>
                    <option value="RB" {{ old('jenis_rapat')=="RB" ? 'selected' : '' }}>Rapat Bulanan</option>
                    <option value="RI" {{ old('jenis_rapat')=="RI" ? 'selected' : '' }}>Rapat Incidental
                        (bersifat
                        mendadak)</option>
                </select>
                @error('jenis_rapat')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group tempat mt-4">      
        </div>

        <div class="form-group mt-4">
            <div class="html-editor">
                <label>Catatan Rapat</label>
                {{-- <textarea class="form-control border-radius-0 textarea_editor" placeholder="Enter text ..."
                    name="catatan" required></textarea> --}}
                <textarea name="catatan" id="editor1"></textarea>
                @error('catatan')
                <div class="form-control-feedback has-danger">{{ $message }}</div>
                @enderror

            </div>
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg">Simpan</button>
        </div>
    </form>

    <div class="tes"></div>
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
                    <th>Author</th>
                    <th>Catatan Rapat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ tanggal_indo($row->tanggal) }}</td>
                    <td>{{ jenis_rapat($row->jenis) }}</td>
                    <td>{{ $row->author }}</td>
                    <td><a href="{{ url('lap-rapat-cetak/' . Crypt::encryptString($row->id) ) }}" class="btn btn-sm btn-warning"
                            data-toggle="toggle" title="Lihat" data-placement="bottom" target="blank"><i class="icon-copy fa fa-file-pdf-o"
                               ></i></a></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-edit" id="{{ $row->id }}"
                            data-toggle="toggle" title="Edit" data-placement="bottom"><i class="icon-copy fa fa-edit"
                                aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-sm btn-danger btn-hapus" data-toggle="toggle" title="Hapus"
                            id="{{ $row->id }}"><i class=" icon-copy fa fa-trash" aria-hidden="true" data-toggle="tooltip"
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
    var editor = CKEDITOR.replace('editor1');


    $('.tanggal').DateTimePicker({
        time: false,
        clearButton: true,
        lang: 'id',
        format: 'YYYY-MM-DD'
    });


    $('.btn-edit').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
            method: "POST",
            url: "/getIdLapRapat",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'

            },
            success: function(res) {
                console.log(htmlspecialchars(res.data['catatan']));
                editor.setData(res.data.catatan);
                $('#tanggal').val(res.data.tanggal);
                $('#jenis_rapat').val(res.data.jenis).change();
                $('#tempat').val(res.data.tempat);
                $('#id').val(res.data.id);
        // $('textarea[name="catatan"]').text(res.catatan);

                // $.each(res, function(key, data) {
                //     console.log(data['catatan']);
                //     $('.edit-catatan').val(data['catatan']);
                //     // $('#edit_kode').val(data['kd_asisten']);
                //     // $('#id_kode').val(data['id']);
                // });

                // $('#edit-modal').modal('show');

            }
        })

    });

    $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $('#id_hapus').val(id);
        $('#hapus-modal').modal('show');

    })

    $('#jenis_rapat').on('change', function(e) {
        let jenis_rapat = $(this).val();
        tempat(jenis_rapat);
    })

    let jenis_rapat = $('#jenis_rapat').val();
    tempat(jenis_rapat);

    function tempat(jenis_rapat) {
        let tempat = '';
        if(jenis_rapat == "RB") {
            tempat += '<label>Tempat</label> <input type="text" name="tempat" class="form-control" placeholder="Rumah" id="tempat">';
        }
        $('.tempat').html(tempat);
    }

   
</script>
@endsection