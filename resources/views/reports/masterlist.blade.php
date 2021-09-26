
<html>
<style>
    .table_timelogs   td  {  
    border: 1px solid #ddd;
    text-align: center;
    padding-top: 0;
    padding-bottom: 0; 
    font-size: 14px;
    }
    
    .table_timelogs{
        border-collapse: collapse;
        width: 100%;
    }
    .page-break {
        page-break-after: always;
    }

</style>
    <body>

    <div style="padding-left: 40%; padding-top: -30;">   

            <img  src="{{ public_path(). '/img/logo.jpg' }}" 
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 80px;"></img>
     </div>


    <table   >
         <tr>
            <th><h6>Category</h6></th>
            <th><h6>Supply name</h6></th> 
            <th><h6>Description</h6></th> 
            <th><h6>Unit</h6></th>  
            <th><h6>Net Price</h6></th>
            <th><h6>Price with Vat</h6></th>
            <th><h6>Vat</h6></th>
            <th><h6>Price w/o Vat</h6></th>
            <th><h6>Expiration Date</h6></th>
            <th><h6>Status</h6></th>
        </tr>
        @foreach ($data as $items)   
                <tr>
                   <td  style="width: 20%;">   {{ $items['category_name']   }}</td>
                   <td  style="width: 20%;">   {{ $items['supply_name'] }} </td>
                   <td  style="width: 20%;">  {{ $items['description'] }}  </td>  
                   <td  style="width: 20%;">   {{ $items['unit'] }}  </td>
                   <td  style="width: 20%;">   {{ $items['net_price'] }}  </td>
    
                   <td  style="width: 20%;">   {{ $items['category'] }}</td>
                   <td  style="width: 20%;">   {{ $items['supply_name'] }} </td>
                   <td  style="width: 20%;">  {{ $items['description'] }}  </td>  
                   <td  style="width: 20%;">   {{ $items['unit'] }}  </td>
                   <td  style="width: 20%;">   {{ $items['net_price'] }}  </td>
    
               
                </tr>  
          
        @endforeach
        </table>
   
    </body>
</iframe>
</html>