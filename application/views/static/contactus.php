<div class="content-base no-hero">
	<div class="container">
		<h1>Contact Us</h1>
		<hr />
		<div class="row">
			<div class="col-md-6">
				
				<div class="contact-block">
					<div class="contact-row clearfix">
						<div class="contact-icon">
							<span class="pe-7s-home"></span>
						</div>
						<div class="contact-details">
							<p><b>Click and Rent Ltd</b></p>
							<p>Dragan Tsankov 14<br/>
                                Varna 9000</p>
						</div>
					</div>
					<div class="contact-row clearfix">
						<div class="contact-icon">
							<span class="pe-7s-call"></span>
						</div>
						<div class="contact-details">
							+359 886 466 000
						</div>
					</div>
				</div>
				<h4>Send us your request</h4>
				<?php if ($formSuccess) {?>
					<div class="panel panel-success">
					  <div class="panel-body">
						Your Request is Sent. Thank you!
					  </div>
					</div>
				<?php } else { ?>
				<form method="post" action="<?php echo site_url('contact-us'); ?>">
					<div class="form-group">
						<label>Your Name</label>
						<input type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control" />
						<?php echo form_error('name'); ?>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" value="<?php echo set_value('email'); ?>" class="form-control" />
						<?php echo form_error('email'); ?>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="text" name="phone"  value="<?php echo set_value('phone'); ?>" class="form-control" />
					</div>
					<div class="form-group">
						<label>Message</label>
						<textarea style="height: 100px" name="message" class="form-control"><?php echo set_value('message'); ?></textarea>
						<?php echo form_error('message'); ?>
					</div>
					<button class="btn btn-primary" style="margin-bottom: 10px">Send Request</button>
				<form>
				<?php }  ?>
			</div>
			<div class="col-md-6">
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
			<div style="overflow:hidden;height:500px;width:100%;">
                <div id="gmap_canvas" style="height:500px;width:100%;">
                </div>
                <style>
                    #gmap_canvas img{
                        max-width:none!important;
                        background:none!important
                    }
                </style>
			</div>
                <script type="text/javascript">
                    function init_map(){
                        var myOptions = {
                            zoom:18,
                            center:new google.maps.LatLng(43.205156, 27.914359),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };

                        map = new google.maps.Map(
                            document.getElementById("gmap_canvas"),
                            myOptions
                        );
                        marker = new google.maps.Marker({
                            map: map,
                            position: new google.maps.LatLng(43.205156, 27.914359)
                        });

                        infowindow = new google.maps.InfoWindow({
                            content:"<b>clicknrent.bg</b><br/>Dragan Tsankov 14 Varna 9000, Bulgaria<br/> "
                        });
                        google.maps.event.addListener(marker, "click", function(){
                            infowindow.open(map,marker);
                        });
                        infowindow.open(map,marker);
                    }
                    google.maps.event.addDomListener(window, 'load', init_map);
                </script>
			</div>
			
		</div>
	
	</div>
</div>
