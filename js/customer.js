
/* global $, document  */
var first_name, father_name, grand_name, family_name, identity_number, phone_number, customer_address, customer_notes;
var discount_name, discount_number, discount_address, discount_notes;
var agent_name, agent_number, agent_address, agent_notes;
var court_address, procecution_number, court_name, procecution_subject, procecution_value, procecution_date;

var procecution_id_global, row_index_global, customer_id_global, insert_customer_id = -1;


$(document).ready(function () {

	var current_fieldset, next_fieldset, previous_fieldset;
	var opacity, left, scale;
	var animating;





	// عند تغيير قيمة رقم القضية بدي اتاكد انه لا يوجد نفس رقم القضية في نفس المكتب 
	$("#number-session").change(function () {

		var procecution_number = $(this).val();

		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "procecution_number": procecution_number, "operation": "check_if_there_exist_such_procecuton_for_this_office" },
			success: function (data) {
				if (data == "procecution is exist in database") {
					$("#court_btn").attr('disabled', 'disabled');
					window.alert("تم اضافة هذه القضية مسبقا يرجى التأكد من رقم القضية");
				} else if (data == "no such procecution") {
					$("#court_btn").removeAttr('disabled');
				}
			}
		});
	});
	// في ديالوج اضافة زبون لما يدخل رقم الهوية   
	$("#customer_identiy_number").change(function () {
		//	var identity_number = document.getElementById("customer_identiy_number").innerhtml.value();
		var identity_number = $(this).val();
		if (identity_number == "") {
			identity_number = -1;
		}
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "identity_number": identity_number, "operation": "get_customer_info_using_id_no" },
			success: function (data) {

				if (data != "no users") {
					var cust = JSON.parse(data);
					if (cust.message == "found") {
						var name = cust.name,
							phone_number = cust.phone_number,
							address = cust.address,
							notes = cust.notes;
						insert_customer_id = cust.customer_id;
						//window.alert(insert_customer_id);
						$("#first-name-customer").val(name);
						$("#father-name-customer").css('display', 'none');
						$("#grandfather-name-customer").css('display', 'none');
						$("#family-name-customer").css('display', 'none');
						$("#contact-number-customer").val(phone_number);
						$("#address-customer").val(address);
						$("#note-about-customer").val(notes);
						disable_add_customer_textfields();
						/// مشان يقبل يعمل سبميت 
						$("#father-name-customer").val("-");
						$("#grandfather-name-customer").val("-");
						$("#family-name-customer").val("-");
					}
				} else {
					insert_customer_id = -1;
					$("#first-name-customer").val("");
					$("#father-name-customer").css('display', 'block');
					$("#grandfather-name-customer").css('display', 'block');
					$("#family-name-customer").css('display', 'block');
					$("#contact-number-customer").val("");
					$("#address-customer").val("");
					$("#note-about-customer").val("");
					enable_add_customer_textfields();
				}

			}
		});
	});
	
	$("#save_procecution_btn").click(function () {

		var procecution_id = procecution_id_global,
			procecution_number = $("#procecution_number").val(),
			subject = $("#subject").val(),
			date = $("#date").val(),
			procecution_value = $("#procecution_value").val(),
			court_name = $("#court_name").val(),
			court_address = $("#court_address").val();
		console.log(
			procecution_id + "   ",
			procecution_number + "   ",
			subject + "   ",
			date + "   ",
			procecution_value + "   ",
			court_name + "   ",
			court_address + "   "
		);

		if (!procecution_number) { procecution_number = 0; }
		if (!subject) { subject = "-"; }
		if (!date) { date = "2000/01/01"; }
		if (!procecution_value) { procecution_value = 0; }
		if (!court_name) { court_name = "-"; }
		if (!court_address) { court_address = "-"; }
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: {
				"procecution_id": procecution_id, "procecution_number": procecution_number, "subject": subject,
				"date": date, "procecution_value": procecution_value, "court_name": court_name,
				"court_address": court_address, "operation": "update_procecution_info"
			},
			success: function (d) {
				if (d == "procecution_updated") {
					show_message_with_id("تم تعديل بيانات القضية والمحكمة بنجاح", "success_dialog_procecution");
				}
				else {
					show_message_with_id("لم يتم تعديل بيانات القضية والمحكمة ", "error_dialog_procecution");
				}

			}
		});
	});

	$("#save_agent_btn").click(function () {

		var procecution_id = procecution_id_global,
			agent_notes = $("#agent_notes").val(),
			agent_address = $("#agent_address").val(),
			agent_number = $("#agent_number").val(),
			agent_name = $("#agent_name").val();

		if (!agent_notes) { agent_notes = "-"; }
		if (!agent_address) { agent_address = "-"; }
		if (!agent_number) { agent_number = 0; }
		if (!agent_name) { agent_name = "-"; }
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: {
				"procecution_id": procecution_id, "agent_name": agent_name, "agent_address": agent_address,
				"agent_number": agent_number, "agent_notes": agent_notes, "operation": "update_agent_info"
			},
			success: function (data) {
				if (data == "updated") {

					show_message_with_id("تم تعديل بيانات وكيل الخصم بنجاح", "success_dialog_agent");
				}
				else {
					show_message_with_id("لم يتم تعديل بيانات وكيل الخصم  ", "error_dialog_agent");
				}

			}
		});
	});

	$("#save_discount_btn").click(function () {

		var procecution_id = procecution_id_global,
			discount_name = $("#discount_name").val(),
			discount_number = $("#discount_number").val(),
			discount_address = $("#discount_address").val(),
			discount_notes = $("#discount_notes").val();

		if (!discount_name) { discount_name = "-"; }
		if (!discount_number) { discount_number = 0; }
		if (!discount_address) { discount_address = "-"; }
		if (!discount_notes) { discount_notes = "-"; }
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: {
				"procecution_id": procecution_id, "discount_name": discount_name, "discount_number": discount_number,
				"discount_address": discount_address, "discount_notes": discount_notes, "operation": "update_discount_info"
			},
			success: function (data) {
				data=data.trim();
				if (data == "updated") {

					show_message_with_id("تم تعديل بيانات الخصم بنجاح", "success_dialog_discount")
				}
				else {
					show_message_with_id("لم يتم تعديل بيانات الخصم  ", "error_dialog_discount")
				}

			}
		});
	});


	$("#save_customer_btn").click(function () {
		console.log("looool");
		var customer_id = customer_id_global,
			customer_name = $("#customer_name").val(),
			phone_number = $("#phone_number").val(),
			identity_number = $("#identity_number").val(),
			customer_address = $("#address").val(),
			customer_notes = $("#notes").val();

		if (!phone_number) { phone_number = "-"; }
		if (!customer_address) { customer_address = "-"; }
		if (!customer_notes) { customer_notes = "-"; }
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "customer_id": customer_id, "customer_name": customer_name, "phone_number": phone_number, "identity_number": identity_number, "customer_address": customer_address, "customer_notes": customer_notes, "operation": "update_customer_info" },
			success: function (data) {
				if (data == "updated") {

					show_message_with_id("تم تعديل بيانات الزبون بنجاح", "success_dialog_custmer")
				}
				else {
					show_message_with_id("لم يتم تعديل بيانات الزبون  ", "error_dialog_customer")
				}

			}
		});
	});

	$(".resume_procecution").click(function () {
		var procecution_id = $(this).closest("tr").find("td:nth-child(6)").find("input").val();
		var row_index = $(this).closest("tr").index();
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "procecution_id": procecution_id, "oper": "resume", "operation": "end_resume_procecution" },

			success: function (data) {
				data=data.trim();
				if (data == "updated") {
					document.getElementById("my_table").deleteRow(row_index + 1);
					show_success_message("تم استعادة القضية الى القضايا غير المنتهية ");
				}
				else {
					show_fail_message("لم يتم استعادة القضية الى القضايا غير المنتهية");
				}

			}
		});
	});
	$(".end_procecution").click(function () {
		var procecution_id = $(this).closest("tr").find("td:nth-child(6)").find("input").val();
		var row_index = $(this).closest("tr").index();
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "procecution_id": procecution_id, "oper": "end", "operation": "end_resume_procecution" },

			success: function (data) {
				data=data.trim();
				if (data == "updated") {
					document.getElementById("my_table").deleteRow(row_index + 1);
					show_success_message("تم تحديد القضية ك منتهية  ");
				}
				else {
					show_fail_message("لم يتم تحديد القضية ك منتهية  ");
				}

			}
		});

	});


	/// عرض تفاصيل الزبون 
	$('.view-button').click(function () {
		var doc = document.getElementById('show-details');
		$(doc).css('display', 'block');
		
		var procecution_id = $(this).closest("tr").find("td:nth-child(6)").find("input").val();
		var customer_id = $(this).closest("tr").find("td:nth-child(5)").find("input").val();
		procecution_id_global = procecution_id;
		customer_id_global = customer_id;
		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "procecution_id": procecution_id, "customer_id": customer_id, "operation": "view_customer_info" },
			success: function (data) {
				var obj = JSON.parse(data);

				var customer = obj.customer, procecution = obj.procecution, discount = obj.discount, discount_agent = obj.discount_agent;
				var name = customer.name, phone_number = customer.phone_number, identity_number = customer.identity_number, address = customer.address, notes = customer.notes;
				var procecution_number = procecution.procecution_number, subject = procecution.subject, date = procecution.date,
					value = procecution.value, court_name = procecution.name, court_address = procecution.address;
				var discount_name = discount.name, discount_number = discount.number, discount_address = discount.address, discount_notes = discount.notes;
				var agent_name = discount_agent.name, agent_number = discount_agent.number, agent_address = discount_agent.address, agent_notes = discount_agent.notes;

				fill_customer_info(name, phone_number, identity_number, address, notes);
				fill_procecution_info(procecution_number, subject, date, value, court_name, court_address);
				fill_discount_info(discount_name, discount_number, discount_address, discount_notes);
				fill_agent_info(agent_name, agent_number, agent_address, agent_notes);



			}
		});

	});

	//اغلاق واجهة عرض التفاصيل 
	$('#close_view_btn').click(function () {
		$('#show-details').css('display', 'none');
	});






	$(".proc_number").change(function () {
		var procecution_id = $(this).closest("tr").find("td:nth-child(6)").find("input").val();
		var procecution_number = $(this).val();
		/*
			window.alert(procecution_id);
			window.alert(procecution_number);*/

		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "procecution_id": procecution_id, "procecution_number": procecution_number, "operation": "update_procecution_number" },

			success: function (data) {
				data=data.trim();
				if (data == "updated") {
					show_success_message("تم تعديل القضية بنجاح ");
				}
				else {
					show_fail_message("لم يتم تعديل القضية ");
				}

			}
		});

	});
