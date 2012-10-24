<?php
/*
$groupsResp = $this->api->invoke('/groups/list.json');
$groups = $groupsResp['result'];

var_dump($groups);*/

//iterate over all of the actions in the photo and separate them into favourites & comments.
$photo['favorites'] = 0;
$photo['comments']  = 0;
foreach ($photo['actions'] as $action) {
	if($action['type'] == 'favorite' && $action['value'] == '1') {
		$photo['favorites'] += 1;
	}
	elseif ($action['type'] == 'comment') {
		$photo['comments'] += 1;	
	}
}
?>

<?php if(isset($photo['title'])): ?>
<div class="headerbar wrapper">
  <h1 id="photo-title"><?php $this->utility->safe($photo['title']); ?></h1> <!-- function bar for e.g. sharing function -->
</div>
<?php endif; ?>

<div class="grids">

<section class="photo-column grid grid-8">
  <img class="photo" width="<?php $this->utility->safe($photo['photo'.$this->config->photoSizes->detail][1]); ?>" height="<?php $this->utility->safe($photo['photo'.$this->config->photoSizes->detail][2]); ?>" src="<?php $this->url->photoUrl($photo, $this->config->photoSizes->detail); ?>" alt="<?php $this->utility->safe($photo['title']); ?>">
  <?php if($photo['description']): ?>
  <p id="photo-description"><?php $this->utility->safe($photo['description']); ?></p>
  <?php endif; ?>
  <h5>Comments</h5>
  <?php if($photo['comments'] > 0) { ?>
    <ul class="comments" id="comments">
      <?php foreach($photo['actions'] as $action): ?>
        <?php if($action['type'] == 'comment'): ?>
        <li class="action-container-<?php $this->utility->safe($action['id']); ?>">
          <img src="<?php $this->utility->safe(User::getAvatarFromEmail(40, $action['email'])); ?>" class="avatar">
          <div>
            <strong><?php $this->utility->getEmailHandle($action['email']); ?> <small>(<?php $this->utility->safe($this->utility->dateLong($action['datePosted'])); ?>)</small></strong>
              <span><?php $this->utility->safe($action['value']); ?></span>
            <span class="date">
              <?php if($this->user->isOwner()) { ?>
                <form method="post" action="<?php $this->url->actionDelete($action['id']); ?>">
                  <input type="hidden" name="crumb" value="<?php echo $crumb; ?>">
                  <a href="<?php $this->url->actionDelete($action['id']); ?>" data-id="<?php $this->utility->safe($action['id']); ?>" class="action-delete-click"><span></span>Delete comment</a>
                </form>
              <?php } ?>
            </span>
          </div>
        </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  <?php } ?>
  <div class="comment-form">
    <form method="post" action="<?php $this->url->actionCreate($photo['id'], 'photo'); ?>">
      
      <?php if($this->user->isLoggedIn()): ?>
      
      <textarea rows="5" cols="50" name="value" class="comment"></textarea>
      <input type="hidden" name="type" value="comment">
      <input type="hidden" name="targetUrl" value="<?php $this->utility->safe(sprintf('http://%s%s', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'])); ?>">
      <input type="hidden" name="crumb" value="<?php $this->utility->safe($crumb); ?>">
      
      <div class="buttons">
      	<button type="submit">Leave a comment</button>
      </div>
      <?php else: ?>
        <button type="button" class="login-click browserid">Sign in to comment</button>
      <?php endif; ?>
    </form>
    <?php if($this->user->isLoggedIn()) { ?>
      <form class="favourite-form" method="post" action="<?php $this->url->actionCreate($photo['id'], 'photo'); ?>">
        <input type="hidden" name="value" value="1">
        <input type="hidden" name="type" value="favorite">
        <input type="hidden" name="targetUrl" value="<?php $this->utility->safe(sprintf('http://%s%s', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'])); ?>">
        <input type="hidden" name="crumb" value="<?php $this->utility->safe($crumb); ?>">
        <button type="submit" class="favourite pink">Like</button>
      </form>
    <?php } ?>
  </div>
  
