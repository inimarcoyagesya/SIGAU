<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-credit-card mr-2"></i>Pembayaran Premium
        </h2>
    </x-slot>

    @push('styles')
    <style>
        .payment-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .payment-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .payment-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #f1c40f;
        }
        
        .payment-header p {
            color: #a0aec0;
            margin-top: 0.5rem;
        }
        
        .payment-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .payment-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.2);
            z-index: 1;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 2;
            flex: 1;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #2d3748;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            position: relative;
        }
        
        .step.active .step-icon {
            background: #4299e1;
            box-shadow: 0 0 0 5px rgba(66, 153, 225, 0.2);
        }
        
        .step.completed .step-icon {
            background: #48bb78;
        }
        
        .step-text {
            text-align: center;
            font-size: 0.9rem;
            color: #a0aec0;
        }
        
        .step.active .step-text {
            color: #4299e1;
            font-weight: 500;
        }
        
        .payment-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        .payment-info {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
        }
        
        .info-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .info-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-title {
            font-size: 1rem;
            color: #a0aec0;
            margin-bottom: 0.5rem;
        }
        
        .info-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: white;
        }
        
        .info-highlight {
            color: #f1c40f;
            font-weight: 600;
        }
        
        .payment-method {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
        }
        
        .qris-container {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            width: 220px;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .qris-placeholder {
            width: 180px;
            height: 180px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: #666;
            text-align: center;
            padding: 10px;
        }
        
        .payment-code {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.8rem;
            border-radius: 8px;
            margin-top: 1rem;
            text-align: center;
            width: 100%;
        }
        
        .payment-code span {
            font-weight: 600;
            letter-spacing: 1px;
            color: #f1c40f;
        }
        
        .expiry-time {
            color: #e53e3e;
            font-weight: 500;
            margin-top: 1rem;
            text-align: center;
        }
        
        .payment-instructions {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
        }
        
        .instructions-title {
            font-size: 1.2rem;
            color: #f1c40f;
            margin-bottom: 1rem;
        }
        
        .instructions-list {
            list-style-type: decimal;
            padding-left: 1.5rem;
        }
        
        .instructions-list li {
            margin-bottom: 0.8rem;
            color: #cbd5e0;
        }
        
        .btn-complete {
            background: linear-gradient(135deg, #48bb78 0%, #2f855a 100%);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1.5rem;
            font-size: 1.1rem;
        }
        
        .btn-complete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        @media (max-width: 768px) {
            .payment-content {
                grid-template-columns: 1fr;
            }
            
            .payment-steps {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .payment-steps::before {
                display: none;
            }
            
            .step {
                flex-direction: row;
                margin-bottom: 1rem;
                width: 100%;
            }
            
            .step-icon {
                margin-right: 1rem;
                margin-bottom: 0;
            }
        }
    </style>
    @endpush

    <div class="payment-container">
        <div class="payment-header">
            <h1>Lengkapi Pembayaran Paket Premium</h1>
            <p>Silakan selesaikan pembayaran untuk mengaktifkan paket premium Anda</p>
        </div>
        
        <div class="payment-steps">
            <div class="step completed">
                <div class="step-icon">
                    <i class="fas fa-shopping-cart text-white"></i>
                </div>
                <div class="step-text">Pilih Paket</div>
            </div>
            <div class="step active">
                <div class="step-icon">
                    <i class="fas fa-credit-card text-white"></i>
                </div>
                <div class="step-text">Pembayaran</div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div class="step-text">Selesai</div>
            </div>
        </div>
        
        <div class="payment-content">
            <div class="payment-info">
                <div class="info-section">
                    <div class="info-title">Paket Premium</div>
                    <div class="info-value">{{ $package->name }}</div>
                </div>
                
                <div class="info-section">
                    <div class="info-title">Detail Harga</div>
                    <div class="info-value">IDR {{ number_format($package->price, 0, ',', '.') }}</div>
                </div>
                
                <div class="info-section">
                    <div class="info-title">Deskripsi Paket</div>
                    <div class="info-value">{{ $package->description }}</div>
                </div>
                
                <div class="info-section">
                    <div class="info-title">Informasi Pengguna</div>
                    <div class="info-value">{{ $user->name }}</div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>
            </div>
            
            <div class="payment-method">
                <h3 class="info-title">Metode Pembayaran</h3>
                <div class="info-value info-highlight">QRIS</div>
                
                <div class="qris-container">
                    <div class="qris-placeholder">
                        Kode QRIS Pembayaran<br>
                        (Scan menggunakan aplikasi e-wallet atau mobile banking)
                    </div>
                </div>
                
                <div class="payment-code">
                    Kode Pembayaran: <span>{{ $transaction->payment_code }}</span>
                </div>
                
                <div class="expiry-time">
                    Batas waktu pembayaran: {{ $expiryTime->format('d M Y H:i') }}
                </div>
                
                <form action="{{ route('payment.complete', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-complete">
                        <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
        
        <div class="payment-instructions">
            <h3 class="instructions-title">Cara Pembayaran Menggunakan QRIS:</h3>
            <ol class="instructions-list">
                <li>Buka aplikasi e-wallet atau mobile banking Anda</li>
                <li>Pilih menu pembayaran atau scan QR</li>
                <li>Arahkan kamera ke kode QR di atas</li>
                <li>Pastikan nominal pembayaran sesuai dengan yang tertera</li>
                <li>Konfirmasi pembayaran</li>
                <li>Tunggu hingga notifikasi pembayaran berhasil muncul</li>
                <li>Klik tombol "Konfirmasi Pembayaran" di atas setelah berhasil melakukan pembayaran</li>
            </ol>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hitung mundur waktu kedaluwarsa
            const expiryElement = document.querySelector('.expiry-time');
            if (expiryElement) {
                const expiryText = expiryElement.textContent;
                const expiryTime = new Date(expiryText.split(': ')[1]);
                
                function updateCountdown() {
                    const now = new Date();
                    const diff = expiryTime - now;
                    
                    if (diff <= 0) {
                        expiryElement.textContent = 'Batas waktu pembayaran telah habis!';
                        return;
                    }
                    
                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    expiryElement.textContent = `Batas waktu pembayaran: ${hours} jam ${minutes} menit ${seconds} detik`;
                }
                
                // Update setiap detik
                setInterval(updateCountdown, 1000);
                updateCountdown();
            }
        });
    </script>
    @endpush
</x-app-layout>