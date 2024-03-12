@extends('layout.main')

@section('content')
    {{-- Modal edit --}}
    <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Data Lab <span id="nmlab"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="formUpdate" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id_addnew_item">

                        <div class="d-flex justify-content-end align-items-center mb-3">
                            <p>
                                Klik disini jika ingin menambahkan data
                            </p>
                            <button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="toggle" title="Tambah"
                                id="btn-plus-modal"><i class=" icon-copy fa fa-plus" aria-hidden="true"
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
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                            </tbody>
                        </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <div class="pd-20 card-box mb-30">
        <h4 class="h4 text-blue">Form Inventory Lab</h4>

        <form action="/inventory-lab" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">

            <label>Pilih Lab</label>
            <div class="input-group mb-3" id="form-input">
                <select class="custom-select2 form-control @error('namalab') form-control-danger @enderror" name="namalab"
                    id="namalab" required style="width: 90%;">
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
                        <th>Cetak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm btn-view" id="{{ $row->id }}"
                                    data-nama="{{ $row->nama }}"> <i class="fa fa-archive"></i> View</button>
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm btn-cetak text-light"
                                    href="{{ url('inventory-lab-cetak/' . Crypt::encryptString($row->id)) }}"
                                    target="_blank"> <i class="fa fa-file-pdf-o"></i></a>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-hapus" id="{{ $row->id }}"
                                    data-nama="{{ $row->nama }}"> <i class="fa fa-trash"></i></button>
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
        $('#btn-plus').on('click', function() {
            // e.preventDefault();
            let input = `
        <div class="row form-group input-remove" id="form-input">

        <div class="col-md-4">
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
        <div class="col-md-3">
            <label for="">Keterangan</label>
            <input type="text" class="form-control" name="keterangan[]">
        </div>
        <div class="col-md-1 d-flex align-items-end">
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
            if (jml_input == 0) {
                $('#tombol').html('');
            }
        })

        $('.btn-view').on('click', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let nama = $(this).data('nama');
            get_data(id, nama);
            $('#id_addnew_item').val(id);
            $('#view-modal').modal('show');
        })


        function get_data(id, nama) {
            $.ajax({
                method: "POST",
                url: "/getIdInventoryLab",
                data: {
                    id,
                    _token: '{{ csrf_token() }}'

                },
                success: function(res) {
                    let barang = JSON.parse(res.barang);
                    let tbody = '';

                    $.each(barang, function(key, row) {
                        let jml_baik = parseInt(row.jml_baik);
                        let jml_rusak = parseInt(row.jml_rusak);
                        let total = jml_baik + jml_rusak;
                        tbody += `
                    <tr>
                        <td>${key+1}</td>
                        <td>
                            <input type="text" class="form-control" name="barang_add[]" value="${row.nama}" required>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="jmlbaik_add[]" value="${jml_baik}" required>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="jmlrusak_add[]" value="${jml_rusak}" required>
                        </td>
                        <td>
                            <input type="text" class="form-control total_add" value="${total}" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="keterangan_add[]" value="${row.keterangan}" required>
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

        $('#btn-plus-modal').on('click', function(e) {
            e.preventDefault();
            let rowCount = $('#data tr').length;
            let newRow = `
            <tr>
                <td>${rowCount + 1}</td>
                <td>
                    <input type="text" class="form-control" name="barang_add[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="jmlbaik_add[]" required>
                </td>
                <td>
                    <input type="number" class="form-control" name="jmlrusak_add[]" required>
                </td>
                <td>
                    <input type="text" class="form-control total_add" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="keterangan_add[]" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning btn-close" data-toggle="toggle" title="Hapus">
                        <i class="icon-copy fa fa-close" aria-hidden="true" data-toggle="tooltip" title="Hapus" data-placement="bottom"></i>
                    </button>
                </td>
            </tr>
        `;

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
            let lengthBtn = $('.btn-close').length;
        });

        // hapus per item data
        $(document).delegate('.btn-hapus-modal', 'click', function(e) {
            e.preventDefault();
            let key = $(this).attr('id');
            let id = $(this).data('id');
            let nama = $(this).data('nama');

            Swal.fire({
                icon: 'warning',
                title: 'Apakah kamu yakin ingin menghapus ?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete-item-lab',
                        data: {
                            id,
                            key,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire({
                                title: res.title,
                                text: res.text,
                                icon: res.icon
                            });

                            get_data(id, nmlab);
                        }
                    });
                }
            });
        })

        // form update data
        $(document).delegate('#formUpdate', 'submit', function(e) {
            e.preventDefault();
            let barang_add = $('input[name="barang_add[]"]').map(function() {
                return $(this).val();
            }).get();
            let jmlbaik_add = $('input[name="jmlbaik_add[]"]').map(function() {
                return $(this).val();
            }).get();
            let jmlrusak_add = $('input[name="jmlrusak_add[]"]').map(function() {
                return $(this).val();
            }).get();
            let keterangan_add = $('input[name="keterangan_add[]"]').map(function() {
                return $(this).val();
            }).get();
            let id = $('#id_addnew_item').val();
            let nmlab = $('#nmlab').text();

            $.ajax({
                method: "POST",
                url: "addnew-item-lab",
                data: {
                    id,
                    barang_add,
                    jmlbaik_add,
                    jmlrusak_add,
                    keterangan_add,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    Swal.fire({
                        title: res.title,
                        text: res.text,
                        icon: res.icon
                    });

                    get_data(id, nmlab);
                }
            })

        })


        // input jumlah on keyup
        $(document).delegate('input[name="jmlbaik_add[]"]', 'keyup', function() {
            updateTotal($(this).closest('tr'));
        });

        $(document).delegate('input[name="jmlrusak_add[]"]', 'keyup', function() {
            updateTotal($(this).closest('tr'));
        });

        function updateTotal(row) {
            var jmlBaik = parseInt(row.find('input[name="jmlbaik_add[]"]').val()) || 0;
            var jmlRusak = parseInt(row.find('input[name="jmlrusak_add[]"]').val()) || 0;
            var total = jmlBaik + jmlRusak;
            row.find('.total_add').val(total);
        }

        // hapus data
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            let nama = $(this).data('nama');
            let id = $(this).attr('id');

            Swal.fire({
                icon: 'warning',
                title: `Apakah kamu yakin ingin menghapus data lab ${nama} ?`,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'hapus-inventory-lab',
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
                                window.location = '/inventory-lab';
                            });
                        }
                    });
                }
            });

        })
    </script>
@endsection
