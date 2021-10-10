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
        background-color: #FAFAFA;
        font: 9pt "Tahoma";
        page-break-inside: avoid
    }

    .header{
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        margin: 0px;
    }
</style>
    <body  >
     
        <div style="text-align: center">   
                <img src="{{ public_path(). '/img/logo.jpg' }}" 
                    style="display: block;  margin-left: auto; margin-right: auto;  width: 30px;"></img>
        </div>
        <p class="header"> Receipt nyo sample </p>
         
            <!-- Page Number --> 
   


            <table style="width: 100%">
            <!-- Header -->
            <tr>
                <th><h6>Product Name</h6></th>
            
                <th><h6> </h6></th> 
                <th><h6> </h6></th> 
                <th><h6> </h6></th> 
                <th><h6> </h6></th> 
                <th><h6> </h6></th> 
                <th><h6> </h6></th> 
                <th><h6> </h6></th>  
            </tr>
            <!-- Rows -->
            @foreach ($data as $items)   
            <tr>
                <td  style="width: auto"> {{ $items['product_name']}}  </td>
                <td  style="width: auto">  </td>  
                <td  style="width: auto">  </td>
                <td  style="width: auto">   </td>
                <td  style="width: auto">  </td>
                <td  style="width: auto">   </td>
                <td  style="width: auto"> </td>  
                <td  style="width: auto">   </td>
            </tr>  
            @endforeach
        </table>
    </body>
</iframe>
</html>