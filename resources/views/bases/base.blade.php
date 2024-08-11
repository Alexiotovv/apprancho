<!DOCTYPE html>
<html lang="es">
  <!-- [Head] start -->

  
<!-- Mirrored from html.phoenixcoded.net/light-able/bootstrap/widget/w_data.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 May 2024 15:07:39 GMT -->
<head>
    <title>Dashboard | Rancho</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="description"
      content="Light Able admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective."
    />
    <meta name="author" content="phoenixcoded"/>

    <!-- [Favicon] icon -->
    <link rel="icon" href="../../../assets/images/favicon.svg" type="image/x-icon" />
    <script src="../../../assets/js/jquery-3.7.1.min.js"></script>



<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="../../../assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="../../../assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="../../../assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="../../../assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../../../assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../../../assets/css/style-preset.css" >

@yield('css')

</head>
  <!-- [Head] end -->



  @if (Auth::check())
  
<!-- [Body] Start -->

      <body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
          <!-- [ Pre-loader ] start -->
      <div class="loader-bg">
        <div class="loader-track">
          <div class="loader-fill"></div>
        </div>
      </div>
      <!-- [ Pre-loader ] End -->
      <!-- [ Sidebar Menu ] start -->
      <nav class="pc-sidebar">
        <div class="navbar-wrapper">
          <div class="m-header">
            
              
              <h6>SGA-Sistema de Gestión de Alimentos</h6>
              <span class="badge bg-brand-color-2 rounded-pill ms-2 theme-version">v1.0</span>
            </a>
          </div>
          <div class="navbar-content">
            <ul class="pc-navbar">
              <li class="pc-item pc-caption">
                <label>Navigation</label>
              </li>
            
              <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link"
                  ><span class="pc-micon"> <i class="ph-duotone ph-layout"></i></span><span class="pc-mtext">Opciones</span
                  ><span class="pc-arrow"><i data-feather="chevron-right"></i></span
                ></a>
                <ul class="pc-submenu">
                  <li class="pc-item"><a class="pc-link" href="{{route('home')}}">Home</a></li>
                  <li class="pc-item"><a class="pc-link" href="{{route('empresas.index')}}">Empresas</a></li>
                  <li class="pc-item"><a class="pc-link" href="{{route('trabajadores.index')}}">Trabajadores</a></li>
                  <li class="pc-item"><a class="pc-link" href="{{route('planillas.index')}}">Planillas</a></li>
                  <li class="pc-item"><a class="pc-link" href="{{route('planillas.ticket.index')}}">Ticket</a></li>
                  
                  
                  
                </ul>
                <ul class="pc-submenu">
                </ul>
              </li>

              @if(auth()->user()->role === "admin")
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link"
                    ><span class="pc-micon"> <i class="ph-duotone ph-layout"></i></span><span class="pc-mtext">Gestión</span
                    ><span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                  </a>
                <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="{{route('users')}}">Usuarios</a></li>
                    
                </ul>  
              @endif
                


                <ul class="pc-submenu">
                </ul>
              </li>

            </ul>

          </div>

        </div>
      </nav>
      <!-- [ Sidebar Menu ] end -->
      <!-- [ Header Topbar ] start -->
      <header class="pc-header">
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <!-- ======= Menu collapse Icon ===== -->
          <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="dropdown pc-h-item d-inline-flex d-md-none">
            <a
              class="pc-head-link dropdown-toggle arrow-none m-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false"
            >
              <i class="ph-duotone ph-magnifying-glass"></i>
            </a>
            <div class="dropdown-menu pc-h-dropdown drp-search">
              <form class="px-3">
                <div class="mb-0 d-flex align-items-center">
                  <input type="search" class="form-control border-0 shadow-none" placeholder="Search..." />
                  <button class="btn btn-light-secondary btn-search">Search</button>
                </div>
              </form>
            </div>
          </li>
          <li class="pc-h-item d-none d-md-inline-flex">
            <form class="form-search">

            </form>
          </li>
        </ul>
      </div>
      <!-- [Mobile Media Block end] -->
      <div class="ms-auto">
        <ul class="list-unstyled">
          <li class="dropdown pc-h-item">
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false"
            >
              <i class="ph-duotone ph-sun-dim"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
              <a href="#!" class="dropdown-item" onclick="cambiar_modo('dark')">
                <i class="ph-duotone ph-moon"></i>
                <span>Dark</span>
              </a>
              <a href="#!" class="dropdown-item" onclick="cambiar_modo('light')">
                <i class="ph-duotone ph-sun-dim"></i>
                <span>Light</span>
              </a>

            </div>
          </li>

          <li class="dropdown pc-h-item">
            Hola, {{ auth()->user()->name }}
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false"
            >
              <i class="ph-duotone ph-diamonds-four"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
              {{-- <a href="#!" class="dropdown-item">
                <i class="ph-duotone ph-user"></i>
                <span>My Account</span>
              </a>
       
              <a href="#!" class="dropdown-item">
                <i class="ph-duotone ph-lock-key"></i>
                <span>Lock Screen</span>
              </a> --}}
              <a href="{{route('logout')}}" class="dropdown-item" id="Salir">
                <i class="ph-duotone ph-power"></i>
                <span>Salir</span>
              </a>
            </div>
          </li>
      
          <li class="dropdown pc-h-item header-user-profile">
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              data-bs-auto-close="outside"
              aria-expanded="false"
            >
            
              <img src="../../../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar" />
            </a>
        
          </li>
        </ul>
        </div>
        </div>
      </header>
      <!-- [ Header ] end -->


      <!-- [ Main Content ] start -->
      <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
        <!-- [ Main Content ] end -->
      </div>
      <!-- [ Main Content ] end -->
      <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
          <div class="row">
            <div class="col-sm-6 my-1">
              
            </div>
            <div class="col-sm-6 ms-auto my-1">
              
            </div>
          </div>
        </div>
      </footer>

      @else
      <div class="row">
        <div class="col-md-4">
          <a type="button" class="btn btn-primary" href="{{route('credentials')}}">Inicie sesión</a>
        </div>
      </div>
      @endif


 <!-- Required Js -->
<script src="../../../assets/js/plugins/popper.min.js"></script>
<script src="../../../assets/js/plugins/simplebar.min.js"></script>
<script src="../../../assets/js/plugins/bootstrap.min.js"></script>
<script src="../../../assets/js/fonts/custom-font.js"></script>
<script src="../../../assets/js/pcoded.js"></script>
<script src="../../../assets/js/plugins/feather.min.js"></script>
<script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>
{{-- <script src="../../../assets/js/plugins/dataTables.min.js"></script> --}}
{{-- <script src="../../../assets/js/plugins/dataTables.bootstrap5.min.js"></script> --}}
{{-- <script src="../../../assets/js/plugins/dataTables.responsive.min.js"></script> --}}
{{-- <script src="../../../assets/js/plugins/responsive.bootstrap5.min.js"></script> --}}



<script>layout_change('light');</script>




<script>layout_sidebar_change('light');</script>



<script>change_box_container('false');</script>


<script>layout_caption_change('true');</script>




<script>layout_rtl_change('false');</script>


<script>preset_change("preset-1");</script>


<script>
  function cambiar_modo(modo){
    layout_change(modo);
    localStorage.setItem('modo',modo)

  }

  $(document).ready(function() {
    let modo = localStorage.getItem('modo');
    layout_change(modo);
  });
</script>

  </body>
  <!-- [Body] end -->

<!-- Mirrored from html.phoenixcoded.net/light-able/bootstrap/widget/w_data.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 May 2024 15:07:45 GMT -->




@yield('js')

</html>
