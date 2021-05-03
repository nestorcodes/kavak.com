<div class="wrapper ">
        @include('layouts.navbars.navs.guest')
        <div class="login-page header-filter" filter-color="black" style="background-image: url('{{ asset('material') }}/img/login.jpg'); background-size: cover; background-position: top center;align-items: center;height: 100vh;" data-color="purple">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="pt-6">
                @yield('content')
                @include('layouts.footers.guest')
            </div>
        </div>
  </div>
