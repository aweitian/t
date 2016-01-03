<?php
/**
 * Date: 2015年12月31日
 * Author: Awei.tian
 * Description: 
 */
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-tower" aria-hidden="true"></span> 永安手游代练顾客计时扣费系统</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?php print App::url_ca("main","add")?>">添加订单记录 </a></li>
        <li><a href="<?php print App::url_ca("main","list")?>">订单列表</a></li>

        
      </ul>
      
      
       <form action="<?php print App::url_ca("his")?>" method="get" class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" name="sid" value="<?php if(isset($_GET["sid"])):?><?php print $_GET["sid"]?><?php endif;?>" class="form-control" placeholder="订单ID">
        </div>
        <button type="submit" class="btn btn-default">订单轨迹查询</button>
      </form>
      
      
      
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="<?php print App::url_ca("login","logout")?>" class="dropdown-toggle">退出</a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>