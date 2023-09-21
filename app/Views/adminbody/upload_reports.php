<section class="page-content">

    <div class="page-content-inner">

	<section class="panel">

    <div class="panel-heading">

        <h3>

            <?php if($type == "1") { $category = 'UPLOAD PRINCIPAL APPORTIONMENT  (P 1)'; }

            elseif($type == "2") { $category = 'UPLOAD PRINCIPAL APPORTIONMENT  (P 2)'; }

            elseif($type == "3") { $category = 'UPLOAD PRINCIPAL APPORTIONMENT  (P 3)'; }

            elseif($type == "4") { $category = 'UPLOAD ANNUAL AUDIT'; }

            elseif($type == "5") { $category = 'UPLOAD REPORT REVIEW'; }

            elseif($type == "6") { $category = 'UPLOAD FCMAT CALCULATOR'; }

            elseif($type == "7") { $category = 'UPLOAD MISC REPORT'; }

            elseif($type == "8") { $category = 'UPLOAD MISC REPORT'; }

            elseif($type == "9") { $category = 'UPLOAD EXPANDED LEARNING OPPURTUNITIES GRANT PLAN'; }

            elseif($type == "11") { $category = 'UPLOAD Annual Adopted Budget'; }

            elseif($type == "12") { $category = 'UPLOAD Unaudited Actuals'; }

            elseif($type == "13") { $category = 'UPLOAD First Interim'; }

            elseif($type == "14") { $category = 'UPLOAD Second Interim'; }

            elseif($type == "15") { $category = 'UPLOAD Lcap'; }

            elseif($type == "16") { $category = 'UPLOAD Third Interim (Annual)'; }

            else { $category = ''; }



            echo $category;

            ?>

        </h3>

    </div>

    <hr>

    <div class="panel-body">

	<!-- Content Header (Page header) -->

	    <div class="row">

        	<section class="content">

                <form action="<?php echo BASE_URL.'admin/update_upload_reports'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">

                    <div class="row" id="content">

                        <div class="col-md-12">

                            <div class="col-md-6">

                                <div class="row-fluid">

                                    <div class="block">

                                        <div class="block-content collapse in">

                                            <div class="row content_div">

                                                <fieldset style="margin-left: 17px">

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Attach File<span class="required">*</span></b>

                                                        <div class="controls">

                                                            <input type="file" name="file" class="form-control file_principal" value="" required/>

                                                        </div>

                                                    </div>

                                                    <div class="control-group" style="margin-top:30px">

                                                        <b class="control-label">Select School<span class="required">*</span></b>

                                                        <div class="controls">

                                                            <select name="select_school" class="form-control select_school" required>

                                                                <option value="">Select School</option>

                                                                <?php

                                                                if(!empty($select_schools))

                                                                {

                                                                    foreach($select_schools as $school)

                                                                    {

                                                                        $selected = '';

                                                                        if($school['id'] == $_GET['school_id']) { $selected = 'selected'; }

                                                                        

                                                                        echo '<option value="'.$school['id'].'" '.$selected.'>'.$school['school_name'].'</option>';

                                                                    }

                                                                }

                                                                ?>

                                                            </select>

                                                        </div>

                                                    </div>

                                                    <input type="hidden" name="hidden_district_id" id="hidden_district_id" value="<?php echo $_GET['district_id']; ?>">

                                                    <input type="hidden" name="hidden_school_id" id="hidden_school_id" value="<?php echo $_GET['school_id']; ?>">

                                                    <input type="hidden" name="hidden_type" id="hidden_type" value="<?php echo $type; ?>">

                                                    <input type="submit" name="principal_submit" class="btn btn-primary principal_submit" value="Submit" style="margin-top:20px">

                                                </fieldset>



                                                <!-- <h5 style="margin-top:20px">Attached Files</h5>

                                                <table class="table">

                                                    <thead>

                                                        <th>S.No</th>

                                                        <th>Filename</th>

                                                        <th>Date & Time</th>

                                                    </thead>

                                                    <tbody>

                                                        <?php

                                                        $files = $this->db->select('*')->from('principal_attachments')->where('type',$type)->order_by('id','desc')->get()->result_array();

                                                        $i = 1;

                                                        if(!empty($files))

                                                        {

                                                            foreach($files as $file)

                                                            {

                                                                echo '<tr>

                                                                    <td>'.$i.'</td>

                                                                    <td><a href="'.BASE_URL.$file['url'].'/'.$file['filename'].'" download>'.$file['filename'].'</td>

                                                                    <td>'.date('d M Y', strtotime($file['updatetime'])).'</td>

                                                                </tr>';

                                                                $i++;

                                                            }

                                                        }

                                                        ?>

                                                    </tbody>

                                                </table> -->

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </section>

        </div>

    </div>

    </section>

    </div>

</section>

<script>

    $(window).change(function(e) {

        if($(e.target).hasClass('select_district'))

        {

            var value = $(e.target).val();

            if(value != ""){

                $.ajax({

                    url:"<?php echo BASE_URL.'admin/school_lists_checkbox'; ?>",

                    type:"post",

                    data:{district_id:value},

                    success:function(result)

                    {

                        $(".select_schools_div").html(result);

                        $(".content_div").show();

                    }

                })

            }

            else{

                $(".content_div").hide();

                $(".select_schools_div").html("");

            }

        }

    });

</script>