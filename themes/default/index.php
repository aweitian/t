<?php
/**
 * @author:awei.tian
 * @date: 2014-9-20
 * @functions:
 */
require_once realpath("./../../")."/pd/const.php";
?><!DOCTYPE html>
<html>
<head>
<title>css demo</title>
<meta charset="UTF-8">
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
<meta http-equiv="Content-Style-Type" content="text/css"/>
<meta http-equiv="Content-Script-Type" content="text/javascript"/>
<meta name="Author" content="netease"/>
<meta name="Version" content="1.0"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/global.css" rel="stylesheet" type="text/css"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/index.css" rel="stylesheet" type="text/css"/>
<link href="<?php print ENTRY_HOME?>/themes/default/css/skin.css" rel="stylesheet" type="text/css"/>
<link type="text/css" href="css/ico/style.css" rel="stylesheet"/>
<link type="text/css" href="slider/css/global.css" rel="stylesheet"/>

<script type="text/javascript" src="<?php print ENTRY_HOME?>/themes/default/js/jquery-1.10.0.js"></script>
<script type="text/javascript" src="<?php print ENTRY_HOME?>/themes/default/js/jquery.slideBox.min.js"></script>
<script type="text/javascript" src="<?php print ENTRY_HOME?>/themes/default/js/showSvrMenu.js"></script>

</head>
<body>
<div class="g-hd">
	<div class="s-bd f-pr">
		<span class="m-logo">
			<a href="/">
				<span class="icon-uniE64E"></span>
				<span class="icon-uni74"></span>
				<span class="icon-uni6F"></span>
				<span class="icon-uni6E"></span>
				<span class="icon-uni79"></span>
				<span class="icon-uni70"></span>
				<span class="icon-uni6C"></span>
			</a>
		</span>	
	
		<div id="loginBar" class="m-sign f-radius5">
			<ul id="unlogin" class="itemlist">
				<li class="item"><a href="javascript:;" ><span class="txt1">Register</span></a></li>
				<li class="item"><span class="bdr"></span></li>
				<li class="item"><a target="_blank" class="line1 js-register" href="javascript:;" ><span class="txt1"><i class="icon-user"></i> Login</span></a></li>
				<li class="item"><span class="bdr"></span></li>
				<li class="item"><a href="javascript:;" ><span class="u-ico1 u-ico1-2"></span><span class="txt1"><i class="icon-cart3"></i> Shopping cart</span></a></li>
			</ul>
		</div>
		
	</div>
