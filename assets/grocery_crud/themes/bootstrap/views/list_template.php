<?php
	$this->set_css($this->default_theme_path.'/bootstrap/css/flexigrid.css');
	$this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);

	if (isset($dialog_forms) && $dialog_forms) {
        $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
        $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
        $this->set_js_lib($this->default_javascript_path.'/common/lazyload-min.js');
    }

    $this->set_js_lib($this->default_javascript_path.'/common/list.js');

	$this->set_js($this->default_theme_path . '/bootstrap/js/cookies.js');
	$this->set_js($this->default_theme_path . '/bootstrap/js/flexigrid.js');

    $this->set_js($this->default_javascript_path . '/jquery_plugins/jquery.form.min.js');

	$this->set_js($this->default_javascript_path . '/jquery_plugins/jquery.numeric.min.js');
	$this->set_js($this->default_theme_path . '/bootstrap/js/jquery.printElement.min.js');

	/** Jquery UI */
	$this->load_js_jqueryui();

?>
<script type='text/javascript'>
	var base_url = '<?php echo base_url();?>';

	var subject = '<?php echo addslashes($subject); ?>';
	var ajax_list_info_url = '<?php echo $ajax_list_info_url; ?>';
	var unique_hash = '<?php echo $unique_hash; ?>';
	var export_url = '<?php echo $export_url; ?>';

	var message_alert_delete = "<?php echo $this->l('alert_delete'); ?>";

</script>
<div id='list-report-error' class='report-div error'></div>
<div id='list-report-success' class='report-div success report-list' <?php if($success_message !== null){?>style="display:block"<?php }?>><?php
if($success_message !== null){?>
	<p><?php echo $success_message; ?></p>
<?php }
?></div>

<div class="flexigrid" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
<div class="page-header">
	<div class="row">
		<!--<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Share</button>
                <button class="btn btn-sm btn-outline-secondary">Export</button>
              </div>
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                This week
              </button>
            </div>
          </div> -->
		<div class="col-md-4">
			<h2><?php echo $subject?></h2>
		</div>
		<div class="col-md-8 text-right">
			<?php if(!$unset_add || !$unset_export || !$unset_print){?>
			<div class="btn-group">
				<?php if(!$unset_add){?>
			
					<a href='<?php echo $add_url?>' title='<?php echo $this->l('list_add'); ?> <?php echo $subject?>' class='btn btn-primary add-anchor add_button'>
							<span class="add"><?php echo $this->l('list_add'); ?> <?php echo $subject?></span>
					</a>
					
				<?php }?>
					<?php if(!$unset_export) { ?>
					<a class="export-anchor btn" href="<?php echo $export_url; ?>" download>
						<span class="export"><?php echo $this->l('list_export');?></span>
					</a>
					<?php } ?>
					<?php if(!$unset_print) { ?>
					<a class="print-anchor btn" data-url="<?php echo $print_url; ?>">
						<span class="print"><?php echo $this->l('list_print');?></span>
					</a>
					<?php }?>
			</div>
			<?php }?>
		</div>
	</div>
</div>
<!--
<form class="form-inline">
  <div class="form-group">
    <label for="exampleInputName2">Name</label>
    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">Email</label>
    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
  </div>
  <button type="submit" class="btn btn-default">Send invitation</button>
