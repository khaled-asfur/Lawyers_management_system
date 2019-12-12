<?php 
session_start();
include_once("classes/Client.php");
include_once("DBConnect.php");


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $operation=$_POST["operation"];

    if($operation=="show_reminds"){
        /* to get procecution_ids*/
        $office_id=$_SESSION["office_id"];
        $procecution_ids = Client::get_office_procecution_ids($office_id);
        $formatted_proc= Client::format_proc_ids($procecution_ids);

        /* DB connect */
        $conn= DBConnect::getConnection();
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

                     
           // echo $today;
           date_default_timezone_set('Asia/Jerusalem');
           $today=date("Y-m-d");

           $reminds["sessions"]= get_sessions_reminds($conn,$formatted_proc,$today);
           $reminds["checks"] =get_checks_reminds($conn,$formatted_proc,$today);
           $reminds["installments"]=get_installments_reminds($conn,$formatted_proc,$today);
           echo json_encode($reminds);
      }
    }

    /* functions*/
    function get_checks_reminds($conn,$formatted_procecution_ids,$remind_date){
        $all_checks=array();
        $all_checks[0]="no checks";
        $count=0;
       $sql=" SELECT procecutions.procecution_number , customers.name , check_owner , checks.date  from checks
        inner join customers 
        inner join procecutions
        inner join fees
        on procecutions.id in ($formatted_procecution_ids)
        and checks.fees_id=fees.id
        and fees.procecution_id =procecutions.id
        and customers.id = procecutions.customer_id
        and check_remind_date=\"$remind_date\" ";

        $result=$conn->query($sql);
        if($result->num_rows==0){
             
        }
        while($row=$result->fetch_assoc()){
                $check["procecution_number"]=$row["procecution_number"];
                $check["name"]=$row["name"];
                $check["date"]=$row["date"];
                $check["check_owner"]=$row["check_owner"];
                $all_checks[$count]=$check;
                $count++;
        }
        return  $all_checks;


    }
    function get_installments_reminds($conn,$formatted_procecution_ids,$remind_date){
        $all_installments=array();
        $all_installments[0]="no installmets";
        $count=0;
       $sql="SELECT procecutions.procecution_number , customers.name , installments.value , installments.date  from installments
            inner join customers 
            inner join procecutions
            inner join fees
            on procecutions.id in ($formatted_procecution_ids)
            and installments.fees_id=fees.id
            and fees.procecution_id =procecutions.id
            and customers.id = procecutions.customer_id
            and remind_date= \"$remind_date\" ";

        $result=$conn->query($sql);
        if($result->num_rows==0){
             
        }
        while($row=$result->fetch_assoc()){
                $installment["procecution_number"]=$row["procecution_number"];
                $installment["name"]=$row["name"];
                $installment["date"]=$row["date"];
                $installment["value"]=$row["value"];
                $all_installments[$count]=$installment;
                $count++;
        }
        return  $all_installments;


    }

    function get_sessions_reminds($conn,$formatted_procecution_ids,$remind_date){
        $all_sessions=array();
        $all_sessions[0]="no sessions";
        $count=0;
        $sql="SELECT procecutions.procecution_number , customers.name , sessions.date from sessions
        inner join customers 
        inner join procecutions
        on procecutions.id in ($formatted_procecution_ids)
        and sessions.procecution_id=procecutions.id
        and customers.id = procecutions.customer_id
        and remind_date=\"$remind_date\"  ";
       // echo $sql;
        $result=$conn->query($sql);
        if($result->num_rows==0){
              //$procecution_ids[] = -1;//لا يوجد جلسات موعد تذكيرها اليوم 
        }
        while($row=$result->fetch_assoc()){
                $session["procecution_number"]=$row["procecution_number"];
                $session["name"]=$row["name"];
                $session["date"]=$row["date"];
                $all_sessions[$count]=$session;
                $count++;
        }
        return $all_sessions;
    }


?>