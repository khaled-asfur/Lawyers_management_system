function fill_row(type, customer_name, procecution_number, date, details) {

$('#reminds_table ').find('tbody').append(' <tr> <td >' + type + '</td><td>' + customer_name + '</td>' + '<td>' + procecution_number + '</td><td>' + date + '</td>' +
'<td style="/*display:none*/">' + details + '</td>' +

'</tr>');
/*
'<td class="actions">' +
'  <button  onclick="show(this)" type="button" class="h btn btn-info view-button"  data-toggle="modal" data-target="#exampleModalCenter">' +
'   <i class="fas fa-eye" style="margin-left:5px"></i>تفاصيل' +
'  </button>' +
'</td>' +
*/
}
    
function show(btn){
    
    var details= $(btn).closest("tr").find("td:nth-child(5)").text();
     $("#details").text(details);
    /* window.alert(details);
     console.log(details);*/
 }

$(document).ready(function () {



    //مشان ينفذ الي جوات ال اف لما تحمل الصفحة 
    if ($('#reminds_table').length) { //If checking if the element exists, use .length


        $.ajax({
            url: "../php/reminds_operations.php",
            type: "POST",
            data: { "operation": "show_reminds" },
            success: function (data) {
                var elements = JSON.parse(data),
                    sessions = elements.sessions,
                    checks = elements.checks,
                    installments = elements.installments;

                    if(checks[0]=="no checks" && sessions[0]=="no sessions" && installments[0]=="no installmets" ){
                        
                        $("#show_success_msg").html("لا يوجد تذكيرات لهذا اليوم ");
                        $('#success_dialog').css('display', 'block');
                    }else{
                    if(sessions[0]!="no sessions"){
                sessions.forEach(sess => {
                    console.log(sess.name);
                    var name = sess.name,
                        procecution_number = sess.procecution_number;
                    date = sess.date;
                    fill_row("جلسة", name, procecution_number, date, " ");
                });
            }

                if(checks[0]!="no checks"){
                checks.forEach(check => {
                    var name = check.name,
                        procecution_number = check.procecution_number;
                    date = check.date;
                    check_owner = check.check_owner;
                    var text = " صاحب الشيك : \n" + check_owner;
                    fill_row("شيك", name, procecution_number, date, text);
                });
            }
            if(installments[0]!="no installmets"){
                installments.forEach(inst => {
                    var name = inst.name,
                        procecution_number = inst.procecution_number;
                    date = inst.date;
                    value = inst.value;
                    var text = "قيمة الدفعة : \n" + value;
                    fill_row("قسط", name, procecution_number, date, text);
                });
            }
            }
        }
        });

    }


});
