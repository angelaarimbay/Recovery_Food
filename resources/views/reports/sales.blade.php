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
        <div class="header" style="text-align: right"> Date: <strong>{{ date('F d, Y') }}</strong> <br>
            Prepared By:
            <strong>{{ $process_by }}</strong>
        </div>
    </div>

    <div style="text-align: center">
        <img src="{{ public_path() . '/img/logo.jpg' }}" style="width: 50px"></img>
    </div>
    <p class="header">Recovery Food</p>
    <p class="header">Sales Report</p>

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
                <h6>BRANCH</h6>
            </th>
            <th>
                <h6>DATE</h6>
            </th>
            <th>
                <h6>REFERENCE NO</h6>
            </th>
            <th>
                <h6>SALES AMOUNT</h6>
            </th>
        </tr>
        <!-- Rows -->
        @foreach ($data as $items)
            <tr>
                <td style="width: auto"> {{ $items['branch_name_details']['branch_name'] }} </td>
                <td style="width: auto"> {{ date('Y-m-d', strtotime($items['created_at'])) }} </td>
                <td style="width: auto"> {{ $items['reference_no'] }} </td>
                <td style="width: auto"> {{ $items['total_amount'] }} </td>
            </tr>
        @endforeach
    </table>
    <!-- Page Number -->
    <htmlpagefooter name="page-footer">
        <p style="bottom: 0%;  ">Page {PAGENO} of {nb}</p>
    </htmlpagefooter>
</body>
</iframe>

</html>
