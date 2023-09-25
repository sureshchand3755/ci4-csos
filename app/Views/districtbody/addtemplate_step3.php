<?php 
$this->db = \Config\Database::connect();
?>
<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <hr>
<style>
.inside_table_div
{
	min-width:1500px;
}
textarea{  
  /* box-sizing: padding-box; */
  overflow:hidden;
  display:block;
  resize: none;
}
.readonly{
  pointer-events: none;
}
.readonly .slider{
  background: #dfdfdf !important;
}
.readonly .slider:before{
  background: #000 !important;
}
input:checked + .slider{
      background-color: #2196F3 !important;
}
.priority_class{
	padding: 7px 10px;
	margin-top: 2px;
    background: #ffffff;
    font-size: 1rem;
}
.summary_label{
	font-size:18px;
	font-weight:800;
	margin-top:20px;
}
.input_title_section{
	width:90%;
	float:right;
	height:38px;
}
.input_subtitle_section{
	width:96%;
	float:right;
	height:38px;
}
.input_new_section{
	width:96%;
	float:right;
	height:38px;
}
	.form-control{
		border:1px solid #dfdfdf;
	}
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 20px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 15px;
  left: 0px;
  bottom: 3px;
  background-color: red;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.disabled{
  cursor:pointer;
  background: #000;
}
</style>
<div class="modal fade alert_modal_submit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:999999999">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="exampleModalLabel">Alert</h4>
        </div>
        <div class="modal-body">
          <div class="sub_title3 alert_content_submit" style="line-height: 25px;">
            
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="common_black_button yes_hit_submit">Yes</button>
            <button type="button" class="common_black_button no_hit_submit">No</button>
        </div>
      </div>
    </div>
