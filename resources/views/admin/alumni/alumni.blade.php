@extends('layouts.template')

@section('content')
<div class="text-white text-center">
    <h1 class="judul-halaman text-white">{{ $pageTitle }}</h1>
    <p class="subjudul-halaman">Ini adalah halaman data alumni.</p>
</div>

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>{{ $pageTitle }}</h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            @include('admin.alumni.alumni-table')  <!-- Memanggil bagian tabel alumni -->
          </div>
        </div>
      </div>
    </div>
</div>

@include('admin.alumni.alumni-modal') <!-- Memanggil modal untuk detail dan edit -->
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('argon/assets/css/alumni.css') }}"> <!-- Menambahkan CSS alumni -->
@endsection

@section('script')
<script src="{{ asset('argon\assets\js\core\alumni.js') }}"></script> <!-- Menambahkan JS alumni dari subfolder core -->
@endsection
