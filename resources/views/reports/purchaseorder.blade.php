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
        <img src="{{ public_path() . '/img/logo.jpg' }}" style="width: 50px"></img>
    </div>
    <p class="header">Recovery Food</p>
    <p class="header">Purchase Order Report</p>

    <table style="border:none; width: 100%">
        <tr>
            <td style="border:none;text-align: left; width: auto"> </td>
            <td style="border:none; text-align: right; width: auto"> From: {{ $param['from'] }} To:
                {{ $param['to'] }} </td>
        </tr>
    </table>

    <!-- Table -->
    <table style="width: 100%">
        <!-- Header -->
        <tr>
            <th>
                <h6>SUPPLIER NAME</h6>
            </th>
            <th>
                <h6>INVOICE NUMBER</h6>
            </th>
            <th>
                <h6>AMT</h6>
            </th>
            <th>
                <h6>DATE</h6>
            </th>
        </tr>
        <!-- Rows -->
        @foreach ($data as $items)
            <tr>
                <td style="width: auto; text-align: left"> {{ $items['supplier_name_details']['supplier_name'] }}
                    {{ $items['supplier_name_details']['description'] }}</td>
                <td style="width: auto"> {{ $items['invoice_number'] }} </td>
                <td style="width: auto; text-align: right"> {{ $items['format_amount'] }} </td>
                <td style="width: auto"> {{ date('Y-m-d', strtotime($items['incoming_date'])) }} </td>

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
