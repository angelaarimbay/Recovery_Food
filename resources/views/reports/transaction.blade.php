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
                style="display: block;  margin-left: auto; margin-right: auto;  width: 150px;"></img>
    </div>
    <p class="header">Transaction Report</p>
    <p class="date">Date exported:
            {{ date("Y-m-d") }}
    </p>

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>BRANCH</h6></th>
                <th><h6>DATE</h6></th> 
                <th><h6>REFERENCE NO</h6></th> 
                <th><h6>TOTAL PRODUCT(S)</h6></th>  
                <th><h6>TOTAL AMT</h6></th>
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)  
            <tr>
                <td style="width: auto"> {{ $items['branch_name_details']['branch_name'] }} </td>
                <td style="width: auto"> {{ date("Y-m-d", strtotime($items['created_at'])) }} </td>
                <td style="width: auto"> {{ $items['reference_no'] }} </td>  
                <td style="width: auto"> {{ $items['quantity'] }} </td>
                <td style="width: auto"> {{ number_format($items['total_amount'],2) }} </td> 
            </tr>  
            @endforeach
        </table>
        <!-- Page Number -->
        <p style="bottom: 0%; position: fixed">Page {PAGENO} of {nb}</p>
    </body>
</iframe>
</html>