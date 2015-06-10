/**
 *	JSON.beauty(object,true,1,true); ���ظ�ʽ�����ַ�
 *	JSON.parse(jsonstring),
 *	2013-9-2 13:30:31
 *	awei.tian
 */
var JSON={
	repeat:function(input,multiplier){
		return new Array(multiplier+1).join(input);
	},
	addslashes:function(str){
		return str.replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
	},
	duplicate:function(o){
		return JSON.parse(JSON.stringify(o));
	},
	beauty:function(o,format,deep,mode){
		var temp=[],ret=[];
		deep=deep||1;
		format=format||false;
		mode=mode||false;
		try{
			switch(o.constructor){
				case String:
					return '"'+(format?o.replace(/\r\n|\t/g,''):JSON.addslashes(o))+'"';
				case Object:
					ret.push('{');
					for(var x in o){
						temp.push(
							(format?'\r\n'+JSON.repeat('\t',deep):'')+
							'"'+JSON.addslashes(x)+'":'+
							JSON.beauty(o[x],format,deep+1,mode)
						);
					}
					ret.push(temp.join(","));
					format&&ret.push((format?'\r\n':'')+JSON.repeat('\t',deep-1));
					ret.push('}');
					break;
				case Array:
					ret.push('[');
					for(var x=0;x<o.length;x++){
						temp.push((format?'\r\n'+JSON.repeat('\t',deep):'')+JSON.beauty(o[x],format,deep+1,mode));
					}
					ret.push(temp.join(","));
					format&&ret.push((format?'\r\n':'')+JSON.repeat('\t',deep-1));
					ret.push(']');	
					break;
				case Function:
					if(format===true){
						if(mode===false)return 'function(){...}';
					}else{
						return 'null';	
					}
				default:
					return (o.toString());
			}
			
		}catch(e){return 'null';}
		ret = ret.join("");
		return ret;
	},
	stringify:function(o){
		return JSON.beauty(o,false,1,false);
	},
	parse:function(str){
		try{
			return eval('('+str+');');
		}catch(e){throw ('JSON parse Error:\n'+(e.description||e.message))}
	}	
};