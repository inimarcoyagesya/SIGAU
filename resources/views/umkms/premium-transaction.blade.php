<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-black">
            <i class="fas fa-crown mr-2"></i>Transaksi Premium
        </h2>
    </x-slot>

    @push('styles')
    <style>
        /* Warna dan gradient */
        .gr-1 { background: linear-gradient(170deg, #01E4F8 0%, #1D3EDE 100%); }
        .gr-2 { background: linear-gradient(170deg, #B4EC51 0%, #429321 100%); }
        .gr-3 { background: linear-gradient(170deg, #C86DD7 0%, #3023AE 100%); }
        .gr-4 { background: linear-gradient(170deg, #FF7E5F 0%, #FEB47B 100%); }
        .gr-5 { background: linear-gradient(170deg, #8E2DE2 0%, #4A00E0 100%); }

        /* Transisi umum */
        * { transition: all 0.4s ease; }

        /* Layout utama */
        .premium-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .premium-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }
        
        .premium-column {
            flex: 1;
            min-width: 300px;
            max-width: 380px;
        }
        
        /* Kartu paket premium */
        .premium-card {
            min-height: 280px;
            padding: 2rem 1.5rem;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            height: 100%;
        }
        
        .premium-card .card-content {
            position: relative;
            z-index: 10;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .premium-card .card-title {
            font-size: 1.7rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            color: white;
        }
        
        .premium-card .card-price {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }
        
        .premium-card .card-desc {
            font-size: 0.95rem;
            line-height: 1.6;
            margin-top: 0.5rem;
            opacity: 0.9;
            flex-grow: 1;
            color: rgba(255, 255, 255, 0.95);
        }
        
        .premium-card .card-form {
            margin-top: 1.5rem;
        }
        
        .premium-btn {
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            display: inline-flex;
            align-items: center;
            width: 100%;
            justify-content: center;
        }
        
        .premium-btn:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .premium-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            background: rgba(255, 255, 255, 0.15);
        }
        
        .premium-btn::after {
            content: '\f054';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: 10px;
            font-size: 0.8rem;
        }
        
        .card-icon {
            position: absolute;
            bottom: -20px;
            right: -20px;
            opacity: 0.15;
            z-index: 0;
        }
        
        .card-icon i {
            font-size: 10rem;
            color: white;
        }
        
        /* Efek hover */
        .premium-column:hover {
            transform: translateY(-10px);
        }
        
        /* Header yang lebih menarik */
        .text-white {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .fa-crown {
            color: #FFD700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }
        
        /* Tambahan animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .premium-column {
            animation: fadeIn 0.6s ease forwards;
            opacity: 0;
        }
        
        .premium-column:nth-child(1) { animation-delay: 0.1s; }
        .premium-column:nth-child(2) { animation-delay: 0.3s; }
        .premium-column:nth-child(3) { animation-delay: 0.5s; }
        .premium-column:nth-child(4) { animation-delay: 0.7s; }
        .premium-column:nth-child(5) { animation-delay: 0.9s; }
        
        /* Status langganan - Warna diubah menjadi biru gelap yang elegan */
        .subscription-status {
            background: linear-gradient(135deg, rgba(13, 27, 42, 0.9) 0%, rgba(27, 38, 59, 0.95) 100%);
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 2rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid rgba(65, 90, 119, 0.5);
            box-shadow: 0 0 25px rgba(0, 50, 100, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .subscription-status::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0d1b2a, #1b263b, #415a77, #0d1b2a);
            background-size: 200% 100%;
            animation: gradientFlow 5s linear infinite;
        }
        
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }
        
        .status-header {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #778da9;
            text-align: center;
        }
        
        .status-content {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
        }
        
        .status-card {
            background: rgba(27, 38, 59, 0.7);
            border-radius: 10px;
            padding: 1.2rem;
            flex: 1;
            min-width: 220px;
            text-align: center;
            border: 1px solid rgba(65, 90, 119, 0.5);
            transition: all 0.3s ease;
        }
        
        .status-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 30, 60, 0.4);
            background: rgba(27, 38, 59, 0.85);
        }
        
        .status-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #a0c4e0;
        }
        
        .status-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #e0e1dd;
        }
        
        .active-status {
            color: #778da9;
            position: relative;
            display: inline-block;
            padding: 0 10px;
        }
        
        .active-status::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -10px;
            width: 8px;
            height: 8px;
            background: #4cc9f0;
            border-radius: 50%;
            transform: translateY(-50%);
            box-shadow: 0 0 10px #4cc9f0;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(76, 201, 240, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(76, 201, 240, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 201, 240, 0); }
        }
        
        /* Tampilan untuk user banned */
        .banned-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 3rem;
            background: linear-gradient(135deg, rgba(40, 15, 15, 0.9) 0%, rgba(80, 20, 20, 0.9) 100%);
            border-radius: 16px;
            border: 1px solid rgba(200, 50, 50, 0.5);
            box-shadow: 0 0 30px rgba(200, 0, 0, 0.3);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .banned-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #400, #800, #c00, #400);
            background-size: 200% 100%;
            animation: gradientFlow 3s linear infinite;
        }
        
        .banned-icon {
            font-size: 5rem;
            color: #e53e3e;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 20px rgba(229, 62, 62, 0.5);
        }
        
        .banned-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        
        .banned-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #ffb8b8;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        .banned-details {
            background: rgba(0, 0, 0, 0.3);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .banned-detail {
            display: flex;
            margin-bottom: 1rem;
        }
        
        .banned-detail:last-child {
            margin-bottom: 0;
        }
        
        .detail-label {
            width: 150px;
            color: #ff9999;
            font-weight: 500;
        }
        
        .detail-value {
            flex: 1;
            color: #fff;
        }
        
        .banned-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .banned-btn {
            padding: 0.8rem 1.8rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .banned-btn i {
            margin-right: 0.5rem;
        }
        
        .contact-btn {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: white;
            border: none;
        }
        
        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(200, 0, 0, 0.3);
        }
        
        .appeal-btn {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .appeal-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
        }
        
        /* Responsif */
        @media (max-width: 768px) {
            .premium-row {
                flex-direction: column;
                align-items: center;
            }
            
            .premium-column {
                width: 100%;
                max-width: 100%;
            }
            
            .status-content {
                flex-direction: column;
            }
            
            .banned-container {
                padding: 2rem 1.5rem;
            }
            
            .banned-title {
                font-size: 1.8rem;
            }
            
            .banned-actions {
                flex-direction: column;
            }
            
            .banned-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    @endpush

    <div class="premium-container">
        @if(auth()->user()->is_banned)
            <!-- Tampilan khusus untuk user yang dibanned -->
            <div class="banned-container">
                <div class="banned-icon">
                    <i class="fas fa-ban"></i>
                </div>
                
                <h2 class="banned-title">AKUN ANDA DIBANNED</h2>
                
                <p class="banned-message">
                    Maaf, akun Anda saat ini dalam status dibanned. Anda tidak dapat melakukan transaksi premium atau mengakses fitur-fitur tertentu.
                </p>
                
                <div class="banned-details">
                    <div class="banned-detail">
                        <div class="detail-label">Status Akun:</div>
                        <div class="detail-value">DIBANNED</div>
                    </div>
                    <div class="banned-detail">
                        <div class="detail-label">Alasan Pembannedan:</div>
                        <div class="detail-value">{{ auth()->user()->ban_reason ?? 'Pelanggaran ketentuan layanan' }}</div>
                    </div>
                    <div class="banned-detail">
                        <div class="detail-label">Tanggal Pembannedan:</div>
                        <div class="detail-value">{{ auth()->user()->banned_at ? auth()->user()->banned_at->format('d M Y H:i') : 'N/A' }}</div>
                    </div>
                </div>
                
                <p class="banned-message">
                    Jika Anda merasa ini adalah kesalahan atau ingin mengajukan banding, silakan hubungi tim dukungan kami.
                </p>
                
                <div class="banned-actions">
                    <button class="banned-btn contact-btn">
                        <i class="fas fa-headset"></i> Hubungi Dukungan
                    </button>
                    <button class="banned-btn appeal-btn">
                        <i class="fas fa-file-alt"></i> Ajukan Banding
                    </button>
                </div>
            </div>
        @else
            <!-- Status Langganan Aktif - Hanya ditampilkan jika tidak banned -->
            @if(isset($activeSubscription) && $activeSubscription)
            <div class="subscription-status">
                <div class="status-header">
                    <i class="fas fa-shield-alt mr-2"></i>Langganan Aktif Anda
                </div>
                <div class="status-content">
                    <div class="status-card">
                        <div class="status-title">Paket</div>
                        <div class="status-value">{{ $activeSubscription->package->name ?? 'Paket Tidak Tersedia' }}</div>
                    </div>
                    <div class="status-card">
                        <div class="status-title">Status</div>
                        <div class="status-value active-status">AKTIF</div>
                    </div>
                    <div class="status-card">
                        <div class="status-title">Berlaku Sampai</div>
                        <div class="status-value">{{ \Carbon\Carbon::parse($activeSubscription->end_date)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
            @endif

            <h2 class="text-xl font-semibold text-center text-white mb-8 mt-4">
                Pilih Paket Premium untuk Meningkatkan Bisnis Anda
            </h2>
            
            <div class="premium-row">
                @php
                    $gradients = ['gr-1', 'gr-2', 'gr-3', 'gr-4', 'gr-5'];
                    $icons = ['fa-rocket', 'fa-gem', 'fa-crown', 'fa-star', 'fa-trophy'];
                @endphp
                
                @foreach($packages as $index => $package)
                <div class="premium-column">
                    <div class="premium-card {{ $gradients[$index % count($gradients)] }}">
                        <div class="card-content">
                            <h3 class="card-title">{{ $package->name }}</h3>
                            <div class="card-price">IDR {{ number_format($package->price, 0, ',', '.') }}</div>
                            <p class="card-desc">{{ $package->description }}</p>
                            <div class="card-form">
                                <form action="{{ route('premium.subscribe') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    
                                    @if(isset($activeSubscription) && $activeSubscription)
                                        <button type="button" class="premium-btn" disabled>
                                            Paket Aktif Berjalan
                                        </button>
                                    @else
                                        <button type="submit" class="premium-btn">
                                            Pilih Paket
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="card-icon">
                            <i class="fas {{ $icons[$index % count($icons)] }}"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-12 p-6 bg-blue-800 bg-opacity-500 rounded-xl border border-gray-700 max-w-3xl mx-auto">
                <h3 class="text-xl font-semibold text-center text-gray-300 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Mengapa Memilih Paket Premium?
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-chart-line text-3xl text-blue-400 mb-2"></i>
                        <h4 class="font-medium text-white">Analitik Lanjutan</h4>
                        <p class="text-gray-300 text-sm mt-2">Akses analitik bisnis mendalam untuk pengambilan keputusan lebih baik</p>
                    </div>
                    <div class="p-4">
                        <i class="fas fa-shield-alt text-3xl text-green-400 mb-2"></i>
                        <h4 class="font-medium text-white">Keamanan Ekstra</h4>
                        <p class="text-gray-300 text-sm mt-2">Proteksi tambahan untuk data bisnis penting Anda</p>
                    </div>
                    <div class="p-4">
                        <i class="fas fa-headset text-3xl text-purple-400 mb-2"></i>
                        <h4 class="font-medium text-white">Dukungan Prioritas</h4>
                        <p class="text-gray-300 text-sm mt-2">Tim dukungan khusus siap membantu 24/7</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi saat kartu muncul
            const columns = document.querySelectorAll('.premium-column');
            columns.forEach(column => {
                column.style.opacity = '1';
            });
            
            // Efek hover tombol
            const buttons = document.querySelectorAll('.premium-btn, .banned-btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    if (!this.disabled) {
                        this.style.transform = 'translateY(-3px)';
                        this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
                    }
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
            
            // Tampilkan notifikasi
            @if(session('success'))
                setTimeout(() => {
                    alertSuccess("{{ session('success') }}");
                }, 500);
            @endif
            
            @if(session('error'))
                setTimeout(() => {
                    alertError("{{ session('error') }}");
                }, 500);
            @endif
            
            function alertSuccess(message) {
                const alert = document.createElement('div');
                alert.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-500 translate-x-0';
                alert.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        <span>${message}</span>
                    </div>
                `;
                document.body.appendChild(alert);
                
                setTimeout(() => {
                    alert.style.transform = 'translateX(150%)';
                    setTimeout(() => document.body.removeChild(alert), 500);
                }, 3000);
            }
            
            function alertError(message) {
                const alert = document.createElement('div');
                alert.className = 'fixed top-4 right-4 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-500 translate-x-0';
                alert.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        <span>${message}</span>
                    </div>
                `;
                document.body.appendChild(alert);
                
                setTimeout(() => {
                    alert.style.transform = 'translateX(150%)';
                    setTimeout(() => document.body.removeChild(alert), 500);
                }, 3000);
            }
            
            // Handler untuk tombol banned
            document.querySelector('.contact-btn')?.addEventListener('click', function() {
                alertInfo('Fitur kontak dukungan akan segera tersedia');
            });
            
            document.querySelector('.appeal-btn')?.addEventListener('click', function() {
                alertInfo('Fitur pengajuan banding akan segera tersedia');
            });
            
            function alertInfo(message) {
                const alert = document.createElement('div');
                alert.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-500 translate-x-0';
                alert.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-3"></i>
                        <span>${message}</span>
                    </div>
                `;
                document.body.appendChild(alert);
                
                setTimeout(() => {
                    alert.style.transform = 'translateX(150%)';
                    setTimeout(() => document.body.removeChild(alert), 500);
                }, 3000);
            }
        });
    </script>
    @endpush
</x-app-layout>