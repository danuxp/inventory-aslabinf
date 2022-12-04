@extends('layout.main')

@section('content')
<div class="pd-20 card-box mb-30">
    <form action="{{ route('angkatan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Angkatan</label>
            <input class="form-control @error('angkatan') form-control-danger @enderror" type="text"
                placeholder="Masukkan Angkatan Ke" name="angkatan">

            @error('angkatan')
            <div class="form-control-feedback has-danger">{{ $message }}</div>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>


<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Tabel Angkatan</h4>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">#</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($angkatan as $row)
                <tr>
                    <td class="table-plus">{{ $loop->iteration }}</td>
                    <td>Angkatan {{ $row->angkatan_ke }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                            data-target="#edit-modal{{ $row->id_angkatan }}"><i class="icon-copy fa fa-edit"
                                aria-hidden="true" data-toggle="toggle" title="Edit"
                                data-placement="bottom"></i></button>

                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                            data-target="#hapus-modal{{ $row->id_angkatan }}"><i class=" icon-copy fa fa-trash"
                                aria-hidden="true" data-toggle="tooltip" title="Hapus"
                                data-placement="bottom"></i></button>
                    </td>
                </tr>


                {{-- edit modal --}}
                <div class="modal fade edit-modal" id="edit-modal{{ $row->id_angkatan }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Pemberitahun</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('angkatan.update', $row->id_angkatan) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Angkatan</label>
                                        <input
                                            class="form-control @error('edit-angkatan') form-control-danger @enderror"
                                            type="text" value="{{ $row->angkatan_ke }}" name="edit-angkatan"
                                            id="angkatan" required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id="btn-edit-angkatan" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- delete modal --}}
                <div class="modal fade" id="hapus-modal{{ $row->id_angkatan }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Peringatan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('angkatan.destroy', $row->id_angkatan) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <p>Apakah anda yakin ingin menghapus ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                <button type="submit" class="btn btn-primary">Ya</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

            </tbody>
        </table>
    </div>
</div>


<script>
    $( document ).ready(function() {
        @if (count($errors) > 0)
        $('.edit-modal').modal('show');
      @endif
    });
</script>

@endsection