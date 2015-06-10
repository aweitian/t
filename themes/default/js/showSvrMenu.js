$(function(){
	$("#svr_menu").hover(function(){
		$("div.m-svrmenu").show();
	},function(){
		$("div.m-svrmenu").hide();
	});
	
	
	$(".m-svrmenu .u-filter li").click(function(){
		$(".m-svrmenu .u-filter li").removeClass("z-active");
		$(this).addClass("z-active");
	});
	
	//过滤菜单项
	$("#g-nav-filter li").click(function(){
		if($(this).text().toLowerCase() == "all"){
			$("#g-nav-menu li").removeClass("f-dn");
		}else if($(this).text().toLowerCase() == "0-9"){
			$("#g-nav-menu li").each(function(){
				if(!/^\d/.test($(this).text())){
					$(this).addClass("f-dn");
				}else{
					$(this).removeClass("f-dn");
				}
			});
		}else{
			var filterText = $(this).text().toLowerCase();
			$("#g-nav-menu li").each(function(){
				var reg = new RegExp("^"+filterText+"","i");
				if(!reg.test($.trim($(this).text()))){
					$(this).addClass("f-dn");
				}else{
					$(this).removeClass("f-dn");
				}
			});
			
		}
	});
	
});