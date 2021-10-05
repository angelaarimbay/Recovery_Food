
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
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 150px;"></img>
     </div>


    <table   >
         <tr>
            <th><h6>supply_name</h6></th>
            <th><h6>TIME IN</h6></th> 
            <th><h6>TIME OUT</h6></th> 
            <th><h6>SOURCE</h6></th>  
            <th><h6>REMARKS</h6></th>
        </tr>
        @foreach ($data as $items)  
       
                <tr>
                   <td  style="width: 20%;">   {{ $items['supply_name'] }}</td>
                   <td  style="width: 20%;">   </td>
                   <td  style="width: 20%;">  </td>  
                   <td  style="width: 20%;">   </td>
                   <td  style="width: 50%; font-size: 8px; text-align: left; padding-left: 5px;">   </td> 

                </tr>  
          
        @endforeach
        </table>
   
    </body>
</iframe>
</html>