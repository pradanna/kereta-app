@extends('admin/base')

@section('content')
    <div class="lazy-backdrop" id="overlay-loading">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
            </div>
            <p class="text-light">Sedang Mengunduh Data Role Akses...</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title-container">
            <h1 class="h1">MANAJEMEN AKSES PENGGUNA APLIKASI</h1>
            <p class="mb-0">Manajemen Data Akses Pengguna Aplikasi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Pengguna Aplikasi</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Akses Pengguna Aplikasi</p>
        </div>
        <div class="isi">
            <div class="form-group w-100 mb-3">
                <label for="user-option" class="form-label">Pengguna Aplikasi</label>
                <select class="select2 form-control" name="user-option" id="user-option"
                        style="width: 100%;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                    @endforeach
                </select>
            </div>
            <hr>
            <div id="panel-menus">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center" id="pills-facility-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-facility" type="button" role="tab" aria-controls="pills-facility"
                                aria-selected="true">
                            <i class="material-symbols-outlined me-1" style="font-size: 14px; color: inherit">train</i>
                            Sarana Dan Keselamatan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center" id="pills-infrastructure-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-infrastructure" type="button" role="tab"
                                aria-controls="pills-infrastructure" aria-selected="false">
                            <i class="material-symbols-outlined me-1"
                               style="font-size: 14px; color: inherit">category</i>
                            PRASARANA
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center" id="pills-traffic-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-traffic" type="button" role="tab"
                                aria-controls="pills-traffic" aria-selected="false">
                            <i class="material-symbols-outlined me-1"
                               style="font-size: 14px; color: inherit">signpost</i>
                            LALU LINTAS
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center" id="pills-master-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-master" type="button" role="tab"
                                aria-controls="pills-master" aria-selected="false">
                            <i class="material-symbols-outlined me-1"
                               style="font-size: 14px; color: inherit">widgets</i>
                            MASTER DATA
                        </button>
                    </li>
                </ul>
                <hr>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-facility" role="tabpanel"
                         aria-labelledby="pills-facility-tab">
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Sertifikasi Sarana</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Sertifikasi
                                            Sarana Lokomotif</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-lokomotif-create"
                                                   name="check-sertifikasi-sarana-lokomotif">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-lokomotif-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-lokomotif-update"
                                                   name="check-sertifikasi-sarana-lokomotif">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-lokomotif-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-lokomotif-delete"
                                                   name="check-sertifikasi-sarana-lokomotif">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-lokomotif-delete">Hapus</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Sertifikasi
                                            Sarana Kereta</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-kereta-create"
                                                   name="check-sertifikasi-sarana-kereta">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-kereta-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-kereta-update"
                                                   name="check-sertifikasi-sarana-kereta">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-kereta-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-kereta-delete"
                                                   name="check-sertifikasi-sarana-kereta">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-kereta-delete">Hapus</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Sertifikasi
                                            Sarana Gerbong</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-gerbong-create"
                                                   name="check-sertifikasi-sarana-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-gerbong-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-gerbong-update"
                                                   name="check-sertifikasi-sarana-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-gerbong-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-gerbong-delete"
                                                   name="check-sertifikasi-sarana-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-gerbong-delete">Hapus</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Sertifikasi
                                            Sarana Peralatan Khusus</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-peralatan-khusus-create"
                                                   name="check-sertifikasi-sarana-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-peralatan-khusus-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-peralatan-khusus-update"
                                                   name="check-sertifikasi-sarana-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-peralatan-khusus-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sertifikasi-sarana-peralatan-khusus-delete"
                                                   name="check-sertifikasi-sarana-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="sertifikasi-sarana-peralatan-khusus-delete">Hapus</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Depo Dan Balai Yasa</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Depo
                                            Dan Balai Yasa</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="depo-dan-balai-yasa-create" name="check-depo-dan-balai-yasa">
                                            <label class="form-check-label menu-title" for="depo-dan-balai-yasa-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="depo-dan-balai-yasa-update" name="check-depo-dan-balai-yasa">
                                            <label class="form-check-label menu-title" for="depo-dan-balai-yasa-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="depo-dan-balai-yasa-delete" name="check-depo-dan-balai-yasa">
                                            <label class="form-check-label menu-title" for="depo-dan-balai-yasa-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Spesifikasi Teknis Sarana</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Spesifikasi
                                            Teknis
                                            Sarana Lokomotif</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-lokomotif-create"
                                                   name="check-spesifikasi-teknis-sarana-lokomotif">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-lokomotif-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-lokomotif-update"
                                                   name="check-spesifikasi-teknis-sarana-lokomotif">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-lokomotif-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-lokomotif-delete"
                                                   name="check-spesifikasi-teknis-sarana-lokomotif">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-lokomotif-delete">Hapus</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Spesifikasi
                                            Teknis
                                            Sarana Kereta</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-kereta-create"
                                                   name="check-spesifikasi-teknis-sarana-kereta">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-kereta-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-kereta-update"
                                                   name="check-spesifikasi-teknis-sarana-kereta">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-kereta-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-kereta-delete"
                                                   name="check-spesifikasi-teknis-sarana-kereta">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-kereta-delete">Hapus</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Spesifikasi
                                            Teknis
                                            Sarana Gerbong</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-gerbong-create"
                                                   name="check-spesifikasi-teknis-sarana-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-gerbong-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-gerbong-update"
                                                   name="check-spesifikasi-teknis-sarana-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-gerbong-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-gerbong-delete"
                                                   name="check-spesifikasi-teknis-sarana-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-gerbong-delete">Hapus</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Spesifikasi
                                            Teknis
                                            Sarana Peralatan Khusus</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-peralatan-khusus-create"
                                                   name="check-spesifikasi-teknis-sarana-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-peralatan-khusus-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-peralatan-khusus-update"
                                                   name="check-spesifikasi-teknis-sarana-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-peralatan-khusus-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="spesifikasi-teknis-sarana-peralatan-khusus-delete"
                                                   name="check-spesifikasi-teknis-sarana-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="spesifikasi-teknis-sarana-peralatan-khusus-delete">Hapus</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Perlintasan Kereta Api (JPL)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Perlintasan
                                            Kereta Api (JPL)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="perlintasan-kereta-api-create"
                                                   name="check-perlintasan-kereta-api">
                                            <label class="form-check-label menu-title"
                                                   for="perlintasan-kereta-api-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="perlintasan-kereta-api-update"
                                                   name="check-perlintasan-kereta-api">
                                            <label class="form-check-label menu-title"
                                                   for="perlintasan-kereta-api-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="perlintasan-kereta-api-delete"
                                                   name="check-perlintasan-kereta-api">
                                            <label class="form-check-label menu-title"
                                                   for="perlintasan-kereta-api-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>IDRK (Daerah Rawan Bencana)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">IDRK
                                            (Daerah Rawan Bencana)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="daerah-rawan-bencana-create" name="check-daerah-rawan-bencana">
                                            <label class="form-check-label menu-title"
                                                   for="daerah-rawan-bencana-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="daerah-rawan-bencana-update" name="check-daerah-rawan-bencana">
                                            <label class="form-check-label menu-title"
                                                   for="daerah-rawan-bencana-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="daerah-rawan-bencana-delete" name="check-daerah-rawan-bencana">
                                            <label class="form-check-label menu-title"
                                                   for="daerah-rawan-bencana-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Peristiwa Luar Biasa Hebat (PLH)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Peristiwa
                                            Luar Biasa Hebat (PLH)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="peristiwa-luar-biasa-hebat-create"
                                                   name="check-peristiwa-luar-biasa-hebat">
                                            <label class="form-check-label menu-title"
                                                   for="peristiwa-luar-biasa-hebat-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="peristiwa-luar-biasa-hebat-update"
                                                   name="check-peristiwa-luar-biasa-hebat">
                                            <label class="form-check-label menu-title"
                                                   for="peristiwa-luar-biasa-hebat-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="peristiwa-luar-biasa-hebat-delete"
                                                   name="check-peristiwa-luar-biasa-hebat">
                                            <label class="form-check-label menu-title"
                                                   for="peristiwa-luar-biasa-hebat-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Alat Material Untuk Siaga (AMUS)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Alat
                                            Material Untuk Siaga (AMUS)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="amus-create" name="check-amus">
                                            <label class="form-check-label menu-title" for="amus-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="amus-update" name="check-amus">
                                            <label class="form-check-label menu-title" for="amus-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="amus-delete" name="check-amus">
                                            <label class="form-check-label menu-title" for="amus-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Bangunan Liar</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Bangunan
                                            Liar</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="bangunan-liar-create" name="check-bangunan-liar">
                                            <label class="form-check-label menu-title"
                                                   for="bangunan-liar-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="bangunan-liar-update" name="check-bangunan-liar">
                                            <label class="form-check-label menu-title"
                                                   for="bangunan-liar-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="bangunan-liar-delete" name="check-bangunan-liar">
                                            <label class="form-check-label menu-title"
                                                   for="bangunan-liar-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Keselamatan Dan Kesehatan Kerja (K3)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Keselamatan
                                            Dan Kesehatan Kerja (K3)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="keselamatan-dan-kesehatan-kerja-create"
                                                   name="check-keselamatan-dan-kesehatan-kerja">
                                            <label class="form-check-label menu-title"
                                                   for="keselamatan-dan-kesehatan-kerja-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="keselamatan-dan-kesehatan-kerja-update"
                                                   name="check-keselamatan-dan-kesehatan-kerja">
                                            <label class="form-check-label menu-title"
                                                   for="keselamatan-dan-kesehatan-kerja-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="keselamatan-dan-kesehatan-kerja-delete"
                                                   name="check-keselamatan-dan-kesehatan-kerja">
                                            <label class="form-check-label menu-title"
                                                   for="keselamatan-dan-kesehatan-kerja-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Sumber Daya Manusia</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Sumber
                                            Daya Manusia</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sumber-daya-manusia-create" name="check-sumber-daya-manusia">
                                            <label class="form-check-label menu-title" for="sumber-daya-manusia-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sumber-daya-manusia-update" name="check-sumber-daya-manusia">
                                            <label class="form-check-label menu-title" for="sumber-daya-manusia-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="sumber-daya-manusia-delete" name="check-sumber-daya-manusia">
                                            <label class="form-check-label menu-title" for="sumber-daya-manusia-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-infrastructure" role="tabpanel"
                         aria-labelledby="pills-infrastructure-tab">
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Safety Assessment</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Safety
                                            Assessment</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="safety-assessment-create" name="check-safety-assessment">
                                            <label class="form-check-label menu-title" for="safety-assessment-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="safety-assessment-update" name="check-safety-assessment">
                                            <label class="form-check-label menu-title" for="safety-assessment-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="safety-assessment-delete" name="check-safety-assessment">
                                            <label class="form-check-label menu-title" for="safety-assessment-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Jembatan Penyebrangan (JPOM, Underpass, Flyover)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Jembatan
                                            Penyebrangan (JPOM, Underpass, Flyover)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="jembatan-penyebrangan-create" name="check-jembatan-penyebrangan">
                                            <label class="form-check-label menu-title"
                                                   for="jembatan-penyebrangan-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="jembatan-penyebrangan-update" name="check-jembatan-penyebrangan">
                                            <label class="form-check-label menu-title"
                                                   for="jembatan-penyebrangan-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="jembatan-penyebrangan-delete" name="check-jembatan-penyebrangan">
                                            <label class="form-check-label menu-title"
                                                   for="jembatan-penyebrangan-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Permohonan Izin Melintas Rel (Crossing)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Permohonan
                                            Izin Melintas Rel (Crossing)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="permohonan-izin-melintas-rel-create"
                                                   name="check-permohonan-izin-melintas-rel">
                                            <label class="form-check-label menu-title"
                                                   for="permohonan-izin-melintas-rel-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="permohonan-izin-melintas-rel-update"
                                                   name="check-permohonan-izin-melintas-rel">
                                            <label class="form-check-label menu-title"
                                                   for="permohonan-izin-melintas-rel-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="permohonan-izin-melintas-rel-delete"
                                                   name="check-permohonan-izin-melintas-rel">
                                            <label class="form-check-label menu-title"
                                                   for="permohonan-izin-melintas-rel-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Jembatan Kereta Api (BH)</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Jembatan
                                            Kereta Api (BH)</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="jembatan-kereta-api-create" name="check-jembatan-kereta-api">
                                            <label class="form-check-label menu-title" for="jembatan-kereta-api-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="jembatan-kereta-api-update" name="check-jembatan-kereta-api">
                                            <label class="form-check-label menu-title" for="jembatan-kereta-api-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="jembatan-kereta-api-delete" name="check-jembatan-kereta-api">
                                            <label class="form-check-label menu-title" for="jembatan-kereta-api-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-traffic" role="tabpanel"
                         aria-labelledby="pills-traffic-tab">
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Stasiun Kereta Api</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Stasiun
                                            Kereta Api</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="stasiun-kereta-api-create" name="check-stasiun-kereta-api">
                                            <label class="form-check-label menu-title" for="stasiun-kereta-api-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="stasiun-kereta-api-update" name="check-stasiun-kereta-api">
                                            <label class="form-check-label menu-title" for="stasiun-kereta-api-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="stasiun-kereta-api-delete" name="check-stasiun-kereta-api">
                                            <label class="form-check-label menu-title" for="stasiun-kereta-api-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-master" role="tabpanel"
                         aria-labelledby="pills-master-tab">
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Kecamatan</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Kecamatan</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-kecamatan-create" name="check-master-kecamatan">
                                            <label class="form-check-label menu-title" for="master-kecamatan-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-kecamatan-update" name="check-master-kecamatan">
                                            <label class="form-check-label menu-title" for="master-kecamatan-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-kecamatan-delete" name="check-master-kecamatan">
                                            <label class="form-check-label menu-title" for="master-kecamatan-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Jenis Lokomotif</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Jenis
                                            Lokomotif</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="amus-create" name="check-amus">
                                            <label class="form-check-label menu-title" for="amus-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="amus-update" name="check-amus">
                                            <label class="form-check-label menu-title" for="amus-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="amus-delete" name="check-amus">
                                            <label class="form-check-label menu-title" for="amus-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Jenis Kereta</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Jenis
                                            Kereta</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-kereta-create" name="check-master-jenis-kereta">
                                            <label class="form-check-label menu-title" for="master-jenis-kereta-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-kereta-update" name="check-master-jenis-kereta">
                                            <label class="form-check-label menu-title" for="master-jenis-kereta-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-kereta-delete" name="check-master-jenis-kereta">
                                            <label class="form-check-label menu-title" for="master-jenis-kereta-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Jenis Gerbong</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Jenis
                                            Gerbong</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-gerbong-create" name="check-master-jenis-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-gerbong-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-gerbong-update" name="check-master-jenis-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-gerbong-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-gerbong-delete" name="check-master-jenis-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-gerbong-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Sub Jenis Gerbong</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Sub
                                            Jenis Gerbong</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-sub-jenis-gerbong-create"
                                                   name="check-master-sub-jenis-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="master-sub-jenis-gerbong-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-sub-jenis-gerbong-update"
                                                   name="check-master-sub-jenis-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="master-sub-jenis-gerbong-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-sub-jenis-gerbong-delete"
                                                   name="check-master-sub-jenis-gerbong">
                                            <label class="form-check-label menu-title"
                                                   for="master-sub-jenis-gerbong-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Jenis Peralatan Khusus</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Jenis
                                            Peralatan Khusus</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-peralatan-khusus-create"
                                                   name="check-master-jenis-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-peralatan-khusus-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-peralatan-khusus-update"
                                                   name="check-master-jenis-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-peralatan-khusus-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-peralatan-khusus-delete"
                                                   name="check-master-jenis-peralatan-khusus">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-peralatan-khusus-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Lintasan</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Lintasan</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-lintasan-create" name="check-master-lintasan">
                                            <label class="form-check-label menu-title" for="master-lintasan-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-lintasan-update" name="check-master-lintasan">
                                            <label class="form-check-label menu-title"
                                                   for="master-lintasan-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-lintasan-delete" name="check-master-lintasan">
                                            <label class="form-check-label menu-title" for="master-lintasan-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Petak</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Petak</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-petak-create" name="check-master-petak">
                                            <label class="form-check-label menu-title"
                                                   for="master-petak-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-petak-update" name="check-master-petak">
                                            <label class="form-check-label menu-title"
                                                   for="master-petak-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-petak-delete" name="check-master-petak">
                                            <label class="form-check-label menu-title"
                                                   for="master-petak-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Jenis Rawan Bencana</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Jenis
                                            Rawan Bencana</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-rawan-bencana-create"
                                                   name="check-master-jenis-rawan-bencana">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-rawan-bencana-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-rawan-bencana-update"
                                                   name="check-master-jenis-rawan-bencana">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-rawan-bencana-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-jenis-rawan-bencana-delete"
                                                   name="check-master-jenis-rawan-bencana">
                                            <label class="form-check-label menu-title"
                                                   for="master-jenis-rawan-bencana-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="w-100 menu-access mb-1">
                                    <span>Resort</span>
                                </div>
                                <div class="p-3">
                                    <div class="mb-3">
                                        <label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">Resort</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-resort-create" name="check-master-resort">
                                            <label class="form-check-label menu-title"
                                                   for="master-resort-create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-resort-update" name="check-master-resort">
                                            <label class="form-check-label menu-title"
                                                   for="master-resort-update">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   id="master-resort-delete" name="check-master-resort">
                                            <label class="form-check-label menu-title"
                                                   for="master-resort-delete">Hapus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama rnd" id="btn-save" href="#">Simpan
                        <i class="material-symbols-outlined menu-icon ms-1 text-white">save</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('user-access') }}';
        let pathAccessMenu = '{{ route('user-access.menu') }}';
        let accessMenus = [
            'sertifikasi-sarana-lokomotif',
            'sertifikasi-sarana-kereta',
            'sertifikasi-sarana-gerbong',
            'sertifikasi-sarana-peralatan-khusus',
            'depo-dan-balai-yasa',
            'spesifikasi-teknis-sarana-lokomotif',
            'spesifikasi-teknis-sarana-kereta',
            'spesifikasi-teknis-sarana-gerbong',
            'spesifikasi-teknis-sarana-peralatan-khusus',
            'perlintasan-kereta-api',
            'daerah-rawan-bencana',
            'peristiwa-luar-biasa-hebat',
            'amus',
            'bangunan-liar',
            'keselamatan-dan-kesehatan-kerja',
            'sumber-daya-manusia',
            'safety-assessment',
            'jembatan-penyebrangan',
            'permohonan-izin-melintas-rel',
            'jembatan-kereta-api',
            'stasiun-kereta-api',
            'master-kecamatan',
            'master-jenis-lokomotif',
            'master-jenis-kereta',
            'master-jenis-gerbong',
            'master-sub-jenis-gerbong',
            'master-jenis-peralatan-khusus',
            'master-lintasan',
            'master-petak',
            'master-jenis-rawan-bencana',
            'master-resort'
        ];

        async function getAccessMenu() {
            try {
                let user = $('#user-option').val();
                let url = pathAccessMenu + '?user=' + user;
                blockLoading(true)
                let response = await $.get(url);
                let data = response['data'];
                matchAccessMenu(data);
                blockLoading(false)
                console.log(response)
            } catch (e) {
                blockLoading(false)
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
                console.log(error_message.message)
            }
        }

        function matchAccessMenu(data = []) {
            $('input:checkbox').prop('checked', false);
            $.each(data, function (k, v) {
                let slug = v['app_menu']['slug'];
                let create = v['is_granted_create'];
                let update = v['is_granted_update'];
                let destroy = v['is_granted_delete'];
                let elNameCreate = '#' + slug + '-' + 'create';
                let elNameUpdate = '#' + slug + '-' + 'update';
                let elNameDelete = '#' + slug + '-' + 'delete';
                $(elNameCreate).prop('checked', create);
                $(elNameUpdate).prop('checked', update);
                $(elNameDelete).prop('checked', destroy);
            });
        }

        async function submitHandler() {
            try {
                let roleAccess = generateRoleAccessData();
                let user = $('#user-option').val();
                let tmpData = {
                    user: user,
                    access: roleAccess
                };
                let data = JSON.stringify(tmpData);
                blockLoading(true);
                await $.post(path, {data});
                blockLoading(false);
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil Menambahkan Data...',
                    icon: 'success',
                    timer: 1000
                }).then(() => {
                    window.location.reload();
                });
            }catch (e) {
                blockLoading(false);
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            }

        }

        function generateRoleAccessData() {
            let results = [];
            $.each(accessMenus, function (k, v) {
                let granted = ['create', 'update', 'delete'];
                let resultGranted = [];
                $.each(granted, function (kG, vG) {
                    let elName = '#' + v + '-' + vG;
                    let val = $(elName).is(':checked');
                    let obj = {
                        access: vG,
                        val: val
                    };
                    resultGranted.push(obj)
                });
                let objParent = {
                    key: v,
                    value: resultGranted
                };
                results.push(objParent);
            });
            return results;
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            getAccessMenu();
            $('#user-option').on('change', function () {
                getAccessMenu();
            });
            $('#btn-save').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menyimpan data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        submitHandler();
                    }
                });
            });
        })
    </script>
@endsection
