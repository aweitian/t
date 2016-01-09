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
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 百度知道负面信息查询</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?php print App::url_ca("main","editword")?>">编辑负面词 </a></li>
        <li><a href="<?php print App::url_ca("main","editurl")?>">编辑查询地址 </a></li>
        <li><a href="<?php print App::url_ca("main","search")?>">任务列表</a></li>

        
      </ul>

      
      
      
      <ul class="nav navbar-nav navbar-right">
       <?php if (roleSession::getInstance()->hasSuper() || roleSession::getInstance()->getRole()== "admin"):?>
      
      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">用户管理 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php print App::url_ca("user","add")?>">添加用户</a></li>

            <li role="separator" class="divider"></li>
            <li><a href="<?php print App::url_ca("user")?>">管理用户</a></li>
            <li><a href="<?php print App::url_ca("user","chpwd")?>">修改密码</a></li>
          </ul>
        </li>
        <?php else:?>
        <li>
          <a href="<?php print App::url_ca("user","chpwd")?>" class="dropdown-toggle">修改密码</a>
        </li>
        <?php endif;?>
        <li>
          <a href="<?php print App::url_ca("login","logout")?>" class="dropdown-toggle"><span class="glyphicon glyphicon-log-out"></span> 退出</a>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>