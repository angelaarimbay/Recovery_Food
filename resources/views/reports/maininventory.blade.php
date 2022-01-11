<html>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    table,
    td,
    th {
        padding: 3px;
        border: 1px solid lightgray;
        border-collapse: collapse;
        text-align: center;
    }

    td {
        font-size: 12px;
    }

    th {
        font-size: 16px;
        color: black;
    }

    @page {
        header: page-header;
        footer: page-footer;
    }

    .body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
    }

    .header {
        text-align: center;
        font-size: 12px;
        margin: 0px;
    }

</style>

<body>
    <div class="row">
        <div class="header" style="text-align: right"> Date: <strong>{{ date('F d, Y') }}</strong>
        </div>
    </div>

    <div style="text-align: center">
        @if ($img != null)
            <img src="{{ public_path() . '/storage/logo/' . $img }}" style="width: 50px"></img>
        @else
            <img src="{{ public_path() . '/img/logo.jpg' }}" style="width: 50px"></img>
        @endif
    </div>
    <p class="header">Recovery Food</p>
    <p class="header">Main Inventory Report</p>


    <!-- Table -->
    <table style="width: 100%; margin-top: 10px">

        @foreach ($data as $array)
            <tr>
                <td colspan="29" style="text-align: center; font-size: 16px; background-color: red; color: white">
                    <h5>{{ $array[0]['category'] }}</h5>
                </td>
            </tr>
            <!-- Header -->
            <tr>
                <th rowspan="2">
                    <h6>SUPPLY NAME</h6>
                </th>
                <th rowspan="2">
                    <h6>UNIT</h6>
                </th>
                <th rowspan="2">
                    <h6>NET PRICE</h6>
                </th>
                <th colspan="2">
                    <h6>BEGINNING INVENTORY</h6>
                </th>
                <th colspan="2">
                    <h6>INCOMING SUPPLIES</h6>
                </th>
                <th colspan="2">
                    <h6>TOTAL STOCKS</h6>
                </th>
                <th colspan="2">
                    <h6>OUTGOING SUPPLIES</h6>
                </th>
                <th colspan="2">
                    <h6>STOCKS ON HAND</h6>
                </th>
                <th colspan="2">
                    <h6>AVERAGE DAILY USAGE</h6>
                </th>
                <th rowspan="2">
                    <h6>LEAD TIME</h6>
                </th>
                <th rowspan="2">
                    <h6>ORDER POINT</h6>
                </th>
                <th rowspan="2">
                    <h6>MINIMUM ORDER QTY</h6>
                </th>
                <th rowspan="2">
                    <h6>ORDER QTY</h6>
                </th>
                <th rowspan="2">
                    <h6>ORDER FREQUENCY</h6>
                </th>
                <th rowspan="2">
                    <h6>TRIGGER POINT</h6>
                </th>
                <th colspan="2">
                    <h6>ENDING INVENTORY</h6>
                </th>
                <th colspan="2">
                    <h6>CONSUMPTION</h6>
                </th>
                <th colspan="2">
                    <h6>IDEAL INVENTORY</h6>
                </th>
                <th colspan="2">
                    <h6>VARIANCE</h6>
                </th>
            </tr>
            <!-- Rows -->
            <tr>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
                <th scope="col">
                    <h6>QTY</h6>
                </th>
                <th scope="col">
                    <h6>VALUE</h6>
                </th>
            </tr>
            @foreach ($array as $items)
                <tr>
                    <td style="width: 15%; text-align: left"> {!! $items['supply_name'] !!}</td>
                    <td style="width: auto; text-align: left"> {{ $items['unit'] }} </td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['net_price'], 2) }} </td>
                    <td style="width: auto; text-align: right"> {{ $items['beginning_q'] ?? 0 }} </td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['beginning_a'] ?? 0, 2) }} </td>
                    <td style="width: auto; text-align: right"> {{ $items['incoming_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['incoming_a'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['total_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['total_a'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['outgoing_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['outgoing_a'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['onhand_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['onhand_a'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['average_q'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format($items['average_a'] ?? 0, 2) }}</td>
                    <td style="width: auto"> {{ $items['lead_time'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['orderpoint'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['minimum_order_quantity'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['ordr'] ?? 0 }}</td>
                    <td style="width: auto"> {{ $items['order_frequency'] ?? 0 }}</td>
                    <td style="width: auto; text-align: left"> {!! $items['triggerpoint'] ?? 0 !!}</td>
                    <td style="width: auto; text-align: right"> {{ $items['ending_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['ending_a'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['consumption_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['consumption_a'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['ideal_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['ideal_a'] ?? 0, 2) }}</td>
                    <td style="width: auto; text-align: right"> {{ $items['variance_q'] ?? 0 }}</td>
                    <td style="width: auto; text-align: right"> {{ number_format((float)$items['variance_a'] ?? 0, 2) }} </td>
                </tr>
            @endforeach
        @endforeach

    </table>

    <div class="row" style="margin-top: 15px">
        <div class="header" style="text-align: right">
            Prepared By:
            <strong>{{ $process_by }}</strong>
        </div>
    </div>
    <!-- Page Number -->
    <htmlpagefooter name="page-footer">
        <p style="bottom: 0%;  ">Page {PAGENO} of {nb}</p>
    </htmlpagefooter>
</body>
</iframe>

</html>
