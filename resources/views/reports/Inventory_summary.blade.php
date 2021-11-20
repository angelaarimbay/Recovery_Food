
<html>
<!-- <style>
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

</style> -->

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

    .Inv_summary{
    display: block;
    margin-left:auto;
    margin-right: auto;
    width: 190px;
    font-style:oblique;

    }
    
</style>




    <body>

    <div style="padding-left: 42%; padding-top: -30;">   

            <img  src="{{ public_path(). '/img/logo.jpg' }}" 
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 120px;"></img>
     </div>

     <p class="Inv_summary">Inventory Summary  Report</p>

<p class="date">Date exported:
       {{ date("Y-m-d") }}
   </p> <hr class="line">


    <table>
         <tr>
            <th><h6>Category</h6></th>
            <th><h6>Incoming</h6></th> 
            <th><h6>Outgoing</h6></th>  
          
        </tr>
        @foreach ($data as $items)  
       
                <tr>
                   <td  style="width: 20%;">   {{ $items['category'] }}</td>
                   <td  style="width: 20%;">  {{ $items['incoming'] }}   </td>
                   <td  style="width: 20%;">   {{ $items['outgoing'] }} </td>  
                 
       

                </tr>  
          
        @endforeach
        </table>
   
    </body>
</iframe>
</html>