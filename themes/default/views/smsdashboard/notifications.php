<div class="section-heading">
  <i class="fa fa-bell" aria-hidden="true"></i>    Default Template
</div>
<div class=" row">
    <div class="col-md-12">
        <div class="box"  style="background:#fff;">                             
            <div class="box-body table-responsive no-padding" id="templateTableListD"></div> 
        </div>
    </div>
</div>

<div class=" row">
    <div class="col-md-12" >&nbsp;</div>
</div>
    
<div class="section-heading">
  <i class="fa fa-bell" aria-hidden="true"></i>   Notifications Date : <?php echo date("d-m-Y"); ?> 
</div>

  <div class=" row">
     <div class="col-md-12" > 
     	<div class="box" style="background:#fff;margin-bottom: 0;border: none;">  
     	  <?php echo isset($notification) ? $this->sma->contactEventNotification($notification):'';?> 
     	</div>  
     </div>
  </div>


<div class="modal fade" id="template_d_Model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p>This is a large modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        function loadTemplate_Form_d(g_id,type){ 
             var url1 =  "<?= site_url('smsdashboard/templateEdit') ?>?template_id="+g_id
             $('#template_d_Model .modal-title').html('Edit Template');
             
            $.ajax({
                type: "get",
                async: false,
                url: url1,
                data: "data", 
                success: function (data) { 
                     $('#template_d_Model .modal-body').html(data);
                 },
                error: function () {
                }
            });       
        }
        
        function loadTemplate_d(){
            
            var turl ='<?= site_url('smsdashboard/templateList') ?>?is_default=1';
            $('#templateTableListD').html('<i class="fa fa-spinner" aria-hidden="true"></i>');
            $.ajax({
                type: "get",
                async: false,
                url: turl,
                data: "data",
                dataType: "json",
                success: function (data) {
                     $('#templateTableListD').html(data['res']);
                 },
                error: function () {
                }
            });       
       }
       
       loadTemplate_d();
       
       $('#template_d_Model').on('hidden.bs.modal', function () { 
            loadTemplate_d();
        }).on('show.bs.modal', function(e) { 
            var $invoker = $(e.relatedTarget);
            var gId =  $invoker.attr('data-value');
            var data_type =  $invoker.attr('data-type');
            loadTemplate_Form_d(gId,'')
        });
        
    });
</script>