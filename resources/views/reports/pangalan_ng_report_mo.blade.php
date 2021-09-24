
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

    <!-- pgas logo -->
    <div style="padding-left: 40%; padding-top: -30;">   

        <img  src="{{ public_path(). '/img/pgasompo.png' }}" 
            style=" display: block;  margin-left: auto; margin-right: auto;  width: 150px;"></img>
    </div>
    <!-- title -->
    <h5 style="padding-left: 40%; padding-top: -15;">DAILY TIME RECORD</h5>

    <!-- user info -->
    <div> 
        <table style="width: 100%;">
            <tr>
                <td style="width: 40%;"><small >EMPLOYEE : <strong> {{ $FULLNAME }} </strong></small><hr style="margin: 0; width: 50px;"></td>  
                <td></td>
                <td style="width: 40%;"><small >YEAR : <strong> {{ $YEAR }} </strong></small><hr style="margin: 0;"></td>
            </tr> 
            <tr>
                <td style="width: 40%;"><small >PERIOD : <strong> {{ $PERIOD[0] }} </strong></small><hr style="margin: 0; width: 50px;"></td>  
                <td></td> 
                <td style="width: 40%;"><small >MONTH : <strong> {{ $MONTH }} </strong></small><hr style="margin: 0; width: 50px;"></td>
            </tr> 
        </table> 
    </div> 
    <br>
    <!-- time logs -->
    </div> 
 
    <table  class="table_timelogs">
         <tr>
            <th><h6>DAY</h6></th>
            <th><h6>TIME IN</h6></th> 
            <th><h6>TIME OUT</h6></th> 
            <th><h6>SOURCE</h6></th>  
            <th><h6>REMARKS</h6></th>
        </tr>
        @foreach ($TIMELOGS as $user)  
            @if ($user['id'] < 16)
                <tr>
                   <td  style="width: 20%;">   {{ $user['id'] }}</td>
                   <td  style="width: 20%;">  {{ $user['timein'] }} </td>
                   <td  style="width: 20%;">  {{ $user['timeout'] }}</td>  
                   <td  style="width: 20%;">  {{ $user['source'] }}</td>
                   <td  style="width: 50%; font-size: 8px; text-align: left; padding-left: 5px;">  {{ $user['remarks'] }}</td> 

                </tr> 
            @endif 
          
        @endforeach
        </table>
    
    </div>
    <br>

    <!-- LEAVE details -->
    <div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 40%;"><sub >NO. OF REGULAR HRS. COMPLETED : <strong>  </strong></sub><hr style="margin: 0; width: 50px;"></td>  
                <td></td>
                <td style="width: 40%;"><sub >NO. OF ABSENCES INCURRED (VL) : <strong> {{ $NOOFVL }} </strong></sub><hr style="margin: 0;"></td>
            </tr> 
            <tr>
                <td style="width: 40%;"><sub >NO. OF OVERTIME RENDERED : <strong>  </strong></sub><hr style="margin: 0; width: 50px;"></td>  
                <td></td> 
                <td style="width: 40%;"><sub >NO. OF ABSENCES INCURRED (SL) : <strong> {{ $NOOFSL }} </strong></sub><hr style="margin: 0; width: 50px;"></td>
            </tr> 
            <tr>
                <td style="width: 40%;"><sub >NO. OF TARDINESS INCURRED : <strong>  </strong></sub><hr style="margin: 0; width: 50px;"></td>  
                <td></td> 
           </tr> 
        </table> 
    </div>
    <br>
    <div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 40%;"><small >NOTED BY : <strong> {{ $APPROVER }} </strong></small><hr style="margin: 0; width: 50px;"></td>  
                <td></td>
                <td style="width: 40%;"><small >EMPLOYEE : <strong> {{ $FULLNAME }} </strong></small><hr style="margin: 0;"></td>
            </tr> 
        </table> 
    </div>
    <br>
    
    <br>
    <hr  >   
    <br>    
    <br>
    <br>
    <!-- user info -->
    <div> 
        <table style="width: 100%;">
            <tr>
                <td style="width: 40%;"><small >EMPLOYEE : <strong> {{ $FULLNAME }} </strong></small><hr style="margin: 0; width: 50px;"></td>  
                <td></td>
                <td style="width: 40%;"><small >YEAR : <strong> {{ $YEAR }} </strong></small><hr style="margin: 0;"></td>
            </tr> 
            <tr>
                <td style="width: 40%;"><small >PERIOD : <strong> {{ $PERIOD[1] }} </strong></small><hr style="margin: 0; width: 50px;"></td>  
                <td></td> 
                <td style="width: 40%;"><small >MONTH : <strong> {{ $MONTH }} </strong></small><hr style="margin: 0; width: 50px;"></td>
            </tr> 
        </table> 
    </div> 
    <!-- time logs -->
    </div> 
    </div>
