<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    @media screen {
        .KOT_TITLE {
            display: none;
        }
    }
    @media print
    {
        .KOT_TITLE{
            display: block;
        }
    }
    <?php if(strtolower($division->name) == 'drink'){ ?>
        @media screen {
            .print_area{
                display: none;
                width: 100%;
            }
        }
        @media print
        {
            .print_area{
                display: block;
                width: 100%;
            }
        }
    <?php } ?>
</style>
<div class="box">
    <div class="box-header no-print">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?=lang('Division')." : KOT" ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#"  id="print-icon" class="tip print_btn" title="<?= lang('print') ?>">
                        <i class="icon fa fa-print"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <!--p class="introtext"><?= lang('list_results'); ?></p-->


                        <h2 class='KOT_TITLE text-center'>KOT ITEMS</h2>
                    <table  class="table table-responsive" >
                        <thead>
                        <tr>
                            <th class="no-print">Ready</th>
                            <th>Notes</th>
                            <th>Product Name</th>
                            <th class="numeric">Qty</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list as $key=>$items){ ?>
                            <tr>
                                <th colspan="4"><?php echo $key; ?></th>
                            </tr>
                        <?php foreach ($items as $item_key=>$item_val){ $val = (object)$item_val; ?>

                            <tr>
                                <td class="no-print"><input type="checkbox" name="isdelivered"  class="checkbox isdelivered" item_quantity="<?php echo $val->quantity; ?>" item_id="<?php echo $val->id; ?>"></td>
                                <td class="center" data-title="Code"><?php echo $val->table_name." : ".$val->suspend_note; ?></td>
                                <td class="center" data-title="Company"><?php echo $val->product_name; ?></td>
                                <td class="center" data-title="Price" class="numeric"><?php echo ($val->quantity-$val->isdelivered); ?></td>
                            </tr>
                        <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>


            </div>
        </div>
    </div>
</div>


<script>
    $(function(){
        $(document).on('ifUnchecked ifChecked', '.checkbox', function(this_element) {
            //console.log(event);
            var this_element = this;
            if(this_element.checked){
               //console.log();
                var suspend_id = this_element.attributes.item_id.value;
                var item_quantity = this_element.attributes.item_quantity.value;

                $.get( "<?php echo base_url('screens/delivered/');?>"+suspend_id+"/"+item_quantity, function( data ) {
                    this_element.closest('tr').remove();
                });
            }
        });

        // Hook up the print link.
        $(".print_btn" ).attr( "href", "javascript:void( 0 )" ).click(
                function(){
                    window.print();
                    return( false );
        });

        window.setTimeout(function(){window.location.href=window.location.href},(30*1000));
    });
</script>

