var g_spancalc = {};
g_spancalc.tpl = '<div class="estimate"><table><caption>Estimate</caption><tr><td>Path</td><td>{path}</td></tr><tr><td>Current:</td><td>{current}</td></tr><tr><td>Destination:</td><td>{destination}</td></tr><tr><td>Gross:</td><td>{gross}</td></tr></table></div>';
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
}
g_spancalc.is23ldpData = function(data){
	try{
		return data[0][0].length == 3;
	}catch(e){return false;}
};
g_spancalc.calc = function(data,c,d,u){
	var f = 1,
		s = 0,
		p = 0,
		r = 0,
		l = 0,
		needdays = 0,
		is23ldp = false;

	var e = data;
	is23ldp = g_spancalc.is23ldpData(e);

	if(!f)f=1;
	if(e[0][0]!=0&&e[0][1]!=0){e.unshift(is23ldp?[0,0,0]:[0,0]);}
	if(c<0||d<0||c>=e[e.length-1][0]||d>e[e.length-1][0]||c>=d){
		throw('Error:3620\nc='+c+'d='+d+'\nc<0'+(c<0)+'\nd<0'+(d<0)+'\nc>=e[e.length-1][0]'+(c>=e[e.length-1][0])+'\nd>e[e.length-1][0]'+'\nc>=d'+(c>=d));
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
//return obj {cur:1,dst:22,path:/a/b,data:[]}
g_spancalc.findInfo = function(wid){
	//查找class=widget-spancalc的结点
	var container = $("#widget-spancalc-unit-"+wid).parent(".widget-spancalc");
	var obj = g_spancalc[wid];
	var unit = $("#widget-spancalc-unit-"+wid).val();
	obj.path = "";
	//认为SELECT为路径,排除NAME为current_state,destination_state
	container.find("select").each(function(i,e){
		switch(e.name){
			case "current_state":
				obj.cur = e.value;break;
			case "destination_state":
				obj.dst = e.value;break;
			default:
				obj.path += "/"+e.value;
				break;
		}
	});
	obj.data = obj["datasrc"][obj.path];	
	return obj;
};
g_spancalc.estimate = function(wid){
	var info = g_spancalc.findInfo(wid);
	
};
g_spancalc.bn = function(wid){
	var info = g_spancalc.findInfo(wid);
	
};