// تعديل الاسم من الجدول
	$(".cust_name").change(function () {
		var customer_id = $(this).closest("tr").find("td:nth-child(5)").find("input").val();
		var name = $(this).val();

		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "customer_id": customer_id, "name": name, "operation": "update_name" },
			success: function (data) {
				data=data.trim();
				if (data == "updated") {
					show_success_message("تم تعديل الاسم بنجاح ");
				}
				else {

					show_fail_message("لم يتم تعديل الاسم  ");

				}

			}
		});
	});

	//تعديل رقم الهوية 
	$(".cust_identity").change(function () {
		var customer_id = $(this).closest("tr").find("td:nth-child(5)").find("input").val();
		var identity_number = $(this).val();

		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "customer_id": customer_id, "identity_number": identity_number, "operation": "update_identity_number" },
			
			success: function (data) {
				data=data.trim();
				
				if (data.length > 35 && data.substring(0,39) == "Error updating record: Duplicate entry") 
					show_success_message("لا يمكن تعديل رقم الهوية ، تم اضافة نفس الرقم لوكيل موجود بالفعل");
				else if (data == "updated")
					show_success_message("تم تعديل رقم الهوية بنجاح ");
				else 
					show_fail_message("لم يتم تعديل رقم الهوية   ");

				

			}
		});

	});

	$('#btn-addNewCustomer').click(function () {
		var doc = document.getElementById('addsec');
		$(doc).css('display', 'block');
	});



	$('.delete-button').click(function () {
		/*	var div = document.getElementById('confirm-delete');
			$(div).css('display', 'block');*/
		var row = $(this).closest("tr");
		procecution_id_global = $(row).find("td:nth-child(6)").find("input").val();
		row_index_global = row.index();

		console.log(procecution_id_global);

	});


	$("#confirm-yes-delete").click(function () {
		/*var div = document.getElementById('exampleModal');
		  $(div).css('display', 'none');*/
         $("#exampleModal").modal('hide');
		//	document.getElementById('exampleModal').style.display="none";

		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "procecution_id": procecution_id_global, "operation": "delete" },
			success: function (data) {
				var message = " kkkkk";
				data=data.trim();
				if (data == "deleted") {
					document.getElementById("my_table").deleteRow(row_index_global + 1);
					show_success_message("تم حذف القضية بنجاح ");
				}
				else {
					show_fail_message("لم يتم حذف القضية ");
				}
			}
		});
		

	});




	$('#client_btn').click(function () {
		first_name = document.getElementById('first-name-customer').value;
		father_name = document.getElementById('father-name-customer').value;
		grand_name = document.getElementById('grandfather-name-customer').value;
		family_name = document.getElementById('family-name-customer').value;
		identity_number = document.getElementById('customer_identiy_number').value;
		phone_number = document.getElementById('contact-number-customer').value;
		customer_address = document.getElementById('address-customer').value;
		customer_notes = document.getElementById('note-about-customer').value;

		//  اذا حطيت اسم المتغير لحاله بين القوسين رح يرجع فولس اذا كان المتغير واحد من هذول الحالات 
		/*null,undefined,NaN,empty string (""),0,false*/
		if (!phone_number) { phone_number = "-"; }
		if (!customer_address) { customer_address = "-"; }
		if (!customer_notes) { customer_notes = "-"; }

		console.log(first_name + "\n", father_name + " ", grand_name + " ", family_name + " " + identity_number + " ", phone_number + " ", customer_address + " ", customer_notes + " ");
	});


	$('#discount_btn').click(function () {
		discount_name = document.getElementById('name-discount').value;
		discount_number = document.getElementById('number-discount').value;
		discount_address = document.getElementById('address-discount').value;
		discount_notes = document.getElementById('note-discount').value;

		if (!discount_name) { discount_name = "-"; }
		if (!discount_number) { discount_number = 0; }
		if (!discount_address) { discount_address = "-"; }
		if (!discount_notes) { discount_notes = "-"; }

		//	console.log(discount_name+"\n",discount_number+"\n " ,discount_address+"\n " ,discount_notes+"\n");
	});


	$('#discount_agent_btn').click(function () {
		agent_name = document.getElementById('agent-name').value;
		agent_number = document.getElementById('number-agent').value;
		agent_address = document.getElementById('address-agent').value;
		agent_notes = document.getElementById('note-agent').value;
		if (!agent_name) { agent_name = "-"; }
		if (!agent_number) { agent_number = "-"; }
		if (!agent_address) { agent_address = "-"; }
		if (!agent_notes) { agent_notes = "-"; }

		console.log(agent_name + "\n", agent_number + "\n ", agent_address + "\n ", agent_notes + "\n");
	});

	// insert new customer
	$('#court_btn').click(function () {
		//if(first_name==" " father_name grand_name family_name identity_number)

		document.getElementById('addsec').style.display = 'none';

		court_address = document.getElementById('address-court').value;
		procecution_number = document.getElementById('number-session').value;
		court_name = document.getElementById('name-court').value;
		procecution_subject = document.getElementById('theme-court').value;
		procecution_value = document.getElementById('value-court').value;
		procecution_date = document.getElementById('date-court').value;


		if (!court_address) { court_address = "-"; }
		if (!procecution_number) { procecution_number = "-"; }
		if (!court_name) { court_name = "-"; }
		if (!procecution_subject) { procecution_subject = "-"; }
		if (!procecution_value) { procecution_value = 0; }
		if (!procecution_date) { procecution_date = "2000-01-01"; }
		insert_customer();

		//console.log(court_address+"\n",session_number+"\n " ,court_name+"\n " ,procecution_subject+" \n" ,procecution_value+"\n ", procecution_date+"\n ");
	});

	$('.next').click(function () {



		if (animating)
			return false;
		animating = true;
		current_fieldset = $(this).parent();
		next_fieldset = $(this).parent().next();
		$('.progressbar li').eq($("fieldset").index(next_fieldset)).addClass("active");
		//show the next fieldset
		next_fieldset.show();
		//hide the current fieldset with style
		current_fieldset.animate({ opacity: 0 }, {
			step: function (now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50) + "%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fieldset.css({
					'transform': 'scale(' + scale + ')',
					'position': 'absolute'
				});
				next_fieldset.css({ 'left': left, 'opacity': opacity });
			},
			duration: 800,
			complete: function () {
				current_fieldset.hide();
				animating = false;
			}, easing: 'easeInOutBack'
			//this comes from the custom easing plugin
		});
	});




	$('.previous').click(function () {
		if (animating) return false;
		animating = true;
		current_fieldset = $(this).parent();
		previous_fieldset = $(this).parent().prev();
		$('.progressbar li').eq($("fieldset").index(current_fieldset)).removeClass("active");
		previous_fieldset.show();

		previous_fieldset.show();
		//hide the current fieldset with style
		current_fieldset.animate({ opacity: 0 }, {
			step: function (now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale previous_fs from 80% to 100%
				scale = 0.8 + (1 - now) * 0.2;
				//2. take current_fs to the right(50%) - from 0%
				left = ((1 - now) * 50) + "%";
				//3. increase opacity of previous_fs to 1 as it moves in
				opacity = 1 - now;
				current_fieldset.css({ 'left': left });
				previous_fieldset.css({ 'transform': 'scale(' + scale + ')', 'opacity': opacity });
			},
			duration: 800,
			complete: function () {
				current_fieldset.hide();
				animating = false;
			},
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	});



});


