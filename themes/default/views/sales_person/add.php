<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

<style>

   .modal.fade {
    -webkit-transition: opacity .3s linear, top .3s ease-out;
    -moz-transition: opacity .3s linear, top .3s ease-out;
    -ms-transition: opacity .3s linear, top .3s ease-out;
    -o-transition: opacity .3s linear, top .3s ease-out;
    transition: opacity .3s linear, top .3s ease-out;
    top: -25%;
}

.modal-header .btnGrp{
      position: absolute;
      top:8px;
      right: 10px;
    } 
     
.pac-container {
        z-index: 10000 !important;
    }
.pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }


      .shownot {
        display: none;
      }
 
</style>
<div class="container" style="margin-top:150px;">				
<!--<div class="mymodal" id="modal-1" role="dailog">-->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
			</button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_sales_person'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form','id' => 'add_sales_person-form');
        echo form_open_multipart("sales_person/add", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">
                <div class="col-md-6 shownot">
                    <div class="form-group">
                        <?= lang("logo", "sales_person_logo"); ?>
                        <?php
                        $sales_person_logos[''] = '';
                        foreach ($logos as $key => $value) {
                            $sales_person_logos[$value] = $value;
                        }
                        echo form_dropdown('logo', $sales_person_logos, '', 'class="form-control select" id="sales_person_logo"'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div id="logo-con" class="text-center"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group company shownot">
                        <?= lang("company", "company"); ?>
                        <?php echo form_input('company', '', 'class="form-control tip" id="company" '); ?>
                    </div>
                    <div class="form-group person ">
                        <?= lang("name", "name"); ?> 
                        <?php echo form_input('name', '', 'class="form-control tip" id="name" data-bv-notempty="true" required="required"'); ?>
                    </div>
                    <div class="form-group shownot">
                        <?= lang("vat_no", "vat_no"); ?>
                        <?php echo form_input('vat_no', '', 'class="form-control" id="vat_no"'); ?>
                    </div>
                      <div class="form-group shownot">
                        <?= lang("gstn_no", "gstn_no"); ?>
                            <?php echo form_input('gstn_no', '', 'class="form-control" id="gstn_no"  onchange="return validateGstin();"'); ?>
                      </div>
                    <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php echo form_input('contact_person', '', 'class="form-control" id="contact_person" data-bv-notempty="true"'); ?>
                    </div>-->
                    <div class="form-group">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="text" name="email" class="form-control"  id="email_address" data-bv-emailaddress
                        data-bv-onerror="onFieldError" data-bv-onsuccess="onFieldSuccess" data-bv-onstatus="onFieldStatus" />
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?>
                        <input type="tel" name="phone" class="form-control" data-bv-phone="true" data-bv-phone-country="US" required="required" id="phone" maxlength="10" />
                    </div>
                    <div class="form-group">
                        <?= lang("Date_OF_Birth", "DOB"); ?>
                        <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="date" autocomplete="off" '); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', '', 'class="form-control" id="address"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("city", "city"); ?>
                        <?php echo form_input('city', '', 'class="form-control" id="city"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("state", "state"); ?>
                       <?php
				                  $st[""] = "";
					                foreach ($states as $state) {
						                $st[$state->name] = $state->name;
					               }
					               echo form_dropdown('state', $st, (isset($_POST['state']) ? $_POST['state'] : ''), 'id="slsales_person" data-placeholder="' . lang("select") . ' ' . lang("state") . 'class="form-control input-tip select" style="width:100%; height:30px;"');
					              ?>
                    </div>
					           <div class="form-group">
                        <?= lang("country", "country");?>
                        <?php echo form_input('country', '', 'class="form-control" id="country"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Pan_card", "Pan_card");?>
                        <?php echo form_input('pan_card', '', 'class="form-control" id="pancard" maxlength="10"'); ?>
                        <small class="text-danger" id="errpancard"></small>
                    </div>
                </div>
                <div class="col-md-6">
                 
                    <div class="form-group">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', '', 'class="form-control" id="postal_code"'); ?>
                    </div>
                    <div class="form-group">
                      <?= lang("Photo", "Photo") ?>
                      <input id="photos" type="file" data-browse-label="<?= lang('browse'); ?>" name="photos" data-show-upload="false"
                      data-show-preview="false" class="form-control file">
                    </div>
                    <div class="form-group">
                      <?= lang("Attach_Identity_Proof", "Attach_identity_proof") ?>
                      <input id="attch_document" type="file" data-browse-label="<?= lang('browse'); ?>" name="attch_document" data-show-upload="false"
                      data-show-preview="false" class="form-control file">
                    </div>
                    <div class="form-group">
                        <?= lang("ssf1", "cf1"); ?>
                        <?php echo form_input('cf1', '', 'class="form-control" id="cf1"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ssf2", "cf2"); ?>
                        <?php echo form_input('cf2', '', 'class="form-control" id="cf2"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ssf3", "cf3"); ?>
                        <?php echo form_input('cf3', '', 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ssf4", "cf4"); ?>
                        <?php echo form_input('cf4', '', 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ssf5", "cf5"); ?>
                        <?php echo form_input('cf5', '', 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ssf6", "cf6"); ?>
                        <?php echo form_input('cf6', '', 'class="form-control" id="cf6"'); ?>
                    </div>
                </div>
                <div class="col-md-12 shownot">
                    <div class="form-group">
                          <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                    <div id="map" style="height:200px;width:100%;"></div>
                    </div>
                    <div class="form-group">
                         <div class="col-md-12">
                            <?php echo form_input('location_map', $sales_person->location_map, 'class="form-control" id="location_map" placeholder="Location On Map" readonly '); ?>
                          </div>
                    </div>
                </div>
                
                <div class="col-md-12 shownot">
                    <div class="form-group">
                        <?= lang("invoice_footer", "invoice_footer"); ?>
                        <?php echo form_textarea('invoice_footer', '', 'class="form-control skip" id="invoice_footer" style="height:100px;"'); ?>
                    </div>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_sales_person', lang('add_sales_person'), 'class="btn btn-primary"'); ?>
       </div>
    </div>
    <?php echo form_close(); ?>
</div>
<!--</div>-->
</div>

<script>

      // In the following example, markers appear when the user clicks on the map.
      // The markers are stored in an array.
      // The user can then click an option to hide, show or delete the markers.
      var map;
      var markers = [];

      function initMap() {
      
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 23.2599, lng: 77.4126},
          zoom: 12,
          mapTypeId: 'terrain'
        });

        // This event listener will call addMarker() when the map is clicked.
        map.addListener('click', function(event) {
          addMarker(event.latLng);
        });
         

  // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  searchBox.addListener('places_changed', function() {
 
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];
 
    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      if (!place.geometry) {
        console.log("Returned place contains no geometry");
        return;
      }
        addMarker(place.geometry.location) ;

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
 


      }

      // Adds a marker to the map and push to the array.
      function addMarker(location) {
		console.log(location);  
		clearMarkers();
                markers = [];
		if(typeof location.lat === 'function') { 
	            $('#location_map').val(location.lat()+','+location.lng());		
		}
		
		var marker = new google.maps.Marker({
          position: location,
          map: map
        });
        markers.push(marker);
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }
 
      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }
	 
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTg4kjqcDeHxyJs4MnwL38FWi4n5lwMBQ&libraries=places&callback=initMap"
    async defer></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#sales_person_logo').change(function (event) {
            var sales_person_logo = $(this).val();
            $('#logo-con').html('<img src="<?=base_url('assets/uploads/logos')?>/' + sales_person_logo + '" alt="">');
        });
    });
</script>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#add_sales_person-form').bootstrapValidator({
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            }, excluded: [':disabled']
        });
        $('select.select').select2({minimumResultsForSearch: 7});
        fields = $('.modal-content').find('.form-control');
        $.each(fields, function () {
            var id = $(this).attr('id');
            var iname = $(this).attr('name');
            var iid = '#' + id;
            if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {
                $("label[for='" + id + "']").append(' *');
                $(document).on('change', iid, function () {
                    $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', iname);
                });
            }
        });
    });
    </script>
    <script type="text/javascript">
    //.$("div").hide();//To Hide
       $('#pancard').change(function(){
            $('#errpancard').html(" ");
            var patt =/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/;
            var pan_card = $(this).val();
            if(patt.test(pan_card)){
                $('#errpancard').html(" ");
            } else {
              $('#errpancard').html( "\"<strong>" + pan_card + " </strong>\" this no. invalid, Please enter valid pancard no.")
              $(this).val(' ');
            }
        });   
    </script>