<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $payment->transaction_id }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-sm.png') }}">
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f6fa; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #dddddd;">

        <!-- Header -->
        <div style="background-color: #007aff; color: #ffffff; padding: 20px; text-align: center;">
            <div style="font-size: 24px; font-weight: bold;">
                <img src="https://i.ibb.co.com/NgKp73dC/logo-light.png" alt="" width="250px">
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        <div style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <table style="width: 48%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">No</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">{{ $payment->transaction_id }}</b>
                        </td>
                    </tr>
                </table>

                <!-- Tabel Kanan -->
                <table style="width: 48%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">Date</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">{{ $payment->created_at->format('d M Y') }}</b>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="height: 2px; background-color: #007aff;"></div>
        </div>

        <!-- Informasi Mahasiswa -->
        <div style="padding: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <!-- Tabel Kiri -->
                <table style="width: 48%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">Nama</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">{{ $payment->bill->student->user->name }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">Prodi</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">{{ $payment->bill->student->major->name }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">NIM</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">{{ $payment->bill->student->user->nim }}</b>
                        </td>
                    </tr>
                </table>

                <!-- Tabel Kanan -->
                <table style="width: 48%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">No HP</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">{{ $payment->bill->student->phone }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">Semester</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">Genap</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <p style="margin: 0; font-size: 14px; color: #666;">Tahun Ajaran</p>
                        </td>
                        <td style="padding: 5px 0; text-align: center; width: 10px;">:</td>
                        <td style="padding: 5px 0;">
                            <b style="font-size: 14px; color: #111;">2025/2026</b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detail Pembayaran -->
        <div style="padding: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #007aff; color: #ffffff;">
                        <th style="padding: 10px; text-align: left;">Details</th>
                        <th style="padding: 10px; text-align: left;">Description</th>
                        <th style="padding: 10px; text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #dddddd;">
                            {{ $payment->bill->payment_type->name }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #dddddd;">
                            {{ $payment->bill->payment_type->description }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #dddddd; text-align: right;">
                            {{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Total Pembayaran -->
        <div style="padding: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <tr style="background-color: #f5f6fa;">
                        <td style="padding: 10px; font-weight: bold; color: #111;">Subtotal</td>
                        <td style="padding: 10px; text-align: right; font-weight: bold; color: #111;">
                            {{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr style="background-color: #f5f6fa;">
                        <td style="padding: 10px; color: #111;">Tax <span style="color: #b5b5b5;">(0%)</span></td>
                        <td style="padding: 10px; text-align: right; color: #111;">Rp. 0</td>
                    </tr>
                    <tr style="background-color: #007aff; color: #ffffff;">
                        <td style="padding: 10px; font-weight: bold;">Grand Total</td>
                        <td style="padding: 10px; text-align: right; font-weight: bold;">
                            {{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div style="padding: 20px; text-align: center; background-color: #f5f6fa;">
            <p style="margin: 0 0 10px 0; font-size: 16px; font-weight: bold; color: #111;">Sekolah Tinggi Teknologi
                Dumai</p>
            <p style="margin: 0;">
                Jl. Utama Karya, Bukit Batrem, Dumai, Riau<br>
                akademik@sttdumai.ac.id <br>
                082174342828
            </p>
        </div>
    </div>
</body>

</html>
