//2014-10-4
function datasrc_22ap(){

}
datasrc_22ap.check = function(data){
	var f;
	f = is_array(data) && count(data) > 0;
	for(i=0; i<count(data) && f; i++){
		f = is_array(data[i])
		&& count(data[i]) == 2 
		&& (is_int(data[i][0]) || (is_numeric(data[i][0]) && preg_match("/^\d+/", data[i][0])))
		&& is_numeric(data[i][1]);
	}
	return f;
}
datasrc_22ap.sample = function(){
	var sample = [
	    [30,2.5],          
	    [60,4.9],          
	    [90,7.3],          
	    [120,9.5]          
	];
	return json.format(sample);
}