<br> 
 
    <table  class="table_timelogs">
         <tr>
            <th><h6>DAY</h6></th>
            <th><h6>TIME IN</h6></th> 
            <th><h6>TIME OUT</h6></th> 
            <th><h6>SOURCE</h6></th>  
            <th><h6>REMARKS</h6></th>
        </tr>
      
        @foreach ($TIMELOGS as $user)  
            @if ($user['id'] > 15 && $user['id'] <  $NOOFDAYS    )
                <tr>
                   <td  style="width: 20%;">   {{ $user['id'] }}</td>
                   <td  style="width: 20%;">  {{ $user['timein'] }} </td>
                   <td  style="width: 20%">  {{ $user['timeout'] }}</td>  
                   <td  style="width: 20%">  {{ $user['source'] }}</td>
                   <td  style="width: 50%; font-size: 8px; text-align: left; padding-left: 5px;">  {{ $user['remarks'] }}</td> 

                </tr> 
            @endif 
          
        @endforeach
        </table>
        <br>


    <!-- LEAVE details -->
    <div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 40%;"><sub >NO. OF REGULAR HRS. COMPLETED : <strong>   </strong></sub><hr style="margin: 0; width: 50px;"></td>  
                <td></td>
                <td style="width: 40%;"><sub >NO. OF ABSENCES INCURRED (VL) : <strong>  </strong></sub><hr style="margin: 0;"></td>
            </tr> 
            <tr>
                <td style="width: 40%;"><sub >NO. OF OVERTIME RENDERED : <strong>  </strong></sub><hr style="margin: 0; width: 50px;"></td>  
                <td></td> 
                <td style="width: 40%;"><sub >NO. OF ABSENCES INCURRED (SL) : <strong>  </strong></sub><hr style="margin: 0; width: 50px;"></td>
            </tr> 
            <tr>
                <td style="width: 40%;"><sub >NO. OF TARDINESS INCURRED : <strong>  </strong></sub><hr style="margin: 0; width: 50px;"></td>  
                <td></td> 
            </tr> 
        </table> 
    </div>
    <br> 
    <div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 40%;"><small >NOTED BY : <strong> {{ $APPROVER }} </strong></small><hr style="margin: 0; width: 50px;"></td>  
                <td></td>
                <td style="width: 40%;"><small >EMPLOYEE : <strong> {{ $FULLNAME }} </strong></small><hr style="margin: 0;"></td>
            </tr> 
          
           
        </table> 
    </div>
   

<!-- dito mo gawin sa ilalim. ako na mag alis ng ibabaw. 
importante dito ung layout.  -->


<table style="width: 100%;">
            <tr>
                <td style="width: 40%;"><small >NOTED BY : <strong> {{ $APPROVER }} </strong></small><hr style="margin: 0; width: 50px;"></td>  
                <td></td>
                <td style="width: 40%;"><small >EMPLOYEE : <strong> {{ $FULLNAME }} </strong></small><hr style="margin: 0;"></td>
            </tr> 
          
           
        </table> 



    </body>
</iframe>
</html>