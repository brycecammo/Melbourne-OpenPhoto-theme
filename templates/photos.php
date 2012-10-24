<?php $thumbnailSize = isset($_GET['size']) ? $_GET['size'] : '280x186xCR'; ?>
<?php if(!empty($photos)) { ?>
  
  <?php if(!empty($album)): ?>
  	<h3 class="wrapper"><?php $this->utility->safe($album['name']); ?></h3>
  <?php elseif(!empty($tags)): ?>
    <h3 class="wrapper light">
      <i class="icon-tags"></i>
      Photos tagged with
      <?php foreach($tags as $cnt => $tag): ?><strong><?php $this->utility->safe($tag); ?></strong><?php if(count($tags) > 1 && $cnt < (count($tags)-1)) { ?><?php if($cnt < (count($tags)-2)) { ?>, <?php } else { ?> and <?php } ?><?php } ?>
      <?php endforeach; ?>
    </h3>
  <?php endif; ?>
  
  <ul class="photo-grid size<?php echo $thumbnailSize; ?>">
    <?php foreach($photos as $photo) { ?>
    <?php 
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
      <li class="grid-item id-<?php $this->utility->safe($photo['id']); ?>">
        <a href="<?php $this->url->photoView($photo['id'], $options); ?>">
          <div class="img-wrapper">
          <img src="<?php $this->url->photoUrl($photo, $thumbnailSize); ?>" alt="<?php $this->utility->safe($photo['title']); ?>" />
          </div>
          <ul class="meta">
            <li class="age"><?php $this->utility->timeAsText($photo['dateTaken'], 'Taken'); ?></li>
            <li class="likes"><?php echo $photo['favorites']; ?> like<?php if($photo['favorites'] == 0 || $photo['favorites'] > 1) echo 's' ?></li>
            <?php if($this->user->isOwner()): ?>
            <li class="permission"><span class="<?php $this->utility->permissionAsText($photo['permission']); ?>" title="Photo is <?php $this->utility->permissionAsText($photo['permission']); ?>"></span></li>
            <? endif; ?>
            <?php if(isset($photo['latitude']) && !empty($photo['latitude'])) { ?><li class="geo"><span title="Photo has geo information"></span></li><?php } ?>
          </ul>
        </a>
      </li>
    <?php } ?>
  </ul>
  <br clear="all">
  <!-- ACTIVITY
  <div class="activity">
  <?php if(!empty($activities)) { ?>
            <?php $i = 0; ?>
            <?php foreach($activities as $activity) { ?>
              <div class="item <?php if($i == 0) { ?>active<?php } ?>">
                <?php $this->theme->display(sprintf('partials/feed-%s.php', $activity[0]['type']), array('activity' => $activity)); ?>
              </div>
              <?php $i++; ?>
            <?php } ?>
  <?php } ?>
  </div>
  -->
  <span class="paginationbottom"><?php $this->theme->display('partials/pagination.php', array_merge($pages, array('labelPosition' => 'bottom'))); ?></span>
<?php } else { ?>
  <?php if($this->user->isOwner()) { ?>
    <a href="<?php $this->url->photoUpload(); ?>" class="link" title="Start uploading now!"><img src="<?php $this->theme->asset('image', 'front.png'); ?>" class="front" /></a>
    <h1>There don't seem to be any photos. You should <a href="<?php $this->url->photosUpload(); ?>" class="link">upload</a> some.</h1>
    <p>
      If you're searching for photos then there aren't any which match your query.
    </p>
  <?php } else { ?>
	<img src="<?php $this->theme->asset('image', 'front-general.png'); ?>" class="front" />
    <h1>No photos to show.</h1>
    <p>
      This could be because the user hasn't uploaded any photos yet or you've searched for photos that do not exist.
    </p>
  <?php } ?>
<?php } ?>
