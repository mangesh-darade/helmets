<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            
            <div class="text-center" style="margin-bottom:20px;">
                <h3> <?= $store_info->name ?> Store Update </h3>
            </div>
            <div class="container">
               
               <?php $attrib = array( 'data-toggle' => 'validator','role' => 'form'); //
                echo form_open("urban_piper/update_store", $attrib);
                ?>
                <input type="hidden" name="store_id" value="<?= $store_info->id ?>" >
                    <table class="table">
                        <tr>
                            <td ><label class="control-label" for="contact_phone"><?=  lang("Mobile No"); ?></label></td>
                            <td>:</td>
                            <td>
                                 <input type="text" class="form-control" name="contact_phone" value="<?= ($store_info->contact_phone)?$store_info->contact_phone:$marchant_no ?>" placeholder="Mobile No" id="contact_phone" />
                            </td>
                        </tr>
                       
                        <tr>
                            <td><label class="control-label" for="address"><?=  lang("Address"); ?></label></td>
                            <td>:</td>
                            <td><input type="text" class="form-control" name="address" value="<?= $store_info->address ?>" id="address" ></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="City "><?=  lang("City "); ?>  *</label></td>
                            <td>:</td>
                            <td><input type="text"  class="form-control" name="city" required placeholder="City" id="city" value="<?= $store_info->city ?>" ><p><span class="text-danger errormsg"  id="city_err"></span></p> </td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="zip_code"><?=  lang("Zip code"); ?></label></td>
                            <td>:</td>
                            <td><input type="text"  class="form-control" name="zip_codes"   value="<?= $store_info->zip_codes ?>"  placeholder="Zip code " id="zip_code" ></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="notifi_email"><?=  lang("Notification Emails"); ?></label></td>
                            <td>:</td>
                            <td><input type="text" class="form-control" name="notification_emails" placeholder="Notification Emails"  value="<?= $store_info->notification_emails ?>" id="notifi_email" ></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="notifi_phone"><?=  lang("Notification Mobile No"); ?></label></td>
                            <td>:</td>
                            <td><input type="text" class="form-control"  name="notification_phones" placeholder=" Notification Mobile No"  value="<?= $store_info->notification_phones  ?>" id="notifi_phone" /></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="min_pickup_time"><?=  lang("Min Pickup Time"); ?></label></td>
                            <td>:</td>
                            <td><!--<input type="number" class="form-control" min="0" maxlength="6" name="min_pickup_time" placeholder="Min Pickup Time "  value="<?= $store_info->min_pickup_time  ?>" id="min_pickup_time" >-->
							<select name="min_pickup_time" class="form-control" id="min_pickup_time" >
								<?php for($iMinPickupTime=10; $iMinPickupTime<=60; $iMinPickupTime+=5){ $iMinPickupTimeValue = $iMinPickupTime*60; ?>
								<option value="<?php echo $iMinPickupTimeValue; ?>" <?= $store_info->min_pickup_time==$iMinPickupTimeValue?'Selected':''?>> <?php echo $iMinPickupTime; ?> </option>
								<?php } ?>
							</select>
							</td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="min_delivery_time"><?=  lang("Min Delivery Time"); ?></label></td>
                            <td>:</td>
                            <td> <!--<input type="number" class="form-control"  min="0" maxlength="6" name="min_delivery_time" placeholder=" Min Delivery Time" value="<?= $store_info->min_delivery_time  ?>" id="min_delivery_time" /> -->
							<select name="min_delivery_time" class="form-control" id="min_delivery_time" >
									<?php for($iMinDeliveryTime=10; $iMinDeliveryTime<=60; $iMinDeliveryTime+=5){ $iMinDeliveryTimeValue = $iMinDeliveryTime*60; ?>
                                    <option value="<?php echo $iMinDeliveryTimeValue; ?>" <?= $store_info->min_delivery_time==$iMinDeliveryTimeValue?'Selected':''?>> <?php echo $iMinDeliveryTime; ?> </option>
									<?php } ?>
                                </select>
							</td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="geo_longitude"><?=  lang("Longitude"); ?></label></td>
                            <td>:</td>
                            <td><input type="text" class="form-control"  name="geo_longitude" placeholder="Longitude" value="<?= $store_info->geo_longitude  ?>"   id="geo_longitude" ></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="geo_latitude"><?=  lang("Latitude"); ?></label></td>
                            <td>:</td>
                            <td><input type="text" class="form-control"  name="geo_latitude" placeholder="Latitude" value="<?= $store_info->geo_latitude ?>" id="geo_latitude" ></td>
                        </tr>
						<tr>
							<td colspan="3">
								<table class="table table-border">
									<thead>
										<tr>
											<th></th>
											<th>Days</th>
											<th>Start Time</th>
											<th>End Time</th>
										</tr>
									</thead>
									<tbody>
									<?php
										
										function get_times( $default = '', $interval = '+30 minutes' ) {

										$output = "<option value=''>Any Time</option>";

										$current = strtotime( '00:00:00' );
										$end = strtotime( '23:59:00' );

										while( $current <= $end ) {
											$time = date( 'H:i:s', $current );
											$sel = ( $time == $default ) ? ' selected' : '';
											
											$output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
											$current = strtotime( $interval, $current );
										}

										return $output;
									}
									?>
									<?php
										$DaysArr = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
										for($iDaysArr=0; $iDaysArr<=6; $iDaysArr++){ 
										
											
									?>
										<tr>
											<td>
											<?php
												if($store_info->days){
												$DaysArrVal = json_decode(stripslashes($store_info->days), true);
												//print_r($DaysArr);
												$DayActive = '';
												$StartTimeSlot = '';
												$EndTimeSlot = '';
												foreach($DaysArrVal as $keyDays){
												//print_r($keyDays['day']);
													if($DaysArr[$iDaysArr] == $keyDays['day']){
														$DayActive = $keyDays['day'];
														foreach($keyDays['slots'] as $key=>$val){
															$StartTimeSlot = $val['start_time'];
															$EndTimeSlot = $val['end_time'];
															//print_r($val);
														}
													}
													
												}
											}
											?>
											<input class="checkbox checkdays" type="checkbox" name="Days[]" id="Days_<?php echo $DaysArr[$iDaysArr]; ?>" value="<?php echo $DaysArr[$iDaysArr]; ?>" <?php if($DaysArr[$iDaysArr] == $DayActive) echo 'checked'; ?>/></td>
											<td><?php echo ucfirst($DaysArr[$iDaysArr]); ?></td>
											<td>
												<select class="form-control"  name="<?php echo $DaysArr[$iDaysArr]; ?>_start_time" id="<?php echo $DaysArr[$iDaysArr]; ?>_start_time">
													<?php echo get_times($StartTimeSlot); ?>
												</select> 
												<span class="text-danger errormsg days_error_msg"  id="<?php echo $DaysArr[$iDaysArr]; ?>_start_time_err"></span>
											</td>
											<td>
												<select class="form-control"  name="<?php echo $DaysArr[$iDaysArr]; ?>_end_time" id="<?php echo $DaysArr[$iDaysArr]; ?>_end_time">
													<?php echo get_times($EndTimeSlot); ?>
												</select>  
												 <span class="text-danger errormsg days_error_msg"  id="<?php echo $DaysArr[$iDaysArr]; ?>_end_time_err"></span>
											</td>
										</tr>
									</tbody>
									<?php } ?>
								</table>
							</td>
						</tr>
                        <tr>
                            <td colspan="3" class="text-center">
							    <input type="hidden" name="DaysTime" id="DaysTime" value="<?= $store_info->days ?>">
                                <button type="submit" class="btn btn-success" onclick="return submitStore();"> Update </button> 
                                <button type="button"  class="btn btn-danger" data-dismiss="modal" aria-hidden="true"> Close </button> 
                            </td>
                        </tr>
                    </table>
                
                <?= form_close(); ?>
            </div>
            
        </div>
    </div>
