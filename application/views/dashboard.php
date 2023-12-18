<?php $this->load->view('templates/header', ['title' => 'Scrutiny']); ?>
<div class="content-wrapper">
    <section class="content pt-3">
        <?php print_r($this->session->userdata()); ?>
    </section>
</div>
<?php $this->load->view('templates/footer'); ?>