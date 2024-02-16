<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .btn-small{padding: 1px 5px;
               border-radius: 4px !important;
               font-size: 12px;}
    .loaderclass{position:absolute;left:0;right:0;top:0;bottom:0;margin:auto; background: #FFF; }

</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode" style="text-transform: capitalize;"></i>Store: <?=$store->name?> / <?= lang('Categories') ?> 
        </h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <button type="button" id="category_add" class="btn btn-primary"   ><i class="fa fa-plus"></i> Import Category</button>
                </li>
            </ul>
        </div>  
    </div>
    <div class="box-content">
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form'); //
        echo form_open("urban_piper/category/$store_id", $attrib);
        echo form_hidden('store_id', $store_id); 
        ?>
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
                    <?php } else if ($this->session->flashdata('errors')) { ?>
                    <div class="alert alert-danger" id="errormsg">
                        <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                    <?= $this->session->flashdata('errors') ?>            
                    </div>
                <?php } ?>
                <div id="showmsg"></div>
                <div class="table-responsive" id="category_list">
                <table id="categorylist" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: left;"><input class="checkbox checkft input-xs" type="checkbox" name="check" id="select_all"/> &nbsp; Sr.No. </th>
                            <th>Image</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Parent Category</th> 
                            <th>Status</th>
                            <th>Add Status</th>
                            <th>Products</th>
                        </tr>
                    </thead>  
                    <tbody>                    
                <?php
                
//                echo '<pre>';
//                print_r($categoryList);
//                echo '</pre>';
//                exit;
                    $sr=1;
                   
                    foreach($categoryList as $category){
                        $imgcat = $category->image;
                        if($category->image){
                            if(!file_exists('assets/uploads/thumbs/'.$imgcat)){
                                $imgcat ='no_image.png';
                            }
                        }else{
                            $imgcat ='no_image.png';
                        }
                        
                        $tabledata.='<tr>';
                            $tabledata.='<td> <input class="checkbox valpass  multi-select input-xs" type="checkbox" onclick="myfunction()" value="'.$category->id.'" name="val[]" id="check_box_" /> &nbsp; ' .$sr.'</td>';
                            $tabledata.='<td class="text-center"> <img src="'.base_url('assets/uploads/thumbs/').$imgcat.'" style="height:32px;"> </td>';
                            $tabledata.='<td>'.$category->code.'</td>';
                            $tabledata.='<td>'.$category->name.'</td>';
                            $tabledata.='<td>'.(($category->parent_id) ? $categoryList[$category->parent_id]->name :'-').'</td>';
                            $tabledata.='<td class="text-center" id="tdstatus_'.$category->id.'">';
                                if($category->up_added=='1'){
                                    if($category->up_is_active=='1'){
                                        $tabledata.='<span class=" btn  btn-success btn-small" onclick="changeStatusStoreCategory(\''.$category->id.'\',\''.$store_id.'\', \'disable\')" > Enabled</span>';
                                    } else {
                                        $tabledata.='<span class="btn btn-danger btn-small" onclick="changeStatusStoreCategory(\''.$category->id.'\',\''.$store_id.'\', \'enabled\')"> Disable</span>';
                                    }
                                } 
//                                 
                            $tabledata.='</td>';
                            $tabledata.='<td class="text-center">';
                                if($category->up_added=='1') {
                                     $tabledata.='<span class="btn btn-primary btn-small" onclick="addStoreCategory(\''.$category->id.'\',\''.$store_id.'\')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </span> ';
                                } else {
                                    $tabledata.='<span class="btn btn-danger btn-small" onclick="addStoreCategory(\''.$category->id.'\',\''.$store_id.'\')">Add</span>';
                                }
                            $tabledata.='</td>'; 
                            $tabledata.='<td><a href="'.base_url("urban_piper/platfrom_product_list/$store_id/".$category->id).'" class="btn btn-default">Products</a></td>'; 
                            
                        $tabledata.='</tr>';
                        $sr++;
                    }
                    echo $tabledata;
                    ?>
                    </tbody> 
                </table>    
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <strong> Action by urbanpiper </strong>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="actionvalue" name="action" required="true">
                            <option value="">-- Select --</option>
                            <option value="Add_category">Add</option>
                            <option value="Enable_category">Enable</option>
                            <option value="Disable_category">Disable</option>
<!--                        <option value="Delete_category">Delete</option>     -->
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary" id="btnaction"> Go</button>
                    </div>
                </div>
            </div>
        </div>
<?= form_close(); ?>  
    </div>    
