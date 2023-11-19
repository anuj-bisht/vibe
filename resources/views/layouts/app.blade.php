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
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/animate/animate.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />






  @yield('styles')
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
  <!-- BEGIN: Header--> @auth() 
  <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow" style="background-color: black;">
    <div class="navbar-container d-flex content">
      <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo-white.png" alt="">
      <ul class="nav navbar-nav align-items-center ml-auto">
        <li class="mr-1">
          <div class="user-nav d-sm-flex d-none">
            <a type="button" class="btn btn-info waves-effect waves-float waves-light" href="{{ route('isRetailSession') }}">Retail Panel</a>
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

          </div>
        </li>
      </ul>
    </div>
  </nav>
  
  <!-- END: Header-->
  <!-- BEGIN: Main Menu-->
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
        <li class=" nav-item  ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="index.html">
            <i data-feather="home"></i>
            <span class="menu-title text-truncate" data-i18n="Dashboards">Home</span>
            <span class=""></span>
          </a>
        </li>
        <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-user">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span class="menu-title text-truncate" data-i18n="user_management">User Management</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('user.listing') || Request::routeIs('user.create') || Request::routeIs('user.view') || Request::routeIs('user.edit') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('user.listing') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Add User</span>
              </a>
            </li>

            


            <li class="{{ Request::routeIs('role.listing') || Request::routeIs('create.role') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('role.listing') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Add Role Manager</span>
              </a>
            </li>

            <li>
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('role.listing') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Permission</span>
              </a>
              <ul class="menu-content">
                <li class="{{ Request::routeIs('permission.listing') ? 'active' : '' }}">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('permission.listing') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-item" data-i18n="List">Listing</span>
                  </a>
                </li>
                <li>
                </li>
              </ul>
            </li>
          </ul>
        </li>

        <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-pocket">
              <path d="M4 3h16a2 2 0 0 1 2 2v6a10 10 0 0 1-10 10A10 10 0 0 1 2 11V5a2 2 0 0 1 2-2z"></path>
              <polyline points="8 10 12 14 16 10"></polyline>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">All Master</span>
          </a>
          <ul class="menu-content">

            <li>
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('role.listing')}}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Product Master</span>
              </a>
              <ul class="menu-content">
                <li class="{{ Request::routeIs('product.index') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('product.index') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Create Product</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('product.create.barcode') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('product.create.barcode') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Print Barcode</span>
                  </a>
                </li>


                <li class="{{ Request::routeIs('master.composition') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.composition') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Composition Master</span>
                  </a>
                </li>
                <li class="{{ Request::routeIs('master.gender') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.gender') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Gender Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.fabric') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.fabric') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Todo">Fabric Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.style') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.style') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Calendar">Style Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.color') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.color') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Color Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.season') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.season') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Season Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.ean') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.ean') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">EAN Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.hsn') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.hsn') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">HSN Master</span>
                  </a>
                </li>

              </ul>
            </li>


            <li>
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Category Master</span>
              </a>
              <ul class="menu-content">
                <li class="{{ Request::routeIs('master.maincategory') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.maincategory') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Main Category</span>
                  </a>
                </li>
                <li class="{{ Request::routeIs('master.category') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.category') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Todo">Category</span>
                  </a>
                </li>
                <li class="{{ Request::routeIs('master.subcategory') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.subcategory') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Calendar">Sub Category</span>
                  </a>
                </li>
                <li class="{{ Request::routeIs('master.subsubcategory') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.subsubcategory') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Sub Sub Category</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.fit') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.fit') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Fit Master</span>
                  </a>
                </li>
              </ul>
            </li>

            <li>
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Production Mas</span>
              </a>
              <ul class="menu-content">
                <li class="{{ Request::routeIs('master.cutting') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.cutting') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Cutting Ratio Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('Allplan') ? 'active' : '' }} nav-item ">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('Allplan') }}">
                    <i data-feather="shopping-cart"></i>
                    <span class="menu-title text-truncate" data-i18n="eCommercef">Cutting Plan</span>
                  </a>
                </li>
              </ul>
            </li>

            <li>
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Client Master</span>
              </a>
              <ul class="menu-content">
                <li class="{{ Request::routeIs('corporate.index') ? 'active' : '' }} nav-item ">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('corporate.index') }}">
                    <i data-feather="shopping-cart"></i>
                    <span class="menu-title text-truncate" data-i18n="eCommerce">Create Corporate</span>
                  </a>
                </li>
                <li class="{{ Request::routeIs('master.commission') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.commission') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Commission Master</span>
                  </a>
                </li>
                <li class="{{ Request::routeIs('master.tax') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.tax') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Tax Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.discount') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.discount') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Discount Master</span>
                  </a>
                </li>

                <li class="{{ Request::routeIs('master.agent') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.agent') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Agent Master</span>
                  </a>
                </li>


                <li class="{{ Request::routeIs('master.crm') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.crm') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">CRM Master</span>
                  </a>
                </li>


                <li class="{{ Request::routeIs('master.transport') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.transport') }}">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate" data-i18n="Kanban">Transport Master</span>
                  </a>
                </li>
              </ul>
            </li>

            <li>
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Retail Master</span>
              </a>
              <ul class="menu-content">
                <li class="{{ Request::routeIs('master.pettyhead') ? 'active' : '' }} nav-item">
                  <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                    href="{{ route('master.pettyhead') }}">
                    <i data-feather="check-square"></i>
                    <span class="menu-title text-truncate" data-i18n="Todo">Petty Head Master</span>
                  </a>
                </li>
              </ul>
            </li>
            {{-- <li class=" nav-item">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('master.size') }}">
                <i data-feather="grid"></i>
                <span class="menu-title text-truncate" data-i18n="Kanban">Size Master</span>
              </a>
            </li> --}}

            {{-- <li class=" nav-item">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('master.margin') }}">
                <i data-feather="grid"></i>
                <span class="menu-title text-truncate" data-i18n="Kanban">Margin Master</span>
              </a>
            </li> --}}
            {{-- <li class=" nav-item">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('master.collection') }}">
                <i data-feather="grid"></i>
                <span class="menu-title text-truncate" data-i18n="Kanban">Collection Master</span>
              </a>
            </li> --}}
          </ul>
        </li>

        {{-- <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-briefcase">
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span class="menu-title text-truncate" data-i18n="Invoice">Product</span>
          </a>
          <ul class="menu-content">
          </ul>
        </li> --}}


        <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
            <i data-feather="file-text"></i>
            <span class="menu-title text-truncate" data-i18n="Invoice">GRN Management</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('corporate.all.grn') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('corporate.all.grn') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">All GRN</span>
              </a>
            </li>
          </ul>
        </li>

        <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-users">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span class="menu-title text-truncate" data-i18n="Invoice">Customer</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('customer.index') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('customer.index') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Listing</span>
              </a>
            </li>
          </ul>
        </li>

        <li class=" nav-item">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-gift">
              <polyline points="20 12 20 22 4 22 4 12"></polyline>
              <rect x="2" y="7" width="20" height="5"></rect>
              <line x1="12" y1="22" x2="12" y2="7"></line>
              <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
              <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
            </svg>
            <span class="menu-title text-truncate" data-i18n="Invoice">Promotion Management</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('coupon.list') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('coupon.list') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Coupon List</span>
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
            <li class="{{ Request::routeIs('petty.index') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('petty.index') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Petty Cash</span>
              </a>
            </li>
            <li class="{{ Request::routeIs('cash.transfer.index') ? 'active' : '' }}">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('cash.transfer.index') }}">
                <i data-feather="circle"></i>
                <span class="menu-item" data-i18n="List">Cash Transfer History</span>
              </a>
            </li>
          </ul>
        </li>
        {{-- <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-user">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Corporate Master</span>
          </a>
          <ul class="menu-content">


          </ul>
        </li> --}}
        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-home">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
              <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Warehouses</span>
          </a>
          <ul class="menu-content">
            {{-- <li class=" nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('warehouse.create') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Add Warehouse</span>
              </a>
            </li> --}}
            <li class="{{ Request::routeIs('warehouse.listing.index') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('warehouse.listing.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Create Warehouse</span>
              </a>
            </li>
            <li class="{{ Request::routeIs('unfinishedwarehouse.index') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('unfinishedwarehouse.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Unfinished Warehouse</span>
              </a>
            </li>
            <li class="{{ Request::routeIs('warehouse.index') ? 'active' : '' }}  nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('warehouse.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Finished </span>
              </a>
            </li>
            {{-- <li class="{{ Request::routeIs('onlinewarehouse.index') ? 'active' : '' }}  nav-item">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('onlinewarehouse.index') }}">
                <i data-feather="check-square"></i>
                <span class="menu-title text-truncate" data-i18n="Todo">Online Warehouses</span>
              </a>
            </li> --}}
          </ul>
        </li>

        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-square">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Report</span>
          </a>
          <ul class="menu-content">
            <li class=" nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('productSummary.report') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Product Summary</span>
              </a>
            </li>

          </ul>
        </li>

        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-list">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Order</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('order.index') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('order.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Order List</span>
              </a>
            </li>

          </ul>
        </li>
        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-list">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Picklist</span>
          </a>
          <ul class="menu-content">


            <li class="{{ Request::routeIs('pick.index') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('pick.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Picklist Listing</span>
              </a>
            </li>

            <li class="{{ Request::routeIs('picklist.generator') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('picklist.generator') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Picklist Generate</span>
              </a>
            </li>
          </ul>
        </li>

        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-list">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Invoice</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('picklist.invoice.index') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('picklist.invoice.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Invoice Listing</span>
              </a>
            </li>

            <li class="{{ Request::routeIs('picklist.invoice') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('picklist.invoice') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Invoice Generate</span>
              </a>
            </li>

            <li class="{{ Request::routeIs('picklist.invoice.difference') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('picklist.invoice.difference') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Invoice Difference</span>
              </a>
            </li>
          </ul>
        </li>
        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-list">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Goods</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('goods.returns.index') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('goods.returns.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Good Return</span>
              </a>
            </li>

          </ul>
        </li>



        <li class=" nav-item ">
          <a class="d-flex align-items-center" style="font-weight: 900; color: black;" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="feather feather-list">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            <span class="menu-title text-truncate" data-i18n="eCommerce">Stock</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::routeIs('stock.audit.index') ? 'active' : '' }} nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('stock.audit.index') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Audit Listing</span>
              </a>
            </li>

            {{-- <li class=" nav-item ">
              <a class="d-flex align-items-center" style="font-weight: 900; color: black;"
                href="{{ route('stock.audit.status') }}">
                <i data-feather="shopping-cart"></i>
                <span class="menu-title text-truncate" data-i18n="eCommerce">Auditing Status</span>
              </a>
            </li> --}}
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
        @yield('content')

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
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js') }}"></script>
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
  <script src="{{asset('app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
  <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>
  <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js" integrity="sha512-zJYu9ICC+mWF3+dJ4QC34N9RA0OVS1XtPbnf6oXlvGrLGNB8egsEzu/5wgG90I61hOOKvcywoLzwNmPqGAdATA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
  <script src="https://unpkg.com/vue-select@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
  </script>
  @yield('scripts')
  @stack('scripts')
</body>
<!-- END: Body-->

</html>