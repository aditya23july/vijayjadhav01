
<div id="content" class="site-content" tabindex="-1">
    <?php 
    $datarow = $this->db->query("select * from tbl_content_management where id='$id'")->row();
    echo $datarow->data;
   
    ?>
</div><!-- #content -->