</div>
<!-- Message Modal -->
<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modeltitle"></h4>
            </div>
            <div class="modal-body">
                <h3 class="text-center" id="showmsg"></h3>
            </div>
            <div class="modal-footer">
                <span id="okbtn"></span>
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Message model --->

<script type="text/javascript">
    
    $(document).ready(function() {
         $('#categorylist').DataTable();
       // getcategory('<?= $store_id ?>');
    });

//    // Get the modal
//    var modal = document.getElementById('myModal');
//
//    // Get the button that opens the modal
//    var btn = document.getElementById("myBtn");
//
//    // Get the <span> element that closes the modal
//    var span = document.getElementsByClassName("close")[0];
//
//    // When the user clicks on the button, open the modal 
//
//
//    // When the user clicks on <span> (x), close the modal
//    span.onclick = function () {
//        modal.style.display = "none";
//    }
//
//    $('#closemodel').click(function () {
//        modal.style.display = "none";
//    });
//    // When the user clicks anywhere outside of the modal, close it
//    window.onclick = function (event) {
//        if (event.target == modal) {
//            modal.style.display = "none";
//        }
//    }

    // Bulk Action 
    $('#btnaction').click(function () {
        if ($('#actionvalue').val() == '') {
            $('#modeltitle').html('message');
            $('#showmsg').html('<div class="alert alert-info">Please select action by urbanpiper </div>');
            modal.style.display = "block";
            $('#okbtn').html('');
            return false;
        } else {
            return true;
        }
    });
    // End Bulk Action

    function category_status(keytype, actKey, catId, action, storeid) {
        var args = arguments;
        var passdata = 'onclick="action_call(\'' + actKey + '\',\'' + catId + '\',\'' + action + '\',\''+storeid+'\')"';
        $('#modeltitle').html('confirmation');
        $('#showmsg').html('<div class="alert alert-warning">Are you sure ' + action + ' category on sales portal?</div>');
        modal.style.display = "block";
        $('#okbtn').html('<button type="button" class="btn btn-success" ' + passdata + '>Ok</button>');
    }

    
    function addStoreCategory(category_id, store_id){
        
        if(confirm('Are you sure add store category on sales portal?')) {
        
       var postUrl = '<?= site_url("urban_piper/AddUpStoreCategories/") ?>'+ category_id + "/" + store_id;
       
            $.ajax({
                type: 'ajax',
                dataType: 'json',
                url: postUrl,
                async: false,
                success: function (result) {
 
                    //$('#ajaxCall').hide();
                    if (result.status == 'success') {
                        $('#showmsg').html('<div class="alert alert-success"> ' + result.messages + '</div>');                    
                    } else {
                        $('#showmsg').html('<div class="alert alert-danger"> ' + result.messages + '</div>');
                    }

                   // $('#modeltitle').html('message');
                   // modal.style.display = "block";

                }, error: function () {
                   // $('#ajaxCall').hide();
                    console.log('error');
                }
            });
        
        } else {
            return false;
        }
        
    }
    
    function changeStatusStoreCategory(category_id, store_id, newstatus){
        
        $('#showmsg').html(''); 
        if(confirm('Are you sure to make '+newstatus+' category on sales portal?')) {
            
            $('#tdstatus_'+category_id).html('<img src="<?= base_url('assets/images/ajax-loader.gif'); ?>" alt="Please Wait.." />');
           
            var postUrl = '<?= site_url("urban_piper/AddUpStoreCategories/") ?>'+ category_id + "/" + store_id+ "/" + newstatus;
         
            $.ajax({
                type: 'ajax',
                dataType: 'json',
                url: postUrl,
                async: false,
                success: function (result) {  
                    $('#ajaxCall').hide();
                    
                    if (result.status == 'success') {
                        
                        $('#showmsg').html('<div class="alert alert-success"> ' + result.messages + '</div>'); 
                        
                            if(newstatus == 'disable'){ 
                                btnname = 'Disable';
                                classnm = 'btn-danger';
                                newstatus = 'enabled';
                            } else {
                                btnname = 'Enable';
                                classnm = 'btn-success';
                                newstatus = 'disable';
                            } 
                            var changebtn ='<span class="btn '+classnm+' btn-small" onclick="changeStatusStoreCategory(\''+category_id+'\',\''+store_id+'\', \''+newstatus+'\')" > '+btnname+'</span>';
                            
                            $('#tdstatus_'+category_id).html(changebtn);
                            
                       
                    } else {
                            
                            $('#showmsg').html('<div class="alert alert-danger"> ' + result.messages + '</div>');
                             
                            if(newstatus == 'disable'){ 
                                btnname = 'Enable';
                                classnm = 'btn-success';
                            } else {
                                btnname = 'Disable';
                                classnm = 'btn-danger';
                            }
                            
                            var changebtn ='<span class="btn '+classnm+' btn-small" onclick="changeStatusStoreCategory(\''+category_id+'\',\''+store_id+'\', \''+newstatus+'\')" > '+btnname+'</span>';
                            
                            $('#tdstatus_'+category_id).html(changebtn);    
                       
                    }

//                    $('#modeltitle').html('message');
//                    modal.style.display = "block";

                }, error: function () {
                    //$('#ajaxCall').hide();
                    console.log('error');
                }
            });
        
        } else {
            return false;
        }
        
    }


    function add_up_category(category_id, store_id) {
        
        var passdata = 'onclick="api_action_call(\'add_store_category\', \'' + category_id + '\', \'' + store_id + '\')"';
        
        $('#modeltitle').html('confirmation');
        $('#showmsg').html('<div class="alert alert-warning">Are you sure add store category on sales portal?</div>');
        modal.style.display = "block";
        $('#okbtn').html('<button type="button" class="btn btn-success" ' + passdata + '>Ok</button>');
    }

    function api_action_call(api_action, category_id, store_id) {

        $('#ajaxCall').show();

        //var para = api_action + "/" + category_id + "/" + store_id;
        var para = category_id + "/" + store_id;
         
        setTimeout(function () {
            $.ajax({
                type: 'ajax',
                dataType: 'json',
                url: '<?= site_url("urban_piper/AddUpStoreCategories/") ?>' + para,
                async: false,
                success: function (result) {
                    $('#ajaxCall').hide();
                    if (result.status == 'success') {
                        $('#showmsg').html('<span class="text-success"> ' + result.messages + '</span>');
                        setTimeout(function () {
                            getcategory(store_id);
                        }, 1000);
                    } else {
                        $('#showmsg').html('<span class="text-danger"> ' + result.messages + '</span>');
                    }

                    $('#modeltitle').html('message');
                    modal.style.display = "block";

                }, error: function () {
                    $('#ajaxCall').hide();
                    console.log('error');
                }
            });
            $('#okbtn').html('');
        }, 100);

    }


    function action_call(actKey, catId, action, storeId) {
        $('#ajaxCall').show();
        var pass = '';
        pass = actKey;
        if (catId) {
            pass += "/" + catId;
        }
        if (action) {
            pass += "/" + action;
        }
        if (storeId) {
            pass += "/" + storeId;
        }
        
        setTimeout(function () {
            $.ajax({
                type: 'ajax',
                dataType: 'json',
                url: '<?= site_url("urban_piper/action/") ?>' + pass,
                async: false,
                success: function (result) {
                    $('#ajaxCall').hide();
                    if (result.status == 'success') {
                        $('#showmsg').html('<span class="text-success"> ' + result.messages + '</span>');
                        setTimeout(function () {
                            getcategory('<?=$store_id?>');
                        }, 1000);
                    } else {
                        $('#showmsg').html('<span class="text-danger"> ' + result.messages + '</span>');
                    }

                    $('#modeltitle').html('message');
                    modal.style.display = "block";

                }, error: function () {
                    $('#ajaxCall').hide();
                    console.log('error');
                }
            });
            $('#okbtn').html('');
        }, 100);

    }

    function getcategory(store_id) {

        $.ajax({
            type: 'ajax',
            dataType: 'json',
            async: false,
            url: '<?= site_url('/urban_piper/getCategories/') ?>' + store_id,
            success: function (result) {
                $('#category_list').html(result);
            }, error: function () {
                console.log('error');
            }
        });
        $('#categorylist').DataTable();
    }

    // Category add 
    $('#category_add').click(function () {
        $('#ajaxCall').show();
        setTimeout(function () {
            $.ajax({
                type: 'ajax',
                dataType: 'json',
                url: '<?= site_url("urban_piper/importStoreCategory/" . $store_id) ?>',
                async: false,
                success: function (result) {
                    if (result.status == 'success') {
//	                    $('#showmsg').html('<span class="text-success"> '+result.messages+'</span>');
                        setTimeout(function () {
                            getcategory('<?= $store_id ?>');
                        }, 1000);
                    } else {
                        alert(result.messages);
                        console.log(result.messages);
                    }
//                       $('#modeltitle').html('message');
//	               modal.style.display = "block";
                }, error: function () {
                    console.log('error');
                }
            });
        }, 100);
    });

    $('#msgclose').click(function () {
        $('#errormsg').hide();
    });

</script>    
