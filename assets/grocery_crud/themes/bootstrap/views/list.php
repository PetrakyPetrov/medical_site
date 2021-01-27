<?php 

	$column_width = (int)(80/count($columns));
	
	$unset_clone = isset($unset_clone) ? $unset_clone : false;
	
	if(!empty($list)){
?><div class="bDiv" >
	
		<table id="flex1" class="table table-striped table-sm">
			<thead>
				<tr>
					<?php foreach($columns as $column){?>
					<th width="<?php echo $column_width?>%">
						<div class="text-left field-sorting <?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?><?php echo $order_by[1]?><?php }?>" 
							rel='<?php echo $column->field_name?>'>
							<?php echo $column->display_as?>
						</div>
					</th>
					<?php }?>
					<?php if(!$unset_delete || !$unset_edit || !$unset_read || !$unset_clone || !empty($actions)){?>
					<th align="left" abbr="tools" axis="col1" class="" width='2%'>
						<div class="text-right">
							<?php echo $this->l('list_actions'); ?>
						</div>
					</th>
					<?php }?>
				</tr>
			</thead>		
		<tbody>
<?php foreach($list as $num_row => $row){ ?>        
		<tr  <?php if($num_row % 2 == 1){?>class="erow"<?php }?>>
			<?php foreach($columns as $column){?>
			<td width='<?php echo $column_width?>%' class='<?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?>sorted<?php }?>'>
				<div class='text-left'><?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; ?></div>
			</td>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<td style="white-space: nowrap;">
				<div class='btn-groups text-right'>				
					<?php if(!$unset_delete){?>
                    	<a href='<?php echo $row->delete_url?>' title='<?php echo $this->l('list_delete')?> <?php echo $subject?>' class="btn btn-sm btn-default delete-row" >
                    			<span class='glyphicon glyphicon-trash'></span>
                    	</a>
                    <?php }?>
                    <?php if(!$unset_edit){?>
						<a href='<?php echo $row->edit_url?>' title='<?php echo $this->l('list_edit')?> <?php echo $subject?>' class="btn btn-sm btn-default edit_button"><span class='glyphicon glyphicon-pencil'></span></a>
					<?php }?>
                    <?php if(!$unset_clone){?>
                        <a href='<?php echo $row->clone_url?>' title='Clone <?php echo $subject?>' class="btn btn-sm btn-default clone_button"><span class='glyphicon glyphicon-floppy-save'></span></a>
                    <?php }?>
					<?php if(!$unset_read){?>
						<a href='<?php echo $row->read_url?>' title='<?php echo $this->l('list_view')?> <?php echo $subject?>' class="btn edit_button"><span class='glyphicon glyphicon-search'></span></a>
					<?php }?>
					<?php 
					if(!empty($row->action_urls)){
						foreach($row->action_urls as $action_unique_id => $action_url){ 
							$action = $actions[$action_unique_id];
					?>
							<a href="<?php echo $action_url; ?>" class=" crud-action btn btn-sm btn-default " 
								title="<?php echo $action->label?>"><?php 
								if(!empty($action->css_class))
								{
									?><span class="glyphicon <?php echo $action->css_class; ?>"></span><?php 	
								} 
								else if(!empty($action->image_url))
								{ 
									?><img src="<?php echo $action->image_url; ?>" alt="<?php echo $action->label?>" /><?php 	
								} 
								else 
								{
									?><span><?php echo $action->label; ?></span><?php 	
								}
							?></a>		
					<?php }
					}
					?>					
				</div>
			</td>
			<?php }?>
		</tr>
<?php } ?>        
		</tbody>
		</table>
	</div>
<?php }else{?>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->l('list_no_items'); ?>
	<br/>
	<br/>
<?php }?>	
