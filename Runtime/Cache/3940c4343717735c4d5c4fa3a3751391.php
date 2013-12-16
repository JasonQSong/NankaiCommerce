<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" type="image/x-icon" href="style/images/favicon.png" />
	<link rel="stylesheet" type="text/css" href="style/css/style.css" media="all" />
	<!--
	<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	-->
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/css/ie7.css" media="all" />
	<![endif]-->
	<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="style/css/ie8.css" media="all" />
	<![endif]-->
	<!--[if IE 9]>
	<link rel="stylesheet" type="text/css" href="style/css/ie9.css" media="all" />
	<![endif]-->
	<script type="text/javascript" src="style/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="style/js/ddsmoothmenu.js"></script>
	<script type="text/javascript" src="style/js/jquery.jcarousel.js"></script>
	<script type="text/javascript" src="style/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="style/js/carousel.js"></script>
	<script type="text/javascript" src="style/js/jquery.flexslider-min.js"></script>
	<script type="text/javascript" src="style/js/jquery.masonry.min.js"></script>
	<script type="text/javascript" src="style/js/jquery.slickforms.js"></script>
	
	<title>Login</title>

	
	<link rel="stylesheet" type="text/css" href="style/css/style2.css" media="all" />

			
	<?php if($IsAdmin): ?><script type="text/javascript" >
		function autofill(){
			$('#ItemName').val('物品名称');
			$('#Description').val('物品描述');
		};
		</script>
		<script type="text/javascript" >
		var fileForm = new Object();
		function HiddenUploadImage(fileObj) {
			if(fileObj.value != "") {
				var form = document.forms['AddItemForm'];
				//把form的原始数据缓存起来
				fileForm.f = form;
				fileForm.a = form.getAttribute("action");  //form.action 为一个静态的对象，所以这里要使用getAttribute方法取值
				fileForm.t = form.target;
				//请求服务器端
				form.target = "HiddenUploadImageFrame";
				form.action = "<?php echo U('Sell/hiddenuploadimage');?>";
				form.submit();// 其实上面的action已经会执行submit操作，这步可有可无
			}
			return false;
		}
		function HiddenUploadImage_callback(ImagePath){
			//还原form属性
			alert("callback");
			alert(ImagePath);
			fileForm.f.target = fileForm.t;
			fileForm.f.setAttribute("action", fileForm.a);
			//处理结果
			$('ImagePath').val(ImagePath);
			return ;
		}
		</script><?php endif; ?>

</head>

