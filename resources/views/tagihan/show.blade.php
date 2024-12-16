<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Order #{{ $tagihan->id }}</title>

    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.css') }}">
    <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>
<body>
    <div class="container-fluid bg-white">
        <header>
            <div class="row d-flex align-items-center">
                <div class="col-6">
                    <div class="m-2">
                        <img src="{{ asset('assets/images/backgrounds/rocket.png') }}" alt="Logo Senang Tours" width="50px" height="50px">
                        <span class="fw-bold text-uppercase">Senang Tours & Travel</span>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <span class="fw-bold text-uppercase">Inovice Voucher</span>
                </div>
            </div> 
        </header>

        <section>
            <div class="container my-1">
                <div class="row ">
                    <div class="col-12 text-end">
                        <button class="btn btn-outline-primary d-print-none" onclick="window.print();">
                            <label class="ti ti-file-export mb-sm-1 me-sm-2"></label>Print
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row border p-2">
                    <div class="col-6">
                        <span class="fw-bold me-4">
                            Tour Code 
                        </span>
                        <span style="font-weight: 500;">
                            : {{ $tagihan->reservasi->tour_code}}
                        </span>
                    </div>
                    <div class="col-6 text-end">
                        <span class="fw-bold mx-4">Date</span> 
                        <span style="font-weight: 500;">: {{ $tagihan->reservasi->dob}} </span> 
                    </div>
                </div>
            </div> 

            <div class="container mt-1">
                <div class="row border p-2">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-bold me-3">
                                    Nama Tamu
                                </span>
                                <span style="font-weight: 500;">: {{ $tagihan->reservasi->guest_name}}</span> 
                            </div>
                            <div class="col-12">
                                <span class="fw-bold" style="margin-right: 3em;">
                                    Negara
                                </span>
                                <span style="font-weight: 500;">: {{ $tagihan->reservasi->bahasa->nama_bahasa}}</span> 
                            </div>
                        </div> 
                    </div>
                    <div class="col-6 text-center">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-bold">
                                    Status Pembayaran
                                </span>
                            </div>
                            <div class="col-12">
                                @php
                                $bg = $tagihan->status == 'paid' ? 'bg-success' : 'bg-danger'; 
                                @endphp
                                <span class="d-print-none badge <?=$bg?> text-white" style="font-size:500">
                                    {{$tagihan->status}}
                                </span>

                                <span class="d-none d-print-block text-dark" style="font-weight:500;">
                                    {{$tagihan->status}}
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </section>

        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5>Data Order</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed">
                                <tr>
                                    <td>ID</td>
                                    <td><b>#{{ $tagihan->id }}</b></td>
                                </tr>
                                <tr>
                                    <td>Total Harga</td>
                                    <td><b>Rp {{ number_format($tagihan->total, 2, ',', '.') }}</b></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td><b>{{ $tagihan->created_at->format('d M Y H:i') }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 d-print-none">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5>Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            @if ($tagihan->status == 'pending')
                            <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button>
                            @elseif ($tagihan->status == 'paid')
                            Pembayaran berhasil!
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="text-center p-2"  style="font-size: 0.8rem;background-color: #AAA6A6;">
                            Apabila memerlukan bantuan, mohon hubungi SenangTours&Travel di <span class="fw-bold">CUSTOMER SERVICE</span> 0813 4562 7788 <span class="fw-bold ms-4">EMAIL </span> cs@SenangTours.com
                        </p>
                        <div class="col-12 text-center"  style="font-size: 0.8rem;">
                            <span class="fw-bold">SENANG TOURS & TRAVEL</span>
                            <br>
                            <p>
                                Jl. Merdeka No 9009, Denpasar - Denpasar, Bali - 80122
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/js/crud/crud.js') }}"></script>
    @if ($tagihan->status == 'pending')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {

             onSuccess: function (result) {
                console.log('Payment Success:', result);

                fetch('/tagihan/callback', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(result),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Status updated on server:', data.message);
                    alert('Pembayaran berhasil! Status tagihan diperbarui.');
                })
                .catch(error => {
                    console.error('Error updating payment status:', error);
                    alert('Terjadi kesalahan saat memperbarui status pembayaran. Silakan coba lagi.');
                });
            },
            // onSuccess: function(result) {
            //     Swal.fire({
            //       title: 'Success!',
            //       text: 'Pembayaran telah berhasil!',
            //       icon: 'success',
            //       confirmButtonText: 'OK',
            //   });


            //     console.log(result.status_message)
            // },
            onPending: function(result) {
                showToastr('warning', 'Pembayaran belum diselesaikan!.', 'Peringatan');
            },
            onError: function(result) {
                showToastr('error', 'Pembayaran gagal dilakukan!.', 'Peringatan');
            }
        });
        });
    </script>
    @endif
</body>
</html>