<?php $thumbnailSize = isset($_GET['size']) ? $_GET['size'] : '280x186xCR'; ?>
<?php $sizeBaseUrl = preg_replace('/[?&]size=[^?&]*/', '', $_SERVER['REQUEST_URI']); ?>
<?php $sizeBaseUrl .=  (strpos($sizeBaseUrl, '?') === false ? '?' : '&'); ?>
<div class="pagination wrapper">
  <?php if(!empty($pages)) { ?>
    <?php if(!isset($labelPosition) || $labelPosition == 'top') { ?>
		<p class="label">
			<span class="audible">Pagination:</span>
			Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>
		</p>
    <?php } ?>
	<ol class="sizechoose">
		<li class="empty">Size:</li>
    <li class="sizesmall <?php if($thumbnailSize == '200x132xCR'){ ?> on <?php } ?>"><a href="<?php $this->utility->safe($sizeBaseUrl); ?>size=200x132xCR" title="Display small thumbnails"><span class="audible">Display medium thumbnails</span></a></li>
    <li class="sizemiddle <?php if($thumbnailSize == '280x186xCR'){ ?> on <?php } ?>"><a href="<?php $this->utility->safe($sizeBaseUrl); ?>size=280x186xCR" title="Display medium thumbnails"><span class="audible">Display medium thumbnails</span></a></li>
    <li class="sizebig <?php if($thumbnailSize == '440x292xCR'){ ?> on <?php } ?>"><a href="<?php $this->utility->safe($sizeBaseUrl); ?>size=440x292xCR" title="Display large thumbnails"><span class="audible">Display large thumbnails</span></a></li>
	</ol>
    <ul role="navigation">
	<li class="empty">Current page:</li>
      <?php foreach($pages as $page) { ?>
        <?php if($page == $currentPage) { ?>
          <li class="on"><p><span class="audible">You're currently on page </span><?php echo $page; ?></p></li>
        <?php } else { ?>
          <li><a href="<?php echo preg_replace('#(/page-\d+)?/list#', "/page-{$page}/list", $requestUri); ?>"><span class="audible">Page </span><?php echo $page; ?></a></li>
        <?php } ?>
      <?php } ?>
    </ul>
    <?php if(isset($labelPosition) && $labelPosition == 'bottom') { ?>
		<p class="label"><span class="audible">Pagination:</span>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></p>
    <?php } ?>
  <?php } ?>
</div>
