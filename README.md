ECOMPARE
========

Compare two instances (view).

Setup
-----

1. create a component on which you provide the data to be compared, in this
example we will compare two Car instances. You can compare anything.

	~~~

	<?php
	// FILE: protected/components/CarCompare.php
	Yii::import("application.extensions.ecompare.*");

	// helper
	function a_sort_helper($a, $b) { return strcmp($a, $b);  }

	// your comparator, oriented to Car instances.
	class CarCompare extends ECompareAction {

		// provide the title
		protected function getTitle(){
			return "<h1>Compare Two Cars</h1><hr/>";
		}

		// some css class to be added on views
		protected function getCssClass(){
			return "ecompare_cars";	
		}

		/**
		 * enumObjects 
		 *  called by the action in order to obtain the instances to be compared
		 *  to each other.
		 *		
		 *	return array("1"=>"Aveo LT", "2"=>"Ford Mustang", "3"=>"Fiat Palio");
		 *
		 * @abstract
		 * @access protected
		 * @return array 
		 */
		protected function enumObjects() {
			$result = array();
			foreach(Car::model()->findAll() as $model)
				$result[$model->car_id] = $model->car_name;
			uasort($result, "a_sort_helper"); // simple sort
			return $result;
		}

		/**
		 * enumAttributes
		 *	called by action in order to obtain the attribute list
		 * 
		 *
		 * @abstract
		 * @access protected
		 * @return array array("mark"=>"Car Mark", "year"=>"Car Year", ... )
		 */
		protected function enumAttributes() {
			$result = array();
			foreach(Car::model()->attributeLabels() as $attr=>$label){
				if("car_id" == $attr) continue; // skip it..or something else
				$result[$attr] = $label;
			}
			return $result;
		}

		/**
		 * getValue
		 *   called by action to obtain a value from a given instance attribute.
		 * 
		 * @param string $instance_id  see also enumObjects() array key
		 * @param string $attribute see also enumAttributes()
		 * @abstract
		 * @access protected
		 * @return string
		 */
		protected function getValue($instance_id, $attribute) {
			if($model = Car::model()->findByPk($instance_id)){
				if(isset($model[$attribute]))
					return $model[$attribute];
			}
			return "...";
		}

		/**
		 * pre
		 *	html to be inserted previous to the comparison table.
		 * 
		 * @param object $model instance of ECompareForm
		 * @access public
		 * @return void    must do "echo" calls
		 */
		public function pre($model){
			echo "A decoration at top of this sample view";
		}

		/**
		 * post
		 *	html to be inserted at the end of the comparison table.
		 * 
		 * @param object $model instance of ECompareForm
		 * @access public
		 * @return void    must do "echo" calls
		 */
		public function post($model){
			// do nothing
		}
	}
~~~

2. create an action in some controller from which you will launch it later.

	~~~
	class CarController extends Controller {
		...
		public function actions(){
			return array(
				"compare"=>array(
					'class'=>'application.components.CarCompare',
				),
			);
		}
		...
	}
~~~

3. lauch the view

	http://localhost/yourapp/index.php?r=/car/compare
