<?php
abstract class ECompareAction extends CAction {
	private $enumObjects_lazy;
	private $enumAttributes_lazy;

	public function run(){
		$model = new ECompareForm();
		$values = array();

		foreach($this->getInstances() as $_id=>$_label){
			if(null==$model->instance_id_a) $model->instance_id_a = $_id;
			if(null==$model->instance_id_b) $model->instance_id_b = $_id;
		}
		
		if(isset($_POST['ECompareForm'])){
			$model->attributes = $_POST['ECompareForm'];
		}

		$this->publishAssets();
		
		//echo "<pre>"; print_r($this->getAttributes()); echo "</pre>";
		//echo "<pre>"; print_r($this->getInstances()); echo "</pre>";

		Yii::app()->controller->render(
			"application.extensions.ecompare.view", 
				array('model'=>$model, 'instances'=>$this->getInstances(),
					'attributes'=>$this->getAttributes(),
					'label_a' => $this->getInstances()[$model->instance_id_a],
					'label_b' => $this->getInstances()[$model->instance_id_b],
					'values' => $this->getValues(
						$model->instance_id_a, $model->instance_id_b),
					'css' => $this->getCssClass(),
					'title' => $this->getTitle(),
					'component' => $this,
				));
	}

	private function publishAssets(){
		$assets = dirname(__FILE__) . '/ecompare.css';
		$css_file = Yii::app()->assetmanager->publish($assets);
        Yii::app()->clientscript->registerCssFile($css_file);
	}

	private function getInstances(){
		if(null == $this->enumObjects_lazy){
			$this->enumObjects_lazy = array();
			foreach($this->enumObjects() as $id=>$text)
				$this->enumObjects_lazy[$id] = $text;
		}
		return $this->enumObjects_lazy;
	}

	private function getAttributes(){
		if(null == $this->enumAttributes_lazy){
			$this->enumAttributes_lazy = array();
			foreach($this->enumAttributes() as $id=>$text)
				$this->enumAttributes_lazy[$id] = $text;
		}
		return $this->enumAttributes_lazy;
	}

	private function getValues($instance_a, $instance_b){
		$result = array();
		foreach($this->getAttributes() as $attr => $label){
			$value_a = $this->getValue($instance_a, $attr);
			$value_b = $this->getValue($instance_b, $attr);
			$result[] = array(
				$attr, $label, $value_a, $value_b
			);
		}	
		return $result;
	}

	protected function getCssClass(){
		return "";
	}

	protected function getTitle(){
		return "<h1>Comparison</h1>";
	}

	/**
	 * enumObjects 
	 *  espera un array con los objetos a ser comparados.
	 *		
	 *	return array("123"=>"titulo 123", "456"=>"titulo 456");
	 *
	 *	array key: "123"  "456"
	 *		usados para identificar cada instancia.
	 *
	 * @abstract
	 * @access protected
	 * @return array 
	 */
	protected abstract function enumObjects();

	/**
	 * enumAttributes
	 *	retorna los atributos a consultar para cada objeto enumerado.
	 * 
	 *
	 * @abstract
	 * @access protected
	 * @return array array("firstname"=>"label", "lastname"=>"label", ... )
	 */
	protected abstract function enumAttributes();


	/**
	 * getValue
	 *	devuelve el valor para un atributo en una instancia dada.
	 * 
	 * @param string $instance_id  see also enumObjects() array key
	 * @param string $attribute see also enumAttributes()
	 * @abstract
	 * @access protected
	 * @return string
	 */
	protected abstract function getValue($instance_id, $attribute);

	/**
	 * pre
	 *	html to be inserted previous to the comparison table.
	 * 
	 * @param object $model instance of ECompareForm
	 * @access public
	 * @return void    must do "echo" calls
	 */
	public abstract function pre($model);

	/**
	 * post
	 *	html to be inserted at the end of the comparison table.
	 * 
	 * @param object $model instance of ECompareForm
	 * @access public
	 * @return void    must do "echo" calls
	 */
	public abstract function post($model);
}
