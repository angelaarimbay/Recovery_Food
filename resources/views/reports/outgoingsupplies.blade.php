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
    <p class="header">Outgoing Supplies Report</p>
 
    <table style="border:none; width: 100%"> 
       <tr> 
       <td  style="border:none;text-align: left;  width: auto">      </td>
       <td  style="border:none; text-align: right; width: auto"> Parameter Date:  {{ $param['from'] }}  -  {{ $param['to'] }}   </td>
         </tr>   
         
    </table>

        <!-- Table -->
        <table style="width: 100%">
            <!-- Header -->
         
            <!-- Rows -->
            @foreach ($data as $array)  
                <tr > 
                    <td  style="text-align: left; width: auto"><h5>{{ $array[0]['category_details'] }}</h5></th> 
                    <td style=" border: none; width: auto"></td>  
                    <td style=" border: none; width: auto"></td>
                    <td style=" border: none; width: auto"></td>
                    <td style=" border: none; width: auto"></td>
                    <td style=" border: none; width: auto"></td>
                    <td style=" border: none; width: auto"></td>
                </tr>
   <tr> 
                <th><h6>SUPPLY NAME</h6></th>
                <th><h6>UNIT</h6></th> 
                <th><h6>NET PRICE</h6></th>  
                <th><h6>WITH VAT</h6></th>
                <th><h6>QTY</h6></th>
                <th><h6>TOTAL AMT</h6></th>
                <th><h6>BRANCH</h6></th>
                <th><h6>OUTGOING DATE</h6></th>
            </tr> 

                @foreach ($array  as $items)   

                <tr>
                <td  style="width: auto"> {!! $items['supply_name']  !!} {{ $items['description']  }}</td>
                <td  style="width: auto"> {{ $items['unit'] }} </td>
                <td  style="width: auto"> {{ ($items['net_price']?number_format( $items['net_price'],2):'') }} </td>  
                <td  style="width: auto"> {{ ($items['with_vat']?number_format( $items['with_vat'],2):'') }} </td>
                <td  style="width: auto"> {{ $items['quantity'] }} </td>  
                <td  style="width: auto"> {{ ($items['quantity_amount']? number_format($items['quantity_amount'],2):'') }} </td>
                <td  style="width: auto"> {{ $items['branch'] }} </td>   
                <td  style="width: auto"> {{ ( $items['outgoing_date']? date("Y-m-d", strtotime( $items['outgoing_date'])):null) }} </td>   
         
            
                </tr>  
                @endforeach  
            @endforeach

            <tr  >
                 
                 <td  style=" border: none;width: auto">  </td>  
                 <td  style=" border: none;width: auto">  </td>
                 <td  style=" border: none;width: auto"> </td>
                 <td  style=" border: none;width: auto">   </td>
                 <td  style=" border: none;width: auto">  </td>
                 <td  style=" border: none; width: auto"> </td>  
                 <td  style=" border: none;width: auto"> </td>
             </tr>  
            <tr  >
                 
                 <td  style=" border: none;width: auto"> Grand Total </td>  
                 <td  style=" border: none;width: auto">  </td>
                 <td  style=" border-top: none;  border-left: none; border-right: none; width: auto"> {{ number_format($net_price,2) }} </td>
                 <td  style=" border-top: none;  border-left: none; border-right: none; width: auto"> {{ number_format($with_vat,2) }} </td>
                 <td  style=" border-top: none;  border-left: none; border-right: none; width: auto"> {{ $quantity }} </td>
                   <td  style=" border-top: none;  border-left: none; border-right: none; width: auto"> {{ number_format($quantity_amount,2) }} </td>  
                 <td  style=" border: none;width: auto"> </td>
             </tr>  
             <tr  >
                 
                 <td  style=" border: none;width: auto">  </td>  
                 <td  style=" border: none;width: auto">  </td>
                 <td  style=" border-bottom: none;  border-left: none; border-right: none; width: auto"> </td>
                 <td  style=" border-bottom: none;  border-left: none; border-right: none; width: auto">  </td>
                 <td  style=" border: none;width: auto">  </td>
                 <td  style=" border-bottom: none;  border-left: none; border-right: none; width: auto">  </td>  
                 <td  style=" border: none;width: auto"> </td>
             </tr>  
        </table>
        <!-- Page Number --> 
        <htmlpagefooter name="page-footer">
        <p style="bottom: 0%;  ">Page {PAGENO} of {nb}</p>      
        </htmlpagefooter>
    </body>
</iframe>
</html>