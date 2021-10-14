<html>
<style>
    table, td, th {
        padding: 3px;
        border-collapse: collapse;
    }

    .header{
        text-align: center;
        font-size: 8px;
        font-family: 'Courier New', monospace;
        text-transform: uppercase;
        margin: 1px;
    }

    .header_location{
        text-align: center;
        font-size: 8px;
        font-family: 'Courier New', monospace;
        margin: 1px;
    }

    .footer{
        text-align: center;
        font-size: 8px;
        font-family: 'Courier New', monospace;
        text-transform: uppercase;
        margin: 1px;
    }

    .bottom_footer {
        text-align: center;
        font-size: 8px;
        font-family: 'Courier New', monospace;
        margin: 1px;
    }

    .body {
        font-size: 8px;
        font-family: 'Courier New', monospace;
        text-transform: uppercase;
        margin: 1px;
        page-break-inside: avoid;
    }
    
    .divider {
        margin: 4px;
        color: transparent;
    }
</style>

<script>
    // var $getHeight = $( document ).height();
    // alert($getHeight);
</script>

    <body style="height: 100%">
        @foreach($data as $items)
        <p class="header"> Recovery Food </p>
        <p class="header"> {{ $items['branch_name_details']['branch_name'] }} </p>
        <p class="header_location"> {{ $items['branch_name_details']['location'] }} </p>

        <p style="font-size: 8px; font-family: 'Courier New', monospace; margin-top: 15px; margin-bottom: 0px"> {{ $items['cashier_name_details']['name'] }} </p>
        <hr class="divider" />
        <p class="header"> {{ date("M-d-Y h:i A", strtotime($items['created_at'])) }} </p>
        <hr class="divider" />
            <table style="width: 100%">
            <!-- Rows --> 
                <tr>
                    <td class="body" style="width: 10%"> {{ $items['quantity'] }}  </td>
                    <td class="body" style="width: 70%"> {{ $items['product_name_details']['product_name'] }} {{ $items['product_name_details']['description'] }}</td>  
                    <td class="body" style="width: 20%; text-align: right; border: none; border-bottom: 1px solid black"> {{ number_format($items['product_name_details']['format_unit_price'] * $items['quantity'], 2, ".", ",") }} </td>
                </tr>
            </table>

            <table style="width: 100%">
                <tr>
                    <td class="body" style="width: 80%; text-align: right"> Sub-Total: </td>
                    <td class="body" style="width: 20%; text-align: right"> {{ number_format($items['sub_total'], 2, ".", ",") }} </td>
                </tr>
                <tr>
                    <td class="body" style="width: 80%; text-align: right"> Grand Total: </td>
                    <td class="body" style="width: 20%; text-align: right"> {{ number_format($items['sub_total_discounted'], 2, ".", ",") }} </td>
                </tr>
                <tr>
                    <td class="body" style="width: 80%; text-align: right"> Payment: </td>
                    <td class="body" style="width: 20%; text-align: right"> {{ number_format($items['payment'], 2, ".", ",") }} </td>
                </tr>
                <tr>
                    <td class="body" style="width: 80%; text-align: right"> Discount: </td>
                    <td class="body" style="width: 20%; text-align: right"> {{ $items['discount'] }}% </td>
                </tr>
                <tr>
                    <td class="body" style="width: 80%; text-align: right"> Change: </td>
                    <td class="body" style="width: 20%; text-align: right"> {{ number_format($items['change'], 2, ".", ",")}} </td>
                </tr>
            </table>

        <!-- Footer -->
        <hr class="divider" />
        <p class="footer"> {{ $items['mode']}} </p>
        <p class="footer"> REFERENCE NO: {{ $items['reference_no']}} </p>
        <hr class="divider" />
        <p class="bottom_footer">Thank you!! Please come again...</p>
        <p class="bottom_footer">Contact # {{ $items['branch_name_details']['phone_number'] }}</p>
        <p class="bottom_footer">This serves as your Official Receipt</p> 
        @endforeach
    </body>
</iframe>
</html>