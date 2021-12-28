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
    <p class="header">Masterlist Supplies Report</p>
    <!-- Table -->
    <table style=" width: 100%; margin-top: 10px">
        <!-- Header -->

        @foreach ($data as $array)
            <tr>
                <td colspan="8" style="text-align: center; font-size: 16px; background-color: red; color: white">
                    {{ $array[0]['category_details'] }}
                </td>
            </tr>
            <tr>
                <th>
                    <h6>SUPPLIER NAME</h6>
                </th>
                <th>
                    <h6>SUPPLY NAME</h6>
                </th>
                <th>
                    <h6>UNIT</h6>
                </th>
                <th>
                    <h6>NET PRICE</h6>
                </th>
                <th>
                    <h6>WITH VAT</h6>
                </th>
                <th>
                    <h6>VAT</h6>
                </th>
                <th>
                    <h6>WITHOUT VAT</h6>
                </th>
                <th>
                    <h6>EXPIRATION DATE</h6>
                </th>
            </tr>

            <!-- Rows -->
            @foreach ($array as $items)
                {{-- @if ($items['supplier_name'] == '<b>TOTAL</b>')
                    <tr style="background-color: #BEBEBE">
                        <td style="width: auto; text-align: left"><b>TOTAL</b></td>
                        <td style="width: auto; text-align: left"> </td>
                        <td style="width: auto; text-align: left"> </td>
                        <td style="width: auto; text-align: right"><b>{{ number_format($total_n, 2) }}</b></td>
                        <td style="width: auto; text-align: right"><b>{{ number_format($total_wv, 2) }}</b></td>
                        <td style="width: auto; text-align: left"> </td>
                        <td style="width: auto; text-align: right"><b>{{ number_format($total_wov, 2) }}</b></td>
                        <td style="width: auto; text-align: left"> </td>
                    </tr>
                @else --}}
                    <tr>
                        <td style="width: auto; text-align: left"> {!! $items['supplier_name'] !!} </td>
                        <td style="width: auto; text-align: left"> {{ $items['supply_name'] }}
                            {{ $items['description'] }}
                        </td>
                        <td style="width: auto; text-align: left"> {{ $items['unit'] }} </td>
                        <td style="width: auto; text-align: right">
                            {{ $items['net_price'] ? number_format($items['net_price'], 2) : '' }} </td>
                        <td style="width: auto; text-align: right">
                            {{ $items['with_vat'] ? number_format($items['with_vat'], 2) : '' }} </td>
                        <td style="width: auto"> {{ $items['vat'] }} </td>
                        <td style="width: auto; text-align: right">
                            {{ $items['without_vat'] ? number_format($items['without_vat'], 2) : '' }} </td>
                        <td style="width: 10%">
                            {{ $items['exp_date'] ? date('Y-m-d', strtotime($items['exp_date'])) : null }} </td>
                    </tr>
                {{-- @endif --}}
            @endforeach
        @endforeach
        {{-- <tr>
            <td style=" border: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
        </tr>
        <tr>

            <td style=" border: none; width: auto"> Grand Total </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border-top: none;  border-left: none; border-right: none; width: auto">
                {{ number_format($net_price, 2) }} </td>
            <td style=" border-top: none;  border-left: none; border-right: none; width: auto">
                {{ number_format($with_vat, 2) }} </td>
            <td style=" border: none;width: auto"> </td>
            <td style=" border-top: none;  border-left: none; border-right: none; width: auto">
                {{ number_format($with_vat, 2) }} </td>
            <td style=" border: none;width: auto"> </td>
        </tr>
        <tr>

            <td style=" border: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border-bottom: none;  border-left: none; border-right: none; width: auto"> </td>
            <td style=" border-bottom: none;  border-left: none; border-right: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
            <td style=" border-bottom: none;  border-left: none; border-right: none; width: auto"> </td>
            <td style=" border: none; width: auto"> </td>
        </tr> --}}
    </table>

    <div class="row" style="margin-top: 15px">
        <div class="header" style="text-align: right">
            Prepared By:
            <strong>{{ $process_by }}</strong>
        </div>
    </div>
    <!-- Page Number -->
    <htmlpagefooter name="page-footer">
        <p style="bottom: 0%;">Page {PAGENO} of {nb}</p>
    </htmlpagefooter>
</body>
</iframe>

</html>
