		<!-- Main Menu -->
	<div data-simplebar class="nicescroll-bar">
	    <div class="menu-content-wrap">

	        <div class="menu-group">
	            <div class="nav-header">
	            <span>Admin Dashboard</span>
	            </div>
	                        <ul class="navbar-nav flex-column">
                <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.home') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Home') }}</span>
                    </a>
                </li>
				<li class="nav-item {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.sliders.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Sliders') }}</span>
                    </a>
                </li>
				<li class="nav-item {{ request()->routeIs('admin.abouts*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.abouts.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Abouts') }}</span>
                    </a>
                </li>
				<li class="nav-item {{ request()->routeIs('admin.roomtypes*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.roomtypes.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Room Type') }}</span>
                    </a>
                </li>
                                <li class="nav-item {{ request()->routeIs('admin.rooms*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.rooms.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                                        <span class="nav-link-text">{{ __('Rooms') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.services.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                                        <span class="nav-link-text">{{ __('Services') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                                        <span class="nav-link-text">{{ __('Booking') }}</span>
                                    </a>
                                </li>

                                       <li class="nav-item {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.blogs.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                                        <span class="nav-link-text">{{ __('Bloges') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.testimonials.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                                        <span class="nav-link-text">{{ __('Testimonials') }}</span>
                                    </a>
                                </li>

	        </div>

	        <!-- System Settings Section -->
	        <div class="menu-group">
	            <div class="nav-header">
	                <span>{{ __('System') }}</span>
	            </div>
	            <ul class="navbar-nav flex-column">
				<li class="nav-item {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 512 512"><path fill="currentColor" d="M78.8 56.1v78.8H0V450h433.2v-78.8H512V56.1H78.8zm354.4 39.4L295.4 233.3L157.5 95.5h275.7zm-39.4 315H39.4V193.9l39.4 39.4v137.8h315.1v39.4zm78.8-78.7H118.2V115.2l177.2 177.2l177.2-177.2v216.6z"/></svg>
                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Messages') }}</span>
                    </a>
                </li>
				@if(auth()->user()->can('view_admins'))
                <li class="nav-item {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.admins.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 36 36"><path fill="currentColor" d="M14.68 14.81a6.76 6.76 0 1 1 6.76-6.75a6.77 6.77 0 0 1-6.76 6.75Zm0-11.51a4.76 4.76 0 1 0 4.76 4.76a4.76 4.76 0 0 0-4.76-4.76Z" class="clr-i-outline clr-i-outline-path-1"/><path fill="currentColor" d="M16.42 31.68A2.14 2.14 0 0 1 15.8 30H4v-5.78a14.81 14.81 0 0 1 11.09-4.68h.72a2.2 2.2 0 0 1 .62-1.85l.12-.11c-.47 0-1-.06-1.46-.06A16.47 16.47 0 0 0 2.2 23.26a1 1 0 0 0-.2.6V30a2 2 0 0 0 2 2h12.7Z" class="clr-i-outline clr-i-outline-path-2"/><path fill="currentColor" d="M26.87 16.29a.37.37 0 0 1 .15 0a.42.42 0 0 0-.15 0Z" class="clr-i-outline clr-i-outline-path-3"/><path fill="currentColor" d="m33.68 23.32l-2-.61a7.21 7.21 0 0 0-.58-1.41l1-1.86A.38.38 0 0 0 32 19l-1.45-1.45a.36.36 0 0 0-.44-.07l-1.84 1a7.15 7.15 0 0 0-1.43-.61l-.61-2a.36.36 0 0 0-.36-.24h-2.05a.36.36 0 0 0-.35.26l-.61 2a7 7 0 0 0-1.44.6l-1.82-1a.35.35 0 0 0-.43.07L17.69 19a.38.38 0 0 0-.06.44l1 1.82a6.77 6.77 0 0 0-.63 1.43l-2 .6a.36.36 0 0 0-.26.35v2.05A.35.35 0 0 0 16 26l2 .61a7 7 0 0 0 .6 1.41l-1 1.91a.36.36 0 0 0 .06.43l1.45 1.45a.38.38 0 0 0 .44.07l1.87-1a7.09 7.09 0 0 0 1.4.57l.6 2a.38.38 0 0 0 .35.26h2.05a.37.37 0 0 0 .35-.26l.61-2.05a6.92 6.92 0 0 0 1.38-.57l1.89 1a.36.36 0 0 0 .43-.07L32 30.4a.35.35 0 0 0 0-.4l-1-1.88a7 7 0 0 0 .58-1.39l2-.61a.36.36 0 0 0 .26-.35v-2.1a.36.36 0 0 0-.16-.35ZM24.85 28a3.34 3.34 0 1 1 3.33-3.33A3.34 3.34 0 0 1 24.85 28Z" class="clr-i-outline clr-i-outline-path-4"/><path fill="none" d="M0 0h36v36H0z"/></svg>                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Admins') }}</span>
                    </a>
                </li>
				@endif
				@if(auth()->user()->can('view_users'))
                <li class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
							<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Users') }}</span>
                    </a>
                </li>
				@endif
				<li class="nav-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.roles.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M22.2 4.86L6.69 11.25V27C6.69 35.44 24 43.5 24 43.5S41.31 35.44 41.31 27V11.25L25.8 4.86a4.68 4.68 0 0 0-3.6 0ZM24 43.5v-39M6.69 24h34.62"/></svg>	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Roles') }}</span>
	                    </a>
	                </li>
	                <li class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.settings.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
	                                    <circle cx="12" cy="12" r="3" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Settings') }}</span>
	                    </a>
	                </li>
	            </ul>
	        </div>

	        <!-- Logout Section -->
	        <div class="menu-group mt-auto">
	            <div class="nav-header">
	                <span>{{ __('Account') }}</span>
	            </div>
	            <ul class="navbar-nav flex-column">
	                <li class="nav-item">
	                    <form action="{{ route('admin.logout') }}" method="POST" id="logout-form">
	                        @csrf
	                        <a class="nav-link logout-btn" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit()">
	                            <span class="nav-icon-wrap">
	                                <span class="svg-icon">
	                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
	                                        <path d="M7 12h14l-3 -3m0 6l3 -3" />
	                                    </svg>
	                                </span>
	                            </span>
	                            <span class="nav-link-text">{{ __('Logout') }}</span>
	                        </a>
	                    </form>
	                </li>
	            </ul>
	        </div>
	    </div>
	</div>
	<!-- /Main Menu -->
