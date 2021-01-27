<?php echo ($page->has_hero) ? $page->hero_text : ''; ?>
<?php
    $this->load->view('parts/pageheader', array(
        'pageConfig' => $pageConfig,
		'headerImage' => $pageConfig['headerImage'],
		'heroTitle' => $pageConfig['heroTitle'],
        'headerClass' => ' image-hero-currencies ',
        'titleAreaClass' => '',
        'size' => 'size-m',
        'additionalText' => $pageConfig['additionalText'],
    ));
?>
<div class="content-base <?php echo ($page->has_hero) ? '' : 'no-hero'; ?>">
	<div class="container">
		<?php echo $page->content; ?>
	</div>
</div>

