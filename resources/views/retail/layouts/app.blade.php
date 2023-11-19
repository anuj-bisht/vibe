<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description"
    content="MVS admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin panel with unlimited possibilities.">
  <meta name="keywords"
    content="admin panel, MVS admin panel, dashboard panel, flat admin panel, responsive admin panel, web app">
  <meta name="author" content="MVS">
  <title>Vibe</title>
  <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico')}}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">
  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/apexcharts.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css')}}">




  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/select.dataTables.min.css') }}">
  {{--
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.min.css') }}"> --}}
  <!-- END: Vendor CSS-->
  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/charts/chart-apex.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css')}}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice-list.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  {{--
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">







  @yield('styles') {{--
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/custom/global.css') }}"> --}}
  @guest <style>
    .body_cover_image::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      top: 0px;
      left: 0px;
    }
  </style> @endguest {{-- @viteReactRefresh
  @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static body_cover_image" data-open="click"
  data-menu="vertical-menu-modern" data-col="" @guest style="background-image: url(https://vibecode.paramsoft.co.in/public/masters/img/login-bg.jpg);
background-size: cover;
background-position: center;
background-repeat: no-repeat;
position: relative;" @endguest>
  <!-- BEGIN: Header--> @auth() <nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow"
    style="background-color: black;">
    <div class="navbar-container d-flex content">
      <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo-white.png" alt="">
      <ul class="nav navbar-nav align-items-center ml-auto">




        <li class="mr-1">
          <div class="user-nav d-sm-flex d-none">
            @php $data = Modules\Corporate\Entities\CorporateProfile::where('is_retail',1)->get();
            $retail_session_data=Session::get('retail');
            @endphp

            <select class="form-control" id="retailselect" style="min-width:200px;" onchange="getRetailor()">
              @foreach($data as $retail)
              <option @if($retail_session_data->id == $retail->id) selected @endif value="{{ $retail->id }}" >
                {{$retail->name }}</option>

              @endforeach
            </select>

          </div>
        </li>

        <li class="nav-item dropdown dropdown-user ">
          <a class="nav-link dropdown-toggle dropdown-user-link text-white" id="dropdown-user"
            href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="user-nav d-sm-flex d-none">
              <span class="user-name font-weight-bolder">{{ auth()->user()->name }}</span>
              <span class="user-status">Admin</span>
            </div>
            <span class="avatar">
              <img class="round" src="{{asset('app-assets/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                height="40" width="40">
              <span class="avatar-status-online"></span>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
            <a class="dropdown-item" href="page-account-settings.html">
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                <i class="mr-50" data-feather="power"></i> Logout </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
              <a class="dropdown-item" href="{{ route('flushRetailSession') }}">
                <i class="mr-50" data-feather="power"></i> Admin Dashboard</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto">
          <a class="navbar-brand" href="html/ltr/vertical-menu-panel/index.html">
            <span class="brand-logo"></span>
            <h2 class="brand-text" style="color:#009973;">Vibe</h2>
          </a>
        </li>
        <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
            <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
            <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
              data-ticon="disc"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>

            <span class="menu-title text-truncate" data-i18n="eCommerce">MRN</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('purchase.listing') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('purchase.listing') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>

                <span class="menu-title text-truncate" data-i18n="eCommerce">Pending MRN</span>
              </a>
            </li>

            <li class="{{ Request::routeIs('purchase.validated.listing') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('purchase.validated.listing') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Validated MRN</span>
              </a>
            </li>

          </ul>
        </li>

        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>

            <span class="menu-title text-truncate" data-i18n="eCommerce">GRN</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('retail.create.grn') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('retail.create.grn') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>

                <span class="menu-title text-truncate" data-i18n="eCommerce">Create GRN</span>
              </a>
            </li>

             <li class="{{ Request::routeIs('retail.pending.grn') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('retail.pending.grn') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Pending Grn</span>
              </a>
            </li> 
            <li class="{{ Request::routeIs('retail.validated.grn') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('retail.validated.grn') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Validated Grn</span>
              </a>
            </li> 

          </ul>
        </li>

        <li class="{{ Request::routeIs('retail.products') ? 'active' : '' }} nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="{{route('retail.products')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Products</span>
          </a>
        </li>

        <li class="{{ Request::routeIs('retail.stockAudit') ? 'active' : '' }} nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="{{route('retail.stockAudit')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>

            <span class="menu-title text-truncate" data-i18n="eCommerce">Stock Audit</span>
          </a>
         
        </li>

        
        <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
            <i data-feather="file-text"></i>
            <span class="menu-title text-truncate" data-i18n="Invoice">Customer</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('retailcustomer.invoiceList') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('retailcustomer.invoiceList') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Invoice List</span>
              </a>
            </li>
            <li class="{{ Request::routeIs('retailcustomer.create') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('retailcustomer.create') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Customer Create</span>
              </a>
            </li>
            <li class="{{ Request::routeIs('customer.create.invoice') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('customer.create.invoice') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Create Invoice</span>
              </a>
            </li>
          </ul>
        </li>


        <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
            <i data-feather="file-text"></i>
            <span class="menu-title text-truncate" data-i18n="Invoice">Account Management</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('incoming.pettycash') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('incoming.pettycash') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Incoming Petty Cash</span>
              </a>
            </li>
            <li class="{{ Request::routeIs('retailpetty.cash.edit') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('retailpetty.cash.edit') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Petty Cash</span>
              </a>
            </li>
            <li class="{{ Request::routeIs('retail.cashtransfer') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('retail.cashtransfer') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Cash Transfer</span>
              </a>
            </li>
          </ul>
        </li>

   
    
      </ul>


    </div>
  </div>
  <!-- END: Main Menu--> @endauth
  <!-- BEGIN: Content-->
  <div class="app-content content ">
    <div class="content-overlay"></div>
    {{-- <div class="header-navbar-shadow"></div> --}}
    <div class="content-wrapper">
      <div class="content-header row"></div>
      <div class="content-body">
        @yield('retail_content')

      </div>
    </div>
  </div>
  <!-- END: Content-->
  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>
  <!-- BEGIN: Footer-->

  <button class="btn btn-primary btn-icon scroll-top" type="button">
    <i data-feather="arrow-up"></i>
  </button>

  <script src="{{ asset('app-assets/vendors/js/vendors.min.js')}}"></script>

  <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}">
  </script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
  {{-- <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script> --}}
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}">
  </script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js') }}">
  </script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') }}"></script>

  <script src="{{ asset('app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js')}}"></script>



  <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
  <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
  <script src="{{asset('app-assets/js/scripts/extensions/ext-component-toastr.js')}}"></script>

  <script src="{{ asset('app-assets/vendors/js/extensions/moment.min.js')}}"></script>

  <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
  <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
  <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
  <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
  <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
  <script src="{{ asset('app-assets/js/core/app-menu.js')}}"></script>
  <script src="{{ asset('app-assets/js/core/app.js')}}"></script>
  <script src="{{ asset('app-assets/js/scripts/pages/app-invoice-list.js')}}"></script>
  <script src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js')}}"></script>
  <script src="{{asset('app-assets/js/scripts/pages/app-invoice.js')}}"></script>
  <script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
  <script src="{{asset('app-assets/js/scripts/components/components-collapse.js')}}"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js"
    integrity="sha512-zJYu9ICC+mWF3+dJ4QC34N9RA0OVS1XtPbnf6oXlvGrLGNB8egsEzu/5wgG90I61hOOKvcywoLzwNmPqGAdATA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
  <script src="https://unpkg.com/vue-select@latest"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>
  <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>


  {{-- <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script> --}}


  <script>
    $(window).on('load', function() {
        if (feather) {
          feather.replace({
            width: 14,
            height: 14
          });
        }

      
        $("input").not($(":button")).keypress(function (evt) {
            if (evt.keyCode == 13) {
                iname = $(this).val();
                if (iname !== 'Submit') {
                    var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
                    var index = fields.index(this);
                    if (index > -1 && (index + 1) < fields.length) {
                        fields.eq(index + 1).focus();
                    }
                    return false;
                }
            }
        });
        $("select").not($(":button")).keypress(function (evt) {
            if (evt.keyCode == 13) {
                iname = $(this).val();
                if (iname !== 'Submit') {
                    var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
                    var index = fields.index(this);
                    if (index > -1 && (index + 1) < fields.length) {
                        fields.eq(index + 1).focus();
                    }
                    return false;
                }
            }
        });
      })
      $("#retail").select2({
    placeholder: "Select an retail",
});
function getRetailor(){
  var retail_id= $('#retailselect').find(':selected').val();
  axios.get("{{ route('changeRetailSession') }}?retail_id="+retail_id).then(res => {
    window.location.reload();
                });

}

  </script>
  @yield('scripts')
  @stack('scripts')
</body>
<!-- END: Body-->

</html>