@extends('admin.base')

@section('title')
    User
@endsection

@section('content')
    <div>


        <div class="panel">
            <div class="title">
                <p>Data User</p>
                <a class="btn-utama-soft sml rnd " id="addData">User Baru <i
                        class="material-symbols-outlined menu-icon ms-2">add_circle</i></a>
            </div>

            <div class="isi">
                <div class="table">
                    <table id="table_id" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modaltambahuser" tabindex="-1" aria-labelledby="modaltambahuser" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form" onsubmit="return saveUser()">
                        @csrf
                        <input id="id" name="id" class=" formData" hidden>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control formData" id="nama" name="nama"
                                    placeholder="Jhony">
                                <label for="nama" class="form-label">Nama</label>
                            </div>

                            <label for="role" class="form-label">Role</label>
                            <select class="form-select mb-3 formData" aria-label="Default select example" id="role"
                                name="role">
                                <option selected>Pilih Role</option>
                                <option value="pimpinan">Pimpinan</option>
                                <option value="admin">Admin</option>
                                <option value="presence">Presence</option>
                            </select>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control  formData" id="no_hp" name="no_hp"
                                    placeholder="08712345678">
                                <label for="nohp" class="form-label">No. Hp</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control formData" id="email" name="email"
                                    placeholder="name@example.com">
                                <label for="floatingInput">Email</label>
                            </div>

                            <hr>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control formData" id="username" name="username"
                                    placeholder="Jhony">
                                <label for="nama" class="form-label">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control formData " id="password" name="password"
                                    placeholder="Jhony">
                                <label for="password" class="form-label">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control formData " id="password_confirmation"
                                    name="password_confirmation" placeholder="Jhony">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            </div>


                        </div>

                        <div class=" m-3">

                            <div class="text-center">
                                <button type="submit" class="btn-utama">Simpan</button>
                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatable();
        });

        $(document).on('click', '#editData, #addData', function() {
            var data = $(this).data('row');
            $('form .formData').val('')
            if (data) {
                $.each(data, function(v, k) {
                    $('#' + v).val(data[v])
                })

                $('#password').val('*******');
                $('#password_confirmation').val('*******');
            }
            $('#modaltambahuser').modal('show')
        })

        function saveUser() {
            saveData('Simpan Data', 'form', window.location.pathname, afterSave);
            return false;
        }

        function afterSave() {
            $('#modaltambahuser').modal('hide')
            datatable();
        }

        $(document).on('click', '#activeData', function() {
            let id = $(this).data('id');
            let active = $(this).data('status');
            let _token = '{{ csrf_token() }}';
            let name = $(this).data('name');
            let status = 'Aktifkan';
            if (active == 1) {
                status = 'Non Aktifkan';
            }
            let form = {
                '_token': _token,
                'id': id,
                'isActive': active
            }

            saveDataObjectFormData(status + ' user ' + name, form, window.location.pathname + '/status', afterSave);


        })

        function datatable() {
            var url = window.location.pathname + '/datatable';
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
                        "data": "nama",
                        "name": "nama"
                    },
                    {
                        "data": "role",
                        "name": "role"
                    },
                    {
                        "data": "email",
                        "name": "email"
                    },
                    {
                        "data": "no_hp",
                        "name": "no_hp"
                    },
                    {
                        "data": "items_count",
                        "name": "items_count"
                    },
                    {
                        "data": "isActive",
                        // "name": "isActive",
                        "render": function(data) {
                            return data == 1 ? 'Aktif' : 'Non Aktif'
                        }
                    },

                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            let string = JSON.stringify(row);
                            var icon = 'visibility_off';
                            if (row.isActive) {
                                icon = 'remove_red_eye';
                            }
                            return "<div class='d-flex'>\n" +
                                "<a class='btn-success-soft sml rnd me-2' data-id='" +
                                data + "' data-row='" + string +
                                "' id='editData'> <i class='material-symbols-outlined menu-icon'>edit</i></a>" +
                                "<a class='btn-danger-soft sml rnd' data-id='" +
                                data + "' data-name='" + row.nama + "' data-status='" + row.isActive +
                                "' id='activeData'> <i class='material-symbols-outlined menu-icon'>" +
                                icon + "</i></a>" +
                                "</div>";
                        }
                    },
                ]
            });

        }
    </script>
@endsection