</form>
-->
<div class="row">
	<?php echo form_open( $ajax_list_url, 'method="post" id="filtering_form" class="filtering_form form-inline" autocomplete = "off" data-ajax-list-info-url="'.$ajax_list_info_url.'"'); ?>
	<div class="col-md-7">
		<div class="input-group">
			<div class="form-group mb-2">
				<label for="staticEmail2" class="sr-only"><?php echo $this->l('list_search');?>: </label>
				<input type="text" class="form-control search_text" id="search_text" name="search_text">
			</div>
			<div class="form-group mx-sm-3 mb-2">
				<select name="search_field" id="search_field" class="form-control">
					<option value=""><?php echo $this->l('list_search_all');?></option>
					<?php foreach($columns as $column){?>
					<option value="<?php echo $column->field_name?>"><?php echo $column->display_as?>&nbsp;&nbsp;</option>
					<?php }?>
				</select>
			</div>
			<input type="submit" value="<?php echo $this->l('list_search');?>" class="btn btn-primary crud_search" id='crud_search'>
			<button id='search_clear' type="button" class="search_clear btn btn-default"><span class="glyphicon glyphicon-remove"></span></button>
			<div class="btn btn-default ajax_refresh_and_loading" id='ajax_refresh_and_loading'>
				<span class="glyphicon glyphicon-refresh"></span>
			</div>
		</div>
		
	</div>
	<div class="col-md-5 text-right">
	<span class="pcontrol hide">
					<?php list($show_lang_string, $entries_lang_string) = explode('{paging}', $this->l('list_show_entries')); ?>
					<?php echo $show_lang_string; ?>
					<select name="per_page" id='per_page' class="per_page">
						<?php foreach($paging_options as $option){?>
							<option value="<?php echo $option; ?>" <?php if($option == $default_per_page){?>selected="selected"<?php }?>><?php echo $option; ?>&nbsp;&nbsp;</option>
						<?php }?>
					</select>
					<?php echo $entries_lang_string; ?>
					<input type='hidden' name='order_by[0]' id='hidden-sorting' class='hidden-sorting' value='<?php if(!empty($order_by[0])){?><?php echo $order_by[0]?><?php }?>' />
					<input type='hidden' name='order_by[1]' id='hidden-ordering' class='hidden-ordering'  value='<?php if(!empty($order_by[1])){?><?php echo $order_by[1]?><?php }?>'/>
				</span>
		<div class="input-group">
			  <span class="input-group-btn">
				<button class="btn btn-default prev-button" type="button">&laquo;</button>
			  </span>
			  <input type="text" class="form-control crud_page" name="page" value="1" style="width: 50px;">
			  <span class="input-group-addon" id="basic-addon2">
				<?php echo $this->l('list_paging_of'); ?> <span id="last-page-number" class="last-page-number"><?php echo ceil($total_results / $default_per_page)?></span></span>
			  <span class="input-group-btn">
				<button class="btn btn-default next-button" type="button">&raquo;</button>
			  </span>
		</div><!-- /input-group -->
		<div class="btn-group" role="group" aria-label="...">
		 <!-- <button type="button" class="btn btn-default">Left</button>
		  <button type="button" class="btn btn-default">Middle</button>
		  <button type="button" class="btn btn-default">Right</button>-->
		  
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
<hr />
<div id="hidden-operations" class="hidden-operations"></div>
<div id='main-table-box' class="main-table-box">

	

	<div id='ajax_list' class="ajax_list">
		<?php echo $list_view?>
	</div>
	<div class="pDiv">
		<div class="pDiv2">
			<div class="pGroup">
				
			</div>
	
			<div class="pGroup">
				
			</div>
			<div class="btnseparator">
			</div>
			<div class="pGroup">
				<span class="pPageStat">
					<?php $paging_starts_from = "<span id='page-starts-from' class='page-starts-from'>1</span>"; ?>
					<?php $paging_ends_to = "<span id='page-ends-to' class='page-ends-to'>". ($total_results < $default_per_page ? $total_results : $default_per_page) ."</span>"; ?>
					<?php $paging_total_results = "<span id='total_items' class='total_items'>$total_results</span>"?>
					<?php echo str_replace( array('{start}','{end}','{results}'),
											array($paging_starts_from, $paging_ends_to, $paging_total_results),
											$this->l('list_displaying')
										   ); ?>
				</span>
			</div>
		</div>
		<div style="clear: both;">
		</div>
	</div>

	</div>
</div>
