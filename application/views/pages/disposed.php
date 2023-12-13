<div class="content-wrapper">
    <section class="content pt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Disposed Cases</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url(); ?>index.php/disposed/" method="post">
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
                                    <option value="<?php echo $e->est_dbname; ?>" <?php echo set_select('establishment', $e->est_dbname); ?>><?php echo $e->estname; ?></option>
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
                                <select 
                                    class="form-control <?php if(form_error('court_name')):?> is-invalid <?php endif; ?>" 
                                        id="court_name" 
                                        name="court_name">
                                    <option value="0" selected="selected">Select Court Name</option>
                                    <?php foreach($court_name as $c): ?>
                                    <option value="<?php echo $c->desg_code; ?>" <?php echo set_select('court_name', $c->desg_code); ?>><?php echo $c->desgname; ?> - <?php echo $c->judge_name; ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback">
                                    <?php echo form_error('court_name'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header p-2">
                                    <h3 class="card-title ml-3">Date of Decision</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="from-date">Date From (DD-MM-YYYY) <!--<span class="text-danger">**</span>--></label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="to-date">Date To (DD-MM-YYYY) <!--<span class="text-danger">**</span>--></label>
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
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header p-2">
                                    <h4 class="card-title ml-3">Case Registration details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="case_type">Case Type <span class="text-danger">**</span></label>
                                                <select name="case_type" id="case_type" class="form-control <?php if(form_error('case_type')):?> is-invalid <?php endif; ?>">
                                                <option value="" selected>Select Case type</option>
                                                    <?php foreach($case_type as $t): ?>
                                                    <option value="<?php echo $t->case_type; ?>"<?php echo set_select('case_type', $t->case_type); ?>><?php echo $t->type_name; ?> - <?php echo $t->case_type; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
						<span class="invalid-feedback">

                                                    <?php echo form_error('case_type'); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="case_number">Case Number</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="case_number" 
                                                    name="case_number"
                                                    value="<?php echo set_value('case_number'); ?>"
                                                >
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="case_number">Year</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="year" 
                                                    name="year"
                                                    value="<?php echo set_value('year'); ?>"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <input type="hidden" value="<?php echo $cname; ?>" name="cname" id="cname">
                <input type="hidden" value="<?php echo $est; ?>" name="est" id="est">
                <?php endif; ?>
                    <?php if(isset($case_numbers)): ?>
                    <div class="table-reponsive">
                        <table class="table dataTable">
                            <thead class="bg-secondary justify-content-center text-center">
                                <tr>
                                    <th></th>
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
                                        <td><a href="#">
                                            <i class="fa fa-plus-circle text-success m-1 pt-1" style="font-size:18px"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input 
                                                type="text"
                                                name="<?php echo $index; ?>_case_number"
                                                id="<?php echo $index; ?>_case_number"
                                                value="<?php echo $c->reg_number; ?>"
                                                class="form-control"
                                                readonly    
                                            >
                                            <input type="hidden" value="<?php echo $c->cino; ?>" name="cino" id="<?php echo $index; ?>_cino">
                                        </td>
                                        <?php if(!isset($isCaseTypeSubmitted)): ?>
                                        <td>
                                            <select 
                                                name="<?php echo $index; ?>_case_type" 
                                                id="<?php echo $index; ?>_case_type" 
                                                class="form-control"
                                                onChange="updateNature(<?php echo $index; ?>)"
                                            >
                                                <option value="0" selected>Select Case type</option>
                                                <?php foreach($case_type as $t): ?>
                                                <option value="<?php echo $t->case_type; ?>"><?php echo $t->type_name; ?> - <?php echo $t->case_type; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <?php endif; ?>
                                        <td width="250">
                                            <?php if(!isset($isCaseTypeSubmitted)): ?>
                                                <select 
                                                    name="<?php echo $index; ?>_nature" 
                                                    id="<?php echo $index; ?>_nature" 
                                                    class="form-control <?php if($c->case_nature): ?> is-valid<?php endif; ?>"
                                                >
                                                <option value="0" selected>Select Nature</option>
                                                <?php foreach($nature as $n): ?>
                                                    <p><?php echo $c->nature_cd ?> <?php echo $n->nature_cd ?></p>
                                                    <?php if($c->nature_cd==$n->nature_cd && $c->regcase_type==$n->case_type_cd): ?>
                                                        <option value="<?php echo $n->nature_cd; ?>" selected="selected"><?php echo $n->nature_desc; ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $n->nature_cd; ?>"><?php echo $n->nature_desc; ?></option>
                                                    <?php endif; ?>   
                                                <?php endforeach; ?>
                                                </select>    
                                                </select>
                                                
                                            <?php else: ?>
                                                <select 
                                                    name="<?php echo $index; ?>_nature" 
                                                    id="<?php echo $index; ?>_nature" 
                                                    class="form-control <?php if($c->case_nature): ?> is-valid<?php endif; ?>"
                                                >
                                                <option value="0" selected>Select Nature</option>
                                                <?php foreach($nature as $n): ?>
                                                    <?php if($c->nature_cd==$n->nature_cd && $c->regcase_type==$n->case_type_cd): ?>
                                                        <option value="<?php echo $n->nature_cd; ?>" selected="selected"><?php echo $n->nature_desc; ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $n->nature_cd; ?>"><?php echo $n->nature_desc; ?></option>
                                                    <?php endif; ?>   
                                                <?php endforeach; ?>
                                                </select>                   
                                            <?php endif; ?>  
                                        </td>
                                        <td>
                                            <select 
                                                name="<?php echo $index; ?>_prayer"  
                                                id="<?php echo $index; ?>_prayer" 
                                                class="form-control <?php if($c->prayer_type): ?> is-valid<?php endif; ?>"
                                            >
                                                <option value="0" selected>Select Prayer</option>
                                                <?php foreach($prayer as $p): ?>
                                                    <?php if($c->prayercode==$p->prayercode): ?>
                                                        <option value="<?php echo $p->prayercode; ?>" selected="selected"><?php echo $p->prayer_type; ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $p->prayercode; ?>"><?php echo $p->prayer_type; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-success btn-sm btn-block" 
                                                id="<?php echo $index; ?>_submit" 
                                                name="<?php echo $index; ?>_submit" 
                                                value="<?php echo $index; ?>" 
                                                onClick="formSubmit(<?php echo $index; ?>)"
                                            >
                                                <i class="fa fa-check mr-2" id="<?php echo $index; ?>_icon"></i>
                                                <span id="<?php echo $index; ?>_btn-text">Update</span>
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
