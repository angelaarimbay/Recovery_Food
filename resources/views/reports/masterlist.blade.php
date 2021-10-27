
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

    .mreport{
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
     <p class="mreport">Masterlist Report</p>

     
    
    <!-- <header>
        <p class="pdf"> Pdf Exported </p> 
        <center><h3 class="RF"> Recovery Food </h3>
        <div class="logo">
 <center>        <img  src="{{ public_path(). '/img/logo.jpg' }}" 
                style=" display: block;  margin-left: auto; margin-right: auto;  width: 80px;"></img>
   </center>
     
        </div>
        </center>
    </header>
    -->
    <p class="date">Date exported:
            {{ date("Y-m-d") }}
        </p> <hr class="line">


       

       
<!-- ito ung table -->
        <table clas="tb2">
        <!-- headr -->
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
          
        </tr>
        <!-- rows -->
        @foreach ($data as $items)   
                <tr>
                   <td  style="width: 20%;">   {{ $items['category_name']   }}</td>
                   <td  style="width: 20%;">   {{ $items['supply_name'] }} </td>
                   <td  style="width: 20%;">  {{ $items['description'] }}  </td>  
                   <td  style="width: 20%;">   {{ $items['unit'] }}  </td>
                   <td  style="width: 20%;">   {{ $items['format_net_price'] }}  </td>
    
                   <td  style="width: 20%;">   {{ $items['format_with_vat'] }}</td>
                   <td  style="width: 20%;">   {{ $items['vat'] }} </td>
                   <td  style="width: 20%;">  {{ $items['format_without_vat'] }}  </td>  
                   <td  style="width: 20%;">   {{ date("Y-m-d",strtotime( $items['exp_date'])) }}  </td>
                </tr>  
        @endforeach
        </table>
    </body>
</iframe>
</html>