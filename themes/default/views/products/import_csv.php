<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('import_products_by_csv'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <?php
                $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("products/import_csv", $attrib);
                $MerchantFields = '';
		$CSVFileName = '';
		if($this->Settings->pos_type=='restaurant'){
			$MerchantFields = ', ' . lang("up_items"). ', ' . lang("food_type_id"). ', ' . lang("up_price"). ', ' . lang("available");
			$CSVFileName = '_restaurant';
		}
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="well well-small">
                            <a href="<?php echo base_url(); ?>assets/csv/sample_products<?php echo $CSVFileName; ?>.xlsx"
                               class="btn btn-primary pull-right"><i
                                    class="fa fa-download"></i> <?= lang("download_sample_file") ?></a>
                            <span class="text-warning"><?= lang("csv1"); ?></span><br/><?= lang("csv2"); ?> <span
                                class="text-info">(<?= lang("name") . ', ' . lang("code"). ', ' . lang("divisionid") . ',  Article Code, ' . lang("barcode_symbology") . ', ' .  lang("brand") . ', ' . lang("category_code") . ', ' . lang("unit_code") . ', ' . lang("sale").' '.lang('unit_code') . ', ' . lang("purchase").' '.lang("unit_code") . ', ' .  lang("cost") . ', ' . lang("price") . ', ' . lang("alert_quantity") . ', ' . lang("tax") . ', ' . lang("tax_method") . ', ' . lang("image") . ', ' . lang("subcategory_code") . ', ' . lang("product_variants_sep_by"). ', ' . lang("MRP_Price"). ', ' . lang("HSN_Code"). ', ' . lang("Warehouse"). ', ' . lang("Quantity"). ', ' . lang("pcf1"). ', ' . lang("pcf2"). ', ' . lang("pcf3"). ', ' . lang("pcf4"). ', ' . lang("pcf5"). ', ' . lang("pcf6") .$MerchantFields ; ?>
                                )</span> <?= lang("csv3"); ?>
                                <p><?= lang('images_location_tip'); ?></p>
								<?php if($this->Settings->pos_type=='restaurant'){ ?>
                                <p><b>Note:</b> The Division Ids and Food type should be filled in the following format: </p>
				<p>For Division Ids : Kitchen - 1, Bar - 2, Lounge -3, Terrace - 4, No print - 5</p>
								<p>For food type : Vegeterian = 1, Non vegeterian = 2, Eggeterian = 3, Not specified = 4</p> <?php } ?>
<?php
									if(!empty($ProductCustomField)){
										echo '<p>For Custom Field Identification: ';
										foreach($ProductCustomField as $keyCustomeField){
											echo $keyCustomeField['custom_field'].'='.$keyCustomeField['display_custom_field'].', ';
										}
										echo '</p>';
									}
								?>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="csv_file"><?= lang("upload_file"); ?></label>
                                <input type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" class="form-control file" data-show-upload="false" data-show-preview="false" id="csv_file" required="required"/>
                            </div>

                            <div class="form-group">
                                <?php echo form_submit('import', $this->lang->line("import"), 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>