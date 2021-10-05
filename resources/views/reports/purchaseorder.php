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
        display: block;
        margin-left:auto;
        margin-right: auto;
        width: 150px;
        font-style:oblique;
    }
</style>

    <body>
    <div style="padding-left: 42%; padding-top: -30;">   

            <img  src="{{ public_path(). '/img/logo.jpg' }}" 
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 120px;"></img>

    </div>
    <p class="header">Purchase Order Report</p>
    <p class="date">Date exported:
            {{ date("Y-m-d") }}
    </p> <hr class="line">

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>Supplier Name</h6></th>
                <th><h6>Invoice Number</h6></th> 
                <th><h6>Total Amount</h6></th> 
                <th><h6>Date</h6></th>  
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)   
            <tr>
                <td  style="width: 25%;"> {{ $items['supplier_name'] }} </td>
                <td  style="width: 25%;"> {{ $items['invoice_number'] }} </td>
                <td  style="width: 25%;"> {{ $items['total_amount'] }} </td>  
                <td  style="width: 25%;"> {{ $items['incoming_date'] }}  </td>
            </tr>  
            @endforeach
        </table>
    </body>
</iframe>
</html>