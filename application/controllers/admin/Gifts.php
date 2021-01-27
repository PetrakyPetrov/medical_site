<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 30.04.18
 * Time: 17:12
 */

require_once 'application/core/UI_Admin.php';

class Gifts extends UI_Admin {

    public function index() {
		$crud = new grocery_CRUD();
        $crud->set_table('up_currencies');
        $crud->columns('code','name','url_key','description', 'cover_img_url', 'description_img_url', 'type_id', 'weight', 'size', 'buy', 'sell');
        $crud->set_relation('type_id','up_currency_types','code');

       
        $crud->where('type_id', '3');
        

        $crud
            ->display_as('code','Код')
            ->display_as('url_key','URL Адрес')
            ->display_as('name','Име')
            ->display_as('description','Описание')
            ->display_as('cover_img_url','Заглавна Снимка')
            ->display_as('description_img_url','Второстепенна Снимка')
            ->display_as('type_id','Тип')
            ->display_as('weight','Tегло в грамове')
            ->display_as('size','Диаметър в милиметри')
            ->display_as('buy','Купува')
            ->display_as('sell','Продава');
        $crud->set_subject('Currency');
        $crud->set_field_upload('cover_img_url','assets/uploads/images/currencies');
        $crud->set_field_upload('description_img_url','assets/uploads/images/currencies');

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
		
	}

    public function displayCurrencies($id = 0) {

        
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