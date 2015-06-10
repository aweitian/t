//2015-1-27 16:54:57
(function(){
	var calc = {};
	function _data_s2i(data){
		for(var i=0;i<data.length;i++){
			data[i][0] = parseInt(data[i][0]);
			data[i][1] = parseFloat(data[i][1]);
		}
		return data;
	}
	calc.calc = function(amount,data){
		var pos = 0;
		var div = true;
		amount = parseInt(amount);
		data = _data_s2i(data);
		for(var row in data){
			if(data[row][0]>amount){
				if(pos>0)pos--;
				break;
			}
			if(data[row][0] == amount){
				div = false;
				break;
			}
			pos++;
		}
		if(pos==data.length){
			pos--;
		}
		if(div){
			return (data[pos][1] / data[pos][0] * amount).toFixed(2);
		}else{
			return data[pos][1];
		}
	};
	calc.estimate = function(wid){
		var container = $("#widget-calc-unit-"+wid).parent();
		var u_p = container.find("span.u-price");
		var u_a = container.find("input[name=amount]");
		var amount = parseInt(u_a.val());
		var sels = container.find("tr.nsrow select");
		var path = [];
		for(var i=0;i<sels.length;i++){
			path.push("/");
			path.push(sels.get(i).value);
			if(sels.get(i) == this)break;
		}
		var data = window[initGvn()][wid][path.join("")];
//		console.log(data);
		if(amount>0){
			u_p.html(calc.calc(amount,data));
		}else{
			alert('invalid amount');
		}
	};
	calc.buynow = function(wid){
		var container = $("#widget-calc-unit-"+wid).parent();
		var u_p = container.find("span.u-price");
		var u_a = container.find("input[name=amount]");
		var amount = parseInt(u_a.val());
		var sels = container.find("tr.nsrow select");
		var path = [];
		for(var i=0;i<sels.length;i++){
			path.push(sels.get(i).value);
		}
		if(amount>0){
			_send_order(wid,"/"+path.join("/"),amount);
			return;
		}else{
			alert('invalid amount');
		}		
	};
	function _send_order(wid,ns,amount){
		var np = $("#np-"+wid).val();
		var url = getEntryHome()+"/order/estimate?";
		var args = [];
		args.push("c=calcJS");
		args.push("np="+np.encode());
		args.push("ns="+ns.encode());
		args.push("wo="+wid);
		args.push("amt="+amount);
		window.open(url+args.join("&"));
	}
	$(function(){
		console.log(getEntryHome());
		$("div.widget-calc").delegate("tr.nsrow select","change",function(){
			var container = $(this).parentsUntil("div.widget-calc").parent().first();
			var sels = container.find("tr.nsrow select");
			var path = [];
			for(var i=0;i<sels.length;i++){
				path.push("/");
				path.push(sels.get(i).value);
				if(sels.get(i) == this)break;
			}
			$.getJSON(getEntryHome()+"/debug/calc?ns="+path.join(""),function(o){
				container.find("table tr.nsrow").remove();
				var html = "";
				for(var x in o){
					html += '<tr class="nsrow"><td>'+o[x].name+'</td><td>'+o[x].html+'</td></tr>';
				}
				container.find("table tr").first().before(html);
			});

		});
	});
	function getEntryHome(){
		return $.getEntryHome();	
	}
	function initGvn(){
		var vn = "gvn";
		var def = "g_calc";
		var _reg = /\/calc\.js(?=\?|#|$)/;
		var _list = document.getElementsByTagName('script');
		if (!_list||!_list.length) return;
		for(var i=_list.length-1,_script;i>=0;i--){
			_script = _list[i];
			if(_reg.test(_script.src)){
				var reg = new RegExp("(^|&)"+ vn +"=([^&]*)(&|$)");
				var sArr = _script.src.split("?");
				if(sArr.length != 2)return def;
				var r = sArr[1].match(reg);
				if (r!=null) return unescape(r[2]);
				return def;
			}
		}		
	}
	window[initGvn()] = calc;
})();