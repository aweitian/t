//2015-4-10 13:25:05
(function(){
	function s(o){
		o.previousSibling.style.display = "block";
		o.style.display = "none";
	}
	function h(o){
		o.parentNode.style.display = "none";
		o.parentNode.nextSibling.style.display = "block";
	}
//	function d(sid){
//		if(typeof jQuery == "undefined")return;
//		var url = document.location.href.split("?")[0];
//		if(url.substr(-1) !== "/"){
//			url += "/";
//		}
//		url += "delivery?sid="+sid;
//		$.getJSON(url,function(o){
//			
//		});
//	}
	window.od = {
		show:s,
		hide:h
	}
})();