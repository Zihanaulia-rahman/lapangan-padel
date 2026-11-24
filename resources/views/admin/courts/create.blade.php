@extends('layouts.app')

@section('title', 'Tambah Arena Baru — Admin PadelHub')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 lg:py-12">
    @include('admin._nav', ['eyebrow' => 'Admin Panel', 'heading' => 'Tambah Arena Baru'])

    <div class="bg-[#132B28] border border-white/10 p-6 sm:p-8 rounded-2xl shadow-xl">
        <form action="{{ route('admin.courts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.courts._form', ['submitLabel' => 'Simpan Arena Baru'])
        </form>
    </div>
</div>
@endsection
