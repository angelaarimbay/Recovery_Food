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
                @php
                    $total  = isset($total)  ? $total  +  $items['incoming'] : 0; 
                    $total1 = isset($total1) ? $total1 +  $items['begining'] : 0; 
                    $total2 = isset($total2) ? $total2 +  $items['total'] : 0; 
                    $total3 = isset($total3) ? $total3 +  $items['outgoing'] : 0;
                    $total4= isset($total4)  ? $total4 +  $items['ending'] : 0;
                    $total5 = isset($total5) ? $total5 +  $items['stocks'] : 0; 
                    $total6 = isset($total6) ? $total6 +  $items['variance'] : 0;
                    $total7 = isset($total7) ? $total7 +  $items['fluctuation'] : 0;
                @endphp
            <tr>
                <td  style="width: auto"> {{ $items['category'] }} </td> 
                <td style="width: auto"> {{ $items['incoming'] }}  @php($total += $items['incoming']) </td>
                <td style="width: auto"> {{ $items['begining'] }}  @php($total1 += $items['begining']) </td>  
                <td style="width: auto"> {{ $items['total'] }}  @php($total2 += $items['total']) </td> 
                <td style="width: auto"> {{ $items['outgoing'] }}  @php($total3 += $items['outgoing'])  </td>
                <td style="width: auto"> {{ $items['ending'] }}  @php($total4 += $items['ending']) </td>
                <td style="width: auto"> {{ $items['stocks'] }}   @php($total5+= $items['stocks']) </td>
                <td style="width: auto"> {{ $items['variance'] }} @php($total6 += $items['variance'])  </td>
                <td style="width: auto"> {{ $items['fluctuation'] }}  @php($total7 += $items['fluctuation']) </td>
            </tr>  
            @endforeach 
            <tr>
                <td  style="width: auto"> Total </td>
                <td  style="width: auto"> {{ number_format($total,2) }}  </td>
                <td  style="width: auto"> {{ number_format($total1,2) }}   </td>
                <td  style="width: auto"> {{ number_format($total2,2) }}   </td>
                <td  style="width: auto"> {{ number_format($total3,2) }}   </td>
                <td  style="width: auto"> {{ number_format($total4,2) }}   </td>
                <td  style="width: auto"> {{ number_format($total5,2) }}   </td>
                <td  style="width: auto"> {{ number_format($total6,2) }}   </td>
                <td  style="width: auto"> {{ number_format($total7,2) }}   </td>
            </tr>   
        </table>

        <!-- Page Number -->
        <p style="bottom: 0%; position: fixed">Page {PAGENO} of {nb}</p>
    </body>
</iframe>
</html>