</div>
<script>
function submitStore(){
		var city = $('#city').val();
		$('.errormsg').text('');
		var flag=false;
		var ArrDays = [];
		 $('.checkdays').each(function () {
			if($(this).is(':checked')){
				var ArrSlotDays = [];
				var SlotTime = {};
				var Days = $(this).val();
				var StartTime = $('#'+Days+'_start_time').val();
				var EndTime = $('#'+Days+'_end_time').val();
				if(StartTime.length!=''){
					if(EndTime.length!=''){
					if(EndTime<StartTime){
						$('#'+Days+'_end_time_err').text('The end date must be a valid date and later than the start date');
						flag=true;
					}
					}
				}
				if(EndTime.length==''){
					$('#'+Days+'_end_time_err').text('Select End Time, if day is selected');
					flag=true;
				}
				if(StartTime.length==''){
					$('#'+Days+'_start_time_err').text('Select start Time, if day is selected');
					flag=true;
				}
					
				ArrSlotDays.push({
						start_time: StartTime,
						end_time: EndTime,
					});
				//console.log(Days);
				ArrDays.push({
					day: Days, 
					slots: ArrSlotDays,
				});
				 
			}
		 });
		 var JsonDays = JSON.stringify(ArrDays);
		 $('#DaysTime').val(JsonDays);
		  if(city.length==''){
			 $('#city_err').text('The City field is required.');
			 $('#city').focus();
			 flag=true;
		 }
		 
		 if(flag)
			 return false;
		 
		
	}
</script>