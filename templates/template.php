<!DOCTYPE html>
<html lang="en" class="cols-12">
<head>
	<!-- Meta tags -->
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width" />
	<meta name="description" content="<?php $this->theme->meta('descriptions', $page); ?>" />
	<meta name="keywords" content="<?php $this->theme->meta('keywords', $page); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!-- No follow (scare away GoogleBot) -->
	<meta name="robots" content="noindex, nofollow" />
	
	<title>
	<?php 
		$this->theme->meta('titles', $page); 
	?>
	</title>
	
	<!-- icons -->
	<link rel="shortcut icon" href="<?php $this->theme->asset('image', 'favicon.png'); ?>" />
	<link rel="apple-touch-icon" href="<?php $this->theme->asset('image', 'apple-touch-icon.png'); ?>" />

	<!-- Stylesheets -->
	<?php //if(isset($_GET['dev'])): ?>
		<link rel="stylesheet" href="<?php $this->theme->asset('stylesheet', 'inuit.css'); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php $this->theme->asset('stylesheet', 'font-awesome.css'); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php $this->theme->asset('stylesheet', 'main.css'); ?>" type="text/css" />
		<link rel="stylesheet" href="/assets/stylesheets/upload.css" type="text/css" />
	<?php //else: ?>
	<!--
		<link rel="stylesheet" href="<?php echo getAssetPipeline(true)
				->addCss($this->theme->asset('stylesheet', 'inuit.css', false))
				->addCss($this->theme->asset('stylesheet', 'font-awesome.css', false))
				->addCss($this->theme->asset('stylesheet', 'main.css', false))
				->addCss("/assets/stylesheets/upload.css")
				->getUrl(AssetPipeline::css, 'b'); ?>">
				-->
	<?php //endif; ?>
	
	<!-- Plugins -->
	<?php $this->plugin->invoke('renderHead'); ?>
	
</head>
<body id="top" class="<?php echo $page; ?>">
	<!-- Plugins -->
	<?php $this->plugin->invoke('renderBody'); ?>

<div id="container">
	
	<!-- Page Header -->
	<header>
		<?php $this->theme->display('partials/header.php'); ?>
	</header>
	
	<!-- The content -->
	<article id="main">
		<?php echo $body; ?>
	</article>

	<!-- Footer -->	
	<footer class="grids">
		<div class="grid grid-8">
			<p>Photos © Bryce Cameron, 2012.</p>
		</div>
		
		<div class="grid grid-4 text-right">
			<p>Powered by <a href="http://theopenphotoproject.org" title="Learn more about the OpenPhoto project">The OpenPhoto Project</a></p>
		</div>
		
	</footer>
	
</div> <!-- /#container -->
	
	<!-- Scripts -->
	<?php if($this->config->site->mode === 'dev') { ?>
	  <script type="text/javascript" src="<?php $this->theme->asset($this->config->dependencies->javascript); ?>"></script>
	  <script type="text/javascript" src="<?php $this->theme->asset('util'); ?>"></script>
	<?php } else { ?>
	  <script type="text/javascript" src="<?php echo getAssetPipeline(true)->addJs($this->theme->asset($this->config->dependencies->javascript, null, false))->
	                                                                    addJs($this->theme->asset('util', null, false))->getUrl(AssetPipeline::js, 'b'); ?>"></script>
	<?php } ?>
	<script>
	    OP.Util.init(jQuery, {
	      js: {
	        assets: [
	          <?php if(isset($_GET['__route__']) && stristr($_GET['__route__'], 'upload')) { ?> 
	            <?php if($this->config->site->mode === 'dev') { ?>
	              '/assets/javascripts/plupload.js',
	              '/assets/javascripts/plupload.html5.js',
	              '/assets/javascripts/jquery.plupload.queue.js',
	              '/assets/javascripts/openphoto-upload.js',
	            <?php } else { ?>
	              '<?php echo getAssetPipeline(true)->addJs('/assets/javascripts/openphoto-upload.min.js')->getUrl(AssetPipeline::js, 'b'); ?>',
	            <?php } ?>
	          <?php } ?>
	
	          <?php if($this->config->site->mode === 'dev') { ?>
	            '/assets/javascripts/openphoto-batch.min.js',
	            '<?php $this->theme->asset('javascript', 'jquery.scrollTo-1.4.2-min.js'); ?>',
	            '<?php $this->theme->asset('javascript', 'jquery.anythingslider.js'); ?>',
	            '<?php $this->theme->asset('javascript', 'theme.melbourne.js'); ?>',
	            'https://browserid.org/include.js'
	            
	          <?php } else { ?>
	            '<?php echo getAssetPipeline(true)->addJs('/assets/javascripts/openphoto-batch.min.js')->
	                                                addJs($this->theme->asset('javascript', 'openphoto-theme-full-min.js', false))->
	                                                addJs($this->theme->asset('javascript', 'theme.melbourne.js', false))->
	                                                getUrl(AssetPipeline::js, 'c'); ?>'
	          <?php } ?>
	        ]
	      }
	    });
	  </script>
	  <?php $this->plugin->invoke('renderFooter'); ?>
	
</body>
</html>