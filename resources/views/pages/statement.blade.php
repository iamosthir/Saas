<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statement</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-between">
                <h3>{{ $merchant->name ?? 'Company Name' }}</h3>
                <p class="text-muted"><strong>Date : {{ now()->format('d/m/Y') }}</strong></p>
            </div>
            <div class="col-md-12 mt-3">
                <table class="table table-striped">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>أسم الزبون</th>
                            <th>رقم الهاتف</th>
                            <th>العنوان</th>
                            <th>أسم المنتج</th>
                            <th>العدد</th>
                            <th>السعر</th>
                            <th>أسم الصفحة</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><span class="badge badge-pill bg-info" dir="ltr">#{{ $order->id }}</></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->phone1 }}</td>
                                <td>{{ $order->state.",".$order->city }}</td>
                                <td>{{ $order->product_type }}</td>
                                <td>{{ $order->qnt }}</td>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->page_name }}</td>
                                <td>
                                    @if ($order->status == "pending")
                                        <span class="badge bg-warning">جاري الشحن</span>
                                    @elseif ($order->status == "delayed")
                                        <span class="badge bg-warning">مؤجل</span>
                                    @elseif ($order->status == "completed")
                                        <span class="badge bg-success">واصل تم</span>
                                    @elseif ($order->status == "canceled")
                                        <span class="badge bg-danger">Canceled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        window.print();
    </script>
</body>
</html>
