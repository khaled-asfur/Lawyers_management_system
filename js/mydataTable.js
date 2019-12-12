
$(document).ready(function(){
   $("body").niceScroll({
             cursorcolor:"#31b0d5",
             cursorwidth:"7px"});
  var dataTable;
  fetch_data();

  function fetch_data()
  {
    dataTable = $('#user_data').DataTable({
     'searching': true,
 "dom": '<"top"lB>rt<"bottom"i>p<"clear"><"div"> ',
  
 
    "oLanguage": {
        "oPaginate": {
            "sPrevious": "",
            "sNext": "",
            "paginationClass": "pagination-dark border-dark pagination-sm" // ModernUI specific code to bring out form color styling
        },
        "sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
        "sLengthMenu": "_MENU_ records",
        "sInfoEmpty": "Showing 0 to 0 of 0 records",
        "sInfoFiltered": "(filtered from _MAX_ total records)",
        "sSearch": "<span class=\"datatables_search\">Search:</span>"
    },
    "bProcessing": true,
		"bServerSide": true,
    "order" : [],
    buttons: [
        'copy', 'excel', 'pdf'
    ],
    "ajax" : {
     url:"../php/fetch.php",
     type:"POST"
    }
   });
  }
  
  function update_data(id, column_name, value,checked)
  {
   
   $.ajax({
    url:"../php/Actions.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value,action:'update',checked:checked},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
     fetch_data();
    }
   });
   
  }
  
  function getcheck(id)
  {
   $.ajax({
    url:"../php/fetch.php",
    method:"POST",
    data:{ id:id, checked:1,},
    success:function(data)
    {
     var div=JSON.parse(data);
     
      if(div[0]==1)
        $("input[name='customers_page']").attr('checked', 1);
        else if(div[0]==0)
        $("input[name='customers_page']").removeAttr('checked');
           if(div[1]==1)
        $("input[name='sessions_page']").attr('checked', 1);
        else if(div[1]==0)
        $("input[name='sessions_page']").removeAttr('checked');
          if(div[2]==1)
        $("input[name='financial_page']").attr('checked', 1);
        else if(div[2]==0)
        $("input[name='financial_page']").removeAttr('checked');
           if(div[3]==1)
        $("input[name='users_page']").attr('checked', 1);
        else if(div[3]==0)
        $("input[name='users_page']").removeAttr('checked');
           if(div[4]==1)
        $("input[name='ended_procecutions']").attr('checked', 1);
        else if(div[4]==0)
        $("input[name='ended_procecutions']").removeAttr('checked');
           if(div[5]==1)
        $("input[name='reminds_page']").attr('checked', 1);
        else if(div[5]==0)
        $("input[name='reminds_page']").removeAttr('checked');
         
        
     
  
    }
   });
  
  }

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
   console.log(id);
   var column_name = $(this).data("column");
   var value = $(this).text();
   update_data(id, column_name, value,0);
  });
 var instantid;
  $(document).on('click', '.edit-button', function(){
     var div=document.getElementsByClassName("show-details");
     instantid = this.id;
       getcheck(this.id);
       $("input[name='customers_page']").attr("disabled", false);
         $("input[name='sessions_page']").attr("disabled", false);
          $("input[name='users_page']").attr("disabled", false);
          $("input[name='ended_proc']").attr("disabled", false);
             $("input[name='reme_page']").attr("disabled", false);
           $("input[name='financial_page']").attr("disabled", false);
        $(div).css('display','block');
  });
    $(document).on('click', '.view-button', function(){
     var div=document.getElementsByClassName("show-details");
   var btn=document.getElementsByClassName("btn-save");

       getcheck(this.id);
        $(div).css('display','block');
        $(btn).css('display','none');
        $("input[name='customers_page']").attr("disabled", true);
         $("input[name='sessions_page']").attr("disabled", true);
          $("input[name='users_page']").attr("disabled", true);
          $("input[name='ended_proc']").attr("disabled", true);
             $("input[name='reme_page']").attr("disabled", true);
           $("input[name='financial_page']").attr("disabled", true);
            
  });
  $(document).on('click', '.updatecheckbox', function (){
    var id = instantid;
   var column_name = $(this).attr("name");
  
   var value = $(this).is(':checked');
   
   
   update_data(id, column_name, value,1);
  });
 
  $('#addd').click(function(){
   var div=document.getElementsByClassName("addLawyer");
   
        $(div).css('display','block');
  });
  
  $(document).on('click', '#insert', function(){
   var name = $('#usename').val();

   var phone_num = $('#phone_number').val();
     var email = $('#email').val();
   var password = $('#password').val();
   var div=document.getElementsByClassName("addLawyer");
   
        $(div).css('display','none');
    console.log(name,phone_num,email,password);
   if(name != '' && phone_num != '' && email != '')
   {
    $.ajax({
     url:"../php/Actions.php",
     method:"POST",
     data:{name:name, phone_num:phone_num,email:email,password:password,action:'insert'},
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     },error:function(data){
      console.log(data);
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
   else
   {
    alert("Both Fields is required");
   }
  });
  
  $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"../php/Actions.php",
     method:"POST",
     data:{id:id,action:'delete'},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
   $('#val').on( 'keyup', function () {
 
        dataTable.search( this.value ).draw();

 });
 });
