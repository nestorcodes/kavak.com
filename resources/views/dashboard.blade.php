@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body table-responsive">
          ¡Ha iniciado sesión correctamente!
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    
  </script>
@endpush