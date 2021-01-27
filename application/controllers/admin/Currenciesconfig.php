<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 30.04.18
 * Time: 17:12
 */

require_once 'application/core/UI_Admin.php';

class Currenciesconfig extends UI_Admin {

    public function index() {}

    public function displayCurrencies($id = 0) {

        $crud = new grocery_CRUD();
        $crud->set_table('up_currencies');
        $crud->columns('code','name','description', 'cover_img_url', 'type_id', 'buy', 'sell');
        $crud->fields('code', 'name', 'description', 'cover_img_url', 'type_id', 'buy', 'sell', 'active', 'order_id');
		
        $crud->set_relation('type_id','up_currency_types','code');
		$crud->where('type_id', '4');
		
		$crud->callback_before_insert(function($post_array){
			$post_array['type_id'] = 4;
			return $post_array;
		});
		
        if($id != 0){
            $crud->where('id=', $id);
        }

        $crud
            ->display_as('code','Код')
            ->display_as('name','Име')
            ->display_as('description','Описание')
            ->display_as('cover_img_url','Снимка')
            ->display_as('type_id','Тип')
            ->display_as('buy','Купува')
            ->display_as('sell','Продава');
        $crud->set_subject('Currency');
        $crud->set_field_upload('cover_img_url','assets/uploads/images/currencies');

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
    }

    public function currencyType() {

        $crud = new grocery_CRUD();
        $crud->set_table('up_currency_types');
        $crud->columns('name','description', 'code');
        $crud
            ->display_as('name','Име')
            ->display_as('description','Описание');

        $crud->set_subject('Currency Type');

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
    }
}