<body>
	
	<!-- Begin Wrapper -->
	<div id="wrapper"> 
		
		
		
			<div id="left"></div>
		
		<!-- Begin Sidebar -->
		<div id="sidebar">
			<div id="logo"><a href="<?php echo U('Index/index');?>"><img src="style/images/logo.png" alt="Caprice" /></a></div>
			
			
				<!-- Begin Menu -->
				<div id="menu" class="menu-v">
					<ul>
						<?php if(is_array($HierarchyCatagories)): $i = 0; $__LIST__ = $HierarchyCatagories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo0): $mod = ($i % 2 );++$i;?><li>
								<a href="<?php echo U('Buy/viewcatagory','catagoryid='.$vo0['ID']);?>"><?php echo ($vo0["DisplayName"]); ?></a>
								<?php if($vo0['Children']): ?><ul>
										<?php if(is_array($vo0['Children'])): $i = 0; $__LIST__ = $vo0['Children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li>
												<a href="<?php echo U('Buy/viewcatagory','catagoryid='.$vo1['ID']);?>"><?php echo ($vo1["DisplayName"]); ?></a>
											</li><?php endforeach; endif; else: echo "" ;endif; ?>
									</ul><?php endif; ?>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<!-- End Menu -->
				<!-- Begin Menu -->
				<div id="menu" class="menu-v">
					<ul>
						<?php if(is_array($AncestorsCatagories)): $i = 0; $__LIST__ = $AncestorsCatagories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo0): $mod = ($i % 2 );++$i;?><li>
								<a href="<?php echo U('Buy/viewcatagory','catagoryid='.$vo0['ID']);?>"><?php echo ($vo0["DisplayName"]); ?></a>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						<?php if(is_array($SubHierarchyCatagories)): $i = 0; $__LIST__ = $SubHierarchyCatagories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo0): $mod = ($i % 2 );++$i;?><li>
								<a href="<?php echo U('Buy/viewcatagory','catagoryid='.$vo0['ID']);?>">|-<?php echo ($vo0["DisplayName"]); ?></a>
								<?php if($vo0['Children']): ?><ul>
										<?php if(is_array($vo0['Children'])): $i = 0; $__LIST__ = $vo0['Children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li>
												<a href="<?php echo U('Buy/viewcatagory','catagoryid='.$vo1['ID']);?>"><?php echo ($vo1["DisplayName"]); ?></a>
											</li><?php endforeach; endif; else: echo "" ;endif; ?>
									</ul><?php endif; ?>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<!-- End Menu -->
			
			
			<div class="sidebox">
				<ul class="share">
					<li><a href="#"><img src="style/images/icon-rss.png" alt="RSS" /></a></li>
					<li><a href="#"><img src="style/images/icon-facebook.png" alt="Facebook" /></a></li>
					<li><a href="#"><img src="style/images/icon-twitter.png" alt="Twitter" /></a></li>
					<li><a href="#"><img src="style/images/icon-dribbble.png" alt="Dribbble" /></a></li>
					<li><a href="#"><img src="style/images/icon-linkedin.png" alt="LinkedIn" /></a></li>
				</ul>
				<img src="Images/university.png"/>
			</div>
		</div>
		<!-- End Sidebar --> 
		
			<div id="header" class="header"> <div id="UserNav">
	<?php if($IsLogin): ?><span><?php echo ($DisplayName); ?></span>
		<?php if($IsAdmin): ?><span><a href="<?php echo U('Admin/index');?>">管理</a></span><?php endif; ?>
		<span><a href="<?php echo U('Sell/index');?>">卖东西</a></span>
		<span><a href="<?php echo U('User/profile');?>">个人资料</a></span>
		<span><a href="<?php echo U('User/logout');?>">登出</a></span>
	<?php else: ?>
		<span><a href="<?php echo U('Sell/index');?>">卖东西</a></span>
		<span><a href="<?php echo U('User/login');?>">登录</a></span>
		<span><a href="<?php echo U('User/register');?>">注册</a></span><?php endif; ?>
</div>
 </div>
		

		<!-- Begin Content -->
		<div id="content">
		
			
			
<div style="width:700px; margin:0 auto;"  >
	<form name="AddItemForm" action="<?php echo U('Sell/additempost');?>" method="post" enctype="multipart/form-data">
		<table border="1" cellspacing="2" cellpadding="2">
			<tr>
				<td><label for="ItemName">物品名称</label></td>
				<td><input id="ItemName" name="ItemName" type="text" maxlength="20"></td>
			</tr>
			<tr>
				<td><label for="Description">物品描述</label></td>
				<td><input id="Description" name="ItemDescription" type="text" maxlength="20"></td>
			</tr>
			<tr>
				<td><label for="CatagoryID">物品分类</label></td>
				<td>
					<select id="CatagoryID" name="CatagoryID">
						<?php if(is_array($ExistCatagories)): $i = 0; $__LIST__ = $ExistCatagories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["ID"]); ?>"><?php echo ($vo["DisplayName"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="ImageFile">物品图片</label></td>
				<td><input id="ImageFile" name="ImageFile" type="file" onchange="HiddenUploadImage(this);" /></td>
			</tr>
			<tr>
				<td><label for="ImagePath">物品预览</label></td>
				<td>
					<img id="ImagePreview" style="width:1024; height:768;" />
					<input id="ImagePath" name="ImagePath" type="hidden" />
				</td>
			</tr>
			<tr>
				<td><label for="BackgroundColor">背景颜色</label></td>
				<td><input id="BackgroundColor" name="BackgroundColor" type="color"></td>
			</tr>
			<tr>
				<td><a href="<?php echo U('User/register');?>">注册</a></td>
				<td><input id="submit" name="submit" type="submit" value="确认">
					<?php if($IsAdmin): ?><a href="#" onclick="autofill()">自动填充（仅限测试）</a>
		<iframe name="HiddenUploadImageFrame" style="width:400px; height:100px;" src="/">abc</iframe><?php endif; ?>
				</td>
			</tr>
		</table>
	</form>
</div>

			
			
				<!-- Begin Footer -->
				<div id="footer">
					<div class="footer-box one-third">
						<h3>Popular Posts</h3>
						<ul class="popular-posts">
							<li> <a href="#"><img src="style/images/art/s1.jpg" alt="" /></a>
								<h5><a href="#">Dolor Commodo Consectetur</a></h5>
								<span>26 Aug 2013 | <a href="#">21 Comments</a></span> </li>
							<li> <a href="#"><img src="style/images/art/s2.jpg" alt="" /></a>
								<h5><a href="#">Dolor Commodo Consectetur</a></h5>
								<span>26 Aug 2013 | <a href="#">21 Comments</a></span> </li>
							<li> <a href="#"><img src="style/images/art/s3.jpg" alt="" /></a>
								<h5><a href="#">Dolor Commodo Consectetur</a></h5>
								<span>26 Aug 2013 | <a href="#">21 Comments</a></span> </li>
						</ul>
					</div>
					<div class="footer-box one-third">
						<h3>About</h3>
						<p>Donec id elit non mi porta gravida at eget metus. Donec ullamcorper nulla non metus auctor fringilla.</p>
						<p>Lorem Ipsum Dolor Sit
							Moon Avenue No:11/21
							Planet City, Earth<br>
							<br>
							<span class="lite1">Fax:</span> +555 797 534 01<br>
							<span class="lite1">Tel:</span> +555 636 646 62<br>
							<span class="lite1">E-mail:</span> name@domain.com</p>
					</div>
					<div class="footer-box one-third last">
						<h3>Custom Text</h3>
						<p>Nullam quis risus eget urna mollis ornare vel eu leo. Maecenas faucibus mollis interdum. Etiam porta sem malesuada magna mollis euismod. Nulla vitae elit. </p>
						<p>Donec ullamcorper nulla non metus auctor fringilla. Maecenas faucibus mollis interdum. Curabitur blandit tempus porttitor.</p>
					</div>
				</div>
				<!-- End Footer --> 
			
		</div>
		<!-- End Content --> 
	</div>
	<!-- End Wrapper -->
	<div class="clear"></div>
	<script type="text/javascript" src="style/js/scripts.js"></script> 
	<!--[if !IE]> -->
	<script type="text/javascript" src="style/js/jquery.corner.js"></script>
	<!-- <![endif]-->
</body>
</html>