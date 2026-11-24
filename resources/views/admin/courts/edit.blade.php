@extends('layouts.app')

@section('title', 'Edit Arena — Admin PadelHub')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 lg:py-12">
    @include('admin._nav', ['eyebrow' => 'Admin Panel', 'heading' => 'Edit Arena: ' . $court->name])

    <div class="bg-[#132B28] border border-white/10 p-6 sm:p-8 rounded-2xl shadow-xl">
        <form action="{{ route('admin.courts.update', $court->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.courts._form', ['court' => $court, 'submitLabel' => 'Perbarui Arena'])
        </form>
    </div>
</div>
@endsection
