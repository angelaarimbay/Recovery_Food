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
                style="display: block;  margin-left: auto; margin-right: auto;  width: 130px"></img>
    </div>
    <p class="header">Masterlist Supplies Report</p>
    <p class="date">Date exported:
            {{ date("Y-m-d") }}
    </p>

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>CATEGORY</h6></th>
                <th><h6>SUPPLY NAME</h6></th> 
                <th><h6>SUPPLY DESCRIPTION</h6></th> 
                <th><h6>UNIT</h6></th>  
                <th><h6>NET PRICE</h6></th>
                <th><h6>WITH VAT</h6></th>
                <th><h6>VAT</h6></th>
                <th><h6>WITHOUT VAT</h6></th>
                <th><h6>EXPIRATION DATE</h6></th>
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)   
            <tr>
                <td  style="width: auto"> {{ $items['category_name'] }} </td>
                <td  style="width: auto"> {{ $items['supply_name'] }} </td>  
                <td  style="width: auto"> {{ $items['supply_description'] }} </td>  
                <td  style="width: auto"> {{ $items['unit'] }}  </td>
                <td  style="width: auto"> {{ $items['format_net_price'] }} </td>
                <td  style="width: auto"> {{ $items['format_with_vat'] }} </td>
                <td  style="width: auto"> {{ $items['vat'] }} </td>
                <td  style="width: auto"> {{ $items['format_without_vat'] }} </td>  
                <td  style="width: auto"> {{ date("Y-m-d",strtotime( $items['exp_date'])) }} </td>
            </tr>  
            @endforeach
        </table>
        <!-- Page Number -->
        <p style="bottom: 0%; position: fixed">Page {PAGENO} of {nb}</p>
    </body>
</iframe>
</html>