<div class="section-heading">
    <i class="fa fa-file-text" aria-hidden="true"></i>   <?= lang('Template'); ?>
</div>
<div class="row">
    <div class="form-template ">    
        <div class="col-md-12 text-right" >
          <button type="button" class="btn btn-primary" data-toggle="modal" data-type="add"  data-target="#templateModel" data-value="0"><i class="fa fa-plus"></i> Add New Template </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-template text-right">
        <div class="col-md-12" id="template_loader" >&nbsp;</div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="box" style="background:#fff;">                             
            <div class="box-body table-responsive no-padding" id="templateTableList">
                 
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<div class="modal fade" id="templateModel" role="dialog">
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
        function loadTemplateForm(g_id,type){ 
            if(type=='add'){
                var url1 =  "<?= site_url('smsdashboard/templateAdd') ?>";
                $('#templateModel .modal-title').html('Add Template'); 
            }
            else if(type=='edit'){
                var url1 =  "<?= site_url('smsdashboard/templateEdit') ?>?template_id="+g_id
                $('#templateModel .modal-title').html('Edit Template');
            }
            else if(type=='del'){
                var url1 =  "<?= site_url('smsdashboard/templateDelete') ?>?template_id="+g_id
                $('#templateModel .modal-title').html('Delete Template');
            }
             
            $.ajax({
                type: "get",
                async: false,
                url: url1,
                data: "data", 
                success: function (data) {
                     $('#templateModel .modal-body').html(data);
                 },
                error: function () {
                }
            });       
        }
        function loadTemplate(type){
            var tType = type;
            var turl ='<?= site_url('smsdashboard/templateList') ?>?tType='+tType;
            $('#templateTableList').html('<i class="fa fa-spinner" aria-hidden="true"></i>');
            $.ajax({
                type: "get",
                async: false,
                url: turl,
                data: "data",
                dataType: "json",
                success: function (data) {
                     $('#templateTableList').html(data['res']);
                 },
                error: function () {
                }
            });       
       }
       loadTemplate('');
       $('#templateModel').on('hidden.bs.modal', function () { 
            loadTemplate('');
            $.ajax({
                type: "get",
                async: false,
                url: "<?= site_url('smsdashboard/template_list_grid') ?>",
                data: "data",
                dataType: "json",
                success: function (data) {
                     console.log(data);
                     $('.sms_template').html(data['res_1']);
                     $('.email_template').html(data['res_2']);
                     $('.appmsg_template').html(data['res_3']);
                 },
                error: function () {
                }
            });      
        }).on('show.bs.modal', function(e) { 
            var $invoker = $(e.relatedTarget);
            var gId =  $invoker.attr('data-value');
            var data_type =  $invoker.attr('data-type');
            loadTemplateForm(gId,data_type)
        });
    });
</script>