<!DOCTYPE html>

<html lang="en">
	@include('admin.layouts.head')
	<!-- <link rel="stylesheet" href="{{ asset('admin/src/scss/layout.scss') }}"> -->
<body>
	<!-- Wrapper -->
	<div class="hk-wrapper" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">
		<!-- Top Navbar -->
		@include('admin.layouts.navbar')
		<!-- /Top Navbar -->
        
        <!-- Vertical Nav -->
        <div class="hk-menu">
			<!-- Brand -->
			<div class="menu-header">
				<span>
					<a class="navbar-brand" href="index.html">
						<img class="brand-img img-fluid" src="{{ asset('admin/dist/img/brand-sm.svg') }}" alt="brand" />
						<img class="brand-img img-fluid" src="{{ asset('admin/dist/img/Jampack.svg') }}" alt="brand" />
					</a>
					<button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle">
						<span class="icon">
							<span class="svg-icon fs-5">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
									<line x1="10" y1="12" x2="20" y2="12"></line>
									<line x1="10" y1="12" x2="14" y2="16"></line>
									<line x1="10" y1="12" x2="14" y2="8"></line>
									<line x1="4" y1="4" x2="4" y2="20"></line>
								</svg>
							</span>
						</span>
					</button>
				</span>
			</div>
			<!-- /Brand -->

			<!-- Main Menu -->
			@include('admin.layouts.aside')
			<!-- /Main Menu -->
		</div>
        <!-- /Vertical Nav -->

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <div class="container-xxl " style="padding-top: 25px;">
                @yield('content')
            </div>
        </div>
        <!-- /Main Content -->
	</div>
	<!-- /Wrapper -->

	@include('admin.layouts.scripts')
</body>
</html>
        