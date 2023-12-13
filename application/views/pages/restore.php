<div class="content-wrapper">
    <section class="content pt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Revoke Restored cases</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url(); ?>index.php/restore/revoke" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="establishment">Establishment</label>
                                <select name="establishment" id="establishment" class="form-control <?php if(form_error('establishment')):?> is-invalid <?php endif; ?>">
                                    <option value="0">Select Establishment</option>
                                    <?php foreach($establishment as $e): ?>
                                    <option value="<?= $e->est_dbname; ?>" <?php echo set_select('establishment', $e->est_dbname, False); ?>><?= $e->estname; ?></option>    
                                    <?php endforeach; ?>    
                                </select>
                                <span class="invalid-feedback">
                                    <?php echo form_error('establishment'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cino">CINO</label>
                                <input 
                                    type="text" 
                                    class="form-control <?php if(form_error('cino')):?> is-invalid <?php endif; ?>" 
                                    id="cino" 
                                    name="cino" 
                                    value="<?php echo set_value('cino'); ?>"
                                >
                                <span class="help-text">e.g </span>
                                <span class="invalid-feedback">
                                    <?php echo form_error('cino'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mt-4 pt-2">
                                <input type="submit" class="btn btn-success" value="Get Details">
                            </div>
                        </div>
                    </div>
                </form>
                <?php if(isset($cases)): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-secondary">
                            <tr>
                                <th>CINO</th>
                                <th>Filing No</th>
                                <th>Case No</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cases as $c): ?>
                            <tr>
                                <td><?= $c->cino; ?></td>
                                <td><?= $c->filling_no; ?></td>
                                <td><?= $c->case_no; ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-times"></i>
                                        <span>Remove</span>
                                    </button>
                                </td>
                            </tr>    
                            <?php endforeach; ?>    
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>    