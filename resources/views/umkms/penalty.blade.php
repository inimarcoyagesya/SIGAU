<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-white">
            <i class="fas fa-exclamation-triangle mr-2"></i>Pembayaran Denda
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                <div class="text-center">
                    <i class="fas fa-ban text-5xl text-red-500 mb-4"></i>
                    <h3 class="text-2xl font-bold mb-4">Akun Anda Diblokir!</h3>
                    <p class="mb-4">Anda harus membayar denda sebesar <span class="font-bold">Rp 200.000</span> untuk mengaktifkan kembali akun.</p>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 max-w-2xl mx-auto">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-yellow-700">
                                    Akun Anda diblokir karena: <span class="font-medium">{{ $banReason ?? 'Pelanggaran ketentuan promosi' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6 max-w-2xl mx-auto">
                        <h4 class="text-lg font-semibold mb-4">Metode Pembayaran</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Transfer Bank -->
                            <div class="border rounded-lg p-4 hover:border-blue-500 cursor-pointer payment-method" data-method="bank_transfer">
                                <div class="flex items-center">
                                    <i class="fas fa-university text-2xl text-blue-500 mr-3"></i>
                                    <div>
                                        <h5 class="font-semibold">Transfer Bank</h5>
                                        <p class="text-sm text-gray-600">BCA, BNI, BRI, Mandiri</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- E-Wallet -->
                            <div class="border rounded-lg p-4 hover:border-green-500 cursor-pointer payment-method" data-method="ewallet">
                                <div class="flex items-center">
                                    <i class="fas fa-wallet text-2xl text-green-500 mr-3"></i>
                                    <div>
                                        <h5 class="font-semibold">E-Wallet</h5>
                                        <p class="text-sm text-gray-600">Gopay, OVO, Dana, ShopeePay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Pembayaran -->
                        <div id="bank-transfer-form" class="mt-6 hidden">
                            <h5 class="font-semibold mb-3">Instruksi Transfer Bank</h5>
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <p class="mb-2">Silakan transfer ke rekening berikut:</p>
                                <div class="flex items-center justify-between mb-2">
                                    <span>Bank BCA</span>
                                    <span class="font-mono">123 456 7890</span>
                                </div>
                                <div class="flex items-center justify-between mb-2">
                                    <span>Atas Nama</span>
                                    <span class="font-mono">UMKM DIGIMAP</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Jumlah</span>
                                    <span class="font-mono font-bold">Rp 200.000</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Upload Bukti Transfer</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="payment_proof" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-500">Klik untuk upload bukti transfer</p>
                                        </div>
                                        <input id="payment_proof" type="file" class="hidden" accept="image/*" />
                                    </label>
                                </div> 
                            </div>
                            
                            <button id="submit-payment" class="w-full bg-gradient-to-r from-blue-500 to-green-500 text-white py-3 rounded-lg shadow hover:shadow-lg transition">
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                        
                        <div id="ewallet-form" class="mt-6 hidden">
                            <h5 class="font-semibold mb-3">Pilih E-Wallet</h5>
                            <div class="grid grid-cols-4 gap-4 mb-6">
                                <div class="border rounded-lg p-3 text-center cursor-pointer ewallet-option" data-ewallet="gopay">
                                    <img src="https://via.placeholder.com/60?text=Gopay" alt="Gopay" class="mx-auto mb-2">
                                    <span>Gopay</span>
                                </div>
                                <div class="border rounded-lg p-3 text-center cursor-pointer ewallet-option" data-ewallet="ovo">
                                    <img src="https://via.placeholder.com/60?text=OVO" alt="OVO" class="mx-auto mb-2">
                                    <span>OVO</span>
                                </div>
                                <div class="border rounded-lg p-3 text-center cursor-pointer ewallet-option" data-ewallet="dana">
                                    <img src="https://via.placeholder.com/60?text=Dana" alt="Dana" class="mx-auto mb-2">
                                    <span>Dana</span>
                                </div>
                                <div class="border rounded-lg p-3 text-center cursor-pointer ewallet-option" data-ewallet="shopeepay">
                                    <img src="https://via.placeholder.com/60?text=ShopeePay" alt="ShopeePay" class="mx-auto mb-2">
                                    <span>ShopeePay</span>
                                </div>
                            </div>
                            
                            <div id="ewallet-qr" class="text-center hidden">
                                <p class="mb-3">Scan QR Code untuk pembayaran:</p>
                                <div class="bg-white p-4 inline-block rounded-lg shadow-md">
                                    <img src="https://via.placeholder.com/200?text=QR+Code" alt="QR Code" class="mx-auto mb-3">
                                    <p class="font-bold">Rp 200.000</p>
                                </div>
                                <p class="mt-4 text-sm text-gray-600">Pembayaran diverifikasi secara otomatis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih metode pembayaran
            document.querySelectorAll('.payment-method').forEach(method => {
                method.addEventListener('click', function() {
                    // Hapus seleksi sebelumnya
                    document.querySelectorAll('.payment-method').forEach(m => {
                        m.classList.remove('border-blue-500', 'border-green-500', 'ring-2');
                    });
                    
                    // Tambah seleksi baru
                    this.classList.add('ring-2');
                    const methodType = this.dataset.method;
                    if (methodType === 'bank_transfer') {
                        this.classList.add('border-blue-500', 'ring-blue-300');
                        document.getElementById('bank-transfer-form').classList.remove('hidden');
                        document.getElementById('ewallet-form').classList.add('hidden');
                    } else {
                        this.classList.add('border-green-500', 'ring-green-300');
                        document.getElementById('ewallet-form').classList.remove('hidden');
                        document.getElementById('bank-transfer-form').classList.add('hidden');
                        document.getElementById('ewallet-qr').classList.add('hidden');
                    }
                });
            });
            
            // Pilih e-wallet
            document.querySelectorAll('.ewallet-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.ewallet-option').forEach(o => {
                        o.classList.remove('border-blue-500', 'ring-2', 'ring-blue-300');
                    });
                    this.classList.add('border-blue-500', 'ring-2', 'ring-blue-300');
                    document.getElementById('ewallet-qr').classList.remove('hidden');
                });
            });
            
            // Submit pembayaran
            document.getElementById('submit-payment').addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                this.disabled = true;
                
                // Simulasi proses pembayaran
                setTimeout(() => {
                    window.location.href = "{{ route('umkm.dashboard') }}?payment=success";
                }, 2000);
            });
        });
    </script>
</x-app-layout>