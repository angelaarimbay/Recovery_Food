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
    <p class="header">Inventory Summary Report</p>

    <table style="border:none; width: 100%">
        <tr>
            <td style="border:none;text-align: left; width: auto"> </td>
            <td style="border:none; text-align: right; width: auto">
                Month Of: {{ date('F', mktime(0, 0, 0, $param['month'], 10)) }}
            </td>
        </tr>
    </table>

    <!-- Table -->
    <table style="width: 100%">
        <!-- Header -->
        <tr style="font-size: 16px; background-color: red">
            <th style="color: white">
                <h6>SUPPLIES CATEGORY</h6>
            </th>
            <th style="color: white">
                <h6>BEGINNING INVENTORY</h6>
            </th>
            <th style="color: white">
                <h6>PURCHASES</h6>
            </th>
            <th style="color: white">
                <h6>TOTAL INVENTORY</h6>
            </th>
            <th style="color: white">
                <h6>OUTGOING SUPPLIES</h6>
            </th>
            <th style="color: white">
                <h6>STOCKS ON HAND</h6>
            </th>
            <th style="color: white">
                <h6>ENDING INVENTORY</h6>
            </th>
            <th style="color: white">
                <h6>VARIANCE</h6>
            </th>
            <th style="color: white">
                <h6>FLUCTUATION</h6>
            </th>
        </tr>
        <!-- Rows -->
        @foreach ($data as $key => $items)
            <tr>
                <td style="width: auto; text-align: left"> {!! $items['category'] !!} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['beginning'], 2) }} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['incoming'], 2) }} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['total'], 2) }} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['outgoing'], 2) }} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['stocks'], 2) }} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['ending'], 2) }} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['variance'], 2) }} </td>
                <td style="width: auto; text-align: right"> {{ number_format($items['fluctuation'], 2) }} </td>
            </tr>
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
