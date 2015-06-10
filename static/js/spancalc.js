//2011-5-23 9:54:47
//2015-2-9 10:39:26
(function(){
	var _init_gvn = false;
	function is23ldpData(data){
		try{
			return data[0][0].length == 3;
		}catch(e){return false;}
	}
	function data_s2i(data){
		var is23ldp = is23ldpData(data);
		for(var i=0;i<data.length;i++){
			data[i][0] = parseInt(data[i][0]);
			data[i][1] = parseFloat(data[i][1]);
			if(is23ldp)data[i][2] = parseFloat(data[i][2]);
		}
		return data;
	}
	function mainCalc(data,c,d,u){
		var f = 1,
			s = 0,
			p = 0,
			r = 0,
			l = 0,
			needdays = 0,
			is23ldp = false;

		var e = data_s2i(data);
		is23ldp = is23ldpData(e);
		c = parseInt(c);
		d = parseInt(d);
		
		if(!f)f=1;
		if(e[0][0]!=0&&e[0][1]!=0){e.unshift(is23ldp?[0,0,0]:[0,0]);}
//		console.log(data);
		if(c<0||d<0||c>=e[e.length-1][0]||d>e[e.length-1][0]||c>=d){
			throw('Error:3620\n'
					+'c='+c+'\n'
					+'d='+d+'\n'
					+'c<0'+(c +'<0')+'\n'
					+'d<0'+(d<0)+'\n'
					+'c>=e[e.length-1][0]  '+(c >= e[e.length-1][0])+'\n'
					+'d>e[e.length-1][0]  '+(d > e[e.length-1][0])+'\n'
					+'c>=d'+(c>=d)
			);
			return;
		}
		for(i=0;i<e.length;i++){
			if(c<e[i][0]){s = i;break;}
		}
		for(i=e.length;i;i--){
			if(d>e[i-1][0]){
				p = i-1;break;
			}
		}
		//
		switch(p-s){
			case -1:
				needdays=((d-c)/+(e[s][0]-e[p][0])*e[s][1]).toFixed(2);
				if(is23ldp){
					price = ((d-c)/+(e[s][0]-e[p][0])*e[s][2]).toFixed(2);
					return {price:price,day:needdays};
				}
				return {price:((d-c)/+(e[s][0]-e[p][0])*e[s][1]*u*f).toFixed(2),day:needdays};
			case 0:
				needdays=(((e[s][0]-c)/(e[s][0]-e[s-1][0])*e[s][1]+(d-e[p][0])/(e[p+1][0]-e[p][0])*e[p+1][1])).toFixed(2);
				if(is23ldp){
					price = (((e[s][0]-c)/(e[s][0]-e[s-1][0])*e[s][2]+(d-e[p][0])/(e[p+1][0]-e[p][0])*e[p+1][2])).toFixed(2);
					return {price:price,day:needdays};
				}
				return {price:(((e[s][0]-c)/(e[s][0]-e[s-1][0])*e[s][1]+(d-e[p][0])/(e[p+1][0]-e[p][0])*e[p+1][1])*u*f).toFixed(2),day:needdays};
			default:
				r = 0;
				l = 0;
				if(is23ldp){
					r+=(e[s][0]-c)/(e[s][0]-e[s-1][0])*e[s][2];
				}
				l=(e[s][0]-c)/(e[s][0]-e[s-1][0])*e[s][1];
				for(i=s;i<p;i++){r+=e[i+1][2];l+=e[i+1][1];}
				l+=(d-e[p][0])/(e[p+1][0]-e[p][0])*e[p+1][1];
				r+=(d-e[p][0])/(e[p+1][0]-e[p][0])*e[p+1][2];
				needdays=l.toFixed(2);
				if(is23ldp){
					price = r.toFixed(2);
					return {price:price,day:needdays}
				}
				return {price:(l*u*f).toFixed(2),day:needdays};
		}
	}
	function getEntryHome(){
		return $.getEntryHome();		
	}
	function initGvn(){
		if(_init_gvn !== false)return _init_gvn;
		var vn = "gvn";
		var def = "g_spancalc";
		var _reg = /\/spancalc\.js(?=\?|#|$)/;
		var _list = document.getElementsByTagName('script');
		if (!_list||!_list.length){
			_init_gvn = def;
			return def;
		}
		for(var i=_list.length-1,_script;i>=0;i--){
			_script = _list[i];
			if(_reg.test(_script.src)){
				var reg = new RegExp("(^|&)"+ vn +"=([^&]*)(&|$)");
				var sArr = _script.src.split("?");
				if(sArr.length != 2){
					_init_gvn = def;
					return def;
				}
				var r = sArr[1].match(reg);
				if (r!=null) {
					_init_gvn = unescape(r[2]);
					return unescape(r[2]);
				}
				_init_gvn = def;
				return def;
			}
		}		
	}
	function estimate(wid){
		var container = $("#widget-spancalc-unit-"+wid).parent();
		var sels = container.find("tr.nsrow select");
		var path = [];
		for(var i=0;i<sels.length;i++){
			path.push("/");
			path.push(sels.get(i).value);
		}
		var data = window[initGvn()][wid]["datasrc"][path.join("")];
		var c = container.find("tr.currow select").val();
		var d = container.find("tr.destrow select").val();
		var u = $("#widget-spancalc-unit-"+wid).val();
		var result = mainCalc(data,c,d,u);
		_wrap_estimate(result,container);
		return;
	}
	function _wrap_estimate(result,container){
		var tpl = "<div class='close'></div><table><tr><td>Price:</td><td>{price}</td></tr><tr><td>Day</td><td>{day}</td></tr></table>";
		var dialog = container.find(".u-dialog");
		if(dialog.length){
			$(dialog.find("td")[1]).html(result.price);
			$(dialog.find("td")[3]).html(result.day);
		}else{
			dialog = $("<div/>").addClass("u-dialog").hide().prependTo(container)
			.html(tpl.strtr({
				"{price}":result.price,
				"{day}":result.day
			})).slideDown("slow",function(){
				var me = this;
				$(this).find(".close").click(function(){
					$(me).remove();
				});
			});
		}
	}
	function buynow(wid){
		var container = $("#widget-spancalc-unit-"+wid).parent();
		var sels = container.find("tr.nsrow select");
		var path = [];
		for(var i=0;i<sels.length;i++){
			path.push(sels.get(i).value);
		}
		var c = container.find("tr.currow select").val();
		var d = container.find("tr.destrow select").val();
		_send_order(wid,c,d,"/"+path.join("/"));
		return;
	}
	function _send_order(wid,c,d,ns){
		var np = $("#np-"+wid).val();
		var url = getEntryHome()+"/order/estimate?";
		var args = [];
		args.push("c=spancalcJS");
		args.push("np="+np.encode());
		args.push("ns="+ns.encode());
		args.push("wo="+wid);
		args.push("cur="+c);
		args.push("dst="+d);
		window.open(url+args.join("&"));
	}
	$(function(){
		$("div.widget-spancalc").delegate("tr.nsrow select","change",function(){
			var container = $(this).parentsUntil("div.widget-spancalc").parent().first();
			var sels = container.find("tr.nsrow select");
			var path = [];
			for(var i=0;i<sels.length;i++){
				path.push("/");
				path.push(sels.get(i).value);
				if(sels.get(i) == this)break;
			}
			$.getJSON(getEntryHome()+"/debug/spancalc?ns="+path.join(""),function(o){
				container.find("table tr.nsrow").remove();
				var html = "";
				for(var x in o.nsdata){
					html += '<tr class="nsrow"><td>'+o.nsdata[x].name+'</td><td>'+o.nsdata[x].html+'</td></tr>';
				}
				container.find("table tr").first().before(html);
				container.find("table tr.currow").remove();
				container.find("table tr.destrow").remove();
				container.find("table tr").last().before('<tr class="currow"><td>'+(o.data.current.name)+'</td><td>'+(o.data.current.html)+'</td></tr>');
				container.find("table tr").last().before('<tr class="destrow"><td>'+(o.data.destination.name)+'</td><td>'+(o.data.destination.html)+'</td></tr>');
			});
			
		});
	});
	if(typeof window[initGvn()] == "undefined")window[initGvn()] = {};
	window[initGvn()].estimate = estimate;
	window[initGvn()].buynow = buynow;
	window[initGvn()].calc = mainCalc;
})();
