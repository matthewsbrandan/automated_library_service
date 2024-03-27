<li class="nav-item">
  <a class="nav-link {{ is_current_route('wallet') ? 'active' : '' }} " href="{{ route('wallet') }}">
    <div
      class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
      <svg width="30px" height="30px" viewBox="0 0 48 48" version="1.1"
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>wallet</title>
        <g id="wallet" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="credit-card" transform="translate(12.000000, 15.000000)" fill="#FFFFFF">
            <path class="color-background"
              d="M3,0 C1.343145,0 0,1.343145 0,3 L0,4.5 L24,4.5 L24,3 C24,1.343145 22.6569,0 21,0 L3,0 Z"
              id="Path" fill-rule="nonzero"></path>
            <path class="color-foreground"
              d="M24,7.5 L0,7.5 L0,15 C0,16.6569 1.343145,18 3,18 L21,18 C22.6569,18 24,16.6569 24,15 L24,7.5 Z M3,13.5 C3,12.67155 3.67158,12 4.5,12 L6,12 C6.82842,12 7.5,12.67155 7.5,13.5 C7.5,14.32845 6.82842,15 6,15 L4.5,15 C3.67158,15 3,14.32845 3,13.5 Z M10.5,12 C9.67158,12 9,12.67155 9,13.5 C9,14.32845 9.67158,15 10.5,15 L12,15 C12.82845,15 13.5,14.32845 13.5,13.5 C13.5,12.67155 12.82845,12 12,12 L10.5,12 Z"
              id="Shape"></path>
          </g>
        </g>
      </svg>
    </div>
    <span class="nav-link-text ms-1">Wallet</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link  {{ is_current_route('RTL') ? 'active' : '' }}" href="{{ route('RTL') }}">
    <div
      class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
      <svg width="30px" height="30px" viewBox="0 0 48 48" version="1.1"
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>rtl</title>
        <g id="rtl" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g id="menu-alt-3" transform="translate(12.000000, 14.000000)" fill="#FFFFFF">
            <path class="color-foreground"
              d="M0,1.71428571 C0,0.76752 0.76752,0 1.71428571,0 L22.2857143,0 C23.2325143,0 24,0.76752 24,1.71428571 C24,2.66105143 23.2325143,3.42857143 22.2857143,3.42857143 L1.71428571,3.42857143 C0.76752,3.42857143 0,2.66105143 0,1.71428571 Z"
              id="Path"></path>
            <path class="color-background"
              d="M0,10.2857143 C0,9.33894857 0.76752,8.57142857 1.71428571,8.57142857 L22.2857143,8.57142857 C23.2325143,8.57142857 24,9.33894857 24,10.2857143 C24,11.2325143 23.2325143,12 22.2857143,12 L1.71428571,12 C0.76752,12 0,11.2325143 0,10.2857143 Z"
              id="Path"></path>
            <path class="color-background"
              d="M10.2857143,18.8571429 C10.2857143,17.9103429 11.0532343,17.1428571 12,17.1428571 L22.2857143,17.1428571 C23.2325143,17.1428571 24,17.9103429 24,18.8571429 C24,19.8039429 23.2325143,20.5714286 22.2857143,20.5714286 L12,20.5714286 C11.0532343,20.5714286 10.2857143,19.8039429 10.2857143,18.8571429 Z"
              id="Path"></path>
          </g>
        </g>
      </svg>
    </div>
    <span class="nav-link-text ms-1">RTL</span>
  </a>
</li>
<li class="nav-item mt-2">
  <div class="d-flex align-items-center nav-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="ms-2"
      viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
      <path fill-rule="evenodd"
        d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
        clip-rule="evenodd" />
    </svg>
    <span class="font-weight-normal text-md ms-2">Laravel Examples</span>
  </div>
</li>
<li class="nav-item border-start my-0 pt-2">
  <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users.profile') ? 'active' : '' }}"
    href="{{ route('users.profile') }}">
    <span class="nav-link-text ms-1">User Profile</span>
  </a>
</li>
<li class="nav-item border-start my-0 pt-2">
  <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users-management') ? 'active' : '' }}"
    href="{{ route('users-management') }}">
    <span class="nav-link-text ms-1">User Management</span>
  </a>
</li>
<li class="nav-item mt-2">
  <div class="d-flex align-items-center nav-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="ms-2"
      viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
      <path fill-rule="evenodd"
        d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
        clip-rule="evenodd" />
    </svg>
    <span class="font-weight-normal text-md ms-2">Account Pages</span>
  </div>
</li>
<li class="nav-item border-start my-0 pt-2">
  <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('profile') ? 'active' : '' }}"
    href="{{ route('profile') }}">
    <span class="nav-link-text ms-1">Profile</span>
  </a>
</li>
<li class="nav-item border-start my-0 pt-2">
  <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('signin') ? 'active' : '' }}"
    href="{{ route('signin') }}">
    <span class="nav-link-text ms-1">Sign In</span>
  </a>
</li>
<li class="nav-item border-start my-0 pt-2">
  <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('signup') ? 'active' : '' }}"
    href="{{ route('signup') }}">
    <span class="nav-link-text ms-1">Sign Up</span>
  </a>
</li>