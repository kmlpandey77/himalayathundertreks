// JavaScript Document
$(document).ready(function(){
	"use strict";
	var height = $( window ).height();
	var navbar_top = $('.navbar').outerHeight();
	var slide_bar = $('.side-bar').height();
	$('.content').css('min-height',height);
	$('#side-bar').css('top', navbar_top);
	
	if(height < slide_bar){
		$('.side-bar').css('height',height + 20)
	}

	// $('#side-bar').enscroll({
	//     verticalTrackClass: 'track',
	//     verticalHandleClass: 'handle',
	//     minScrollbarLength: 28
	// });
	new SimpleBar($('#side-bar')[0])
});

$(document).on('click', '.js-modal-call', function (e) {
	e.preventDefault();
	$('#jsModal').modal('show');
	url = $(this).attr('href');
	$.ajax(url,{
		type: 'POST',
		dataType:'html',
		headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
		success:function (response) {
			$('#jsModal').find('.modal-content').html(response);
		},
		error: function () {
			$('#jsModal').find('.modal-content').html('error');
		}
	});
});


//activities
function show_in_menu(){
	if ($('input#show_in_menu').is(':checked')) {
		$('#menu_title').collapse('show');
	}else{
		$('#menu_title').collapse('hide');		
	}
}
$(document).on('click', '#show_in_menu', function () {
	show_in_menu();
});
$(document).ready(function () {
	show_in_menu();
});



//add more facts
function fact_add_another(){
	var new_fact = $('#facts_wrap > .last').clone();
	new_fact.find('input:text').val('');
	$('#facts_wrap > .last').removeClass('last');
	new_fact.appendTo($('#facts_wrap'));	
}

//add more graph
function graph_add_another(){
	var new_graph = $('#graphs_wrap > .last').clone();
	new_graph.find('input:text').val('');
	$('#graphs_wrap > .last').removeClass('last');
	new_graph.appendTo($('#graphs_wrap'));	
}

//add more itineraries
function itinerary_add_another(){
	var new_fact = $('#itinerary_wrap > .last').clone();
	var day = new_fact.find('input#day').val();
	var day = parseInt(day.replace(/[^0-9\.]/g, ''), 10);
	day++
	new_fact.find('input:text').val('');
	new_fact.find('input#day').val('Day ' + day);
	new_fact.find('textarea').val('');
	$('#itinerary_wrap > .last').removeClass('last');
	new_fact.appendTo($('#itinerary_wrap'));	
}



// ======================== NOT NEEDED ==================================

// $(document).on('click', '.banner_delete', function(){
// 	var ele = $(this);
// 	var id = ele.data('id');
// 	var url = base_url + 'admin/banner_delete';
// 	$.ajax(url,{
// 		data:{id:id},
// 		type:'post',
// 		dataType:'json',
// 		success: function(data){
// 			if(data.status == 'success'){
// 				ele.parent().slideUp();
// 			}
// 		}
// 	});
// });


// //package_tab_load
// function package_tab_load(tab){
// 	$('#tab_' + tab).addClass('active');
// 	$('#' + tab).addClass('active');
// }

// // package save
// function save_package(save, next){
// 	save = save;
// 	next = next;
// 	var form = $('#form_' + save )
// 	var data = form.serialize();
// 	var url = form.attr('action');
// 	$.ajax(url,{
// 		data:data,
// 		type:'POST',
// 		dataType:'json',
// 		success:function(r){
// 			if (typeof next != 'undefined'){
				
// 				if(r.status == 'success'){				
// 					window.location.href = base_url + 'admin/app/packages/create/' + r.id + '/' + next;
// 				}
				
// 			}else{
// 				window.location.href = base_url + 'admin/app/packages';
// 			}			
// 		}
// 	});		
// }





// // cropmodal js
// $(document).on('change', '.js-crop-modal-call', function () {
// 	$('#js-crop-modal').modal('show');
// 	var type = $(this).data('type');	
// 	var reader = new FileReader();
//     reader.onload = function(event) {
//         $('#js-crop-modal-image').attr("src", event.target.result);
//         $('#form_image_type').val(type);
//     };
//     reader.onerror = function(event) {
//         alert("ERROR: " + event.target.error.code);
//     };
//     reader.readAsDataURL(this.files[0]);
// });

// window.addEventListener('DOMContentLoaded', function () {

// 	var image = document.getElementById('js-crop-modal-image');
// 	var cropBoxData;
// 	var canvasData;
// 	var cropper; 

// 	$('#js-crop-modal').on('shown.bs.modal', function () {
// 		if($('#form_image_type').val() == 'thumb' ){
// 			var crop_w = thumb_w;
// 			var crop_h = thumb_h;
// 		}else{
// 			var crop_w = banner_w;
// 			var crop_h = banner_h;
// 		}
// 		// console.log(crop_h);	
// 		cropper = new Cropper(image, {
// 			autoCropArea: 1,
// 			aspectRatio: crop_w / crop_h,
// 		});
// 	}).on('hidden.bs.modal', function () {		
// 		$('.js-crop-modal-call').val('');
// 		cropper.destroy();
// 	});

// 	$(document).on('click', '#js-crop-modal-crop-btn', function () {
// 		var id = $('#form_id').val();
// 		var type = $('#form_image_type').val();
// 		if(type == 'thumb' ){
// 			var url = base_url + 'admin/ajax_crop_thumb';		
// 		}else{
// 			var url = base_url + 'admin/ajax_crop_banner';
// 		}
// 		$('#js-crop-modal').modal('hide');
// 		cropedimage = cropper.getCroppedCanvas().toDataURL('image/jpeg');
// 		$.ajax(url,{
// 			data:{id:id,cropedimage:cropedimage},
// 			type:'post',
// 			dataType:'json',			
// 			success:function (data) {
// 				$('.js-crop-modal-cropped-img-load-' + type).html(data.img);
// 				$('.js-crop-modal-cropped-img-load-' + type).find('img').addClass('img-responsive');
// 			}			
// 		})
// 	});

// });