<?php 

use function Laravel\Folio\{name, middleware};
middleware(['auth']);
 
name('home');

?>

<x-layouts.app subheaderTitle="Dashboard" >
    @volt
    <div class="container">
        <!--begin::Dashboard-->

        @role('counter')
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('assets/be/media/svg/shapes/abstract-3.svg') }})">
                            <!--begin::Body-->
                            <div class="card-body">
                                <a href="/data-penduduk/penduduk">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $residentTotal ?? 0 }}</span>
                                    <span class="font-weight-bold text-muted font-size-sm">Total Pegawai</span>
                                </a>
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('assets/be/media/svg/shapes/abstract-3.svg') }})">
                            <!--begin::Body-->
                            <div class="card-body">
                                <a href="/informasi-desa/umkm/pending">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <rect fill="#000000" opacity="0.3" x="2" y="2" width="10" height="12" rx="2"/>
                                                <path d="M4,6 L20,6 C21.1045695,6 22,6.8954305 22,8 L22,20 C22,21.1045695 21.1045695,22 20,22 L4,22 C2.8954305,22 2,21.1045695 2,20 L2,8 C2,6.8954305 2.8954305,6 4,6 Z M18,16 C19.1045695,16 20,15.1045695 20,14 C20,12.8954305 19.1045695,12 18,12 C16.8954305,12 16,12.8954305 16,14 C16,15.1045695 16.8954305,16 18,16 Z" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $umkmTotal ?? 0 }}</span>
                                    <span class="font-weight-bold text-muted font-size-sm">Transaksi Hari Ini</span>
                                </a>
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('assets/be/media/svg/shapes/abstract-3.svg') }})">
                            <!--begin::Body-->
                            <div class="card-body">
                                <a href="master-data/staff">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <rect fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1"/>
                                                <path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{{ $staffTotal ?? 0 }}</span>
                                    <span class="font-weight-bold text-muted font-size-sm">Pemasukan Hari Ini</span>
                                </a>
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-custom card-stretch gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Menu</h3>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 py-3">
                        <!--begin::Chart-->
                        
                        <ul class="navi navi-hover navi-border navi-active">
                            <li class="navi-item">
                                <a class="navi-link" href="#">
                                    <span class="navi-icon mr-2"><i class="flaticon2-browser-1 text-primary"></i></span>
                                    <div class="navi-text">
                                        <span class="d-block font-weight-bold">Cashier</span>
                                        <span class="text-muted">Menu Pemesanan dan transaksi</span>
                                    </div>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a class="navi-link" href="#">
                                    <span class="navi-icon mr-2"><i class="flaticon2-paper-plane text-primary"></i></span>
                                    <div class="navi-text">
                                        <span class="d-block font-weight-bold">Delivery Order</span>
                                        <span class="text-muted">Daftar dan Buat DO</span>
                                    </div>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a class="navi-link" href="#">
                                    <span class="navi-icon mr-2"><i class="flaticon2-box-1  text-primary"></i></span>
                                    <div class="navi-text">
                                        <span class="d-block font-weight-bold">Inventaris</span>
                                        <span class="text-muted">Project & tasks</span>
                                    </div>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a class="navi-link" href="#">
                                    <span class="navi-icon mr-2"><i class="flaticon2-file  text-primary"></i></span>
                                    <div class="navi-text">
                                        <span class="d-block font-weight-bold">Laporan Penjualan</span>
                                        <span class="text-muted">Daftar Transaksi</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!--end::Chart-->
                    </div>
                </div>
            </div>
        </div>
        @endrole

        <!--begin::Row-->
        <div class="row">
            <div class="col-xl-4">
                <!--begin::Mixed Widget 4-->
                <div class="card card-custom bg-radial-gradient-danger gutter-b card-stretch">
                    <!--begin::Header-->
                    <div class="card-header border-0 py-5">
                        <h3 class="card-title font-weight-bolder text-white">{{ Auth::getDefaultDriver() }}</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="btn btn-text-white btn-hover-white btn-sm btn-icon border-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-header pb-1">
                                            <span class="text-primary text-uppercase font-weight-bold font-size-sm">Add new:</span>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Order</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-calendar-8"></i>
                                                </span>
                                                <span class="navi-text">Event</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-graph-1"></i>
                                                </span>
                                                <span class="navi-text">Report</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-rocket-1"></i>
                                                </span>
                                                <span class="navi-text">Post</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-writing"></i>
                                                </span>
                                                <span class="navi-text">File</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body d-flex flex-column p-0">
                        <!--begin::Chart-->
                        <div id="kt_mixed_widget_4_chart" style="height: 200px"></div>
                        <!--end::Chart-->
                        <!--begin::Stats-->
                        <div class="card-spacer bg-white card-rounded flex-grow-1">
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col px-8 py-6 mr-8">
                                    <div class="font-size-sm text-muted font-weight-bold">Average Sale</div>
                                    <div class="font-size-h4 font-weight-bolder">$650</div>
                                </div>
                                <div class="col px-8 py-6">
                                    <div class="font-size-sm text-muted font-weight-bold">Commission</div>
                                    <div class="font-size-h4 font-weight-bolder">$233,600</div>
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col px-8 py-6 mr-8">
                                    <div class="font-size-sm text-muted font-weight-bold">Annual Taxes</div>
                                    <div class="font-size-h4 font-weight-bolder">$29,004</div>
                                </div>
                                <div class="col px-8 py-6">
                                    <div class="font-size-sm text-muted font-weight-bold">Annual Income</div>
                                    <div class="font-size-h4 font-weight-bolder">$1,480,00</div>
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 4-->
            </div>
            <div class="col-xl-8">
                <!--begin::Base Table Widget 6-->
                <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Penukaran Nasabah</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">lebih dari 200 nasabah</span>
                        </h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_3_1">Bulan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_3_2">Minggu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_3_3">Hari</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0">
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-borderless table-vertical-center">
                                <thead>
                                    <tr>
                                        <th class="p-0" style="width: 50px"></th>
                                        <th class="p-0" style="min-width: 150px"></th>
                                        <th class="p-0" style="min-width: 120px"></th>
                                        <th class="p-0" style="min-width: 70px"></th>
                                        <th class="p-0" style="min-width: 70px"></th>
                                        <th class="p-0" style="min-width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pl-0">
                                            <div class="symbol symbol-50 symbol-light mr-2 mt-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/avatars/001-boy.svg" class="h-75 align-self-end" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Brad Simmons</a>
                                            <span class="text-muted font-weight-bold d-block">Successful Fellas</span>
                                        </td>
                                        <td></td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold d-block font-size-sm">Paid</span>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$2,000,000</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="font-weight-bolder text-primary">+28%</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0">
                                            <div class="symbol symbol-50 symbol-light mr-2 mt-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/avatars/018-girl-9.svg" class="h-75 align-self-end" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Jessie Clarcson</a>
                                            <span class="text-muted font-weight-bold d-block">HTML, CSS Coding</span>
                                        </td>
                                        <td></td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold d-block font-size-sm">Paid</span>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$1,200,000</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="font-weight-bolder text-warning">+52%</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0">
                                            <div class="symbol symbol-50 symbol-light mr-2 mt-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/avatars/047-girl-25.svg" class="h-75 align-self-end" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Lebron Wayde</a>
                                            <span class="text-muted font-weight-bold d-block">ReactJS Developer</span>
                                        </td>
                                        <td></td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold d-block font-size-sm">Paid</span>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$3,400,000</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="font-weight-bolder text-danger">-34%</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0">
                                            <div class="symbol symbol-50 symbol-light mr-2 mt-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/avatars/014-girl-7.svg" class="h-75 align-self-end" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Natali Trump</a>
                                            <span class="text-muted font-weight-bold d-block">UI/UX Designer</span>
                                        </td>
                                        <td></td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold d-block font-size-sm">Paid</span>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$4,500,000</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="font-weight-bolder text-success">+48%</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0">
                                            <div class="symbol symbol-50 symbol-light mr-2 mt-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/avatars/043-boy-18.svg" class="h-75 align-self-end" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Kevin Leonard</a>
                                            <span class="text-muted font-weight-bold d-block">Art Director</span>
                                        </td>
                                        <td></td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold d-block font-size-sm">Paid</span>
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$35,600,000</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="font-weight-bolder text-info">+230%</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Base Table Widget 6-->
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-xl-4">
                <div class="row">
                    <div class="col-xl-12">
                        <!--begin::Stats Widget 11-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-circle symbol-50 symbol-light-danger mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-danger">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">750$</span>
                                        <span class="text-muted font-weight-bold mt-2">Weekly Income</span>
                                    </div>
                                </div>
                                <div id="kt_stats_widget_11_chart" class="card-rounded-bottom" data-color="danger" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 11-->
                    </div>
                    <div class="col-xl-12">
                        <!--begin::Stats Widget 10-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-circle symbol-50 symbol-light-info mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-info">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">+259</span>
                                        <span class="text-muted font-weight-bold mt-2">Sales Change</span>
                                    </div>
                                </div>
                                <div id="kt_stats_widget_10_chart" class="card-rounded-bottom" data-color="info" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 10-->
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!--begin::List Widget 14-->
                <div class="card card-custom gutter-b card-stretch">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Market Leaders</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-ver"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-header font-weight-bold py-4">
                                            <span class="font-size-lg">Choose Label:</span>
                                            <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
                                        </li>
                                        <li class="navi-separator mb-3 opacity-70"></li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-success">Customer</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-danger">Partner</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-warning">Suplier</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-primary">Member</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-dark">Staff</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-separator mt-3 opacity-70"></li>
                                        <li class="navi-footer py-4">
                                            <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                                            <i class="ki ki-plus icon-sm"></i>Add new</a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2">
                        <!--begin::Item-->
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                                <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-17.jpg')"></div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">Cup &amp; Green</a>
                                <span class="text-muted font-weight-bold font-size-sm my-1">Local, clean &amp; environmental</span>
                                <span class="text-muted font-weight-bold font-size-sm">Created by:
                                <span class="text-primary font-weight-bold">CoreAd</span></span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center py-lg-0 py-2">
                                <div class="d-flex flex-column text-right">
                                    <span class="text-dark-75 font-weight-bolder font-size-h4">24,900</span>
                                    <span class="text-muted font-size-sm font-weight-bolder">votes</span>
                                </div>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Item-->
                        <!--begin: Item-->
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                                <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-10.jpg')"></div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">Yellow Background</a>
                                <span class="text-muted font-weight-bold font-size-sm my-1">Strong abstract concept</span>
                                <span class="text-muted font-weight-bold font-size-sm">Created by:
                                <span class="text-primary font-weight-bold">KeenThemes</span></span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center py-lg-0 py-2">
                                <div class="d-flex flex-column text-right">
                                    <span class="text-dark-75 font-weight-bolder font-size-h4">70,380</span>
                                    <span class="text-muted font-weight-bolder font-size-sm">votes</span>
                                </div>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end: Item-->
                        <!--begin::Item-->
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                                <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-1.jpg')"></div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column flex-grow-1 pr-3">
                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">Nike &amp; Blue</a>
                                <span class="text-muted font-weight-bold font-size-sm my-1">Footwear overalls</span>
                                <span class="text-muted font-weight-bold font-size-sm">Created by:
                                <span class="text-primary font-weight-bold">Invision Inc.</span></span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center py-lg-0 py-2">
                                <div class="d-flex flex-column text-right">
                                    <span class="text-dark-75 font-size-h4 font-weight-bolder">7,200</span>
                                    <span class="text-muted font-size-sm font-weight-bolder">votes</span>
                                </div>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                                <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-9.jpg')"></div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">Desserts platter</a>
                                <span class="text-muted font-size-sm font-weight-bold my-1">Food trends &amp; reviews</span>
                                <span class="text-muted font-size-sm font-weight-bold">Created by:
                                <span class="text-primary font-weight-bold">Figma Studio</span></span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center py-lg-0 py-2">
                                <div class="d-flex flex-column text-right">
                                    <span class="text-dark-75 font-size-h4 font-weight-bolder">36,450</span>
                                    <span class="text-muted font-size-sm font-weight-bolder">votes</span>
                                </div>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="d-flex flex-wrap align-items-center">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60 symbol-2by3 flex-shrink-0 mr-4">
                                <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-12.jpg')"></div>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">Cup &amp; Green</a>
                                <span class="text-muted font-weight-bold font-size-sm my-1">Local, clean &amp; environmental</span>
                                <span class="text-muted font-weight-bold font-size-sm">Created by:
                                <span class="text-primary font-weight-bold">CoreAd</span></span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center py-lg-0 py-2">
                                <div class="d-flex flex-column text-right">
                                    <span class="text-dark-75 font-weight-bolder font-size-h4">23,900</span>
                                    <span class="text-muted font-size-sm font-weight-bolder">votes</span>
                                </div>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 14-->
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-lg-12 col-xxl-12">
                <!--begin::Advance Table Widget 9-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 py-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Agents Stats</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>
                        </h3>
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-info font-weight-bolder font-size-sm mr-3">New Arrivals</a>
                            <a href="#" class="btn btn-danger font-weight-bolder font-size-sm">Create</a>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0 pb-3">
                        <div class="tab-content">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table table-head-custom table-vertical-center table-head-bg table-borderless">
                                    <thead>
                                        <tr class="text-left">
                                            <th style="min-width: 250px" class="pl-7">
                                                <span class="text-dark-75">products</span>
                                            </th>
                                            <th style="min-width: 120px">earnings</th>
                                            <th style="min-width: 100px">comission</th>
                                            <th style="min-width: 100px">company</th>
                                            <th style="min-width: 100px">rating</th>
                                            <th style="min-width: 100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="pl-0 py-8">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50 symbol-light mr-4">
                                                        <span class="symbol-label">
                                                            <img src="assets/media/svg/avatars/001-boy.svg" class="h-75 align-self-end" alt="" />
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Brad Simmons</a>
                                                        <span class="text-muted font-weight-bold d-block">HTML, JS, ReactJS</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                                <span class="text-muted font-weight-bold">In Proccess</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$520</span>
                                                <span class="text-muted font-weight-bold">Paid</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Intertico</span>
                                                <span class="text-muted font-weight-bold">Web, UI/UX Design</span>
                                            </td>
                                            <td>
                                                <img src="assets/media/logos/stars.png" alt="image" style="width: 5rem" />
                                                <span class="text-muted font-weight-bold d-block">Best Rated</span>
                                            </td>
                                            <td class="pr-0 text-right">
                                                <a href="#" class="btn btn-light-success font-weight-bolder font-size-sm">View Offer</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0 py-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50 symbol-light mr-4">
                                                        <span class="symbol-label">
                                                            <img src="assets/media/svg/avatars/018-girl-9.svg" class="h-75 align-self-end" alt="" />
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Jessie Clarcson</a>
                                                        <span class="text-muted font-weight-bold d-block">C#, ASP.NET, MS SQL</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$23,000,000</span>
                                                <span class="text-muted font-weight-bold">Pending</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$1,600</span>
                                                <span class="text-muted font-weight-bold">Rejected</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Agoda</span>
                                                <span class="text-muted font-weight-bold">Houses &amp; Hotels</span>
                                            </td>
                                            <td>
                                                <img src="assets/media/logos/stars.png" alt="image" style="width: 5rem" />
                                                <span class="text-muted font-weight-bold d-block">Above Average</span>
                                            </td>
                                            <td class="pr-0 text-right">
                                                <a href="#" class="btn btn-light-success font-weight-bolder font-size-sm">View Offer</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0 py-8">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50 symbol-light mr-4">
                                                        <span class="symbol-label">
                                                            <img src="assets/media/svg/avatars/047-girl-25.svg" class="h-75 align-self-end" alt="" />
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Lebron Wayde</a>
                                                        <span class="text-muted font-weight-bold d-block">PHP, Laravel, VueJS</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$34,000,000</span>
                                                <span class="text-muted font-weight-bold">Paid</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$6,700</span>
                                                <span class="text-muted font-weight-bold">Paid</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">RoadGee</span>
                                                <span class="text-muted font-weight-bold">Transportation</span>
                                            </td>
                                            <td>
                                                <img src="assets/media/logos/stars.png" alt="image" style="width: 5rem" />
                                                <span class="text-muted font-weight-bold d-block">Best Rated</span>
                                            </td>
                                            <td class="pr-0 text-right">
                                                <a href="#" class="btn btn-light-success font-weight-bolder font-size-sm">View Offer</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0 py-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50 symbol-light mr-4">
                                                        <span class="symbol-label">
                                                            <img src="assets/media/svg/avatars/014-girl-7.svg" class="h-75 align-self-end" alt="" />
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Natali Trump</a>
                                                        <span class="text-muted font-weight-bold d-block">Python, PostgreSQL, ReactJS</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$2,600,000</span>
                                                <span class="text-muted font-weight-bold">Paid</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$14,000</span>
                                                <span class="text-muted font-weight-bold">Pending</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">The Hill</span>
                                                <span class="text-muted font-weight-bold">Insurance</span>
                                            </td>
                                            <td>
                                                <img src="assets/media/logos/stars.png" alt="image" style="width: 5rem" />
                                                <span class="text-muted font-weight-bold d-block">Average</span>
                                            </td>
                                            <td class="pr-0 text-right">
                                                <a href="#" class="btn btn-light-success font-weight-bolder font-size-sm">View Offer</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Advance Table Widget 9-->
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-xl-6">
                <!--begin::List Widget 10-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Notifications</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-ver"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                    <!--begin::Naviigation-->
                                    <ul class="navi">
                                        <li class="navi-header font-weight-bold py-5">
                                            <span class="font-size-lg">Add New:</span>
                                            <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
                                        </li>
                                        <li class="navi-separator mb-3 opacity-70"></li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Order</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="navi-icon flaticon2-calendar-8"></i>
                                                </span>
                                                <span class="navi-text">Members</span>
                                                <span class="navi-label">
                                                    <span class="label label-light-danger label-rounded font-weight-bold">3</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="navi-icon flaticon2-telegram-logo"></i>
                                                </span>
                                                <span class="navi-text">Project</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="navi-icon flaticon2-new-email"></i>
                                                </span>
                                                <span class="navi-text">Record</span>
                                                <span class="navi-label">
                                                    <span class="label label-light-success label-rounded font-weight-bold">5</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-separator mt-3 opacity-70"></li>
                                        <li class="navi-footer pt-5 pb-4">
                                            <a class="btn btn-light-primary font-weight-bolder btn-sm" href="#">More options</a>
                                            <a class="btn btn-clean font-weight-bold btn-sm d-none" href="#" data-toggle="tooltip" data-placement="right" title="Click to learn more...">Learn more</a>
                                        </li>
                                    </ul>
                                    <!--end::Naviigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <!--begin::Item-->
                        <div class="mb-6">
                            <!--begin::Content-->
                            <div class="d-flex align-items-center flex-grow-1">
                                <!--begin::Checkbox-->
                                <label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
                                    <input type="checkbox" value="1" />
                                    <span></span>
                                </label>
                                <!--end::Checkbox-->
                                <!--begin::Section-->
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column align-items-cente py-2 w-75">
                                        <!--begin::Title-->
                                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Daily Standup Meeting</a>
                                        <!--end::Title-->
                                        <!--begin::Data-->
                                        <span class="text-muted font-weight-bold">Due in 2 Days</span>
                                        <!--end::Data-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Label-->
                                    <span class="label label-lg label-light-primary label-inline font-weight-bold py-4">Approved</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="mb-6">
                            <!--begin::Content-->
                            <div class="d-flex align-items-center flex-grow-1">
                                <!--begin::Checkbox-->
                                <label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
                                    <input type="checkbox" value="1" />
                                    <span></span>
                                </label>
                                <!--end::Checkbox-->
                                <!--begin::Section-->
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column align-items-cente py-2 w-75">
                                        <!--begin::Title-->
                                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Group Town Hall Meet-up with showcase</a>
                                        <!--end::Title-->
                                        <!--begin::Data-->
                                        <span class="text-muted font-weight-bold">Due in 2 Days</span>
                                        <!--end::Data-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Label-->
                                    <span class="label label-lg label-light-warning label-inline font-weight-bold py-4">In Progress</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="mb-6">
                            <!--begin::Content-->
                            <div class="d-flex align-items-center flex-grow-1">
                                <!--begin::Checkbox-->
                                <label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
                                    <input type="checkbox" value="1" />
                                    <span></span>
                                </label>
                                <!--end::Checkbox-->
                                <!--begin::Section-->
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column align-items-cente py-2 w-75">
                                        <!--begin::Title-->
                                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Next sprint planning and estimations</a>
                                        <!--end::Title-->
                                        <!--begin::Data-->
                                        <span class="text-muted font-weight-bold">Due in 2 Days</span>
                                        <!--end::Data-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Label-->
                                    <span class="label label-lg label-light-success label-inline font-weight-bold py-4">Success</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="mb-6">
                            <!--begin::Content-->
                            <div class="d-flex align-items-center flex-grow-1">
                                <!--begin::Checkbox-->
                                <label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
                                    <input type="checkbox" value="1" />
                                    <span></span>
                                </label>
                                <!--end::Checkbox-->
                                <!--begin::Section-->
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column align-items-cente py-2 w-75">
                                        <!--begin::Title-->
                                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Sprint delivery and project deployment</a>
                                        <!--end::Title-->
                                        <!--begin::Data-->
                                        <span class="text-muted font-weight-bold">Due in 2 Days</span>
                                        <!--end::Data-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Label-->
                                    <span class="label label-lg label-light-danger label-inline font-weight-bold py-4">Rejected</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end: Item-->
                        <!--begin: Item-->
                        <div class="">
                            <!--begin::Content-->
                            <div class="d-flex align-items-center flex-grow-1">
                                <!--begin::Checkbox-->
                                <label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
                                    <input type="checkbox" value="1" />
                                    <span></span>
                                </label>
                                <!--end::Checkbox-->
                                <!--begin::Section-->
                                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column align-items-cente py-2 w-75">
                                        <!--begin::Title-->
                                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Data analytics research showcase</a>
                                        <!--end::Title-->
                                        <!--begin::Data-->
                                        <span class="text-muted font-weight-bold">Due in 2 Days</span>
                                        <!--end::Data-->
                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Label-->
                                    <span class="label label-lg label-light-warning label-inline font-weight-bold py-4">In Progress</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end: Item-->
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end: Card-->
                <!--end: List Widget 10-->
            </div>
            <div class="col-xl-6">
                <!--begin::Base Table Widget 1-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Trending Items</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>
                        </h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_1">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_2">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_1_3">Day</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0">
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-borderless table-vertical-center">
                                <thead>
                                    <tr>
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-200px"></th>
                                        <th class="p-0 min-w-100px"></th>
                                        <th class="p-0 min-w-40px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Top Authors</a>
                                            <span class="text-muted font-weight-bold d-block">Successful Fellas</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">65%</span>
                                                    <span class="text-muted font-size-sm font-weight-bold">Progress</span>
                                                </div>
                                                <div class="progress progress-xs w-100">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 65%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/015-telegram.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </th>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Popular Authors</a>
                                            <span class="text-muted font-weight-bold d-block">Most Successful</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">83%</span>
                                                    <span class="text-muted font-size-sm font-weight-bold">Progress</span>
                                                </div>
                                                <div class="progress progress-xs w-100">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 83%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/003-puzzle.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </th>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">New Users</a>
                                            <span class="text-muted font-weight-bold d-block">Awesome Users</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">47%</span>
                                                    <span class="text-muted font-size-sm font-weight-bold">Progress</span>
                                                </div>
                                                <div class="progress progress-xs w-100">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 47%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/005-bebo.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </th>
                                        <td class="py-6 pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Active Customers</a>
                                            <span class="text-muted font-weight-bold d-block">Best Customers</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">71%</span>
                                                    <span class="text-muted font-size-sm font-weight-bold">Progress</span>
                                                </div>
                                                <div class="progress progress-xs w-100">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 71%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/014-kickstarter.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </th>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Bestseller Theme</a>
                                            <span class="text-muted font-weight-bold d-block">Amazing Templates</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column w-100 mr-2">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">50%</span>
                                                    <span class="text-muted font-size-sm font-weight-bold">Progress</span>
                                                </div>
                                                <div class="progress progress-xs w-100">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Base Table Widget 1-->
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-lg-4">
                <!--begin::List Widget 8-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Trends</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-ver"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-header pb-1">
                                            <span class="text-primary text-uppercase font-weight-bold font-size-sm">Add new:</span>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-shopping-cart-1"></i>
                                                </span>
                                                <span class="navi-text">Order</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-calendar-8"></i>
                                                </span>
                                                <span class="navi-text">Event</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-graph-1"></i>
                                                </span>
                                                <span class="navi-text">Report</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-rocket-1"></i>
                                                </span>
                                                <span class="navi-text">Post</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="flaticon2-writing"></i>
                                                </span>
                                                <span class="navi-text">File</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0">
                        <!--begin::Item-->
                        <div class="mb-10">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-45 symbol-light mr-5">
                                    <span class="symbol-label">
                                        <img src="assets/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" alt="" />
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Top Authors</a>
                                    <span class="text-muted font-weight-bold">5 day ago</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Desc-->
                            <p class="text-dark-50 m-0 pt-5 font-weight-normal">A brief write up about the top Authors that fits within this section</p>
                            <!--end::Desc-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="mb-10">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-45 symbol-light mr-5">
                                    <span class="symbol-label">
                                        <img src="assets/media/svg/misc/015-telegram.svg" class="h-50 align-self-center" alt="" />
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">Popular Authors</a>
                                    <span class="text-muted font-weight-bold">5 day ago</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Desc-->
                            <p class="text-dark-50 m-0 pt-5 font-weight-normal">A brief write up about the Popular Authors that fits within this section</p>
                            <!--end::Desc-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-45 symbol-light mr-5">
                                    <span class="symbol-label">
                                        <img src="assets/media/svg/misc/014-kickstarter.svg" class="h-50 align-self-center" alt="" />
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1">New Users</a>
                                    <span class="text-muted font-weight-bold">5 day ago</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Desc-->
                            <p class="text-dark-50 m-0 pt-5 font-weight-normal">A brief write up about the New Users that fits within this section</p>
                            <!--end::Desc-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end: Card-->
                <!--end::List Widget 8-->
            </div>
            <div class="col-lg-8">
                <!--begin::Base Table Widget 2-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">New Arrivals</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>
                        </h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_2_1">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_2_2">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_2_3">Day</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2 pb-0">
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-borderless table-vertical-center">
                                <thead>
                                    <tr>
                                        <th class="p-0" style="width: 50px"></th>
                                        <th class="p-0" style="min-width: 150px"></th>
                                        <th class="p-0" style="min-width: 140px"></th>
                                        <th class="p-0" style="min-width: 120px"></th>
                                        <th class="p-0" style="min-width: 40px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Top Authors</a>
                                            <span class="text-muted font-weight-bold d-block">Successful Fellas</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">ReactJs, HTML</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">4600 Users</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/015-telegram.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Popular Authors</a>
                                            <span class="text-muted font-weight-bold d-block">Most Successful</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">Python, MySQL</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">7200 Users</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/003-puzzle.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">New Users</a>
                                            <span class="text-muted font-weight-bold d-block">Awesome Users</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">Laravel, Metronic</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">890 Users</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/005-bebo.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Active Customers</a>
                                            <span class="text-muted font-weight-bold d-block">Best Customers</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">AngularJS, C#</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">6370 Users</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 py-5">
                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                <span class="symbol-label">
                                                    <img src="assets/media/svg/misc/014-kickstarter.svg" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Bestseller Theme</a>
                                            <span class="text-muted font-weight-bold d-block">Amazing Templates</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">ReactJS, Ruby</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted font-weight-bold">354 Users</span>
                                        </td>
                                        <td class="text-right pr-0">
                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Base Table Widget 2-->
            </div>
        </div>
        <!--end::Row-->
        <!--end::Dashboard-->
    </div>

    @push('script')
       
    @endpush

    @endvolt
</x-layouts.app>