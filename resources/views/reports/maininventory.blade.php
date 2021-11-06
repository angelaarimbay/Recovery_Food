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
     <div class="row">
            <div style="text-align: right">  Date: {{ date("F d, Y") }} <br> Proccess by: {{ $process_by }} </div>       
        </div> 
    <div style="text-align: center">   
    <img src="{{ public_path(). '/img/logo.jpg' }}" 
                style="  width: 50px;"></img>
    </div> 
    <p class="header">Main Inventory Report</p>
    
     
        <!-- Table -->
        <table style="width: 100%">

        @foreach ($data as $array)
                 <tr > 
                    <td  style="text-align: left;  "><h5>{{ $array[0]['category'] }}</h5></th>  
                </tr>
            <!-- Header -->
            <tr> 
                <th rowspan="2"><h6>SUPPLY NAME</h6></th>
                <th rowspan="2"><h6>UNIT</h6></th>
                <th rowspan="2"><h6>NET PRICE</h6></th>
                <th colspan="2"><h6>BEGINNING INVENTORY</h6></th>
                <th colspan="2"><h6>INCOMING SUPPLIES</h6></th>
                <th colspan="2"><h6>TOTAL STOCKS</h6></th>
                <th colspan="2"><h6>OUTGOING SUPPLIES</h6></th>
                <th colspan="2"><h6>STOCKS ON HAND</h6></th>
                <th colspan="2"><h6>AVERAGE DAILY USAGE</h6></th>
                <th rowspan="2"><h6>LEAD TIME</h6></th>
                <th rowspan="2"><h6>ORDER POINT</h6></th>
                <th rowspan="2"><h6>MINIMUM ORDER QTY</h6></th>
                <th rowspan="2"><h6>ORDER QTY</h6></th>
                <th rowspan="2"><h6>ORDER FREQUENCY</h6></th>
                <th rowspan="2"><h6>TRIGGER POINT</h6></th>
                <th colspan="2"><h6>ENDING INVENTORY</h6></th>
                <th colspan="2"><h6>CONSUMPTION</h6></th>
                <th colspan="2"><h6>IDEAL INVENTORY</h6></th>
                <th colspan="2"><h6>VARIANCE</h6></th>
            </tr>
            <!-- Rows -->
            <tr>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
                <th scope="col"><h6>QTY</h6></th>
                <th scope="col"><h6>VALUE</h6></th>
            </tr>
            @foreach ($array as $items)
            <tr> 
                <td style="width: auto"> {!! $items['supply_name'] !!}</td>
                <td style="width: auto"> {{ $items['unit'] }} </td>
                <td style="width: auto"> {{ $items['net_price']??0  }} </td>
                <td style="width: auto"> {{ $items['beginning_q']??0 }} </td>
                <td style="width: auto"> {{  $items['beginning_a']??0 }} </td>
                <td style="width: auto"> {{ $items['incoming_q']??0 }}</td>
                <td style="width: auto"> {{ $items['incoming_a']??0 }}</td>
                <td style="width: auto"> {{ $items['total_q']??0 }}</td>
                <td style="width: auto"> {{ $items['total_a']??0 }}</td>
                <td style="width: auto"> {{ $items['outgoing_q']??0 }}</td>
                <td style="width: auto"> {{ $items['outgoing_a']??0 }}</td>
                <td style="width: auto"> {{ $items['onhand_q']??0 }}</td>
                <td style="width: auto"> {{ $items['onhand_a']??0 }}</td>
                <td style="width: auto"> {{ $items['average_q']??0 }}</td>
                <td style="width: auto"> {{ $items['average_a']??0 }}</td>
                <td style="width: auto"> {{ $items['lead_time']??0 }}</td>
                <td style="width: auto"> {{ $items['orderpoint']??0 }}</td>
                <td style="width: auto"> {{ $items['minimum_order_quantity']??0 }}</td>
                <td style="width: auto"> {{ $items['ordr']??0 }}</td>
                <td style="width: auto"> {{ $items['order_frequency']??0 }}</td>
                <td style="width: auto"> {{ $items['triggerpoint']??0 }}</td>
                <td style="width: auto"> {{ $items['ending_q']??0 }}</td>
                <td style="width: auto"> {{ $items['ending_a']??0 }}</td>
                <td style="width: auto"> {{ $items['consumption_q']??0 }}</td>
                <td style="width: auto"> {{ $items['consumption_a']??0 }}</td>
                <td style="width: auto"> {{ $items['ideal_q']??0 }}</td>
                <td style="width: auto"> {{ $items['ideal_a']??0 }}</td>
                <td style="width: auto"> {{ $items['variance_q']??0 }}</td>
                <td style="width: auto"> {{ $items['variance_a']??0  }} </td>
            </tr>  
            @endforeach
            @endforeach  
             
        </table>
        <!-- Page Number --> 
        <htmlpagefooter name="page-footer">
        <p style="bottom: 0%;  ">Page {PAGENO} of {nb}</p>      
        </htmlpagefooter>
    </body>
</iframe>
</html>