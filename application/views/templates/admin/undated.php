<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Undated Cases</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Undated Cases</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Undated Cases</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                        <?php foreach($report as $data): ?>
                            <table class="table table-bordered table-striped mt-4">
                                <thead class="text-center">
                                    <tr class="bg-light">
                                        <td colspan="5" class="">
                                            <strong><?php if(isset($data[0])): echo $data[0]->court_name; endif; ?></strong>
                                        </td>				
                                    </tr>	
                                    <tr class="bg-secondary text-white">
                                        <th scope="col">S.&nbsp;No</th>
                                        <th scope="col" style="width:600px">Court Name</th>
                                        <th scope="col">Civil</th>
                                        <th scope="col">Criminal</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $count = 1; 
                                        $civil_total = 0; 
                                        $criminal_total = 0;
                                        $grand_total =0;
                                    ?>
                                    <?php foreach($data as $r): ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $r->desgname; ?></td>
                                        <td><?php echo $r->civil; ?></td>
                                        <td><?php echo $r->criminal; ?></td>
                                        <td><?php echo $r->total; ?></td>
                                        <?php 
                                            $civil_total += $r->civil; 
                                            $criminal_total += $r->criminal;
                                            $grand_total += $r->total;
                                        ?>
                                    </tr>
                                    <?php $count++; ?>
                                    <?php endforeach; ?>
                                    <tr style="font-weight:bold">
                                        <td colspan="2" style="text-align:right">Total</td>
                                        <td><?php echo $civil_total; ?></td>
                                        <td><?php echo $criminal_total; ?></td>
                                        <td><?php echo $grand_total; ?></td>
                                    </tr>
                                <tbody>
                            </table>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <div>
            </div>
        </div>
    </section>
</div>