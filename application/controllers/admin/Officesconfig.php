<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 30.04.18
 * Time: 16:43
 */

require_once 'application/core/UI_Admin.php';

class Officesconfig extends UI_Admin {

    public function index()
    {

        $crud = new grocery_CRUD();
        $crud->set_table('up_offices');
        $crud->set_relation('location_id', 'up_locations', 'name');
        $crud->set_subject('Office');
        $crud->required_fields('name', 'latitude', 'longitude');
        $crud->columns('name', 'address', 'phone_number', 'fax_number', 'work_time', 'location_id', 'latitude', 'longitude', 'use_fetcher', 'url_key');

        $crud
            ->display_as('name', 'Име')
            ->display_as('address', 'Адрес')
            ->display_as('phone_number', 'Тел. номер')
            ->display_as('fax_number', 'Факс')
            ->display_as('work_time', 'Работно време')
            ->display_as('location_id', 'Местоположение')
            ->display_as('url_key', 'URL Адрес');


        //Now set the 2 fields we want to capture with type set to hidden
        $crud->change_field_type('latitude', 'hidden');
        $crud->change_field_type('longitude', 'hidden');
        $crud->set_js("assets/js/jquery-3.3.1.min.js");
//make sure you add MAP as extra / additional field that we gona set the callback to.

//        $crud->callback_add_field('map', array($this, 'show_map_field'));
        if ($crud->getState() == 'read') {
//            $crud->set_js('http://maps.google.com/maps/api/js?sensor=false', FALSE);
//            $crud->set_js("manage/plot_point_js");
            $crud->set_js($this->plot_point_js());
        } elseif ($crud->getState() == 'add' || $crud->getState() == 'edit') {
            $crud->callback_add_field('map', $this->show_map_field());
//            $crud->set_js('http://maps.google.com/maps/api/js?sensor=false', FALSE);
            $crud->set_js("assets/js/map.js");

//Make sure you remove / unset the map field before you do insert / update as its not 1 in the table and non-removal of it will give error
            $crud->callback_before_insert(array($this, 'unset_map_field_add'));
            $crud->callback_before_update(array($this, 'unset_map_field_edit'));
        }

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
//Function to generate the map field


    }

    private function show_map_field($value = false, $primary_key = false)
    {
        echo '<div id="map-area">
                <input id="pac-input" class="controls" type="text" placeholder="Търсене">
                <div id="retailer-map" style="width:700px; height:300px;"></div>
              </div>';
    }

    private function plot_point_js()
    {
        $retailer_id = $this->session->userdata('retailer_id');
        $retailer = $this->cModel->getByField('retailers', 'rid', $retailer_id);
        if (count($retailer) > 0) {
            $latitude = $retailer['latitude'];
            $longitude = $retailer['longitude'];
            $script = '
				var map;
				var marker;
				var circle;
				var geocoder;
				window.onload = function() {
					geocoder = new google.maps.Geocoder();
					var latlng = new google.maps.LatLng(' . $latitude . ',' . $longitude . ');
					var myOptions = {
				      zoom: 18,
				      center: latlng,
				      mapTypeId: google.maps.MapTypeId.SATELLITE
				    };
				    map = new google.maps.Map(document.getElementById("retailer-map"), myOptions);
					addMarker(map.getCenter());
					google.maps.event.addListener(map,"click", function(event) {
						//alert("You cannot reset the location by changing pointer in here");
			  			//addMarker(event.latLng);
			  		});
			  	}
							
				function addMarker(location) {
			  		if(marker) {marker.setMap(null);}
			  		marker = new google.maps.Marker({
			     		position: location,
			      		draggable: true
			  		});
			  		marker.setMap(map);
			  	}
			';
            echo $script;
        }
    }

}