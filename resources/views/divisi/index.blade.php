@extends('layout.main')

@section('content')
    <div class="pd-20 card-box mb-30">
        <h4 class="h4 text-blue">Form Divisi</h4>

        <form action="{{ url('/tambah-divisi') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">

            <div class="form-group">
                <label>Nama Divisi</label>
                <input class="form-control @error('divisi') form-control-danger @enderror" type="text"
                    placeholder="Masukkan Nama Divisi" name="divisi" id="divisi" required>

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
                                    data-toggle="toggle" title="Edit" data-placement="bottom"><i
                                        class="icon-copy fa fa-edit" aria-hidden="true"></i></button>

                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-toggle="toggle"
                                    title="Hapus" id="{{ $row->id_divisi }}"><i class=" icon-copy fa fa-trash"
                                        aria-hidden="true" data-toggle="tooltip" title="Hapus"
                                        data-placement="bottom"></i></button>
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
                    $('#divisi').val(res.data.nama_divisi);
                    $('#id').val(res.data.id_divisi);
                }
            })

        });

        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');

            Swal.fire({
                icon: 'warning',
                title: 'Apakah kamu yakin ingin menghapus data?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/hapus-divisi',
                        data: {
                            id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire({
                                title: res.title,
                                text: res.text,
                                icon: res.icon
                            }).then((result) => {
                                window.location = '/divisi';
                            });
                        }
                    });
                }
            });

        })
    </script>
@endsection
