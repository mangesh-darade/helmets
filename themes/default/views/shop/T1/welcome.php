<?php include_once 'header.php'; ?>
<div id="modalDialog" class="modal fade" role="dialog">
    <div class="modal-dialog" id="bootstrapAlert"></div>
</div>
    <section class="middle_section"><!--Middle section view-->
        <div class="container">
            <?php
            
                switch($Settings->pos_type) {
                    
                    case 'pharma':
                        include_once 'welcome_pharma.php'; 
                    break;
                
                    case 'grocery':
                        include_once 'welcome_grocery.php'; 
                    break;
                
                    case 'bakery':
                        include_once 'welcome_bakery.php'; 
                    break;
                
                    case 'electronics':
                        include_once 'welcome_electronics.php'; 
                    break;
                
                    case 'hardware':
                        include_once 'welcome_hardware.php'; 
                    break;
                
                    case 'restaurant':
                        include_once 'welcome_restaurant.php'; 
                    break;
                
                    case 'stationery':
                        include_once 'welcome_stationery.php'; 
                    break;
                
                    case 'furniture':
                        include_once 'welcome_furniture.php'; 
                    break;
                
                    case 'apparel':
                        include_once 'welcome_apparel.php'; 
                    break;
                
                    case 'sport':
                        include_once 'welcome_sport.php'; 
                    break;
                
                    case 'electrical':
                        include_once 'welcome_common.php'; 
                    break;
                
                    case 'jewellery':
                        include_once 'welcome_common.php'; 
                    break;

                    default:                       
                        include_once 'welcome_common.php';                        
                    break;
                }//end switch.
            ?>
          
        </div>             
    </section><!--/Middle section view-->
    <input type="hidden" id="baseurl" value="<?= $baseurl;?>" />
    <input type="hidden" id="catId" value="<?= $default_category;?>" />
    <input type="hidden" id="page" value="<?= $page_no;?>" />
    <input type="hidden" id="limit" value="<?= $per_page_items;?>" />
    
<?php include_once 'footer.php'; ?>
    
 <script>
        
    $(document).ready(function(){
                
        // Check browser support
        if (typeof(Storage) !== "undefined") {

            var baseUrl = $('#baseurl').val();

            getAllCategory(baseUrl);                    
            // Retrieve
           // $('#modalDialog').modal('show');

           // var ShowData = '<div class="modal-content"><div class="modal-body">' + sessionStorage.getItem('category') + '</div></div>';

            //document.getElementById("bootstrapAlert").innerHTML = ShowData;

        } else {
            $('#modalDialog').modal('show');
            document.getElementById("bootstrapAlert").innerHTML = "<div class='alert alert danger'>Sorry, your browser does not support Web Storage. Please use suporting browser.</div>";
        }
    
    });
        
</script>