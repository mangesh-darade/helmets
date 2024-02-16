<div class="section-heading">
    <i class="fa fa-users" aria-hidden="true"></i>   <?= lang('Group'); ?>
</div>
    <div class="row">
        <div class="form-group ">    
            <div class="col-md-12 text-right" >
              <button type="button" class="btn btn-primary" data-toggle="modal" data-type="add"  data-target="#groupModel" data-value="0"><i class="fa fa-plus"></i> Add New Group</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group text-right">
            <div class="col-md-12" id="group_loader" >&nbsp;</div>
        </div>
    </div>
<div class="col-md-12">
    <div class="row" style="background:#fff;">
        <div class="box">                             
            <div class="box-body table-responsive no-padding" id="groupTableList">
                 
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<div class="modal fade" id="groupModel" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p>Loading.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        function loadGroupForm(g_id,type){
            if(type=='add'){
                var url1 =  "<?= site_url('smsdashboard/groupAdd') ?>";
                $('#groupModel .modal-title').html('Add Group'); 
            }
            else if(type=='edit'){
                var url1 =  "<?= site_url('smsdashboard/groupEdit') ?>?group_id="+g_id
                $('#groupModel .modal-title').html('Edit Group');
            }
            else if(type=='del'){
                var url1 =  "<?= site_url('smsdashboard/groupDelete') ?>?group_id="+g_id
                $('#groupModel .modal-title').html('Delete Group');
            }
             
            $.ajax({
                type: "get",
                async: false,
                url: url1,
                data: "data", 
                success: function (data) {
                     $('#groupModel .modal-body').html(data);
                 },
                error: function () {
                }
            });       
        }
        function loadGroup(){
            $.ajax({
                type: "get",
                async: false,
                url: "<?= site_url('smsdashboard/groupList') ?>",
                data: "data",
                dataType: "json",
                success: function (data) {
                     $('#groupTableList').html(data['res']);
                 },
                error: function () {
                }
            });       
        }
       loadGroup('');
       
    $('#groupModel').on('hidden.bs.modal', function () { 
            loadGroup();
             $.ajax({
                type: "get",
                async: false,
                url: "<?= site_url('smsdashboard/group_list_grid') ?>",
                data: "data",
                dataType: "json",
                success: function (data) {
                    $('ul.contact-group .row').html(data['res']);
                    $('.group_count').val(data['group_count']); 
                     $('.group_submit_button').removeClass("dis_submit");
                    if(data['group_count']==0){ 
                        $('.group_submit_button').addClass("dis_submit");
                    }
                       
                 },
                error: function () {
                }
            });        
            
        }).on('show.bs.modal', function(e) {
            var $invoker = $(e.relatedTarget);
            var gId =  $invoker.attr('data-value');
            var data_type =  $invoker.attr('data-type');
            loadGroupForm(gId,data_type)
        });
        
     
      
    });
</script>