</div>
    <div class="panel-body">
	<!-- Content Header (Page header) -->
	    <div class="row">
        	<section class="content">
        	    <!-- Small boxes (Stat box) -->
                     <!-- BEGIN FORM-->
                    <form action="<?php echo BASE_URL.'district/save_template_content_step3'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BASE_URL.'district/addtemplate/'.$template_id; ?>">Step 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BASE_URL.'district/addtemplate_step2/'.$template_id; ?>">Step 2</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link link_active active" href="javascript:">Step 3</a>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">
                                    <div class="tab-pane active main_table_row" id="home1" role="tabpanel" aria-expanded="false">
                                    	<?php
                                    	if($templates['school_id'] != '0')
                                    	{
                                    		$school_details = $this->db->table('go_schools')->select('*')->where('id', $templates['school_id'])->get()->getRowArray();

											$district_details = $this->db->table('go_schools')->select('*')->where('id', $school_details['district_id'])->get()->getRowArray();

											
                                    	}
                                    	
                                    	if($templates['status'] > 1) { $disabled = 'readonly'; }
                                    	else{ $disabled = ''; }
                                    	?>
                                    	<div class="col-md-12">
                                    		<h5>Legend</h5>
                                    		<textarea class="form-control editor" name="editor_1" id="editor_1" <?php echo $disabled; ?>>
                                    			<?php echo $templates['legend']; ?>
                                    		</textarea>
                                    	</div>
                                    	<div class="col-md-12" id="menulist" style="margin-top:20px">
                                    	<?php 
                                    	if($templates['status'] > 1) { 
                                    		?>
                                    		<style>
                                    			.remove_title,.add_title,.add_sub_section{display:none;}
                                    		</style>
                                    		<?php
                                    	} else { ?>
                                    		<a href="javascript:" class="btn btn-primary add_new_section" id="add_new_section" style="float:right;">Add New Section</a>
                                    		<?php
                                    	}
                                    	?>
                                    	</div>
                                    	<div class="template_main_div" style="width:100%;overflow-x:scroll">
                                    	<?php
                                    	

                                    	if(!empty($forms))
                                    	{
                                    		$outputval = '';
                                    		foreach($forms as $key => $form)
                                    		{
                                    			$keycountval = $key + 1;
                                    			if($key == 0)
                                    			{
                                    				$outputval.= '<div class="table_row">';
                                    			}
                                    			else{
                                    				$outputval.= '<div class="table_row" style="margin-top:20px"><p>&nbsp;</p>';
                                    			}
	                                    			$checkbox = '<div class="attach_div col-md-7">
                                                
                                                		<input type="hidden" name="attachment[]" value="0">
  	                                    				<select name="priority[]" class="input-sm" style="display:none">
                                    							<option value="0">Select Priority</option>
                                    						</select>
			                                        	<label class="containerr" style="display:none">&nbsp; <input type="checkbox" class="checkmark_title" value="2" checked="checked"><span class="checkmark"></span></label>
			                                        	<input type="hidden" class="check_title" name="check_title[]" value="2">
			                                        	<span style="font-weight:800;font-size: 16px;line-height: 3;">'.$keycountval.'</span><textarea name="section[]" class="form-control input_section input_new_section" onkeyup="textAreaAdjust(this)" required '.$disabled.'>'.$form['section'].'</textarea>
			                                        </div>';
			                                        $remove = '<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;" '.$disabled.'></a>';
                                    			
			                                        $outputval.='
			                                        	<div class="col-md-12 inside_table_div main_div" style="margin-top:15px">
					                                        '.$checkbox.'
					                                        <div class="col-md-1">
					                                        	<input type="text" name="strong[]" class="form-control input_strong" value="'.$form['strong'].'" required '.$disabled.'>
					                                        </div>
					                                        <div class="col-md-1">
					                                        	<input type="text" name="sufficient[]" class="form-control input_sufficient" value="'.$form['sufficient'].'" required '.$disabled.'>
					                                        </div>
					                                        <div class="col-md-1">
					                                        	<input type="text" name="insufficient[]" class="form-control input_insufficient" value="'.$form['insufficient'].'" required '.$disabled.'>
					                                        </div>
					                                        <div class="col-md-1">
					                                        	<input type="text" name="na[]" class="form-control input_na" value="'.$form['na'].'" required '.$disabled.'>
					                                        </div>
					                                        <div class="col-md-1 action_div">
					                                        	'.$remove.'
					                                        	<a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;" '.$disabled.'></a>
					                                        </div>
					                                    </div>';
					                                $get_sub_inputs = $this->db->table('template_forms')->select('*')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
					                                if(!empty($get_sub_inputs))
					                                {
					                                	foreach($get_sub_inputs as $input)
					                                	{
					                                		if($input['set_title'] == "1")
		                                    				{
		                                    					$checkbox_sub = '<div class="attach_div col-md-7">
                                                    				<input type="hidden" name="attachment[]" value="0">
		                                    						<select name="priority[]" class="input-sm" style="display:none">
			                                    							<option value="0">Select Priority</option>
			                                    						</select>
		                                    						<label class="containerr" style="display:none">&nbsp; <input type="checkbox" class="checkmark_title" value="1" checked="checked"><span class="checkmark"></span></label>
			                                    						<input type="hidden" class="check_title" name="check_title[]" value="1">
						                                        	<textarea name="section[]" class="form-control input_section input_subtitle_section" onkeyup="textAreaAdjust(this)" required '.$disabled.'>'.$input['section'].'</textarea>
						                                        </div>';
		                                    				}
		                                    				else{
		                                    					if($input['priority'] == 1) { $one_checked = 'selected'; } else { $one_checked = ''; }
		                                    					if($input['priority'] == 2) { $two_checked = 'selected'; } else { $two_checked = ''; }
		                                    					if($input['priority'] == 3) { $three_checked = 'selected'; } else { $three_checked = ''; }
		                                    					if($input['attachment'] == "0") { $check_attach = ''; $attachvalue = 0; }
                                                  else{ $check_attach = 'checked'; $attachvalue = 1; }

                                                  $checkbox_sub = '<div class="attach_div col-md-7">
                                                    <label class="switch '.$disabled.'">
                                                      <input type="checkbox" class="attach_class '.$disabled.'" value="1" '.$check_attach.'>
                                                      <span class="slider round '.$disabled.'"></span>
                                                    </label>
                                                    <input type="hidden" name="attachment[]" class="attach_hidden" value="'.$attachvalue.'">
		                                    						<select name="priority[]" class="input-sm priority_class '.$disabled.'">
		                                    							<option value="1" '.$one_checked.'>√</option>
		                                    							<option value="2" '.$two_checked.'>∆</option>
		                                    							<option value="3" '.$three_checked.'>∑</option>
		                                    						</select>

		                                    						<label class="containerr" style="display:none">&nbsp; <input type="checkbox" class="checkmark_title" value="0"><span class="checkmark"></span></label>
			                                    						<input type="hidden" class="check_title" name="check_title[]" value="0">
						                                        	<textarea name="section[]" class="form-control input_section input_title_section" onkeyup="textAreaAdjust(this)" required '.$disabled.'>'.$input['section'].'</textarea>
						                                        </div>';
		                                    				}

					                                        $remove_sub = '<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;" '.$disabled.'></a>';

					                                        if($input['set_title'] == "1")
			                                    			{
				                                    			$outputval.='
				                                    			<div class="col-md-12 inside_table_div sub_div" style="margin-top:15px">
							                                        '.$checkbox_sub.'
							                                        <div class="col-md-1">
							                                        	<input type="text" name="strong[]" class="form-control input_strong" value="" style="background:#dfdfdf" readonly>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<input type="text" name="sufficient[]" class="form-control input_sufficient" value="" style="background:#dfdfdf" readonly>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<input type="text" name="insufficient[]" class="form-control input_insufficient" value="" style="background:#dfdfdf" readonly>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<input type="text" name="na[]" class="form-control input_na" value="" style="background:#dfdfdf" readonly>
							                                        </div>
							                                        <div class="col-md-1 action_div">
							                                        	'.$remove_sub.'
							                                        	<a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;" '.$disabled.'></a>
							                                        </div>
							                                    </div>';
							                                }
							                                else{
							                                	$outputval.='
				                                    			<div class="col-md-12 inside_table_div" style="margin-top:15px">
							                                        '.$checkbox_sub.'
							                                        <div class="col-md-1">
							                                        	<input type="text" name="strong[]" class="form-control input_strong" value="'.$input['strong'].'" required '.$disabled.'>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<input type="text" name="sufficient[]" class="form-control input_sufficient" value="'.$input['sufficient'].'" required '.$disabled.'>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<input type="text" name="insufficient[]" class="form-control input_insufficient" value="'.$input['insufficient'].'" required '.$disabled.'>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<input type="text" name="na[]" class="form-control input_na" value="'.$input['na'].'" required '.$disabled.'>
							                                        </div>
							                                        <div class="col-md-1 action_div">
							                                        	'.$remove_sub.'
							                                        	<a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;" '.$disabled.'></a>
							                                        </div>
							                                    </div>
							                                    ';
							                                }
					                                	}
					                                }

					                            $outputval.='</div>';
                                    		}
                                    		echo $outputval;
                                    	}
                                    	else{
                                    		?>
                                    		<div class="table_row">
	                                    		<div class="col-md-12 inside_table_div main_div">
			                                        <div class="attach_div col-md-7">
			                                        	<input type="hidden" name="attachment[]" value="0">
			                                        	<span style="font-weight:800;font-size: 16px;line-height: 3;">1.</span><label class="containerr" style="display:none">&nbsp; <input type="checkbox" class="checkmark_title" value="2" checked="checked"><span class="checkmark"></span></label>
			                                        	<input type="hidden" class="check_title" name="check_title[]" value="2">
			                                        	<textarea name="section[]" class="form-control input_section input_new_section" onkeyup="textAreaAdjust(this)" required>Education Program</textarea>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<input type="text" name="strong[]" class="form-control input_strong" value="Strong" required>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<input type="text" name="sufficient[]" class="form-control input_sufficient" value="Sufficient" required>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<input type="text" name="insufficient[]" class="form-control input_insufficient" value="Insufficient" required>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<input type="text" name="na[]" class="form-control input_na" value="N/A" required>
			                                        </div>
			                                        <div class="col-md-1 action_div">
			                                        	<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a>

			                                        	<a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>

			                                        	<a href="javascript:" class="fa fa-sitemap add_sub_section" title="Add New Sub Section" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>
			                                        </div>
			                                    </div>
		                                    </div>
		                                    <!-- <div class="col-md-12 summary_div">
		                                        <label class="summary_label">Summary:</label>
		                                        <textarea name="summary[]" class="form-control summary_input" onkeyup="textAreaAdjust(this)"></textarea>
		                                    </div> -->
                                    		<?php
                                    	}
                                    	?>
                                    	</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_template_id" id="hidden_template_id" value="<?php echo $template_id; ?>">
                        <?php
                        if($templates['status'] > 1) {
                        	?>
                        	<input type="button" class="btn btn-primary alert_submitted" value="Save & Complete Template" style="margin-top:20px">
                        	<?php
                        }
                        else { ?>
                        	<input type="submit" class="btn btn-primary submit_step_3" name="submit_step3" value="Save & Complete Template" style="margin-top:20px">
                        <?php } ?>
                    </form>

                    <!--END FORM-->

            </section>
        </div>
    </div>
    </section>
    </div>
