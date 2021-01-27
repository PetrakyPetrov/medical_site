<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 30.04.18
 * Time: 17:43
 */

require_once 'application/core/UI_Admin.php';

class Locationsconfig extends UI_Admin {

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('up_locations');
        $crud->required_fields('name', 'url_key');
        $crud->columns('name', 'order_id');
        $crud
            ->display_as('name','Име')
            ->display_as('url_key','URL Адрес');

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
    }
}