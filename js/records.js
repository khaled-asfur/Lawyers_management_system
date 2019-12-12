'use strict';
 /* global $, document,  */ //حفظ الروو في هذا المتغير عند الضغط على اديت لاستخدامه عند الضغط على كونفيرم اديت
 var name = "",
 procecution_id= -1, 
 session_number=-1,
 session_date = "",
 remind_date = "",
session_actions="",
 session_id_global =-1;
var row_index_global=-1;
var operation=" " ;// بحدد اذا بدي اضيف جلسة او اعرض جلسة

function fill_show_session_dialog(name,procecution_id ,session_number ,session_date ,remind_date ,session_id ,session_actions)
{
    document.getElementById('customer_name_update').value=name;
    document.getElementById('procecution_number_update').value=procecution_id;
    document.getElementById('session_number_update').value=session_number;
    document.getElementById('session_date_update').value=session_date;
    document.getElementById('remind_date_update').value=remind_date;
    document.getElementById('actions_update').value=session_actions;


}
// 

    
      

$(document).ready(function(){
   /* $("body").niceScroll({
           cursorcolor:"#138496",
           cursorwidth:"7px"
    });*/


 /***Edit that session**/
    $(".session_cell").change(function(){
        var row=$(this).closest("tr");
        row_index_global = row.index();
          row=(document.getElementById("my_table").rows[row_index_global+1]);
         var procecution_number= $(row).find("td:nth-child(2)").find("input").val(), 
         session_number=$(row).find("td:nth-child(3)").find("input").val(),
         session_date = $(row).find("td:nth-child(4)").find("input").val(),
         remind_date = $(row).find("td:nth-child(5)").find("input").val(),
         session_id = $(row).find("td:nth-child(6)").find("input").val(),
         session_actions = $(row).find("td:nth-child(7)").find("input").val();
 
         console.log("procecution_number="+procecution_number);
         console.log("session_number="+session_number);
         console.log("session_date="+session_date);
         console.log("remind_date="+remind_date);
         console.log("sess id="+session_id);
         console.log("session_actions="+session_actions);
 
         update_Session(session_number,
             session_date,remind_date,session_actions ,session_id)
    });

    $('.actions button').click(function(){
      var idName= $(this).attr('id');
                     // *************view button
        if(idName=='view-button'){
            operation="update";
            var row=$(this).closest("tr"),
            name = $(row).find("td:nth-child(1)").find("input").val(),
            procecution_id= $(row).find("td:nth-child(2)").find("input").val(), 
            session_number=$(row).find("td:nth-child(3)").find("input").val(),
            session_date = $(row).find("td:nth-child(4)").find("input").val(),
            remind_date = $(row).find("td:nth-child(5)").find("input").val(),
            session_id = $(row).find("td:nth-child(6)").find("input").val(),
            session_actions = $(row).find("td:nth-child(7)").find("input").val();
           
            session_id_global = session_id;
            /*console.log(procecution_id);
            console.log(session_number);
            console.log(session_date);
            console.log(remind_date);
            console.log(session_id);
            console.log(session_actions);*/


            fill_show_session_dialog(name,procecution_id ,session_number ,session_date ,remind_date  ,session_id ,session_actions);
           var div=document.getElementById('update_session_dialog');
            $(div).css('display','block');

                //  ********* deleeeeeeeet button
        }if(idName=='delete-button'){
     
          var div= document.getElementById('confirm-delete');
            $(div).css('display','block');

            var row=$(this).closest("tr"),
            session_id = $(row).find("td:nth-child(6)").find("input").val();
            session_id_global = session_id;
            row_index_global = row.index();
            //console.log(" index= "+row_index_global);

            /////// ***** edit button
        }/*if(idName=='edit-button'){
            row=$(this).closest("tr");
            row_index_global = row.index();
            var div= document.getElementById('confirm-edit');
            $(div).css('display','block');
        }*/
    });

   


                    /*****confirm delete**** */
    /** حذف الجلسة من الداتا بيز باستخدام الاجاكس   */
  $("#confirm-yes-delete").click(function(){
        document.getElementById('confirm-delete').style.display='none';
        if(session_id_global==-1){
            window.alert("session id is still empty!");
        }
        //don`t care until **
        if (window.XMLHttpRequest) {
          var  xmlhttp = new XMLHttpRequest();
        } else {
           var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        // **
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //اذا تم حذف الجلسة 

                if(this.responseText=="deleted"){

                document.getElementById("my_table").deleteRow(row_index_global+1);
                document.getElementById("show_success_msg").innerHTML = "تم حذف الجلسة بنجاح ";
                document.getElementById('success_dialog').style.display="block";
                }
                else{
                    //اذا لم يتم حذف الجلسة 
               document.getElementById("show_Error").innerHTML = this.responseText;
               document.getElementById('error_dialog').style.display="block";
            }
            }
        };
        xmlhttp.open("POST", "../php/delete_session.php?session_id="+session_id_global,true);
        xmlhttp.send();
      
    });
    

    /***Eidt that row**/

    /*$("#confirm-yes-edit").click(function(){
        document.getElementById('confirm-edit').style='display:none';
       var  row=(document.getElementById("my_table").rows[row_index_global+1]);
        var procecution_number= $(row).find("td:nth-child(2)").find("input").val(), 
        session_number=$(row).find("td:nth-child(3)").find("input").val(),
        session_date = $(row).find("td:nth-child(4)").find("input").val(),
        remind_date = $(row).find("td:nth-child(5)").find("input").val(),
        session_id = $(row).find("td:nth-child(6)").find("input").val(),
        session_actions = $(row).find("td:nth-child(7)").find("input").val();

        console.log("procecution_number="+procecution_number);
        console.log("session_number="+session_number);
        console.log("session_date="+session_date);
        console.log("remind_date="+remind_date);
        console.log("sess id="+session_id);
        console.log("session_actions="+session_actions);

        update_Session(session_number,
            session_date,remind_date,session_actions ,session_id)
       // update_Session(  1 ,1,1,1,1,1 ,1)
        
    });*/


     /**************** الضغط على بوتون اضافة جلسة جديدة ***************/
     $("#addNew").click(function(){
        /*** تفريغ محتويات التكست بوكسز في الديالوج   */
      document.getElementById('session_number').value="";
        document.getElementById('session_date').value="";
        document.getElementById('remind_date').value="";
        document.getElementById('actions').value="";
           
        var div= document.getElementById('add_session_dialog');
            $(div).css('display','block');
        });


    // عند الضغط على حفظ في ديالوج تعديل  جلسة

    $("#save_update_dialog").click(function(){
        
          var div= document.getElementById('update_session_dialog');
          $(div).css('display','none');
        var session_number=  document.getElementById('session_number_update').value;
        var session_date = document.getElementById('session_date_update').value;
        var remind_date =  document.getElementById('remind_date_update').value;
        var session_actions =  document.getElementById('actions_update').value;

        update_Session(session_number,session_date,remind_date,session_actions ,session_id_global);
          });    

          // عند الضغط على حفظ في ديالوج اضافة   جلسة
        $("#save").click(function(){

          

          var procecution_number = document.getElementById('dialog_search_procecution_number').value;
          if(procecution_number.trim()==""){
          //  window.alert("يجب ادخال رقم القضية اولا ");
            $("#add_session_show_Error").text("يجب ادخال رقم القضية اولا");
            $('#add_session_error_dialog').css('display', 'block');
        
          }else{
          var session_number=  document.getElementById('session_number').value;
          var session_date = document.getElementById('session_date').value;
          var remind_date =  document.getElementById('remind_date').value;
          var session_actions =  document.getElementById('actions').value;

          //تحديد اذا كانت العملية اضافة جلسة جديدة او مشاهدة جلسة وحفظ التعديلات 
          var div= document.getElementById('add_session_dialog');
          $(div).css('display','none');
             insert_Session(  procecution_number ,session_number,session_date,remind_date,session_actions);

          }

            });    


            //اضافة على الداتا بيز بالستخدام االجاكس
        function insert_Session(  procecution_number ,session_number,session_date,remind_date,actions){
            //don`t care until **
            if (window.XMLHttpRequest) {
              var  xmlhttp = new XMLHttpRequest();
            } else {
               var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // **
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //اذا تم اضافة الجلسة 
    
                    if(this.responseText.trim() === "inserted" ){
                    document.getElementById('success_dialog').style.display="block";
                    document.getElementById("show_success_msg").innerHTML = "تم اضافة الجلسة بنجاح ";

                }
                    
                    else{  //اذا لم يتم اضافة الجلسة 
                   document.getElementById("show_Error").innerHTML =this.responseText;
                   document.getElementById('error_dialog').style.display="block";
                }
                }

            };
            operation="insert";
            xmlhttp.open("GET", "../php/session_operations.php?procecution_number="+procecution_number+
            "&session_number="+session_number+"&session_date="+session_date+
            "&remind_date="+remind_date+"&actions="+actions+"&ended="+0+"&operation="+ operation,true);
            xmlhttp.send();
        }




      

        function update_Session(session_number,
            session_date,remind_date,session_actions ,session_id){

                /*console.log(name);
                console.log(procecution_number);
                console.log(session_number);
                console.log(session_date);
                console.log(remind_date);
                console.log("sess id="+session_id);
                console.log(session_actions);*/
            //don`t care until **
            if (window.XMLHttpRequest) {
              var  xmlhttp = new XMLHttpRequest();
            } else {
               var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            // **
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //اذا تم تعديل الجلسة 
    
                    if(this.responseText.trim() ==="updated"){
    
                        document.getElementById("show_success_msg").innerHTML = "تم تعديل الجلسة بنجاح ";
                        document.getElementById('success_dialog').style.display="block";
                    }
                    else{
                        //اذا لم يتم تعديل الجلسة 
                        document.getElementById("show_Error").innerHTML = this.responseText ;
                        document.getElementById('error_dialog').style.display="block";
                }
                }
            };
            operation="update";
            xmlhttp.open("GET", "../php/session_operations.php?session_number="+session_number+"&session_date="+session_date+
            "&remind_date="+remind_date+"&actions="+session_actions+"&session_id="+session_id+"&operation="+ operation,true);
            xmlhttp.send();    
        }

        // بحث عن الاسم في الديالوج 
        // استخدام اجاكس و جيسون
        $("#search_name_id_no_button_dialog").click(function(){
            var key= document.getElementById('search_name_id_no_input_dialog').value;
            
            if (window.XMLHttpRequest) {
                var  xmlhttp = new XMLHttpRequest();
              } else {
                 var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
              // **
              xmlhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      //اذا تم تعديل الجلسة 
                      if(this.responseText.trim() ==="updated"){
      
                          document.getElementById("show_success_msg").innerHTML = "تم تعديل الجلسة بنجاح ";
                          document.getElementById('success_dialog').style.display="block";
                      }
                      else{
                          //اذا لم يتم تعديل الجلسة 
                          document.getElementById("show_Error").innerHTML = this.responseText + "loooooool";
                          document.getElementById('error_dialog').style.display="block";
                  }
                  }
              };
              operation="get_proc_numbers_from_dialog";
              xmlhttp.open("GET", "../php/session_operations.php?key="+key+"&operation="+operation,true);
              xmlhttp.send();

            });    
  
});

$(".close_success").click(function () {
	$('#success_dialog').css('display', 'none');
});
$(".close_fail").click(function () {
	$('#error_dialog').css('display', 'none');
});
$(".client_close_fail").click(function () {
	$('.client_error_dialog').css('display', 'none');
});