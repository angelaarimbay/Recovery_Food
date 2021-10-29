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
    @page {
        header: page-header;
        footer: page-footer;
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
                <th><h6>BEGINNING INVENTORY</h6></th>
                <th><h6>PURCHASES</h6></th>
                <th><h6>TOTAL STOCKS</h6></th>
                <th><h6>OUTGOING</h6></th>
                <th><h6>STOCKS ON HAND</h6></th>
                <th><h6>ENDING INVENTORY</h6></th>
                <th><h6>VARIANCE</h6></th>
                <th><h6>FLUCTUATION</h6></th>
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)  
            <tr>
                <td style="width: auto"> {{ $items['category'] }} </td>
                <td style="width: auto"> {{ $items['begining'] }} </td>
                <td style="width: auto"> {{ $items['incoming'] }} </td>
                <td style="width: auto"> {{ $items['total'] }} </td>
                <td style="width: auto"> {{ $items['outgoing'] }} </td>
                <td style="width: auto"> {{ $items['stocks'] }} </td>
                <td style="width: auto"> {{ $items['ending'] }} </td>
                <td style="width: auto"> {{ $items['variance'] }} </td>
                <td style="width: auto"> {{ $items['fluctuation'] }} </td>
            </tr>  
            @endforeach
            <tr>
                <th><h5>GRAND TOTALS</h5></th>
                <td><h5>{{ $items['begining_orig'] }}</h5></td>
                <td><h5></h5></td>
                <td><h5></h5></td>
                <td><h5></h5></td>
                <td><h5></h5></td>
                <td><h5></h5></td>
                <td><h5></h5></td>
                <td><h5></h5></td>
            </tr>
        </table>
        <!-- Page Number --> 
        <htmlpagefooter name="page-footer">
        <p style="bottom: 0%;  ">Page {PAGENO} of {nb}</p>      
        </htmlpagefooter>
    </body>
</iframe>
</html>