<!DOCTYPE html>
<html lang="en" style="background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;min-height: 100%;position: relative;">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Home</title>
		<link href="<?= $assets?>shop/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= $assets?>shop/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?= $assets?>shop/css/main.css" rel="stylesheet">
		<link href="<?= $assets?>shop/css/responsive.css" rel="stylesheet">	
		<style>

		</style>
	</head><!--/head-->
	<body style="padding:0">
		<div class="page-outer-div">
<div class="outer-di">
  <div class="middle-di">
    <div class="inner-di">

   
			<div class="container">
				<div class="row">
<div class="col-sm-12">
	<div class="col-md-6 col-md-offset-3">
		<span class="ord declined"><i class="fa fa-warning aria-hidden" ></i></span>
                                <div class="suc-ord declined">
                                    <div class="alert alert-error">Error:  <?php echo $error;?></div>    
                                    <h2>Order has  not been placed successfully!</h2>
                                    <p> Sorry , your order  has  not been placed successfully!</p>
                                    <a class="btn btn-danger" style="border-radius:0;" href="<?php echo site_url('shop/home');?>" > Back to shop </a>
                                </div>
                                <div class="clearfix"></div>
		<div class="clearfix"></div>
	</div>
</div>
</div>
			</div>
		    </div>
  </div>
</div> 	</div>	
	</body>
</html>