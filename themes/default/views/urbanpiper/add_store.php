<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Add Store'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger" id="errormsg">
                        <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                        <?= validation_errors() ?>            
                    </div>
                <?php }
                if ($this->session->flashdata('success')) {
                    ?>
                    <div class="alert alert-success" id="errormsg">
                        <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                    <?= $this->session->flashdata('success') ?>            
                    </div>
                <?php }/* else if($this->session->flashdata('error')){ ?>
                  <div class="alert alert-danger" id="msg">
                  <?=  $this->session->flashdata('error') ?>
                  </div>
                  <?php } */ ?>



                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'StoreForm'); //
                echo form_open("urban_piper/add_store", $attrib);
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="name"> Store Name</label>
                            <div class="controls">
                                <input type="text" required="required" class="form-control" name="name" maxlength="100" required="true" placeholder="Store Name" value="<?=$postdata['name']?>" id="name" />
                                <span class="text-danger errormsg" id="name_err"></span>
                            </div>
                        </div> 
                    </div>    
                </div>  
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="address"><?= lang("Store Address"); ?></label>
                            <div class="controls">
                                <input type="text" required="required" maxlength="250" class="form-control" placeholder="Store Address" name="address" id="address" value="<?=$postdata['address']?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="warehouse">Assign Warehouse</label>
                            <div class="controls"> <?php
                                foreach ($warehouses as $warehouse) {
                                    $wh[0] = '-- Select --';
                                    $wh[$warehouse->id] = $warehouse->name . ' (' . $warehouse->code . ')';
                                }
                              $selected_warehouse = $postdata['warehouse'] ?  $postdata['warehouse'] : $Settings->default_warehouse;
                                echo form_dropdown('warehouse', $wh, $selected_warehouse, 'class="form-control tip" id="warehouse" required="required" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="emial">Email</label>
                            <div class="controls">
                                <input type="email" class="form-control" name="email" value="<?=$postdata['email']?>" placeholder="Email Address" required="required"  />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="contact_phone"><?= lang("Mobile No"); ?> </label>
                            <div class="controls"> 
                                <input type="hidden" name="code" id="code" >
                                <input type="text" maxlength="10" class="form-control" name="contact_phone" value="<?=$postdata['contact_phone']?>" required="required" placeholder="Mobile No" />
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="City "><?= lang("City "); ?> *</label>
                            <div class="controls">
                                <input type="text" class="form-control" name="city" value="<?=$postdata['city']?>" required="required" placeholder="City" id="city" > 
                                <span class="text-danger errormsg" id="city_err"></span>								
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="zip_code"><?= lang("Zip Code"); ?></label>
                            <div class="controls">
                                <input type="text" maxlength="6" required="required" class="form-control" value="<?=$postdata['zip_code']?>" name="zip_code" value="<?php echo set_value('zip_code'); ?>"  placeholder="Zip code " id="zip_code" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="notifi_email"><?= lang("Notification Emails Address"); ?></label>
                            <div class="controls">
                                <input type="email" class="form-control" required="required" value="<?=$postdata['notification_emails']?>" name="notification_emails" placeholder="Notification Emails" id="notifi_email" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="notifi_phone"><?= lang("Notification Mobile No"); ?></label>
                            <div class="controls"> 
                                <input type="text" maxlength="10" required="required" class="form-control" value="<?=$postdata['notification_phones']?>" name="notification_phones" placeholder="Notification Mobile No" id="notifi_phone" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="min_pickup_time"><?= lang("Min Pickup Time"); ?> (In Minutes)</label>
                            <div class="controls">
                                <select name="min_pickup_time" class="form-control" id="min_pickup_time" >
                                    <?php for ($iMinPickupTime = 10; $iMinPickupTime <= 60; $iMinPickupTime += 5) {
                                        $iMinPickupTimeValue = $iMinPickupTime * 60; ?>
                                        <option value="<?php echo $iMinPickupTimeValue; ?>" <?php if ($postdata['min_pickup_time'] && $postdata['min_pickup_time'] == $iMinPickupTimeValue) {
                                            echo 'selected';
                                        } else {
                                            if ($iMinPickupTimeValue == 900) echo 'selected';
                                        } ?>> <?php echo $iMinPickupTime; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="min_delivery_time"><?= lang("Min Delivery Time"); ?> (In Minutes)</label>
                            <div class="controls"> 
                                <select name="min_delivery_time" class="form-control" id="min_delivery_time" >
                                <?php for ($iMinDeliveryTime = 10; $iMinDeliveryTime <= 60; $iMinDeliveryTime += 5) {
                                    $iMinDeliveryTimeValue = $iMinDeliveryTime * 60; ?>
                                        <option value="<?php echo $iMinDeliveryTimeValue; ?>" 
                                    <?php if ($postdata['min_delivery_time'] && $postdata['min_delivery_time'] == $iMinDeliveryTimeValue) {
                                        echo 'selected';
                                    } else {
                                        if ($iMinDeliveryTimeValue == 1800) echo 'selected';
                                    } ?> > <?php echo $iMinDeliveryTime; ?> </option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="min_order_value"><?= lang("Min Order Quantiry"); ?> </label>
                            <div class="controls">
                                <select name="min_order_value" class="form-control" id="min_order_value" >
                                <?php for ($iMinOrdervalue = 0; $iMinOrdervalue <= 100; $iMinOrdervalue++) { ?>
                                    <option value="<?php echo $iMinOrdervalue; ?>" <?= ($postdata['min_order_value'] == $iMinOrdervalue) ? 'Selected' : '' ?>> <?php echo $iMinOrdervalue; ?> </option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="ordering_enabled"><?= lang("Receive Orders"); ?></label>
                            <div class="controls"> 
                                <select name="ordering_enabled" class="form-control" >
                                    <option value="true" <?= ($postdata['ordering_enabled'] == 'true') ? 'Selected' : '' ?>> Enabled </option>
                                    <option value="false" <?= ($postdata['ordering_enabled'] == 'false') ? 'Selected' : '' ?>> Disable </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="geo_longitude"><?= lang("Longitude"); ?></label>
                            <div class="controls">
                                <input type="text" class="form-control"  name="geo_longitude" placeholder="Longitude" value="<?=$postdata['geo_longitude']; ?>"   id="geo_longitude" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"
                                   for="geo_latitude"><?= lang("Latitude"); ?></label>
                            <div class="controls"> 
                                <input type="text" class="form-control"  name="geo_latitude" placeholder="Latitude" value="<?php echo $postdata['geo_latitude']; ?>" id="geo_latitude" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
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

                                function get_times($default = '', $interval = '+30 minutes') {

                                    $output = "<option value=''>Any Time</option>";

                                    $current = strtotime('00:00:00');
                                    $end = strtotime('23:59:00');

                                    while ($current <= $end) {
                                        $time = date('H:i:s', $current);
                                        $sel = ( $time == $default ) ? ' selected' : '';

                                        $output .= "<option value=\"{$time}\"{$sel}>" . date('h.i A', $current) . '</option>';
                                        $current = strtotime($interval, $current);
                                    }

                                    return $output;
                                }
                                ?>
<?php
$DaysArr = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
for ($iDaysArr = 0; $iDaysArr <= 6; $iDaysArr++) {
    ?>
                                    <tr>
                                        <td><input class="checkbox checkdays" type="checkbox" name="Days[]" id="Days_<?php echo $DaysArr[$iDaysArr]; ?>" value="<?php echo $DaysArr[$iDaysArr]; ?>"/></td>
                                        <td><?php echo ucfirst($DaysArr[$iDaysArr]); ?></td>
                                        <td>
                                            <select class="form-control"  name="<?php echo $DaysArr[$iDaysArr]; ?>_start_time" id="<?php echo $DaysArr[$iDaysArr]; ?>_start_time">
    <?php echo get_times(); ?>
                                            </select> 
                                            <span class="text-danger errormsg days_error_msg"  id="<?php echo $DaysArr[$iDaysArr]; ?>_start_time_err"></span>
                                        </td>
                                        <td>
                                            <select class="form-control"  name="<?php echo $DaysArr[$iDaysArr]; ?>_end_time" id="<?php echo $DaysArr[$iDaysArr]; ?>_end_time">
    <?php echo get_times(); ?>
                                            </select>  
                                            <span class="text-danger errormsg days_error_msg"  id="<?php echo $DaysArr[$iDaysArr]; ?>_end_time_err"></span>
                                        </td>
                                    </tr>
                                </tbody>
<?php } ?>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="hidden" name="DaysTime" id="DaysTime" >
                        <button type="submit" class="btn btn-success"> Save </button> 
                        <button type="button" onclick="window.location = '<?= site_url('urban_piper/store_info') ?>'" class="btn btn-primary" > Back </button> 
                    </div>
                </div>
<?= form_close(); ?>
            </div>
        </div>
    </div>    
</div>    

<script>
    
    $('#msgclose').click(function () {
        $('#errormsg').hide();
    });
</script>    
