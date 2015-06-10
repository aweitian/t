//2014-10-4
function datasrc_23tpe(){

}
datasrc_23tpe.check = function(data){
	var f;
	f = is_array(data) && count(data) > 0;
	for(i=0; i<count(data) && f; i++){
		f = f && is_array(data[i])
		&& count(data[i]) == 2 
		&& (is_int(data[i][0]) || (is_numeric(data[i][0]) && preg_match("/^\d+/", data[i][0])))
		&& is_numeric(data[i][1])
		;
	}
	return f;
}
datasrc_23tpe.sample = function(){
	var sample = [
	    [30,2],          
	    [40,5],          
	    [50,7.3],          
	    [70,12]          
	];
	return json.format(sample);
}