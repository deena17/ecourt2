<div class="content-wrapper">
    <section class="content pt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Disposed Cases</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url(); ?>index.php/disposed/" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="establishment">Establishment <span class="text-danger">**</span></label>
                                <select 
                                    class="form-control <?php if(form_error('establishment')):?> is-invalid <?php endif; ?>" 
                                    id="establishment"
                                    name="establishment"
                                    readonly
                                >
                                    <!-- <option value="0" selected="selected">Select Establishment</option> -->
                                    <?php foreach($establishment as $e): ?>
                                    <option value="<?= $e->est_dbname; ?>" <?php echo set_select('establishment', $e->est_dbname); ?>><?= $e->estname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback">
                                    <?php echo form_error('establishment'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="court-name">Court Name <span class="text-danger">**</span></label>
                                <select class="form-control <?php if(form_error('court_name')):?> is-invalid <?php endif; ?>" id="court_name" name="court_name">
                                    <option value="0" selected="selected">Select Court Name</option>
                                    <?php foreach($court_name as $c): ?>
                                    <option value="<?= $c->desg_code; ?>" <?php echo set_select('court_name', $c->desg_code); ?>><?= $c->desgname; ?> - <?= $c->judge_name; ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback">
                                    <?php echo form_error('court_name'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="from-date">Date From (DD-MM-YYYY) <span class="text-danger">**</span></label>
                                <input 
                                    type="text" 
                                    class="form-control datepicker <?php if(form_error('from_date')):?> is-invalid <?php endif; ?>" 
                                    id="from_date" 
                                    name="from_date"
                                    value="<?php echo set_value('from_date'); ?>"
                                >
                                <span class="invalid-feedback">
                                    <?php echo form_error('from_date'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="to-date">Date To (DD-MM-YYYY) <span class="text-danger">**</span></label>
                                <input 
                                    type="text" 
                                    class="form-control datepicker <?php if(form_error('from_date')):?> is-invalid <?php endif; ?>" 
                                    id="to_date" 
                                    name="to_date"
                                    value="<?php echo set_value('to_date'); ?>"
                                >
                                <span class="invalid-feedback">
                                    <?php echo form_error('to_date'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="case_type">Case Type</label>
                            <select name="case_type" id="case_type" class="form-control">
                            <option value="0" selected>Select Case type</option>
                                <?php foreach($case_type as $t): ?>
                                <option value="<?= $t->case_type; ?>"<?php echo set_select('case_type', $t->case_type); ?>><?= $t->type_name; ?> - <?= $t->case_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="case_number">Case Number</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="case_number" 
                                name="case_number"
                                value="<?= set_value('case_number'); ?>"
                            >
                        </div>
                        <div class="col-md-2">
                            <label for="case_number">Year</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="year" 
                                name="year"
                                value="<?= set_value('year'); ?>"
                            >
                        </div>
                        <div class="col-md-2 pt-3">
                            <div class="form-group">
                                <button class="btn btn-info btn-block" type="submit" id="" name="">Get Details</button>
                            </div>
                        </div>
                        <div class="text-danger mt-4 ml-2"><strong>** Mandatory fields</strong></div>
                    </div>
                    
                </form>
                <div id="grid pt-3">
                <div class="alert alert-dismissible" style="display:none" id="dis-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span id="alert-text"></span>
                </div>
                <?php if(isset($est) && isset($cname)): ?>
                <input type="hidden" value="<?= $cname; ?>" name="cname" id="cname">
                <input type="hidden" value="<?= $est; ?>" name="est" id="est">
                <?php endif; ?>
                    <?php if(isset($case_numbers)): ?>
                    <div class="table-reponsive">
                        <table class="table dataTable">
                            <thead class="bg-secondary justify-content-center text-center">
                                <tr>
                                    <th width="150">Registration Number</th>
                                    <?php if(!isset($isCaseTypeSubmitted)): ?><th>Case Type</th><?php endif; ?>
                                    <th>Nature</th>
                                    <th>Prayer</th>
                                    <th class="px-1" width="100">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index=1; foreach($case_numbers as $c): ?>
                                    <tr>
                                        <td>
                                            <input 
                                                type="text"
                                                name="<?= $index; ?>_case_number"
                                                id="<?= $index; ?>_case_number"
                                                value="<?= $c->reg_number; ?>"
                                                class="form-control"
                                                readonly    
                                            >
                                            <input type="hidden" value="<?= $c->cino; ?>" name="cino" id="<?= $index; ?>_cino">
                                        </td>
                                        <?php if(!isset($isCaseTypeSubmitted)): ?>
                                        <td>
                                            <select 
                                                name="<?= $index; ?>_case_type" 
                                                id="<?= $index; ?>_case_type" 
                                                class="form-control"
                                                onChange="updateNature(<?= $index; ?>)"
                                            >
                                                <option value="0" selected>Select Case type</option>
                                                <?php foreach($case_type as $t): ?>
                                                <option value="<?= $t->case_type; ?>"><?= $t->type_name; ?> - <?= $t->case_type; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <?php endif; ?>
                                        <td width="250">
                                            <?php if(!isset($isCaseTypeSubmitted)): ?>
                                                <select name="<?= $index; ?>_nature" id="<?= $index; ?>_nature" class="form-control">
                                                    <option value="0" selected>Select Nature</option>
                                                </select>
                                            <?php else: ?>
                                                <select name="<?= $index; ?>_nature" id="<?= $index; ?>_nature" class="form-control">
                                                <option value="0" selected>Select Nature</option>
                                                <?php foreach($nature as $n): ?>
                                                <option value="<?= $n->nature_cd; ?>"><?= $n->nature_desc; ?></option>
                                                <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>    
                                        </td>
                                        <td>
                                            <select name="<?= $index; ?>_prayer" id="<?= $index; ?>_prayer" class="form-control">
                                                <option value="0" selected>Select Prayer</option>
                                                <?php foreach($prayer as $p): ?>
                                                <option value="<?= $p->prayercode; ?>"><?= $p->prayer_type; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-success btn-sm btn-block" 
                                                id="<?= $index; ?>_submit" 
                                                name="<?= $index; ?>_submit" 
                                                value="<?= $index; ?>" 
                                                onClick="formSubmit(<?= $index; ?>)"
                                            >
                                                <i class="fa fa-check mr-2" id="<?= $index; ?>_icon"></i>
                                                <span id="<?= $index; ?>_btn-text">Update</span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php $index++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>