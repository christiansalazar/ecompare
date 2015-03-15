<?php
class ECompareForm extends CFormModel {
	public $instance_id_a;
	public $instance_id_b;
	public function rules(){
		return array(
			array('instance_id_a, instance_id_b', 'required'),
		);
	}	
	public function attributeLabels(){
		return array(
			"instance_id_a"=>"Seleccione",
			"instance_id_b"=>"Seleccione",
		);
	}
}
