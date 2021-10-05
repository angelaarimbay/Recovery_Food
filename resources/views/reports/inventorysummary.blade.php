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
        width: 190px;
        font-style:oblique;
    }
</style>

    <body>
    <div style="padding-left: 42%; padding-top: -30;">   
            <img src="{{ public_path(). '/img/logo.jpg' }}" 
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 120px;"></img>
    </div>
    <p class="header">Inventory Summary Report</p>

    <p class="date">Date exported:
        {{ date("Y-m-d") }}
    </p> <hr class="line">

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>Category</h6></th>
                <th><h6>Incoming Supplies</h6></th>
                <th><h6>Outgoing Supplies</h6></th>
                <th><h6>Stocks On hand</h6></th>
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)  
            <tr>
                <td  style="width: 25%;"> {{ $items['category'] }} </td>
                <td  style="width: 25%;"> {{ $items['incoming'] }} </td>
                <td  style="width: 25%;"> {{ $items['outgoing'] }} </td>
                <td  style="width: 25%;"> {{ $items['stocks'] }} </td>
            </tr>  
            @endforeach
        </table>
    </body>
</iframe>
</html>