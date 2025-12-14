<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INVOICE PRINT - {{ count($invoices) * $copy }}</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=B612&display=swap');

    html,
    body {
        font-family: 'B612', sans-serif;
    }


    body>div>table:nth-child(13)>tbody>tr>td:nth-child(2)>span {
        position: relative;
        top: 4px;
    }

    .informationphone1 {


        position: relative;
        bottom: 2.1px;
        font-size: 22px;
        right: 3px;
    }

    .sex {
        position: relative;
        top: 5px;
    }

    .informationphone2 {
        position: relative;
        right: 249%;
        bottom: 9px;
        font-size: 22px;
    }

    .logoimage {
        position: relative;
        bottom: 25px;
        max-width: 150px;
        max-height: 80px;
        object-fit: contain;
    }

    .three {
        position: relative;
        bottom: 3px;
    }

    .elevent {
        position: relative;
        top: 59px;
        width: 100%;
    }


    .four {
        position: relative;
        top: 4px;
    }

    .basicinfo {
        position: relative;
        bottom: 28px;
    }

    body>div>div:nth-child(8) {
        position: relative;
        top: 64px;
    }

    p.informationnote {
        font-weight: bold;
        font-size: 19px;
        position: relative;
        bottom: 36px;
    }


    .invoice-box {
        width: 14.8cm;
        height: 21cm;
        border: 1px solid black;
        margin: 10px auto;
        border-radius: 5px;
        box-shadow: 0 3px 6px black;
        padding: 10px 15px;
    }

    h5,
    h6 {
        margin: 0;
        color: black;
    }

    table {
        width: 100%;
    }

    td {
        padding: 0x 0;
    }

    @media print {
        .invoice-box {
            border: none;
            box-shadow: none;
        }
    }

    /* imagesproduct */

    .imagesitemclass {
        margin: 1px;
    }

    .imagesitem {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .image-container {
        margin: 10px;
        width: 200px;
        height: 200px;
        overflow: hidden;
        border-radius: 5px;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.2s ease-in-out;
    }

    .image-container:hover img {
        transform: scale(1.1);
    }
</style>

<body>
    @foreach ($invoices as $inv)
        @for ($i = 0; $i < $copy; $i++)
            <div class="invoice-box">
                <table>
                    <tr>
                        <td style="width: 74%">
                            <h5 style="font-weight: bold;font-size:28px;">{{ $merchant->name ?? 'شــركــة' }}</h5>
                        </td>
                        <td style="width: 50%; text-align:left;">
                            <img class="logoimage" src="{{ $merchant->logo ?? asset('images/logo.png') }}" alt="">
                        </td>
                    </tr>
                </table>
                <div class="basicinfo">
                    <div class="one" style="width: 100%;height:2px;background-color: black"></div>
                    <table>
                        <tr>
                            <td style="width: 50%">
                                <h6 style="margin-top: 5px; font-size: 16px;">تاريخ :
                                    <span>{{ $inv->created_at->format('Y/m/d') }}</span>
                                </h6>
                            </td>
                            <td style="">
                                <h6 style="margin-top: 7px; font-size: 16px; position: relative; left: 18%;"> <span>
                                        {!! DNS1D::getBarcodeHTML($inv->id, 'C128') !!} </span></h6>
                            </td>
                            <td style="width: 50%; padding: 10px 0;">
                                <h6 style="margin-top: 5px; font-size: 16px; text-align:left">
                                    <span
                                        style="border: 2px solid rgb(75, 75, 75); padding:5px 12px;border-radius:3px;">NO.
                                        {{ strtoupper($inv->id) }} </span>
                                </h6>
                            </td>
                        </tr>
                    </table>
                    <div class="tow" style="width: 100%;height:2px;background-color: black"></div>
                    <table>
                        <tr>
                            <td style="width: 100%">
                                <h6 style="margin-top: 5px; font-size: 23px;"> شركة الشحن : {{ $inv->shiping }} </h6>
                            </td>
                        </tr>
                    </table>
                    <div class="three" style="width: 100%;height:2px;background-color: black"></div>
                    <table>
                        <tr>
                            <td style="width: 30%">

                                <span style="border: 2px solid rgb(75, 75, 75); padding:5px 15px;border-radius:3px;">
                                    أسم البيج</span></h6>
                            </td>
                            <td style="width: 70%;">
                                <span style="font-size: 23px;">{{ $inv->page_name }}.</span>
                            </td>
                            <td style="width: 70%;">
                                <span style="font-size: 23px;">{{ $merchant->phone_primary ?? $siteSetting->phone }}</span>
                            </td>
                        </tr>
                    </table>
                    <div class="four" style="width: 100%;height:2px;background-color: black"></div>
                    <table>
                        <tr>
                            <td style="width: 30%">
                                <h6 style="margin-top: 5px; font-size: 16px;"><span
                                        style="border: 2px solid rgb(75, 75, 75); padding:5px 8px;border-radius:3px; position:relative; top:9px;">
                                        أسم الزبون</span></h6>
                            </td>
                            <td style="width: 70%;">
                                <span
                                    style="font-size: 20px; position: relative; top: 12px; left: 32%;">{{ $inv->customer_name }}</span>
                            </td>
                            <td style="width: 70%;">
                                <span class="informationphone1">{{ $inv->phone1 }}</span>
                            </td>

                        </tr>




                        <td>
                            <span class="informationphone2">{{ $inv->phone2 }}</span>
                        </td>

                        <div class="elevent" style="height:2px;background-color: black"></div>


                    </table>
                    <table>

                        <tr>
                            <td style="width: 30%">
                                <h6 style="margin-top: -10px; font-size: 14px;"><span
                                        style="border: 2px solid rgb(75, 75, 75); padding:5px 14px;border-radius:3px;">
                                        المحافظة</span></h6>
                            </td>
                            <td style="width: 70%;">
                                <span
                                    style="font-size: 14px; position: relative; left: 20%; bottom: 5px;">{{ $inv->state }}
                                    {{ $inv->city }} {{ $inv->address }} </span>
                            </td>
                        </tr>
                    </table>
                    <div class="five" style="width: 100%;height:2px;background-color: black"></div>

                    <table>
                        <tr>
                            <td style="width: 30%">
                                <h6 style="margin-top: 5px; font-size: 16px;"><span
                                        style="border: 2px solid rgb(75, 75, 75); padding:5px 7px;border-radius:3px;">
                                        المبلغ الكلي</span></h6>
                            </td>
                            <td style="width: 30%;">
                                <span
                                    style="font-size: 23px; position: relative; left: -30%;">{{ $inv->price }}</span>
                            </td>
                            <td style="width: 30%; text-align:center;">
                                <h6 style="margin-top: 5px; font-size: 16px;"><span
                                        style="border: 2px solid rgb(75, 75, 75); padding:5px 12px;border-radius:3px;">
                                        العدد </span></h6>
                            </td>
                            <td style="width: 10%">
                                <span class="informationorder2">{{ $inv->total_quantity }}</span>
                            </td>
                        </tr>

                    </table>
                    <div class="sex" style="width: 100%;height:2px;background-color: black"></div>

                    <table style="margin-bottom: 15px;">
                        <tr>
                            <td style="width: 20%">
                                <h6 style="margin-top: 5px; font-size: 16px;"><span
                                        style="border: 2px solid rgb(75, 75, 75);
                             padding:5px 9px;border-radius:3px; position: relative; top: 8px;">
                                        نوع المنتج</span></h6>
                            </td>
                            <td style="width: 80%;">
                                @foreach ($inv->items as $item)
                                    {{-- <span
                                        style="font-size: 16px  !important; position: relative; top: 10px;">{{ $item->product->name }}
                                        ({{ $item->variant->var_name }})
                                        x {{ $item->quantity }}</span> , --}}
                                    <span
                                        style="font-size: 16px  !important; position: relative; top: 10px;">{{ $item->product->name }}
                                        ({{ $item->variant->var_name }})
                                         </span>
                                @endforeach
                            </td>
                        </tr>
                    </table>




                    <div class="seven" style="width: 100%;height:2px;background-color: black"></div>

                    <table style="margin-bottom: 15px;">
                        <tr>
                            <td style="width: 20%">
                                <h6 style="margin-top: 5px; font-size: 16px;"><span
                                        style="border: 2px solid rgb(75, 75, 75); padding:5px 15px;border-radius:3px; position: relative; top: 4px;">
                                        ملاحـظـة</span></h6>
                            </td>
                            <td style="width: 30%;">
                                <span
                                    style="font-size: 23px !important; position: relative; top: 5px;">{{ $inv->note }}</span>
                            </td>
                        </tr>
                    </table>
                    <div class="ehyt" style="width: 100%;height:2px;background-color: black"></div>
                </div>


                <table>


                        <table>
                            <tr>
                                <td style="width: 100%;text-align:center;padding:0;">
                                    <h6
                                        style="margin-top: 5px; font-size: 50px;font-weight:bolder; font-weight: bold; position: relative;   bottom: 23px;">
                                        أنتباه - أنتباه - أنتباه</h6>
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 100%;text-align:center;padding:0;">
                                    <p class="informationnote">الرجاء من المندوب فتح وفحص الطلب </p>
                                    <p class="informationnote">امام الزبون قبل التسليم وعند الاسترجاع او الاستبدال لضمان
                                        حق
                                        الطرفين</p>
                                </td>
                            </tr>
                        </table>





            </div>
        @endfor
    @endforeach
    <script>
        window.print();
    </script>
</body>

</html>
