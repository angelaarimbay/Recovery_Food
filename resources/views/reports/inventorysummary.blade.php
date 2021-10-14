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
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 130px;"></img>
    </div>
    <p class="header">Inventory Summary Report</p>
    <p class="date">Date exported:
        {{ date("Y-m-d") }}
    </p>

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>SUPPLIES CATEGORY</h6></th>
                <th><h6>INCOMING SUPPLIES</h6></th>
                <th><h6>OUTGOING SUPPLIES</h6></th>
                <th><h6>STOCKS ON HAND</h6></th>
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)  
            <tr>
                <td  style="width: auto"> {{ $items['category'] }} </td>
                <td  style="width: auto"> {{ $items['incoming'] }} </td>
                <td  style="width: auto"> {{ $items['outgoing'] }} </td>
                <td  style="width: auto"> {{ $items['stocks'] }} </td>
            </tr>  
            @endforeach
        </table>
        <!-- Page Number -->
        <p style="bottom: 0%; position: fixed">Page {PAGENO} of {nb}</p>
    </body>
</iframe>
</html>