</section>

<script>
/**************************MenuDiv Scroll for dragging***************************/
$('#menulist').addClass('original').clone().insertAfter('#menulist').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','80px').css('z-index','500').removeClass('original').hide();
scrollIntervalID = setInterval(stickIt, 10);
function stickIt() {
	var orgElementPos = $('.original').offset();
	orgElementTop = orgElementPos.top;
	if ($(window).scrollTop() >= (orgElementTop)) {
		// scrolled past the original position; now only show the cloned, sticky element.
		// Cloned element should always have same left position and width as original element.
		orgElement = $('.original');
		coordsOrgElement = orgElement.offset();
		leftOrgElement = coordsOrgElement.left;
		widthOrgElement = orgElement.css('width');
		$('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
		$('.original').css('visibility','hidden');
	} else {
		// not scrolled past the menu; only show the original menu.
		$('.cloned').hide();
		$('.original').css('visibility','visible');
	}
}
/**************************************************************/
// managage back button click (and backspace)
// var count = 0; // needed for safari
// window.onload = function () { 
//     if (typeof history.pushState === "function") { 
//         history.pushState("back", null, null);          
//         window.onpopstate = function () { 
//             history.pushState('back', null, null);              
//             if(count == 1){ alert("Click on the Step2 Tab to move back to the Previous Step.") }
//          }; 
//      }
//  }  
// setTimeout(function(){count = 1;},200);


$(document).ready(function() {
    CKEDITOR.replace(editor_1,
    {
        height: '150px',
    });

    $(".add_title").each(function() {
    	var select_row = $(this).parents(".table_row");

	    $(this).parents(".table_row").find(".inside_table_div").find(".action_div").find(".add_sub_section").detach();
	    $(this).parents(".table_row").find(".inside_table_div").find(".action_div").find(".add_title").detach();


	    select_row.find(".inside_table_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a><a href="javascript:" class="fa fa-sitemap add_sub_section" title="Add New Sub Section" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>');
    });
});
function textAreaAdjust(o) {
  o.style.height = "1px";
  o.style.height = (5+o.scrollHeight)+"px";
}
$(".alert_submitted").click(function() {
	alert("You are unable to make changes to the completed survey once submitted.");
})
$(document).ready(function() {
	$("textarea").each(function(e){
		textAreaAdjust(this);
	});	

    $(".editor").each(function(e) {
         CKEDITOR.replace(this.id,
         {
            height: '150px',
         });
    });

    var select_row = $(".table_row");

    $(".table_row").find(".inside_table_div").find(".action_div").find(".add_title").detach();

    if(select_row.find(".inside_table_div:last").hasClass("sub_div"))
    {
    	select_row.find(".inside_table_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>');
    }
    else{
    	select_row.find(".inside_table_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a><a href="javascript:" class="fa fa-sitemap add_sub_section" title="Add New Sub Section" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>');
    }
});

    $.ajaxSetup({async:false});

    $( "#form_sample_3" ).validate({

    rules: {

        template_name: {required: true,},
        'content_title[]':{required: true,},

    },

    messages: {

        template_name : "Template Name is required",
        'content_title[]': "Title is required",
    },

    });

CKEDITOR.on('instanceCreated', function (e) {
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 second for example
        var $input = e.editor;

        $input.on('change', function () {
            var value = CKEDITOR.instances[$input.name].getData();
            $("#"+$input.name).text(value);
        });
});
// $("form[id^='form_sample_3']").on("change keyup", ":input", function() {
// 	window.addEventListener('beforeunload', function (e) { 
// 	    e.preventDefault(); 
// 	    e.returnValue = ''; 
// 	    var hidden_template_id = $("#hidden_template_id").val();
// 	    $.ajax({
// 	        url:"<?php echo BASE_URL.'district/ajax_create_master_template_step3'; ?>",
// 	        type:"post",
// 	        data:{formdatas:$("#form_sample_3").serialize(),template_id:hidden_template_id},
// 	        success: function(result)
// 	        {
	            
// 	        }
// 	    });
// 	}); 	
// });

$(window).click(function(e) {
  if($(e.target).parents(".switch").length > 0)
  {

    if($(e.target).parents(".attach_div").find(".attach_class").is(":checked"))
    {
    	console.log("skdjskd");
      $(e.target).parents(".attach_div").find(".attach_hidden").val("1");
    }
    else{
      $(e.target).parents(".attach_div").find(".attach_hidden").val("0");
    }
  }
	if($(e.target).hasClass("checkmark_title"))
	{
		if($(e.target).is(":checked"))
		{
			$(e.target).parents(".inside_table_div").find(".input_strong").val("");
			$(e.target).parents(".inside_table_div").find(".input_sufficient").val("");
			$(e.target).parents(".inside_table_div").find(".input_insufficient").val("");
			$(e.target).parents(".inside_table_div").find(".input_na").val("");
			$(e.target).parents(".inside_table_div").find(".check_title").val("1");
		}
		else{
			$(e.target).parents(".inside_table_div").find(".input_strong").val("X");
			$(e.target).parents(".inside_table_div").find(".input_sufficient").val("X");
			$(e.target).parents(".inside_table_div").find(".input_insufficient").val("X");
			$(e.target).parents(".inside_table_div").find(".input_na").val("X");
			$(e.target).parents(".inside_table_div").find(".check_title").val("0");
		}
	}
    if($(e.target).hasClass('add_title'))
    {
        var count = $(".table_row").find(".inside_table_div").length;
        var nextval = count + 1;
        var htmlcontent = '<div class="col-md-12 inside_table_div" style="margin-top:15px"><div class="attach_div col-md-7"><label class="switch"><input type="checkbox" class="attach_class" value="1"><span class="slider round"></span></label><input type="hidden" name="attachment[]" class="attach_hidden" value="0"><select name="priority[]" class="input-sm priority_class"><option value="1">√</option><option value="2">∆</option><option value="3">∑</option></select><label class="containerr" style="display:none">&nbsp; <input type="checkbox" class="checkmark_title" value="0"><span class="checkmark"></span></label> <input type="hidden" class="check_title" name="check_title[]" value="0"><textarea name="section[]" class="form-control input_section input_title_section" onkeyup="textAreaAdjust(this)" required></textarea></div><div class="col-md-1"><input type="text" name="strong[]" class="form-control input_strong" value="X" readonly></div><div class="col-md-1"><input type="text" name="sufficient[]" class="form-control input_sufficient" value="X" readonly></div><div class="col-md-1"><input type="text" name="insufficient[]" class="form-control input_insufficient" value="X" readonly></div><div class="col-md-1"><input type="text" name="na[]" class="form-control input_na" value="X" readonly></div><div class="col-md-1 action_div"><a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a><a href="javascript:" class="fa fa-sitemap add_sub_section" title="Add New Sub Section" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a></div></div>';
        $(e.target).parents(".table_row").append(htmlcontent);
        
        var select_row = $(e.target).parents(".table_row");

        $(e.target).parents(".table_row").find(".inside_table_div").find(".action_div").find(".add_sub_section").detach();
        $(e.target).parents(".table_row").find(".inside_table_div").find(".action_div").find(".add_title").detach();


        select_row.find(".inside_table_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a><a href="javascript:" class="fa fa-sitemap add_sub_section" title="Add New Sub Section" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>');
    }
    if($(e.target).hasClass('add_sub_section'))
    {
        var count = $(".table_row").find(".inside_table_div").length;
        var nextval = count + 1;
        var htmlcontent = '<div class="col-md-12 inside_table_div sub_div" style="margin-top:15px"><div class="attach_div col-md-7"><input type="hidden" name="attachment[]" value="0"><select name="priority[]" class="input-sm" style="display:none"><option value="0">Select Priority</option></select><label class="containerr" style="display:none">&nbsp; <input type="checkbox" class="checkmark_title" value="1" checked="checked"><span class="checkmark"></span></label> <input type="hidden" class="check_title" name="check_title[]" value="1"><textarea name="section[]" class="form-control input_section input_subtitle_section" onkeyup="textAreaAdjust(this)" required></textarea></div><div class="col-md-1"><input type="text" name="strong[]" class="form-control input_strong" value="" style="background:#dfdfdf" readonly></div><div class="col-md-1"><input type="text" name="sufficient[]" class="form-control input_sufficient" value="" style="background:#dfdfdf" readonly></div><div class="col-md-1"><input type="text" name="insufficient[]" class="form-control input_insufficient"  value="" style="background:#dfdfdf" readonly></div><div class="col-md-1"><input type="text" name="na[]" class="form-control input_na" value="" style="background:#dfdfdf" readonly></div><div class="col-md-1 action_div"><a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a></div></div>';
        $(e.target).parents(".table_row").append(htmlcontent);
        
        var select_row = $(e.target).parents(".table_row");

        $(e.target).parents(".table_row").find(".inside_table_div").find(".action_div").find(".add_title").detach();
        $(e.target).parents(".table_row").find(".inside_table_div").find(".action_div").find(".add_sub_section").detach();

        select_row.find(".inside_table_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>');
    }
    if($(e.target).hasClass('remove_title'))
    {
    	var select_row = $(e.target).parents(".table_row");
    	if($(e.target).parents(".inside_table_div").hasClass("sub_div"))
    	{
    		var r = confirm("Are you Sure you want to delete this Sub Section?.");
    		if(r){
    			console.log("jdsshd");
    			for(var i=0; i<=100;i++)
    			{
    				if($(e.target).parents(".inside_table_div").next().length == 0)
    				{
    					$(e.target).parents(".inside_table_div").detach();
	    				return false;
    				}
    				else{
    					if($(e.target).parents(".inside_table_div").next().hasClass("sub_div"))
	    				{
	    					$(e.target).parents(".inside_table_div").detach();
	    					return false;
	    				}
	    				else{
	    					$(e.target).parents(".inside_table_div").next().detach();
	    				}
    				}
    			}
    		}
    	}
    	else if($(e.target).parents(".inside_table_div").hasClass("main_div"))
    	{
    		var r = confirm("Are you Sure you want to delete this Section?.");
    		if(r){
    			var lengthval = $(".table_row").length;
		    	if(lengthval > 1)
		    	{
		    		$(e.target).parents(".table_row").next(".summary_div").detach();
		    		$(e.target).parents(".table_row").detach();
		    		var countval = 1;
		    		$(".table_row:first").find("p").detach();
		    		$(".input_new_section").each(function(e) {
		    			$(this).parents(".inside_table_div").find("span").html(countval);
		    			countval++;
		    		});
		    	}
		        else{
		        	alert("Cant able to delete this title. Because there should be atleast one title.")
		        }
    		}
    	}
    	else{
    		$(e.target).parents(".inside_table_div").detach();
	        if(select_row.find(".inside_table_div:last").hasClass('sub_div'))
	        {
	        	select_row.find(".inside_table_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>');
	        }
	        else{
	        	select_row.find(".inside_table_div:last").find(".action_div").html('<a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a><a href="javascript:" class="fa fa-sitemap add_sub_section" title="Add New Sub Section" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a>');
	        }
    	}

  //   	window.addEventListener('beforeunload', function (e) { 
		//     e.preventDefault(); 
		//     e.returnValue = ''; 
		//     var hidden_template_id = $("#hidden_template_id").val();
		//     $.ajax({
		//         url:"<?php echo BASE_URL.'district/ajax_create_master_template_step3'; ?>",
		//         type:"post",
		//         data:{formdatas:$("#form_sample_3").serialize(),template_id:hidden_template_id},
		//         success: function(result)
		//         {
		            
		//         }
		//     });
		// }); 
    }
    // if($(e.target).hasClass('remove_maintitle'))
    // {
    // 	var lengthval = $(".table_row").length;
    // 	if(lengthval > 1)
    // 	{
    // 		$(e.target).parents(".table_row").detach();
    // 	}
    //     else{
    //     	alert("Cant able to delete this title. Because there should be atleast one title.")
    //     }
    // }
    if($(e.target).hasClass('add_new_section'))
    {
    	var section_count = $(".input_new_section").length;
    	var count = section_count + 1;
        var htmlcontent = '<div class="table_row" style="margin-top:30px"><p>&nbsp;</p><div class="col-md-12 inside_table_div main_div"><div class="attach_div col-md-7"><input type="hidden" name="attachment[]" value="0"><select name="priority[]" class="input-sm" style="display:none"><option value="0">Select Priority</option></select><span style="font-weight:800;font-size: 16px;line-height: 3;">'+count+'.</span><label class="containerr" style="display:none">&nbsp; <input type="checkbox" class="checkmark_title"  value="2" checked="checked"><span class="checkmark"></span></label><input type="hidden" class="check_title" name="check_title[]" value="2"><textarea name="section[]" class="form-control input_section input_new_section" onkeyup="textAreaAdjust(this)" required></textarea></div><div class="col-md-1"><input type="text" name="strong[]" class="form-control input_strong" value="Strong" required></div><div class="col-md-1"><input type="text" name="sufficient[]" class="form-control input_sufficient" value="Sufficient" required></div><div class="col-md-1"><input type="text" name="insufficient[]" class="form-control input_insufficient" value="Insufficient" required></div><div class="col-md-1"><input type="text" name="na[]" class="form-control input_na" value="N/A" required></div><div class="col-md-1 action_div"><a href="javascript:" class="fa fa-trash remove_title" title="Delete this Question" style="font-size:20px;color:red;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;"></a><a href="javascript:" class="fa fa-plus add_title" title="Add New Question" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a><a href="javascript:" class="fa fa-sitemap add_sub_section" title="Add New Sub Section" style="font-size:20px;color:green;padding: 5px;border: 1px solid #dfdfdf;background: #dfdfdf;margin-top: 4px;margin-left: 4px;"></a></div></div></div>';
        $(".template_main_div").append(htmlcontent);
    }
    if($(e.target).hasClass('submit_step_3'))
    {
    	e.preventDefault();
    	var value = 1;
    	$(".input_section").each(function() {
    		var content = $(this).val();
    		if(content == "")
    		{
    			value++;
    		}
    	});
    	if(value == 1)
    	{
    		<?php 
    		if($templates['school_id'] != '0')
            {
	    		if(isset($district_details['allow_discreation']) == 1)
	    		{
	    			?>
	    			$("#form_sample_3").submit();
	    			<?php
	    		}
	    		else{
	    			?>
	    			$(".alert_modal_submit").modal("show");
	        		$(".alert_content_submit").html("Are you sure you want to submit the survey to school admin? Once submitted you will not be able to make changes to the survey.");
	    			<?php
	    		}
	    	}
	    	else{
	    		?>
	    		$("#form_sample_3").submit();
	    		<?php
	    	}
    		?>
    		
    		
    	}
    	else{
    		alert("Please Fill all the Fields to Create new Template");
    	}
    }
    if($(e.target).hasClass('yes_hit_submit'))
    {
        $(".alert_modal_submit").modal("hide");
        $("#form_sample_3").submit();
    }
    if($(e.target).hasClass('no_hit_submit'))
    {
        $(".alert_modal_submit").modal("hide");
    }
});
</script>