
$(document).ready(function(){
  
  var dataTable;
  fetch_data();

  function fetch_data()
  {
    dataTable = $('#user_data').DataTable({
     'searching': true,
 "dom": '<"top"lB>rt<"bottom"i><"clear"><"div"> ',
  
 
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
   function fetch_general(name,id){
    var table;
    
    if(name=='view-checks'){
        $('#cheks-details').css('display','block');{
            name='view-check';
         table='#check_user_data';
        }
 $('#installment-details').css('display','none');
    }else{
        $('#installment-details').css('display','block');
        name='view-prem';
         table='#installment_user_data';
         $('#cheks-details').css('display','none');
    }
 $(table).DataTable().destroy();
    dataTable = $(table).DataTable({
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
    "ajax" :{
    url:"../php/fetch.php",
    method:"POST",
    data:{type:name,id:id},
    
    }
   });
  }
  

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
  
   var column_name = $(this).data("column");
   var value = $(this).text();
    if(value==""){
     value = $('#'.concat(this.id)).val();
       

    }
 
    
  
   $.ajax({
     url:"../php/Actions.php",
     method:"POST",
     data:{id:id, column_name:column_name, value:value,action:'update',type:viewprim==null?'view-check':'view-prim'},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      if((viewprim==null?'view-check':'view-prim')=='view-prim'){
      $('#installment_user_data').DataTable().destroy();}
      else{
        
      $('#check_user_data').DataTable().destroy();
      }
      fetch_general(viewname,viewprim==null?viecheck:viewprim);
     
    }});
   });
  var viewprim;
 var viecheck;
 var viewname;
    $(document).on('click', '.view-button', function(){
     var doc=document.getElementById('show-details');
        $(doc).css('display','block');
        viewname=$(this).attr("name");
        if(viewname =='view-prem'){
        viewprim=this.id;
        viecheck=null;
        }
        else{
        viecheck = this.id;
        viewprim=null;}
        
         fetch_general(this.name,this.id);
        
  });
 
 
  $(document).on('click', '.prem-delete', function(){
   var id = $(this).attr("id");
 
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"../php/Actions.php",
     method:"POST",
     data:{id:id,action:'delete',del:'prem'},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#installment_user_data').DataTable().destroy();
      fetch_general(this.name,viewprim);
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
  
   $(document).on('click', '.check-delete', function(){
   var id = $(this).attr("id");
 
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"../php/Actions.php",
     method:"POST",
     data:{id:id,action:'delete',del:'check'},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#cheks-details').DataTable().destroy();
      fetch_general(this.name,viecheck);
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
   $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
 
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"../php/Actions.php",
     method:"POST",
     data:{id:id,action:'delete',del:'gen'},
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