function fill_customer_info(name, phone_number, identity_number, address, notes) {

	$("#customer_name").val(name);
	$("#phone_number").val(phone_number);
	$("#identity_number").val(identity_number);
	$("#address").val(address);
	$("#notes").val(notes);

}

function fill_procecution_info(procecution_number, subject, date, value, court_name, court_address) {

	$("#procecution_number").val(procecution_number);
	$("#subject").val(subject);
	$("#date").val(date);
	$("#procecution_value").val(value);
	$("#court_name").val(court_name);
	$("#court_address").val(court_address);

}
function fill_discount_info(discount_name, discount_number, discount_address, discount_notes) {

	$("#discount_name").val(discount_name);
	$("#discount_number").val(discount_number);
	$("#discount_address").val(discount_address);
	$("#discount_notes").val(discount_notes);
}
function fill_agent_info(agent_name, agent_number, agent_address, agent_notes) {
	$("#agent_name").val(agent_name);
	$("#agent_number").val(agent_number);
	$("#agent_address").val(agent_address);
	$("#agent_notes").val(agent_notes);
}
function show_success_message(message) {
	$("#show_success_msg").html(message);
	$('#success_dialog').css('display', 'block');
}

function show_fail_message(message) {
	$("#show_Error").html(message);
	$('#error_dialog').css('display', 'block');
}

