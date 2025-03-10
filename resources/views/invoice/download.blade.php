<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <!-- Site Title -->
    <title>Invoice {{ $payment->transaction_id }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-sm.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/invoice-style.css') }}">
</head>

<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style1 tm_type1" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_top_head tm_mb15 tm_align_center">
                        <div class="tm_invoice_left">
                            <div class="tm_logo"><img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo">
                            </div>
                        </div>
                        <div class="tm_invoice_right tm_text_right tm_mobile_hide">
                            <div class="tm_f50 tm_text_uppercase tm_white_color">Invoice</div>
                        </div>
                        <div class="tm_shape_bg tm_accent_bg tm_mobile_hide"></div>
                    </div>
                    <div class="tm_invoice_info tm_mb25">
                        <div class="tm_card_note tm_mobile_hide" hi><b class="tm_primary_color">Payment Method:
                            </b> {{ Str::upper($payment->payment_method) }} </div>
                        <div class="tm_invoice_info_list tm_white_color">
                            <p class="tm_invoice_number tm_m0">No: <b>{{ $payment->transaction_id }}</b></p>
                            <p class="tm_invoice_date tm_m0">Date: <b> {{ $payment->created_at->format('d M Y') }}</b>
                            </p>
                        </div>
                        <div class="tm_invoice_seperator tm_accent_bg"></div>
                    </div>
                    <div class="tm_invoice_head tm_mb10">
                        <div class="tm_invoice_left">
                            <p class="tm_mb2 tm_f16"><b class="tm_primary_color tm_text_uppercase">STT Dumai</b>
                            </p>
                            <p>
                                Jl. Utama Karya, Bukit Batrem <br>Dumai, Riau<br>
                                akademik@sttdumai.ac.id <br>
                                082174342828
                            </p>
                        </div>
                        <div class="tm_invoice_right">
                            <div class="tm_grid_row tm_col_3  tm_col_2_sm tm_invoice_table tm_round_border">
                                <div>
                                    <p class="tm_m0">Nama:</p>
                                    <b class="tm_primary_color"
                                        style="font-size: 12px">{{ $payment->bill->student->user->name }}</b>
                                </div>
                                <div>
                                    <p class="tm_m0">NIM:</p>
                                    <b class="tm_primary_color"
                                        style="font-size: 12px">{{ $payment->bill->student->user->nim }}</b>
                                </div>
                                <div>
                                    <p class="tm_m0">Prodi:</p>
                                    <b class="tm_primary_color"
                                        style="font-size: 12px">{{ $payment->bill->student->major->name }}</b>
                                </div>
                                <div>
                                    <p class="tm_m0">Semester:</p>
                                    <b class="tm_primary_color" style="font-size: 12px">Genap</b>
                                </div>
                                <div>
                                    <p class="tm_m0">Tahun Ajaran:</p>
                                    <b class="tm_primary_color" style="font-size: 12px">2025/2026</b>
                                </div>
                                <div>
                                    <p class="tm_m0">No HP:</p>
                                    <b class="tm_primary_color"
                                        style="font-size: 12px">{{ $payment->bill->student->phone }}
                                    </b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tm_table tm_style1">
                        <div class="">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                        <tr class="tm_accent_bg">
                                            <th class="tm_width_3 tm_semi_bold tm_white_color">Details</th>
                                            <th class="tm_width_4 tm_semi_bold tm_white_color">Description</th>
                                            <th class="tm_width_2 tm_semi_bold tm_white_color tm_text_right">Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="tm_width_3">{{ $payment->bill->payment_type->name }}</td>
                                            <td class="tm_width_4">{{ $payment->bill->payment_type->description }}
                                            </td>
                                            <td class="tm_width_2 tm_text_right">
                                                {{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_border_top tm_mb15 tm_m0_md">
                            <div class="tm_left_footer">

                            </div>
                            <div class="tm_right_footer">
                                <table class="tm_mb15">
                                    <tbody>
                                        <tr class="tm_gray_bg ">
                                            <td class="tm_width_3 tm_primary_color tm_bold">Subtoal</td>
                                            <td class="tm_width_3 tm_primary_color tm_bold tm_text_right">
                                                {{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="tm_gray_bg">
                                            <td class="tm_width_3 tm_primary_color">Tax <span
                                                    class="tm_ternary_color">(0%)</span></td>
                                            <td class="tm_width_3 tm_primary_color tm_text_right">Rp. 0</td>
                                        </tr>
                                        <tr class="tm_accent_bg">
                                            <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color">Grand
                                                Total </td>
                                            <td
                                                class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_white_color tm_text_right">
                                                {{ 'Rp ' . number_format($payment->amount, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_type1">
                            <div class="tm_left_footer"></div>
                            <div class="tm_right_footer">
                                <div class="tm_sign tm_text_center">
                                    <p class="tm_m0 tm_f16 tm_primary_color">Ketua STT Dumai</p>
                                    <img src="{{ asset('assets/images/sign.svg') }}" alt="Sign">
                                    <p class="tm_m0 tm_ternary_color">Dra. Hj. Sirlyana, MP</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                                stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <circle cx="392" cy="184" r="24" fill='currentColor' />
                        </svg>
                    </span>
                    <span class="tm_btn_text">Print</span>
                </a>
                <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32" />
                        </svg>
                    </span>
                    <span class="tm_btn_text">Download</span>
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/js/html2canvas.min.js') }}"></script>
    <script>
        (function($) {
            'use strict';

            $('#tm_download_btn').on('click', function() {
                var downloadSection = $('#tm_download_section');
                var cWidth = downloadSection.width();
                var cHeight = downloadSection.height();
                var topLeftMargin = 0;
                var pdfWidth = cWidth + topLeftMargin * 2;
                var pdfHeight = pdfWidth * 1.5 + topLeftMargin * 2;
                var canvasImageWidth = cWidth;
                var canvasImageHeight = cHeight;
                var totalPDFPages = Math.ceil(cHeight / pdfHeight) - 1;

                html2canvas(downloadSection[0], {
                    allowTaint: true
                }).then(function(
                    canvas
                ) {
                    canvas.getContext('2d');
                    var imgData = canvas.toDataURL('image/png', 1.0);
                    var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
                    pdf.addImage(
                        imgData,
                        'PNG',
                        topLeftMargin,
                        topLeftMargin,
                        canvasImageWidth,
                        canvasImageHeight
                    );
                    for (var i = 1; i <= totalPDFPages; i++) {
                        pdf.addPage(pdfWidth, pdfHeight);
                        pdf.addImage(
                            imgData,
                            'PNG',
                            topLeftMargin,
                            -(pdfHeight * i) + topLeftMargin * 0,
                            canvasImageWidth,
                            canvasImageHeight
                        );
                    }
                    pdf.save('{{ $payment->transaction_id }}' + '.pdf');
                });
            });

        })(jQuery);
    </script>
</body>

</html>
