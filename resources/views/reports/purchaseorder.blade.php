<html>
<style>
    .table_po td {  
        border: 1px solid #ddd;
        padding-top: 0;
        padding-bottom: 0;
        font-size: 14px;
    }
    
    .table_po {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }
    .page-break {
        page-break-after: always;
    }

</style>
    <body>

    <!-- Recovery Food Logo -->
    <div style="padding-left: 42%; padding-top: -30;">   
        <img src="{{ public_path(). '/img/logo.jpg' }}" 
            style=" display: block;  margin-left: auto; margin-right: auto;  width: 150px;"></img>
    </div>

    <!-- Title -->
    <h6 style="font-size: 15px; text-align: center; margin-top: 0; margin-bottom: 0">PURCHASE ORDER REPORT</h6>
    <p style="text-align: right; margin-top: 0; margin-bottom: 0"> Date Exported: {{ date("m-d-Y") }} </p>

    <!-- Purchase Order Info -->
    <table class="table_po" style="width: 100%">
         <tr>
            <th style="text-align: left"><h6>#</h6></th>
            <th style="text-align: left"><h6>SUPPLIER NAME</h6></th>
            <th style="text-align: left"><h6>INVOICE NUMBER</h6></th>
            <th style="text-align: left"><h6>AMOUNT</h6></th>
            <th style="text-align: left"><h6>DATE</h6></th>
        </tr>
        @foreach ($data as $items)  
                <tr>
                   <td style="width: 10%"> {{ $loop->iteration }} </td>
                   <td style="width: 20%"> {{ $items['supplier_name_details']['supplier_name'] }} </td>
                   <td style="width: 20%"> {{ $items['invoice_number'] }} </td>
                   <td style="width: 20%"> {{ $items['format_amount'] }} </td>
                   <td style="width: 20%"> {{ $items['incoming_date'] }} </td>
                </tr>
        @endforeach
        </table>
    </body>
</iframe>
</html>