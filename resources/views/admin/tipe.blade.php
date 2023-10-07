@extends('admin.base')

@section('title')
    Tipe Iklan
@endsection

@section('content')
    <div>

        <div class="panel">
            <div class="title">
                <p>Tipe Iklan</p>
                <a class="btn-utama-soft sml rnd " id="addData">Tipe Baru <i
                        class="material-symbols-outlined menu-icon ms-2">add_circle</i></a>
            </div>

            <div class="isi">
                <div class="table">
                    <table id="table_id" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr> --}}
                            {{-- <td>1</td> --}}
                            {{-- <td>Baliho</td> --}}
                            {{-- <td><img class="icon-table" --}}
                            {{-- src="https://icons.iconarchive.com/icons/icons8/windows-8/128/Files-Png-icon.png" /> --}}
                            {{-- </td> --}}

                            {{-- <td class="d-flex"><a class="btn-utama-soft sml rnd me-1" data-bs-toggle="modal" --}}
                            {{-- data-bs-target="#modaldetail"> <i class="material-symbols-outlined menu-icon ">map</i></a> --}}
                            {{-- <a class="btn-success-soft sml rnd "> <i class="material-symbols-outlined menu-icon ">edit</i></a> --}}
                            {{-- </td> --}}
                            {{-- </tr> --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah Tipe Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" enctype="multipart/form-data">
                            @csrf
                            <input id="id" name="id" hidden>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Nama Tipe">
                                <label for="name" class="form-label">Nama Tipe</label>
                            </div>

                            <div class="mb-3">
                                <label for="icontipe" class="form-label">Icon Tipe</label>
                                {{-- <input class="form-control form-control-sm" id="icontipe" type="file"> --}}
                                <input type="file" id="icon" name="" class="image" required
                                    data-min-height="10" accept="image/jpeg, image/jpg, image/png"
                                    data-allowed-file-extensions="jpg jpeg png" />
                            </div>

                            <div class="my-3">
                                <div class="d-flex">
                                    <button type="submit" class="btn-utama" style="width: 100%">Simpan</button>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- Modal Detail-->

    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table_piutang').DataTable();
            datatable();
            saveData();
        });

        $(document).on('click', '#addData, #editData', function() {
            let id = $(this).data('id');
            let data = $(this).data('row');
            $('#form #name').val('');
            $('#form #id').val(id);
            let img = null;
            if (id) {
                $('#form #name').val(data.name);
                img = data.icon;
            }
            setImgDropify('icon', 'Masukkan Icon', img, 300);

            $('#modaltambahtitik').modal('show')
        })

        function datatable() {
            var url = '/admin/type/datatable';
            $('#table_id').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: url,
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    // debugger;
                    var numStart = this.fnPagingInfo().iStart;
                    var index = numStart + iDisplayIndexFull + 1;
                    // var index = iDisplayIndexFull + 1;
                    $("td:first", nRow).html(index);
                    return nRow;
                },
                columns: [{
                        "className": '',
                        "orderable": false,
                        "defaultContent": ''
                    },
                    {
                        "data": "name",
                        "name": "name"
                    },
                    {
                        "data": "icon",
                        "render": function(data, type, row) {
                            return "<img class=\"icon-table\"\n" +
                                "                                        src='" + data + "' />"
                        }
                    },

                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            let string = JSON.stringify(row);
                            return "<div class='d-flex'>\n" +
                                "                                <a class='btn-success-soft sml rnd' data-id='" +
                                data + "' data-row='" + string +
                                "' id='editData'> <i class='material-symbols-outlined menu-icon'>edit</i></a></div>";
                        }
                    },
                ]
            });

        }

        function saveData() {
            let form = $('#form');
            form.submit(async function(e) {
                e.preventDefault(e);
                let formData = new FormData(this);
                console.log(formData);
                let data = {
                    'form_data': formData,
                    'image': {
                        'icon': 'icon',
                    }
                };
                saveDataAjaxWImage('Simpan Data', 'form', data, window.location.pathname, afterSave);
                return false;
            })
        }

        function afterSave() {
            $('#modaltambahtitik').modal('hide')
            datatable();
        }
    </script>
@endsection