function show_message_with_id(message, dialog_id) {
	var temp_dialog_id = "#" + dialog_id;
	$(temp_dialog_id).css('display', 'block');
	var msg_div_id = "#msg_" + dialog_id;
	$(msg_div_id).html(message);
}
function disable_add_customer_textfields() {
	$("#first-name-customer").attr("disabled", "disabled");
	$("#contact-number-customer").attr("disabled", "disabled");
	$("#address-customer").attr("disabled", "disabled");
	$("#note-about-customer").attr("disabled", "disabled");
}
function enable_add_customer_textfields() {
	$("#first-name-customer").removeAttr('disabled');
	$("#contact-number-customer").removeAttr('disabled');
	$("#address-customer").removeAttr('disabled');
	$("#note-about-customer").removeAttr('disabled');
}


function validate_number(text) {
	if (text.trim() == "" || isNaN(text))
		return false;
	else
		return true;
}
function validate_string(text) {
	if (text.trim() == "" || !isNaN(text))
		return false;
	else
		return true;
}
$(".close_success").click(function () {
	$('#success_dialog').css('display', 'none');
});
$(".close_fail").click(function () {
	$('.d_error_dialog').css('display', 'none');
});

$(".close_dialog_success").click(function () {
	$('.d_success_dialog').css('display', 'none');
});

