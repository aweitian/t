<?php 
if(!isset($count)){
	$count = 30;
}
if(!isset($url)){
	$url = tian::$context->getRequest()->frontUrl();
	if(!$url){
		$url = ENTRY_HOME."/priv";
	}
}
?>
<div class="pure-g">
    <div class="pure-u-1-3"></div>
    <div class="pure-u-1-3 redirct-info redirct-info-fail">
    <table>
    <tr>
    	<td><span class="icon-uniE684 ico"></span></td>
    	<td>
    		错误:<?php echo $error;?>
    		<div class="direct-count">
	    		页面在 <span id="count"><?php echo $count;?></span> 秒后自动转跳至
	    		<a id="url" href="<?php echo $url?>"><?php echo $url?></a>    		
    		</div>

    	</td>
    </tr>
    </table>
    
    
    </div>
    <div class="pure-u-1-3"></div>
</div>
<script>
(function(){
	var o = document.getElementById("count");
	var c = parseInt(o.innerHTML);
	if(c<=0){
		window.location.href =  document.getElementById("url").href;
	}else{
		o.innerHTML = --c;
		setTimeout(arguments.callee,1000);
	}
})();

</script>