<?php 
include_once("Client.php");
include_once(Client::get_path()."php/DBConnect.php");
class Session{
    public  function show_sessions_info($procecution_ids,$name){

        $conn= DBConnect::getConnection();
              if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
              }
                     $sql="SELECT sessions.id, sessions.session_number , 
                      sessions.`date`, sessions.actions, 
                      sessions.remind_date , procecutions.procecution_number
                        FROM sessions
                inner JOIN procecutions ON sessions.procecution_id = procecutions.id and procecutions.id in ($procecution_ids) 
                order by procecution_id desc , session_number desc , `date` desc ;";
                     $result=$conn->query($sql);
                     if ($result->num_rows ==0 ){ 
                        Client::show_fail_message(" لا يوجد جلسات مضافة لهذه القضية ");
                        
                        }
                      else{
                      while($row = $result->fetch_assoc()) {
                          
                          $session_id=$row["id"]; 
                          $procecution_number=$row["procecution_number"];
                          $session_number=$row["session_number"];
                          $date=$row["date"];
                          $session_actions=$row["actions"];
                          $remind_date=$row["remind_date"];
                      echo "
                      <tr >
                 
                       <td><input  type='text' value='$name'/></td>
                       <td><input  type='text' class=' specialWidth' value='$procecution_number'/></td>
                       <td><input  type='text' class='session_cell specialWidth' value='$session_number'/></td>
                       <td><input class='session_cell' type='date' value='$date'/></td>
                       <td><input class='session_cell' class='session_cell' type='date' value='$remind_date'/></td>
                       <td style='display:none'><input type='text' value='$session_id'/></td> 
                       <td style='display:none'><input type='text' value='$session_actions'/></td> 

                       <td class='actions' >
                      <button type='button' class='btn btn-info' id='view-button'><i class='fas fa-eye' style='margin-right:5px'></i>مشاهدة</button>
                       <button type='button'   class='btn btn-danger' id='delete-button'><i class='fas fa-trash-alt' style='margin-right:5px'></i>حذف</button>
                  
                       </td>
                   </tr>
                   ";
                  
                      }
                    }
                     
    }


}
?>