</div>
<div class="f-pr">
	<div class="g-nav f-pr">
		<ul class="f-cb s-bd">
			<li class="f-fl"><a href="/" class="g-nav-link"><span>Home</span></a></li>
			<li id="svr_menu" class="f-fl u-svrmenu">
				<a class="g-nav-link" href="/" ><span class="f-fwb">All services <i class="icon-arrow-down3 f-vam f-fwb"></i></span></a>
				<div class="m-svrmenu f-cb">
					<div class="m-svrmenu-left">
						<ul class="u-filter f-cb">
							<li class="z-active">All</li>
							<li>0-9</li>
							<li>A</li>
							<li>B</li>
							<li>C</li>
							<li>D</li>
							<li>E</li>
							<li>F</li>
							<li>G</li>
							<li>H</li>
							<li>I</li>
							<li>J</li>
							<li>K</li>
							<li>L</li>
							<li>M</li>
							<li>N</li>
							<li>O</li>
							<li>P</li>
							<li>Q</li>
							<li>R</li>
							<li>S</li>
							<li>T</li>
							<li>V</li>
							<li>W</li>
							<li>X</li>
							<li>Y</li>
							<li>Z</li>
							
						</ul>	
						<div class="m-svrlist f-cb">
						
							<div class="m-svrlist-item">
								<h4>World of warcraft</h4>
								<ul>
									<li><a href="#">Professions</a></li>
									<li><a href="#">Valor point</a></li>
									<li><a href="#">Reputation</a></li>
									<li><a href="#">Battlefield</a></li>
									<li><a href="#">Powerlevel</a></li>
									<li><a href="#">Buy Gold</a></li>
									<li><a href="#">TCG Loot</a></li>
									<li><a href="#">Warlords of Draenor</a></li>
									<li><a href="#">Gold Challenge Mode</a></li>
									<li><a href="#">T16 Gear Pieces</a></li>
									<li><a href="#">Raid Item</a></li>
									<li><a href="#">Boe Gears</a></li>
									<li><a href="#">Achievement</a></li>
									<li><a href="#">Powerlevel</a></li>
								</ul>
							</div>
						
						
							<div class="m-svrlist-item">
								<h4>World of warcraft</h4>
								<ul>
									<li><a href="#">Professions</a></li>
									<li><a href="#">Valor point</a></li>
									<li><a href="#">Reputation</a></li>
									<li><a href="#">Battlefield</a></li>
									<li><a href="#">Powerlevel</a></li>
									<li><a href="#">Buy Gold</a></li>
									<li><a href="#">TCG Loot</a></li>
									<li><a href="#">Warlords of Draenor</a></li>
									<li><a href="#">Gold Challenge Mode</a></li>
									<li><a href="#">T16 Gear Pieces</a></li>
									<li><a href="#">Raid Item</a></li>
									<li><a href="#">Boe Gears</a></li>
									<li><a href="#">Achievement</a></li>
									<li><a href="#">Powerlevel</a></li>
								</ul>
							</div>
							
							<div class="m-svrlist-item">
								<h4>World of warcraft</h4>
								<ul>
									<li><a href="#">Professions</a></li>
									<li><a href="#">Valor point</a></li>
									<li><a href="#">Reputation</a></li>
									<li><a href="#">Battlefield</a></li>
									<li><a href="#">Powerlevel</a></li>
									<li><a href="#">Buy Gold</a></li>
									<li><a href="#">Raid Item</a></li>
									<li><a href="#">Boe Gears</a></li>
									<li><a href="#">Achievement</a></li>
									<li><a href="#">Powerlevel</a></li>
								</ul>
							</div>
							
							<div class="m-svrlist-item">
								<h4>World of warcraft</h4>
								<ul>
									<li><a href="#">Professions</a></li>
									<li><a href="#">Valor point</a></li>
									<li><a href="#">Reputation</a></li>
									<li><a href="#">Battlefield</a></li>
									<li><a href="#">Boe Gears</a></li>
									<li><a href="#">Achievement</a></li>
									<li><a href="#">Powerlevel</a></li>
								</ul>
							</div>
							
							
							<div class="m-svrlist-item">
								<h4>World of warcraft</h4>
								<ul>
									<li><a href="#">Professions</a></li>
									<li><a href="#">Valor point</a></li>
									<li><a href="#">Reputation</a></li>
									<li><a href="#">Battlefield</a></li>
									<li><a href="#">Boe Gears</a></li>
									<li><a href="#">Achievement</a></li>
									<li><a href="#">Powerlevel</a></li>
								</ul>
							</div>
						</div>
										
					</div>
					<div class="m-svrmenu-right">
					
					
						<div><a href="#"><img src="<?php echo ENTRY_HOME?>/uploads/svrmenu/76EZ3DNJVNWC1418783810537.jpg"></a></div>
						<div><a href="#"><img src="<?php echo ENTRY_HOME?>/uploads/svrmenu/IYMIDOQN22DJ1395355983240.jpg"></a></div>
						<div><a href="#"><img src="<?php echo ENTRY_HOME?>/uploads/svrmenu/XSSSLI84WSGY1418675606429.jpg"></a></div>
					
					</div>
					
				
				
				</div>
			</li>
			<li class="f-fl"><a class="g-nav-link" href="/" ><span>VIP</span></a></li>
			<li class="f-fl"><a class="g-nav-link" href="/" ><span>Feedback</span></a></li>
			<li class="f-fl"><a class="g-nav-link" href="/" ><span>Help</span></a></li>
		</ul>		
	</div>

	
</div>

	




<div class="m-box f-cb">
    <div class="m-boxleft">
      		<div class="news-slder-frame css3-radius8 css3-box">
				<div id="news_slideBox" class="slideBox">
					<ul class="items">
						<li><a title="aaaaaaaa " href="/bp/mainnews/i/23"><img src="slider/img/slide-1.jpg"></a></li>
						<li><a title="bbbbbbbbb" href="/bp/mainnews/i/22"><img src="slider/img/slide-2.jpg"></a></li>
						<li><a title="ccccccccccc" href="/bp/mainnews/i/21"><img src="slider/img/slide-3.jpg"></a></li>
						<li><a title="ddddddddd" href="/bp/mainnews/i/20"><img src="slider/img/slide-4.jpg"></a></li>
					</ul>
				</div>
			<script type="text/javascript">
				$('#news_slideBox').slideBox();
			</script>
		</div>
    </div>	
    
     <div class="m-boxright">
					<h3 class="u-tt-lg f-tac">Customer Service</h3>

			        <a href="#boxed">
			            <img src="css/img/online.jpg" alt="" width="80%"/>
			        </a>
			        <br>
			        <table style="width:100%;height:113px;margin-top:5px">
      <tr>
      	<td><img src="css/img/msn.jpg" width="20" style="vertical-align:middle"></td>
      	<td>tonyadk_27@hotmail.com </td>
      </tr>
      <tr>
      	<td><img src="css/img/eml.jpg" width="20" style="vertical-align:middle"></td>
      	<td>tonyadk_168@hotmail.com</td>
      </tr>
      <tr>
      	<td><img src="css/img/qq.jpg" width="20" style="vertical-align:middle"></td>
			        	<td>2629438554</td>
			        </tr>
			        <tr>
			        	<td colspan="2" align="center"><a href="#">More contacts >></a></td>
			        </tr>
			        </table>

 		 </div>
</div>

   














</body>
</html>