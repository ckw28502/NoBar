
<style>
  body {
  background-color: #fbfbfb;
}
@media (min-width: 991.98px) {
  main {
    padding-left: 240px;
  }
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  padding: 58px 0 0; /* Height of navbar */
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
  width: 240px;
  z-index: 600;
}

@media (max-width: 991.98px) {
  .sidebar {
    width: 100%;
  }
}
.sidebar .active {
  border-radius: 5px;
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: 0.5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}
</style>
<!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <span href="#" class="list-group-item list-group-item-action py-2 ripple pointer" aria-current="true" onclick="PageChange(event)" target="0" id="nav_dashboard">
            <i class="fas fa-tachometer-alt fa-fw me-3"></i>Main dashboard
        </span>
        
        <span onclick="PageChange(event)" href="" target="1" id="nav_report" class="list-group-item list-group-item-action py-2 ripple active"><i class="fas fa-building fa-fw me-3" ></i>
            <span>Report</span>
            
        </span>

        <span  href="" target="1" id="nav_report" class="list-group-item list-group-item-action py-2 ripple active">
            <a data-mdb-toggle="collapse" href="#sidenav-collapse-1-0-1" role="button" aria-expanded="true" tabindex="1">
              <i class="fas fa-gem fa-fw me-3"> MDB Pro</i>
              
            <i class="fas fa-angle-down rotate-icon" style="transition-property: transform; transform: rotate(180deg);"></i>
          </a>

            <ul class="sidenav-collapse collapse show" id="sidenav-collapse-1-0-1" style="transition-property: height;">
              <li class="sidenav-item" style="border-bottom: 1px solid #eee;"> 
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/" tabindex="1">About MDB Pro</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/installation/" tabindex="1">Installation</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/plugins-installation/" tabindex="1">Plugins installation</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/quick-start/" tabindex="1">Quick start</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/faq/" tabindex="1">FAQ</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/git/" tabindex="1">Git &amp; repository</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/support/" tabindex="1">Premium support</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/updates/" tabindex="1">Updates</a>
          
              </li>
              <li class="sidenav-item">
                <a class="sidenav-link ripple-surface" href="/docs/standard/pro/enterprise/" tabindex="1">Enterprise &amp; Resellers</a>
          
              </li>
            </ul>
        </span>
        
      </div>
    </div>
  </nav>
  <!-- Sidebar -->

  <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button
        class="navbar-toggler"
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand" href="#">
        NOBAR MANAGER
      </a>
      <!-- Search form -->
      <form class="d-none d-md-flex input-group w-auto my-auto">
        <input
          autocomplete="off"
          type="search"
          class="form-control rounded"
          placeholder='Search (ctrl + "/" to focus)'
          style="min-width: 225px;"
        />
        <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
      </form>

      <!-- Right links -->
      <ul class="navbar-nav ms-auto d-flex flex-row">
        <a href="" class="btn btn-primary">LOGOUT</a>
      </ul>
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 58px;">
  <div class="container pt-4">
    @yield('body-nav')
  </div>
</main>
<!--Main layout-->
<script>
  
</script>