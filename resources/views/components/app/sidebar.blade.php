<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand d-flex align-items-center m-0"
      href=" https://demos.creative-tim.com/corporate-ui-dashboard/pages/dashboard.html " target="_blank">
      <span class="font-weight-bold text-lg">{{ Config::get('app.name') }}</span>
    </a>
  </div>
  <div class="collapse navbar-collapse px-4  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link  {{ is_current_route('dashboard') ? 'active' : '' }}"
          href="{{ route('dashboard') }}">
          <div
            class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
            <svg width="30px" height="30px" viewBox="0 0 48 48" version="1.1"
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <title>dashboard</title>
              <g id="dashboard" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="template" transform="translate(12.000000, 12.000000)" fill="#FFFFFF"
                  fill-rule="nonzero">
                  <path class="color-foreground"
                    d="M0,1.71428571 C0,0.76752 0.76752,0 1.71428571,0 L22.2857143,0 C23.2325143,0 24,0.76752 24,1.71428571 L24,5.14285714 C24,6.08962286 23.2325143,6.85714286 22.2857143,6.85714286 L1.71428571,6.85714286 C0.76752,6.85714286 0,6.08962286 0,5.14285714 L0,1.71428571 Z"
                    id="Path"></path>
                  <path class="color-background"
                    d="M0,12 C0,11.0532171 0.76752,10.2857143 1.71428571,10.2857143 L12,10.2857143 C12.9468,10.2857143 13.7142857,11.0532171 13.7142857,12 L13.7142857,22.2857143 C13.7142857,23.2325143 12.9468,24 12,24 L1.71428571,24 C0.76752,24 0,23.2325143 0,22.2857143 L0,12 Z"
                    id="Path"></path>
                  <path class="color-background"
                    d="M18.8571429,10.2857143 C17.9103429,10.2857143 17.1428571,11.0532171 17.1428571,12 L17.1428571,22.2857143 C17.1428571,23.2325143 17.9103429,24 18.8571429,24 L22.2857143,24 C23.2325143,24 24,23.2325143 24,22.2857143 L24,12 C24,11.0532171 23.2325143,10.2857143 22.2857143,10.2857143 L18.8571429,10.2857143 Z"
                    id="Path"></path>
                </g>
              </g>
            </svg>
          </div>
          <span class="nav-link-text ms-1">Home</span>
        </a>
      </li>
      @if(auth()->user()->type === 'admin')
        <x-app.sidebar-admin/>
      @endif
    </ul>
  </div>
</aside>
