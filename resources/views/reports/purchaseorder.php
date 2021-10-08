<html>
<style>
    table, td, th {
        padding: 10px;
        border: 1px solid lightgray;
        border-collapse: collapse;
        text-align: center;
    }
    
    td{
        font-size: 15px;
    }
    
    th{
        background-color:aliceblue;
        color: black;
    } 
    
    .body{
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }

    .header{
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        margin: 0px;
    }
</style>
    <body>
    <div style="text-align: center">   
            <img src="{{ public_path(). '/img/logo.jpg' }}" 
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 120px;"></img>
    </div>
    <p class="header">Purchase Order Report</p>
    <p class="date">Date exported:
            {{ date("Y-m-d") }}
    </p>

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>SUPPLIER NAME</h6></th>
                <th><h6>INVOICE NUMBER</h6></th> 
                <th><h6>AMT</h6></th> 
                <th><h6>DATE</h6></th>  
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)
            <tr>
                <td style="width: auto"> {{ $items['supplier_name_details']['supplier_name'] }} </td>
                <td style="width: auto"> {{ $items['invoice_number'] }} </td>
                <td style="width: auto"> {{ $items['total_amount'] }} </td>
                <td style="width: auto"> {{ $items['incoming_date'] }} </td>
            </tr>
            @endforeach
        </table>
        <!-- Page Number -->
        <p style="bottom: 0%; position: fixed">Page {PAGENO} of {nb}</p>
    </body>
</iframe>
</html>