//اغلاق ديالوج الخطأ الي بتم طباعته من كلاس كلاينت 
$(".client_close_fail").click(function () {
	$('.client_error_dialog').css('display', 'none');
});
$(".close_dialog_fail").click(function () {
	$('#d_error_dialog').css('display', 'none');
});



function insert_customer() {
	if (!(validate_string(first_name) && validate_string(father_name) && validate_string(grand_name) && validate_string(family_name))) {
		window.alert(first_name + father_name + grand_name + family_name + "يرجى التأكد من ادخال اسم المستخدم كاملا وبشكل صحيح ");
	}
	else if (!(validate_number(identity_number))) {
		window.alert("يرجى التأكد من ادخال رقم الهوية بالشكل الصحيح");
	}
	else if (!(validate_number(procecution_number))) {
		window.alert("يرجى التأكد من ادخال رقم القضية بالشكل الصحيح");
	}
	else {
		var customer_info = {
			"first_name": first_name, "father_name": father_name, "grand_name": grand_name,
			"family_name": family_name, "identity_number": identity_number, "phone_number": phone_number,
			"customer_address": customer_address, "customer_notes": customer_notes
		};

		var discount_info = { "discount_name": discount_name, "discount_number": discount_number, "discount_address": discount_address, "discount_notes": discount_notes };
		var agent_info = { "agent_name": agent_name, "agent_number": agent_number, "agent_address": agent_address, "agent_notes": agent_notes };
		var court_info = {
			"court_address": court_address, "procecution_number": procecution_number, "court_name": court_name,
			"procecution_subject": procecution_subject, "procecution_value": procecution_value, "procecution_date": procecution_date
		};

		var customer = JSON.stringify(customer_info);
		var discount = JSON.stringify(discount_info);
		var agent = JSON.stringify(agent_info);
		var court = JSON.stringify(court_info);

		$.ajax({
			url: "../php/customers_operations.php",
			type: "POST",
			data: { "customer": customer, "discount": discount, "agent": agent, "court": court, "customer_id": insert_customer_id, "operation": "insert" },
			success: function (data) {
				var msg = "Errors";
				var there_exist_errors = 0;
				/*  show_fail_message(data);
					window.alert(data);*/
				var obj = JSON.parse(data);
				//var x = obj.court;

				if (obj.court != 1) {
					there_exist_errors = 1;
					msg += obj.court + "\n ";
				}
				if (obj.customer != 1) {
					there_exist_errors = 1;
					msg += obj.customer + "\n ";
				}
				if (obj.procecution != 1) {
					there_exist_errors = 1;
					msg += obj.procecution + "\n ";
				}
				if (obj.discount != 1) {
					there_exist_errors = 1;
					msg += obj.discount + "\n ";
				}
				if (obj.discount_agent != 1) {
					there_exist_errors = 1;
					msg += obj.discount_agent + "\n ";
				}

				if (there_exist_errors == 0) {

					msg = "تمت الاضافة بنجاح";

					show_success_message(msg);
					window.alert(msg);
				}
				else {
					show_fail_message("لم تنجح عملية الاضافة ");
					window.alert("لم تنجح عملية الاضافة ");
					console.log(msg);

				}

			}

		});
	}
}

