<?php

class Form {
	
	public $id;
	public $action;	
	public $method;
	public $css;
	public $ret = false;
	public $fields = [];
	public $data = [];	
	public $render_wrapper = false;
	
	// admin form
	public $is_admin_form = false;
	public $del_url;
	
	function __construct($id = 'entity_name', $action = '', $method = 'POST', $css = 'form-horizontal admin-form') {
		$this->id = $id;
		$this->action = $action;		
		$this->method = $method;
		$this->css = $css;		
		$this->ret = _g('r', false);
	}
	
	public function addField($field) {
		$objField = (object)$field;
		$objField->value = isset($objField->value) ? $objField->value : null;
		$this->fields[$field['name']] = $objField;
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
		
		if ($this->is_admin_form) {
			$this->action = sprintf($this->action, $this->data->val($this->id));
			$this->del_url = sprintf($this->del_url, $this->data->val($this->id));
		}
		
		foreach ($this->fields as $field) {
			
			$field->value = $this->data->val($field->name);
			
			if ($field->type == 'select') {
				$field->select_data = ModelBase::select(
					$db, 
					$field->select_table, /* table */
					null, /* where */
					null, /* bindings */
					null, /* types */
					null, /* paging */
					$field->select_label_field /* orderby */
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
	
	public function renderStartTag() {
		?>
			<form id="form_<?=$this->id ?>" action="<?=$this->action ?>" method="<?=$this->method ?>" class="<?=$this->css ?>">
		<?php
	}
	
	public function render() {
		global $base_url;
		
		if ($this->render_wrapper) {
			$this->renderStartTag();
		}
								
		if ($this->ret) {
			?>
				<input type="hidden" name="r" value="<?=$this->ret ?>" />
			<?php
		}
		
		foreach ($this->fields as $field) {
			$disabled = (isset($field->disabled)) ? $field->disabled : '';
			
			if ($field->type == 'hidden') {
				?>
					<input type="hidden" name="<?=$field->name ?>" id="field_<?=$field->name ?>" value="<?=$field->value ?>" />
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
										<input type="text" name="<?=$field->name ?>" <?=$disabled ?> value="<?=$field->value ?>" class="form-control" />
									<?php
									break;			
									
									case 'select' :
										renderSelect(
											$field->name,
											$field->select_data,
											$field->select_id_field,
											$field->select_label_field,
											$field->value
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
											<p class="form-control-static"><?=$field->value ?></p>
										<?php
									break;
								}
							
								if (isset($field->validations)) {
									foreach ($field->validations as $validation) {
										?>
											<div class="form-validation" id="<?=$field->name ?>_validation_<?=$validation['type'] ?>"><?= isset($validation['message']) ? $validation['message'] : t('Required.') ?></div>
										<?php
									}
								}
							?>											
							
						</div>
						
					</div>
				<?php
			}						
		}
						
		if ($this->is_admin_form) {
			?>
	
				<div class="form-buttons">
					<a class="form-button" href="<?=_url($this->ret) ?>"><?= t('Back') ?></a>
					<input type="button" onclick="javascript:deleteItem_<?=$this->id ?>();" class="btn btn-danger form-button" value="<?=t('Delete') ?>">
					<input type="button" onclick="javascript:validateForm_<?=$this->id ?>();" class="btn btn-success form-button" value="<?=t('Save') ?>">
				</div>
				
				<script>
					function deleteItem_<?=$this->id ?>() {
						if (confirm('<?= t('Are you sure to delete this item?') ?>')) {
							document.location = '<?= _url($this->del_url, $this->ret) ?>';
						}
					}	
				</script>
			<?php
		}
		
		if ($this->render_wrapper) {
			?>
				</form>
			<?php
		}
		
		?>
				
			<script>
				function validateForm_<?=$this->id ?>() {
					var frm = new formValidation('form_<?=$this->id ?>');
						<?php
							foreach ($this->fields as $field) {
								if (isset($field->validations)) {
									foreach ($field->validations as $val) {
										?>
											frm.add('<?=$field->name ?>', '<?=$val['type'] ?>', '<?=(isset($val['param'])) ? $val['param'] : 1 ?>');
										<?php
									}
								}
							}
						?>						
					frm.submit();
				}			
			</script>
		
		<?php
	}
		
}

class AdminForm extends Form {
		
	function __construct($entity) {
		parent::__construct($entity . '_id', 'admin/' . $entity . '/edit/%d');
		$this->entity_name = $entity;
		$this->del_url = 'admin/' . $entity . '/delete/%d';		
		$this->is_admin_form = true;
		$this->render_wrapper = true;
		$this->addField(
			[
				'name' => $this->id,
				'type' => 'hidden'
			]
		);
	}
	
}