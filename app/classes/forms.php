<?php

class Form {
	
	public $id;
	public $action;
	public $del_url;
	public $method;
	public $css;
	public $ret = false;
	public $fields = [];
	public $data = [];
	
	function __construct($id = 'entity_id', $action = '', $del_url = null, $method = 'POST', $css = 'form-horizontal admin-form') {
		$this->id = $id;
		$this->action = $action;
		$this->del_url = $del_url;
		$this->method = $method;
		$this->css = $css;		
		$this->ret = _g('ret', false);
	}
	
	public function addField($field) {
		$this->fields[$field['name']] = (object)$field;
	}
	
	public function add($fields) {
		if (is_array($fields)) {			
			foreach ($fields as $field) {
				$this->addField($field);
			}			
		} else {
			$this->addField($fields);
		}
	}
	
	public function processInput($data) {
		$result = [];
		foreach ($this->fields as $field) {
			if (isset($data[$field->name]) && !isset($field->disabled)) {
				$result[$field->name] = $data[$field->name];
			}
		}
		return $result;
	}
	
	public function prepare($db, $data) {
		$this->data = $data;
		
		foreach ($this->fields as $field) {
										
			if ($field->type == 'select') {
				$field->select_data = ModelBase::select(
				/* db */		$db, 
				/* table */		$field->select_table, 
				/* where */		null,
				/* bindings */	null,
				/* types */		null,
				/* paging */	null,
				/* orderby */	$field->select_label_field
				);
			} elseif ($field->type == 'foreign_key_link') {
				$entity = new ModelBase($db);
				$entity->table_name = $field->link_table;
				$filter = sprintf('%s = ?', $field->link_id_field);
				$entity->loadSingleFiltered($filter, [$this->data->val($field->name)]);
				$field->link_label = $entity->val($field->link_label_field);
				$field->link_url = sprintf($field->link_template, $entity->val($field->link_id_field));
			}
		}
	}
	
	public function render() {
		global $base_url;
		
		// render whole form
		
			?>
				<form id="form_<?=$this->id ?>" action="<?=sprintf($this->action, $this->data->val($this->id)) ?>" method="<?=$this->method ?>" class="<?=$this->css ?>">
					
					<?php
						
						if ($this->ret) {
							?>
								<input type="hidden" name="ret" value="<?=$this->ret ?>" />
							<?php
						}
						
						foreach ($this->fields as $field) {
							$disabled = (isset($field->disabled)) ? $field->disabled : '';
							
							if ($field->type == 'hidden') {
								?>
									<input type="hidden" name="<?=t($field->name) ?>" id="field_<?=t($field->name) ?>" value="<?=$this->data->val($field->name) ?>" />
								<?php
							} else {
								?>
									<div class="form-group">
										<label for="<?=$field->name ?>" class="col-sm-2 control-label"><?=t($field->label) ?>:</label>
										<div class="col-sm-6">
											<?php
																		
												switch ($field->type) {
													case 'text' :
													?>
														<input type="text" name="<?=t($field->name) ?>" <?=$disabled ?> value="<?=$this->data->val($field->name) ?>" class="form-control" />
													<?php
													break;			
													
													case 'select' :
														renderSelect(
															$field->name,
															$field->select_data,
															$field->select_id_field,
															$field->select_label_field,
															$this->data->val($field->name)
														);
													break;
													
													case 'foreign_key_link' :
														?>
															<p class="form-control-static">
																<?php
																	renderLink(
																		$field->link_url,
																		$field->link_label															
																	);
																?>
															</p>
														<?php
													break;
													
													case 'static' :
														?>
															<p class="form-control-static"><?=$this->data->val($field->name)?></p>
														<?php
													break;
												}
											
												if (isset($field->validations)) {
													foreach ($field->validations as $val) {
														?>
															<div class="form-validation" id="<?=$field->name ?>_validation_<?=$val['type'] ?>"><?= t('Required.') ?></div>
														<?php
													}
												}
											?>											
											
										</div>
										
									</div>
								<?php
							}						
						}
					?>
					
					<div class="form-buttons">
						<a class="form-button" href="<?=$this->ret ?>"><?= t('Back') ?></a>
						<input type="button" onclick="javascript:deleteItem();" class="btn btn-danger form-button" value="<?=t('Delete') ?>">
						<input type="button" onclick="javascript:validateForm();" class="btn btn-success form-button" value="<?=t('Save') ?>">
					</div>
		
				</form>
				
				<script>
					function validateForm() {
						var frm = new formValidation('form_<?=$this->id ?>');
							<?php
								foreach ($this->fields as $field) {
									if (isset($field->validations)) {
										foreach ($field->validations as $val) {
											?>
												frm.add('<?=$field->name ?>', '<?=$val['type'] ?>', '<?=$val['param'] ?>');
											<?php
										}
									}
								}
							?>						
						frm.submit();
					}
					
					function deleteItem() {
						if (confirm('<?= t('Are you sure to delete this item?') ?>')) {
							document.location = '<?= $base_url . sprintf($this->del_url, $this->data->val($this->id)) ?>?ret=<?=$this->ret ?>';
						}
					}	
				</script>
			<?php
	}
		
}

class AdminForm extends Form {
		
	function __construct($entity) {
		parent::__construct($entity . '_id', '/admin/' . $entity . '/edit/%d', '/admin/' . $entity . '/delete/%d');
	}
	
}