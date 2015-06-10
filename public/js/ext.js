//2015-2-9 14:00:41
String.prototype.strtr = function(from){
	var ret="";
	var matched=false;
	for(var i=0;i<this.length;i++){
		matched=false;
		for(var k in from){
			if(this.substr(i,k.length)==k){
				ret+=from[k];
				i+=k.length-1;
				matched=true;
				break;
			}
		}
		if(!matched){
			ret+=this.substr(i,1);
		}
	}
	return ret;
};
String.prototype.encode = function(){
	return encodeURIComponent(this);
};
jQuery.extend({
	getEntryHome:function(){
		var m = $("meta[name=entrypoint]");    
		return m.attr("content");
	},
	pp:function(c,np,wid,ns,li){
		var url = $.getEntryHome()+"/order/estimate?";
		var args = [];
		args.push("c="+c);
		args.push("np="+np.encode());
		args.push("ns="+ns.encode());
		args.push("wo="+wid);
		switch(c){
		case "tbJS":
			args.push("tt="+li);
			break;
		case "spancalcJS":
			args.push("cur="+li.split("-")[0]);
			args.push("dst="+li.split("-")[1]);
			break;
		case "calcJS":
			args.push("amt="+li);
			break;
		}
		window.open(url+args.join("&"));
		
	}
});