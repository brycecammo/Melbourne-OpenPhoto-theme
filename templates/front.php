<?php if($photos[0]['totalRows'] == 0) { ?>
  <?php if($this->user->isOwner()) { ?>
    <a href="<?php $this->url->photoUpload(); ?>" class="link" title="Start uploading now!"><img src="<?php $this->theme->asset('image', 'front.png'); ?>" class="front" /></a>
    <h1>Oh no, you haven't uploaded any photos yet. <a href="<?php $this->url->photoUpload(); ?>" class="link">Start Now</h1>
  <?php } else { ?>
    <img src="<?php $this->theme->asset('image', 'front-general.png'); ?>" class="front" />
    <h1>Sorry, no photos. <a class="login-click browserid link">Login</a> to upload some.</h1>
  <?php } ?>
<?php } else { ?>
	<section id="slideshow">
			<div id="swipe">
				 <ul id="slider">
					<?php foreach($photos as $photo) { ?>
						<li><a href="<?php $this->url->photoView($photo['id']); ?>"><img src="<?php $this->url->photoUrl($photo, '800x450xCR'); ?>" title="<?php if(isset($photo['title']) && !empty($photo['title'])) { $this->utility->safe($photo['title']); } ?>" class="photo" /></a></li>
				  	<?php } ?>
				 </ul>
			</div>
	</section>
<?php } ?>

