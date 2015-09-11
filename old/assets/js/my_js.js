	
	function autotime(){
		var tgl = new Date();
		var sec, min, hou;
				
		setTimeout("autotime()", 1000);
		
		if(tgl.getSeconds() >= 0 && tgl.getSeconds() <= 9){
			sec = "0" + tgl.getSeconds();
		}else{
			sec = tgl.getSeconds();
		}

		if(tgl.getMinutes() >= 0 && tgl.getMinutes() <= 9){
			min = "0" + tgl.getMinutes();
		}else{
			min = tgl.getMinutes();
		}
		
		if(tgl.getHours() >= 0 && tgl.getHours() <= 9){
			hou = "0" + tgl.getHours();
		}else{
			hou = tgl.getHours();
		}
				
		document.getElementById("h2time").innerHTML = hou + " : " + min + " : " + sec + " WIB";
	}
	function heal_hutang(id_tr, hrg_jual){
		$.ajax({
			type: 'post',
			url: site_url + 'tracking/new_healHutang',
			async: false,
			data: 'id_tr=' + id_tr,
			cache: false,
			success: function(msg){
				if(msg == 'success'){
					$('#tr-' + id_tr).hide(300);
					
					var total_hutang = $('span#total-hutang');
					var sum = parseInt(total_hutang.html()) - parseInt(hrg_jual);
					
					total_hutang.html(sum);
				}
			}
		});
	}
	function get_effect(obj){
		$('#' + obj).animate({
			'padding-right' : '15px',
			'margin-left' : '-88px'
		});
	}
	function remove_effect(obj){
		$('#' + obj).animate({
			'padding-right' : '0',
			'margin-left' : '-73px'
		});
	}
	function get_datePlugin(obj_name){
		$('input[name="' + obj_name + '"]').datepicker({
			dateFormat		: "yy-mm-dd",
			changeMonth		: true,
			changeYear		: true
		});
	}
	
	$(function(){
		
		window.setTimeout("autotime()",1000);
		var dur = 500;
		
		$('.one').fadeIn(dur, function(){
			$('.two').fadeIn(dur, function(){
				$('.three').fadeIn(dur, function(){
					$('.four').fadeIn(dur, function(){
						$('.five').fadeIn(dur, function(){
							$('.six').fadeIn(dur);
						});
					});
				});
			});
		});
		
		$('div.search-control').click(function(){
			$('form#form_search').slideToggle(400);
		});
		$('div#t-2').click(function(){
			$('html, body').animate({ scrollTop: 0 }, 'slow');
		});
	
	});