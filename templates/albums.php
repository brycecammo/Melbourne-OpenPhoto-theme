<?php if(!empty($albums)): ?>
  <?php if(count($albums) >= 8 || (isset($_GET['page']) && $_GET['page'] > 1)): ?>
    <div class="pagination">
      <ul role="navigation">
        <?php /* TODO this is really crude */ ?>
        <?php if(isset($_GET['page']) && $_GET['page'] > 1): ?>
          <li><a href="<?php $this->utility->safe(preg_replace('/page=\d+/', 'page='.intval($_GET['page']-1), $_SERVER['REQUEST_URI'])); ?>">&larr; Prev</a></li>
        <?php endif; ?>
        <?php if(count($albums) >= 8): ?>
          <?php if(stristr($_SERVER['REQUEST_URI'], 'page=')): ?>
            <li><a href="<?php $this->utility->safe(preg_replace('/page=\d+/', 'page='.intval($_GET['page']+1), $_SERVER['REQUEST_URI'])); ?>">Next &rarr;</a></li>
          <?php else: ?>
            <li><a href="<?php $this->utility->safe($_SERVER['REQUEST_URI']); ?>?page=2">Next &rarr;</a></li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
    </div>
  <?php endif; ?>
  
      <ul class="album-grid">
        <?php foreach($albums as $alb): ?>
          <li class="wrapper">
            <a href="<?php $this->url->photosView(sprintf('album-%s', $alb['id'])); ?>">
              <?php if(empty($alb['cover'])): ?>
                <i class="icon-picture icon-large"></i>
              <?php else: ?>
                <div class="album-cover" style="background-image:url('<?php $this->utility->safe($alb['cover']['path200x200xCR']); ?>');"></div>
              <?php endif; ?>
            </a>
            <h4><?php $this->utility->safe($alb['name']); ?></h4>
            <p><?php $this->utility->safe($alb['count']); ?> Photo<?php if($alb['count'] == 0 || $alb['count'] > 1) echo 's'; ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
      
<?php else: ?>
  <h1>There are no albums to display.</h1>
<?php endif; ?>
