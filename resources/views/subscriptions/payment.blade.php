<!DOCTYPE html>
<html>
<head>
    <title>Payment Gateway</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body>
    <button id="pay-button">Bayar Sekarang</button>

    <script>
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) { 
                    alert("Pembayaran sukses!"); 
                    window.location.href = '/dashboard';
                },
                onPending: function(result) { 
                    alert("Menunggu pembayaran!"); 
                },
                onError: function(result) { 
                    alert("Pembayaran gagal!"); 
                }
            });
        });
    </script>
</body>
</html>