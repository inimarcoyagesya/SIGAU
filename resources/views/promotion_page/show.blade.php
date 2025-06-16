<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ads') }}
        </h2>
    </x-slot>
<div class="container">
    <!-- Header UMKM -->
    <div class="mb-5">
        <h1>{{ $umkm->nama_usaha }}</h1>
        <p>{{ $umkm->deskripsi }}</p>
        
        <!-- Sosial Media -->
        <div class="social-media mb-4">
            @if($umkm->facebook_url)
                <a href="{{ $umkm->facebook_url }}" target="_blank" onclick="trackClick('facebook')">
                    <i class="fab fa-facebook"></i>
                </a>
            @endif
            <!-- Tambahkan platform lain serupa -->
        </div>
    </div>

    <!-- Galeri Produk -->
    <h2>Produk Kami</h2>
    <div class="row">
        @foreach($umkm->inventories as $produk)
            <div class="col-md-4 mb-4">
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="img-fluid">
                <h5>{{ $produk->nama_produk }}</h5>
            </div>
        @endforeach
    </div>

    <!-- Promosi Aktif -->
    <h2>Promosi</h2>
    <div class="promotions">
        @foreach($umkm->promotions as $promosi)
            <div class="card mb-3">
                <div class="card-body">
                    <h3>{{ $promosi->judul_promosi }}</h3>
                    <p>{{ $promosi->deskripsi }}</p>
                    
                    @if($promosi->kode_kupon)
                        <div class="coupon">
                            <strong>Kupon:</strong> {{ $promosi->kode_kupon }}
                            <br><small>Berlaku hingga {{ $promosi->masa_berlaku }}</small>
                        </div>
                    @endif
                    
                    @if($umkm->verified && $promosi->link_iklan)
                        <a href="{{ $promosi->link_iklan }}" 
                           target="_blank" 
                           class="btn btn-primary mt-2"
                           onclick="trackAdClick({{ $promosi->id }})">
                            Lihat Iklan
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function trackAdClick(promotionId) {
    fetch(`/promotion/${promotionId}/track-click`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
}
</script>

</x-app-layout>