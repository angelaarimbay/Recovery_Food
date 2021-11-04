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
                style="display: block;  margin-left: auto; margin-right: auto;  width: 130px"></img>
    </div>
    <p class="header">Masterlist Supplies Report</p>
    <p class="date">Date exported:
            {{ date("Y-m-d") }} - Proccess By:
            {{ $data[0]['process_by'] }}
    </p>
    <p>Category:
            {{ $data[0]['category_name'] }}
    </p>
        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
            <tr> 
                <th><h6>SUPPLY NAME</h6></th> 
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
                 
                <td  style="width: auto"> {{ $items['supply_name'] }} {{ $items['description'] }} </td>  
                <td  style="width: auto"> {{ $items['unit'] }}  </td>
                <td  style="width: auto"> {{ number_format($items['net_price'] ,2)}} </td>
                <td  style="width: auto"> {{  number_format($items['with_vat'] ,2) }} </td>
                <td  style="width: auto"> {{ number_format($items['vat'] ,2)  }} </td>
                <td  style="width: auto"> {{ number_format($items['without_vat'] ,2)}} </td>  
                <td  style="width: auto"> {{ ( $items['exp_date']? date("Y-m-d",strtotime( $items['exp_date'])):null) }} </td>
            </tr>  
            @endforeach
        </table>
        <!-- Page Number -->
        <htmlpagefooter name="page-footer">
        <p style="bottom: 0%;  ">Page {PAGENO} of {nb}</p>      
        </htmlpagefooter>
    </body>
</iframe>
</html>