</section>
<aside class="sidebar grid grid-4">

	<h5>Photo details</h5>
	<ul class="meta wrapper">
	<?php ?>
	  <li class="date"><i class="icon-calendar"></i><?php $this->utility->dateLong($photo['dateTaken']); ?></li>
	  
	  <li class="favourites">
	  	<i class="icon-heart"></i>
	  	<?php echo @$photo['favorites'] ?> like<?php if($photo['favorites'] == 0 || $photo['favorites'] > 1) echo 's' ?>
	  </li>
	  
	  <li>
	  	<i class="icon-comment"></i>
	  	<?php echo @$photo['comments'] ?> <a href="#comments" class="action-jump-click" title="Jump to comments">comment<?php if($photo['comments'] == 0 || $photo['comments'] > 1) echo 's' ?></a>
	  </li>
	  
	  <?php if(isset($photo['tags']) && !empty($photo['tags'])) { ?>
	    <li class="tags"><i class="icon-tag"></i><?php $this->url->tagsAsLinks($photo['tags']); ?></li>
	  <?php } ?>
	  <?php if(isset($photo['license']) && !empty($photo['license'])) { ?>
	    <li class="license"><i class="icon-file"></i><?php $this->utility->licenseLong($photo['license']); ?></li>
	  <?php } ?>
	 
	  <?php if(isset($photo['latitude']) && !empty($photo['latitude'])) { ?>
	    <li class="location">
	      <i class="icon-globe"></i>
	      <?php $this->utility->safe($photo['latitude']); ?>, <?php $this->utility->safe($photo['longitude']); ?>
	      <img src="<?php $this->utility->staticMapUrl($photo['latitude'], $photo['longitude'], 14, '255x150'); ?>" class="map">
	    </li>
	  <?php } ?>
	  <?php if(!empty($photo['exifCameraMake']) && !empty($photo['exifCameraMake'])) { ?>
	  <li class="exif">
	    <i class="icon-camera"></i>
	    <ul>
	      <?php foreach(array('exifCameraMake' => 'Camera make: <em>%s</em>',
	      'exifCameraModel' => 'Camera model: <em>%s</em>',
	      'exifFNumber' => 'Av: <em>f/%1.0F</em>',
	      'exifExposureTime' => 'Tv: <em>%s</em>',
	      'exifISOSpeed' => 'ISO: <em>%d</em>',
	      'exifFocalLength' => 'Focal Length: %1.0fmm') as $key => $value) { ?>
	        <?php if(!empty($photo[$key])) { ?>
	        <li><?php printf($value, $this->utility->safe($photo[$key], false)); ?></li>
	        <?php } ?>
	      <?php } ?>
	    </ul>
	  </li>
	  <li class="fullsize">
	  <i class="icon-resize-full"></i>
	  <a href="<?php echo($photo['pathOriginal']); ?>">View original size</a>
	  </li>
	  <li class="link">
	  	<i class="icon-link"></i>
	  	<a href="<?php echo('http://bryc.me/i/'.$photo['id']); ?>"><?php echo('http://bryc.me/i/'.$photo['id']); ?></a>
	  </li>
	  <?php } ?>
	  <?php if($this->user->isOwner()) { ?>
	  <li class="permission <?php $this->utility->permissionAsText($photo['permission']); ?>">
	  <i class="icon-minus-sign"></i>
	  <?php $this->utility->permissionAsText($photo['permission']); ?>
	  </li>
	  <li class="edit">
	    <i class="icon-pencil"></i>
	    <a href="#edit-photo-modal" class="modal-open">Edit this photo</a>
	  </li>
	  <?php } ?>
	</ul>
	
	<h5>Explore more photos</h5>
  <ul class="image-pagination wrapper">
    <?php if(!empty($photo['previous'])) { ?>
    <li class="previous">
      <a href="<?php $this->url->photoView($photo['previous']['id'], $options); ?>" title="Go to previous photo">
        <img src="<?php $this->url->photoUrl($photo['previous'], $this->config->photoSizes->nextPrevious); ?>" alt="Go to previous photo" />
        <span class="prev"><span class="audible">Go to previous photo</span></span>
      </a>
    </li>
    <?php } else { ?>
      <li class="previous empty">
        <img src="<?php $this->theme->asset('image', 'empty.png'); ?>" alt="No previous photo" />
      </li>
    <?php } ?>
    <?php if(!empty($photo['next'])) { ?>
    <li class="next">
      <a href="<?php $this->url->photoView($photo['next']['id'], $options); ?>" title="Go to next photo">
        <img src="<?php $this->url->photoUrl($photo['next'], $this->config->photoSizes->nextPrevious); ?>" alt="Go to next photo" />
        <span class="next"><span class="audible">Go to next photo</span></span>
      </a>
    </li>
    <?php } else { ?>
      <li class="next empty">
        <img src="<?php $this->theme->asset('image', 'empty.png'); ?>" alt="No next photo" />
      </li>
    <?php } ?>
  </ul>

  </aside>

</div>
<div style="clear:both;"></div>

<div id="edit-photo-modal" class="modal wrapper">
	<a href="#" class="modal-close" aria-hidden="true">&times;</a>
	<h3>Edit Photo</h3>
	<form method="post" action="/photo/<?php echo($photo['id']); ?>/update.json" id="edit-photo-form" data-id="<?php echo($photo['id']); ?>">
	    <input type="hidden" name="crumb" value="<?php $this->utility->safe($crumb); ?>">
	    <label for="title">Title</label>
	    <input type="text" name="title" id="title" placeholder="A title to describe your photo" value="<?php $this->utility->safe($photo['title']); ?>"><br />
	  
	    <label for="description">Description</label>
	    <textarea name="description" id="description" placeholder="A description of the photo (typically longer than the title)"><?php $this->utility->safe($photo['description']); ?></textarea><br />
	  
	    <label for="tags">Tags</label>
	    <input type="text" name="tags" id="tags" class="typeahead-tags" placeholder="A comma separated list of tags" value="<?php $this->utility->safe(implode(',', $photo['tags'])); ?>"><br />
	  
	    <label for="latitude">Latitude</label>
	    <input type="text" class="input-small" name="latitude" id="latitude" placeholder=" e.g. 49.73" value="<?php $this->utility->safe($photo['latitude']); ?>"> <br />
	    <label for="latitude">Longitude</label>
	    <input type="text" class="input-small" name="longitude" id="longtitude" placeholder="e.g. 18.34" value="<?php $this->utility->safe($photo['longitude']); ?>"><br />
	  
	      <label>Permission</label>
	        <label class="radio inline">
	          <input type="radio" name="permission" id="public" value="1" <?php if($photo['permission'] == 1) { ?> checked="checked" <?php } ?>>
	          Public
	        </label>
	        <label class="radio inline">
	          <input type="radio" name="permission" id="private" value="0" <?php if($photo['permission'] == 0) { ?> checked="checked" <?php } ?>>
	          Private
	        </label>
	    <p>
	    	<button class="red modal-close" aria-hidden="true">Cancel</button>
	    	<button value="Submit">Save changes</button>
	    </p>
	  </form>
	  
</div>
<div id="modal-backdrop"></div>

