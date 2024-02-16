 <?php include_once 'header.php'; ?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Order Details (Reff. No: <?= $order['sale']['reference_no'];?>) </h4>
    </div>
     
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>

<?php include_once 'footer.php'; ?>