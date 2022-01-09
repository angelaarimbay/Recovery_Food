<html>
<style>
    body {
        text-transform: uppercase;
    }

    table,
    td,
    th {
        padding: 2px;
        border-collapse: collapse;
    }

    .header {
        text-align: center;
        font-size: 9px;
        font-family: Arial, Helvetica, sans-serif;
        margin: 1px;
    }

    .header_location {
        text-align: center;
        font-size: 9px;
        font-family: Arial, Helvetica, sans-serif;
        margin: 1px;
    }

    .footer {
        text-align: center;
        font-size: 9px;
        font-family: Arial, Helvetica, sans-serif;
        margin: 1px;
    }

    .bottom_footer {
        text-align: center;
        font-size: 9px;
        font-family: Arial, Helvetica, sans-serif;
        margin: 1px;
    }

    .body {
        font-size: 9px;
        font-family: Arial, Helvetica, sans-serif;
        margin: 1px;
        page-break-inside: avoid;
        text-transform: uppercase;
    }

    .divider {
        margin: 4px;
        color: transparent;
    }

</style>

<body style="height: 100%">
    <p class="header"> Recovery Food </p>
    <p class="header"> {{ $branch }} </p>
    <p class="header_location"> {{ $branch_location }} </p>

    <p style="font-size: 9px; font-family: Arial, Helvetica, sans-serif; margin-top: 15px; margin-bottom: 0px">Cashier:
        {{ $cashier_name_details }} </p>
    <hr class="divider" />
    <p class="header"> {{ date('M-d-Y h:i A', strtotime($created_at)) }} </p>
    <hr class="divider" />

    @foreach ($data as $items)
        <table style="width: 100%">
            <!-- Rows -->
            <tr>
                <td class="body" style="width: 60%"> {{ $items['product_name_details']['product_name'] }}
                    {{ $items['product_name_details']['description'] }} </td>
                <td class="body" style="width: 20%"></td>
                <td class="body" style="width: 20%"></td>
            </tr>
            <tr>
                <td class="body"> {{ $items['quantity'] }} </td>
                <td class="body" style="text-align: left">
                    {{ number_format($items['sub_total_discounted'], 2, '.', ',') }} </td>
                <td class="body" style="text-align: right">
                    {{ number_format($items['sub_total_discounted'] * $items['quantity'], 2, '.', ',') }} </td>
            </tr>
        </table>
    @endforeach
    <table style="width: 100%">
        <tr>
            <td class="body" style="width: 60%">
            </td>
            <td class="body" style="width: 40%">
                <hr class="divider" />
            </td>
        </tr>
        <tr>
            <td class="body" style="text-align: right"> Sub-Total: </td>
            <td class="body" style="text-align: right"> {{ number_format($sub_total, 2, '.', ',') }} </td>
        </tr>
        <tr>
            <td class="body" style="text-align: right"> Grand Total: </td>
            <td class="body" style="text-align: right">
                {{ number_format($sub_total_discounted, 2, '.', ',') }} </td>
        </tr>
        <tr>
            <td class="body">
            </td>
            <td class="body">
                <hr class="divider" />
            </td>
        </tr>
        <tr>
            <td class="body" style="text-align: right"> Payment: </td>
            <td class="body" style="text-align: right"> {{ number_format($payment, 2, '.', ',') }} </td>
        </tr>
        <tr>
            <td class="body" style="text-align: right"> Discount: </td>
            <td class="body" style="text-align: right"> {{ $discount }}% </td>
        </tr>
        <tr>
            <td class="body" style="text-align: right"> Change: </td>
            <td class="body" style="text-align: right"> {{ number_format($change, 2, '.', ',') }} </td>
        </tr>
        <tr>
            <td class="body">
            </td>
            <td class="body">
                <hr class="divider" />
            </td>
        </tr>
        <tr>
            <td class="body" style="text-align: right"> Vatable Sales: </td>
            <td class="body" style="text-align: right"> {{ number_format($vatable_sales, 2) }} </td>
        </tr>
        <tr>
            <td class="body" style="text-align: right"> Vat Amount: </td>
            <td class="body" style="text-align: right"> {{ number_format($vat_amount, 2) }} </td>
        </tr>
    </table>

    <!-- Footer -->
    <hr class="divider" />
    <p class="footer"> {{ $mode }} </p>
    <p class="footer"> REFERENCE NO: {{ $reference_no }} </p>
    <hr class="divider" />
    <p class="bottom_footer">Thank you!! Please come again...</p>
    <p class="bottom_footer">Contact # {{ $branch_number }}</p>
    <p class="bottom_footer">This is not an official receipt</p>
</body>

</html>
