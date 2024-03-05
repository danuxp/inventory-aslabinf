@extends('layout.main')

@section('content')

{{-- Modal edit --}}
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Data Lab <span id="nmlab"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="/hapus-kode" method="post">
                    @csrf
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <p>
                            Klik disini jika ingin menambahkan data
                        </p>
                        <button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="toggle" title="Tambah" id="btn-plus-modal"><i class=" icon-copy fa fa-plus" aria-hidden="true"
                        data-toggle="tooltip" title="Tambah" data-placement="bottom"></i></button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Baik</th>
                                <th>Jumlah Rusak</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            
                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-danger">Ya</button>
            </div>
            </form>
        </div>
    </div>
</div>


{{-- hapus item modal --}}
<div class="modal fade" id="hapus-item-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Peringatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="/delete-item-lab" method="post">
                    @csrf
                    <p>Apakah anda yakin ingin menghapus <strong id="nm-item"></strong> ?</p>
                    <input type="hidden" name="id" id="id_hapus_item">
                    <input type="hidden" name="key" id="key_hapus_item">

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
    <h4 class="h4 text-blue">Form Inventory Lab</h4>

    <form action="{{ url('/inventory-lab') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="id">

        <label>Pilih Lab</label>
        <div class="input-group mb-3" id="form-input">
            <select class="custom-select2 form-control @error('namalab') form-control-danger @enderror" name="namalab" id="namalab"  required style="width: 90%;">
                <option value="" selected disabled>Pilih</option>
                @foreach ($nama_lab as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
              <button type="button" class="btn btn-primary" id="btn-plus"><i class="fa fa-plus"></i></button>
            </div>
        </div>


        <div id="tombol"></div>
    </form>
</div>


<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Inventory Lab</h4>
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
                    <th>Nama Lab</th>
                    <th>Data Inventory</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nama }}</td>
                        <td><button class="btn btn-primary btn-sm btn-view" id="{{ $row->id }}" data-nama="{{ $row->nama }}"> <i class="fa fa-archive"></i> View</button></td>
                        
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#btn-plus').on('click', function(){
        // e.preventDefault();
        let input = `
        <div class="row form-group input-remove" id="form-input">

        <div class="col-md-6">
            <label for="">Nama Barang</label>
            <input type="text" class="form-control" name="nama_barang[]">
        </div>
        <div class="col-md-2">
            <label for="">Jumlah Kondisi Baik</label>
            <input type="number" class="form-control" min="0" name="jml_baik[]">
        </div>
        <div class="col-md-2">
            <label for="">Jumlah Kondisi Rusak</label>
            <input type="number" class="form-control" min="0" name="jml_rusak[]">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger" id="btn-remove"><i class="fa fa-close"></i></button>
        </div>
    </div>

        `;
        $('#form-input').after(input);
        $('#tombol').html('<button type="submit" class="btn btn-primary">Simpan</button>');
    })

    $('body').on('click', '#btn-remove', function() {
        $(this).parents('#form-input').remove();
        let jml_input = $('.input-remove').length;
        if(jml_input == 0) {
            $('#tombol').html('');
        }
    })

    $('.btn-view').on('click', function(e){
        e.preventDefault();
        let id = $(this).attr('id');
        let nama = $(this).data('nama');
        // console.log(id);
        get_data(id, nama);
        $('#view-modal').modal('show');
    })


    function get_data(id, nama)
    {
        $.ajax({
            method: "POST",
            url: "/getIdInventoryLab",
            data: {
                id,
                _token: '{{ csrf_token() }}'

            }, success: function(res) {
                let barang = JSON.parse(res.barang);
                let tbody = '';

                $.each(barang, function(key, row){
                    let jml_baik = parseInt(row.jml_baik);
                    let jml_rusak = parseInt(row.jml_rusak);
                    let total = jml_baik + jml_rusak;
                    tbody += `
                    <tr>
                        <td>${key+1}</td>
                        <td>
                            <input type="text" class="form-control" value="${row.nama}">
                        </td>
                        <td>
                            <input type="number" class="form-control" value="${jml_baik}">
                        </td>
                        <td>
                            <input type="number" class="form-control" value="${jml_rusak}">
                        </td>
                        <td>
                            <input type="number" class="form-control" value="${total}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger btn-hapus-modal" data-toggle="toggle" title="Hapus"
                    id="${key}" data-nama="${row.nama}" data-id="${id}"><i class=" icon-copy fa fa-trash" aria-hidden="true"
                        data-toggle="tooltip" title="Hapus" data-placement="bottom"></i></button>
                        </td>
                    </tr>
                    `
                })
                $('#data').html(tbody);
                $('#nmlab').text(nama);
            }
        })
    }

    $('#btn-plus-modal').on('click', function(e){
        e.preventDefault();
        let rowCount = $('#data tr').length;
        console.log(1);
        let newRow = `
            <tr>
                <td>${rowCount + 1}</td>
                <td>
                    <input type="text" class="form-control" value="">
                </td>
                <td>
                    <input type="number" class="form-control" value="">
                </td>
                <td>
                    <input type="number" class="form-control" value="">
                </td>
                <td>
                    <input type="number" class="form-control" value="">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning btn-close" data-toggle="toggle" title="Hapus">
                        <i class="icon-copy fa fa-close" aria-hidden="true" data-toggle="tooltip" title="Hapus" data-placement="bottom"></i>
                    </button>
                </td>
            </tr>
        `;
        
        // Menambahkan data baru ke tabel
        $('#data').append(newRow);
    })

    function updateRowNumbers() {
        $('#data tr').each(function(index, row) {
            $(row).find('td:first').text(index + 1);
        });
    }

    $(document).on('click', '.btn-close', function() {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });

    $(document).delegate('.btn-hapus-modal', 'click',  function(e){
        e.preventDefault();
        let key = $(this).attr('id');
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        $('#id_hapus_item').val(id);
        $('#key_hapus_item').val(key);
        $('#nm-item').text(nama);
        $('#hapus-item-modal').modal('show');
        // console.log(key);
    })

</script>
@endsection
