<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile UMKM') }}
        </h2>
    </x-slot>
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('umkm.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Usaha</label>
            <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha', $umkm->nama_usaha) }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat', $umkm->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $umkm->kontak) }}">
        </div>

        <div class="mb-3">
            <label>Jam Operasional</label>
            <input type="text" name="jam_operasional" class="form-control" value="{{ old('jam_operasional', $umkm->jam_operasional) }}">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</x-app-layout>
