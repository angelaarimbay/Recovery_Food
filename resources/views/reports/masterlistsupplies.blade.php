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
    <p class="header">Masterlist Report</p>
    <p class="date">Date exported:
            {{ date("Y-m-d") }}
    </p> <hr class="line">

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>Category</h6></th>
                <th><h6>Supply name</h6></th> 
                <th><h6>Description</h6></th> 
                <th><h6>Unit</h6></th>  
                <th><h6>Net Price</h6></th>
                <th><h6>Price w/ Vat</h6></th>
                <th><h6>Vat</h6></th>
                <th><h6>Price w/o Vat</h6></th>
                <th><h6>Expiration Date</h6></th>
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)   
            <tr>
                <td  style="width: 10%;"> {{ $items['category'] }} </td>
                <td  style="width: 10%;"> {{ $items['supply_name'] }} </td>
                <td  style="width: 10%;"> {{ $items['description'] }} </td>  
                <td  style="width: 10%;"> {{ $items['unit'] }}  </td>
                <td  style="width: 10%;"> {{ $items['format_net_price'] }} </td>
                <td  style="width: 10%;"> {{ $items['format_with_vat'] }} </td>
                <td  style="width: 10%;"> {{ $items['vat'] }} </td>
                <td  style="width: 10%;"> {{ $items['format_without_vat'] }} </td>  
                <td  style="width: 10%;"> {{ date("Y-m-d",strtotime( $items['exp_date'])) }} </td>
            </tr>  
            @endforeach
        </table>
    </body>
</iframe>
</html>