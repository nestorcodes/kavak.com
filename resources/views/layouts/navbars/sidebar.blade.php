<div class="sidebar" data-color="azure" data-background-color="white">
  @php
    $isActive = function ($pageName) use ($activePage) {
      return $pageName === $activePage ? 'active' : '';
    };

    $collapseActive = function ($sectionName) use ($activePage) {
      return strpos('_'.$activePage, $sectionName) !== false ? 'active' : '';
    };

    $collapseShowing = function ($sectionName) use ($activePage) {
      return strpos('_'.$activePage, $sectionName) !== false ? 'show' : '';
    };
  @endphp
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
      {{ __('KAVAK') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item {{ $isActive('dashboard') }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ $isActive('cars.index') }}">
        <a class="nav-link" href="{{ route('cars.index') }}">
          <i class="material-icons">car_rental</i>
          <p>{{ __('Vehiculos') }}</p>
        </a>
      </li>
      <li class="nav-item {{ $collapseActive('maintenance') }}">
        <a class="nav-link" data-toggle="collapse" href="#maintenance" aria-expanded="true">
          <i class="material-icons">settings</i>
          <p>{{ __('Mantenimiento') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ $collapseShowing('maintenance') }}" id="maintenance">
          <ul class="nav">
            <li class="nav-item {{ $isActive('maintenance.brand') }}">
              <a class="nav-link" href="{{ route('maint.brand.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">{{ __('Marca') }} </span>
              </a>
            </li>
            <li class="nav-item {{ $isActive('maintenance.model') }}">
              <a class="nav-link" href="{{ route('maint.model.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">{{ __('Modelo') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      
    </ul>
  </div>
</div>