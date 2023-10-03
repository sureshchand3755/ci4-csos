<?php 
$this->db	= \Config\Database::connect();
?>
<section class="page-content">
    <div class="page-content-inner">
	<section class="panel">
    <hr>
<script src="<?php echo BASE_URL; ?>assets/print.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/print.min.css">
<style>
.inside_table_div
{
	min-width:1200px;
}
.modal_load {
display:    none;
position:   fixed;
z-index:    999999;
top:        0;
left:       0;
height:     100%;
width:      100%;
background: rgba( 255, 255, 255, .8 ) 
            url(<?php echo BASE_URL.'assets/images/loading.gif'; ?>) 
            50% 50% 
            no-repeat;
}
body.loading {
overflow: hidden;   
}
body.loading .modal_load {
display: block;
}
h5{
	width:95%;
	float:right;
	line-height: 36px;
}
.priority_icon{
	font-weight: 1000;
    padding: 10px;
}
.priority_class{
	padding: 9px;
    background: #ffffff;
    font-size: 1rem;
    line-height: 1.5;
}
textarea{  
  /* box-sizing: padding-box; */
  overflow:hidden;
  display:block;
}
.summary_label{
	font-size:18px;
	font-weight:800;
	margin-top:20px;
}
.input_title_section{
	width:94%;
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
/* The container */
.containerr {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.containerr input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  margin-top: 7px;
    margin-left: 42%;
}

/* On mouse-over, add a grey background color */
.containerr:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.containerr input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.containerr input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.containerr .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.fa-plus, .fa-pencil-square{cursor: pointer;}

.dropzone .dz-preview.dz-image-preview {

    background: #949400 !important;

}

.dz-message span{text-transform: capitalize !important; font-weight: bold;}

.trash_imageadd{

  cursor:pointer;

}

.dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message *{

      margin-top: 40px;

}

.dropzone .dz-preview {

  margin:0px !important;

  min-height:0px !important;

  width:100% !important;

  color:#000 !important;

    float: left;

  clear: both;

}

.dropzone .dz-preview p {

  font-size:12px !important;

}

.remove_dropzone_attach{

  color:#f00 !important;

  margin-left:10px;

}

.delete_all_image, .delete_all_notes_only, .delete_all_notes, .download_all_image, .download_rename_all_image, .download_all_notes_only, .download_all_notes{cursor: pointer;}
.img_div{
    border: 1px solid #000;
    width: 100%;
    min-height: 118px;
    background: rgb(255, 255, 0);
    float: left;
    margin-bottom: 10px;
}
.upload_img{

  position: absolute;

    top: 0px;

    z-index: 1;

    background: rgb(226, 226, 226);

    padding: 19% 0%;

    text-align: center;

    overflow: hidden;

}

.upload_text{

  font-size: 15px;

    font-weight: 800;

    color: #631500;

}
</style>
<div class="modal fade add_attachment_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:999999999">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="exampleModalLabel">Add Attachment</h4>
        </div>
        <div class="modal-body">
          <div class="attachment_show_div" style="display:none">
            <strong>Attachments:</strong>
            <div class="attachment_inner_div">

            </div>
          </div>
          <div class="img_div">
             <div class="image_div_attachments">
               <form action="<?php echo BASE_URL.'district/upload_images'; ?>" method="post" enctype="multipart/form-data" class="dropzone" id="imageUpload" style="clear:both;min-height:80px;background: #949400;color:#000;border:0px solid; height:auto; width:100%; float:left">
                   <input name="hidden_file_id" type="hidden" id="hidden_file_id" value="">
               </form>
             </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary close_dropzone">Submit</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade download_sections_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="exampleModalLabel">Choose Sections to Download</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <h4>Step1</h4>
            <?php
            $template_details = $this->db->table('master_templates')->select('*')->where('id',$template_id)->get()->getRowArray();
            if(!empty($template_details))
            {
                $unserialize = unserialize($template_details['content']);
                if(count($unserialize)){
                    foreach($unserialize as $key => $content)
                    {
                    ?>
                        <div class="col-md-12">
                            <label class="containerr" style="padding-left: 28px;">&nbsp; <input type="checkbox" class="select_sections" value="<?php echo $key; ?>"><span class="checkmark" style="margin-left:0px"></span> <?php echo $key; ?></label>
                        </div>
                    
                    <?php
                    }
                }
            }
            ?>
            <h4>Step2</h4>
            <div class="col-md-12">
                <label class="containerr" style="padding-left: 28px;">&nbsp; <input type="checkbox" class="select_sections" value="addendum"><span class="checkmark" style="margin-left:0px"></span> Addendum</label>
            </div>
            <h4>Step3</h4>
            <?php
            if(!empty($forms))
            {
              $outputval = '';
              foreach($forms as $key => $form)
              {
                  ?>
                  <div class="col-md-12">
                      <label class="containerr" style="padding-left: 28px;">&nbsp; <input type="checkbox" class="select_sections" value="<?php echo $form['section']; ?>"><span class="checkmark" style="margin-left:0px"></span> <?php echo $form['section']; ?></label>
                  </div>
                  <?php
              }
            }
            ?>    
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-primary download_selected_sections">Download as PDF</button>
        </div>
      </div>
    </div>
</div>


<div class="modal fade print_sections_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="exampleModalLabel">Choose Sections to Print</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <h4>Step1</h4>
            <?php
            $template_details = $this->db->table('master_templates')->select('*')->where('id',$template_id)->get()->getRowArray();
            if(!empty($template_details))
            {
                $unserialize = unserialize($template_details['content']);
                if(count($unserialize)){
                    foreach($unserialize as $key => $content)
                    {
                    ?>
                        <div class="col-md-12">
                            <label class="containerr" style="padding-left: 28px;">&nbsp; <input type="checkbox" class="select_sections_print" value="<?php echo $key; ?>"><span class="checkmark" style="margin-left:0px"></span> <?php echo $key; ?></label>
                        </div>
                    
                    <?php
                    }
                }
            }
            ?>
            <h4>Step2</h4>
            <div class="col-md-12">
                <label class="containerr" style="padding-left: 28px;">&nbsp; <input type="checkbox" class="select_sections_print" value="addendum"><span class="checkmark" style="margin-left:0px"></span> Addendum</label>
            </div>
            <h4>Step3</h4>
            <?php
            if(!empty($forms))
            {
              $outputval = '';
              foreach($forms as $key => $form)
              {
                  ?>
                  <div class="col-md-12">
                      <label class="containerr" style="padding-left: 28px;">&nbsp; <input type="checkbox" class="select_sections_print" value="<?php echo $form['section']; ?>"><span class="checkmark" style="margin-left:0px"></span> <?php echo $form['section']; ?></label>
                  </div>
                  <?php
              }
            }
            ?>    
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-primary print_selected_sections">Print</button>
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
                    <form action="<?php echo BASE_URL.'district/save_template_content_step3_submitted'; ?>" id="form_sample_3" method="post" enctype="multipart/form-data">
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BASE_URL.'district/add_submitted_template/'.$template_id; ?>">Step 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo BASE_URL.'district/add_submitted_template_step2/'.$template_id; ?>">Step 2</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:">Step 3</a>
                                    </li>
                                    <li class="nav-item" style="float:right">
                                        <div class="dropdown">
                                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Download As PDF
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item download_pdf" href="javascript:">Download Full Survey</a>
                                            <a class="dropdown-item download_sections" href="javascript:">Download Sections</a>
                                          </div>
                                        </div>
                                    </li>
                                    <li class="nav-item" style="float:right">
                                        <div class="dropdown">
                                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Print
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <a class="dropdown-item print_pdf" href="javascript:">Print Full Survey</a>
                                            <a class="dropdown-item print_sections" href="javascript:">Print Sections</a>
                                          </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">
                                    <div class="tab-pane active main_table_row" id="home1" role="tabpanel" aria-expanded="false">
                                    	<div class="col-md-12">
                                    		<h5>Legend</h5>
                                    		<h6>
                                    			<?php echo $template['legend']; ?>
                                    		</h6>
                                    	</div>
                                    	<div class="template_main_div" style="width:100%;overflow-x:scroll">
                                    	<?php
                                    	$template_details = $this->db->table('master_templates')->select('*')->where('id',$template_id)->get()->getRowArray();
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
	                                    			$checkbox = '<div class="col-md-4">
			                                        	<h6>'.$keycountval.'. '.$form['section'].'</h6>
			                                        </div>';
                                    			
			                                        $outputval.='
			                                        	<div class="col-md-12 inside_table_div main_div" style="margin-top:15px">
					                                        '.$checkbox.'
					                                        <div class="col-md-1">
					                                        	<h6 style="text-align:center">'.$form['strong'].'</h6>
					                                        </div>
					                                        <div class="col-md-1">
					                                        	<h6 style="text-align:center">'.$form['sufficient'].'</h6>
					                                        	
					                                        </div>
					                                        <div class="col-md-1">
					                                        	<h6 style="text-align:center">'.$form['insufficient'].'</h6>
					                                        </div>
					                                        <div class="col-md-1">
					                                        	<h6 style="text-align:center">'.$form['na'].'</h6>
					                                        </div>
                                                  <div class="col-md-2">
                                                    Attachments
                                                  </div>
					                                        <div class="col-md-2 action_div">
					                                        	<input type="hidden" name="mark[]" class="hidden_mark" value="0">
					                                        	<h6 style="text-align:left">Comments</h6>
					                                        	'.$form['comments'].'
					                                        </div>
					                                    </div>';
					                                $get_sub_inputs = $this->db->table('template_forms')->select('*')->where('sub_id',$form['id'])->where('template_id',$form['template_id'])->get()->getResultArray();
					                                if(!empty($get_sub_inputs))
					                                {
					                                	foreach($get_sub_inputs as $keyvalinput => $input)
					                                	{
					                                		if($input['set_title'] == "1")
		                                    				{
		                                    					$checkbox_sub = '<div class="col-md-4">
						                                        	<h6>'.$input['section'].'</h6>
						                                        </div>';
		                                    				}
		                                    				else{
		                                    					if($input['priority'] == 1)
		                                    					{
		                                    						$priority_icon = '<strong class="priority_icon">√</strong>';
		                                    					}
		                                    					elseif($input['priority'] == 2)
		                                    					{
		                                    						$priority_icon = '<strong class="priority_icon">∆</strong>';
		                                    					}
		                                    					elseif($input['priority'] == 3)
		                                    					{
		                                    						$priority_icon = '<strong class="priority_icon">∑</strong>';
		                                    					}
		                                    					else{
		                                    						$priority_icon = '';
		                                    					}
		                                    					$checkbox_sub = '<div class="col-md-4">
						                                        	<h6>'.$priority_icon.' '.$input['section'].'</h6>
						                                        </div>';
		                                    				}

					                                    if($input['set_title'] == "1")
			                                    		{
				                                    			$outputval.='
				                                    			<div class="col-md-12 inside_table_div sub_div" style="margin-top:15px">
							                                        '.$checkbox_sub.'
							                                        <div class="col-md-1">
							                                        	&nbsp;
							                                        </div>
							                                        <div class="col-md-1">
							                                        	&nbsp;
							                                        </div>
							                                        <div class="col-md-1">
							                                        	&nbsp;
							                                        </div>
							                                        <div class="col-md-1">
							                                        	&nbsp;
							                                        </div>
                                                      <div class="col-md-2">
                                                        &nbsp;
                                                      </div>
							                                        <div class="col-md-2 action_div">
							                                        	<input type="hidden" name="mark[]" class="hidden_mark" value="0">
							                                        	&nbsp;
							                                        	'.$input['comments'].'
							                                        </div>
							                                    </div>
							                                    ';
							                                }
							                                else{
							                                	if($input['strong'] == "1") { $strong_selected = 'checked'; } else { $strong_selected = '';  }
							                                	if($input['sufficient'] == "1") { $sufficient_selected = 'checked'; } else { $sufficient_selected = '';  }
							                                	if($input['insufficient'] == "1") { $insufficient_selected = 'checked'; } else { $insufficient_selected = '';  }
							                                	if($input['na'] == "1") { $na_selected = 'checked'; } else { $na_selected = '';  }

							                                	if($input['strong'] == "1") { $mark_value = 1; }
							                                	elseif($input['sufficient'] == "1") { $mark_value = 2; }
							                                	elseif($input['insufficient'] == "1") { $mark_value = 3; }
							                                	elseif($input['na'] == "1") { $mark_value = 4; }
							                                	else{$mark_value = 0; }

							                                	if($template_details['status'] >= 3) { $disabled = 'disabled'; } else { $disabled = ''; }
                                                $downloadfile = '';
                                                $files = $this->db->table('template_attachments')->select('*')->where('form_id',$input['id'])->get()->getResultArray();
                                                if(!empty($files))
                                                {
                                                  $downloadfile_image = '';
                                                  $downloadfile_doc = '';
                                                  $downloadfile_excel = '';
                                                  $downloadfile_pdf = '';
                                                  $downloadfile_video = '';
                                                  foreach($files as $file)
                                                  {
                                                    $explode = explode(".",$file['filename']);
                                                    if(end($explode) == "jpg" || end($explode) == "jpeg" || end($explode) == "png" || end($explode) == "bmp" || end($explode) == "svg")
                                                    {
                                                      $downloadfile_image ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a><br/>';

                                                      $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_image" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/img.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                      <div class="hidden" id="type_'.$file['id'].'_image" style="display:none">
                                                        <div class="popover-heading">
                                                          Attachment
                                                        </div>
                                                        <div class="popover-body">
                                                          '.$downloadfile_image.'
                                                        </div>
                                                      </div>';
                                                    }
                                                    if(end($explode) == "doc" || end($explode) == "txt" || end($explode) == "rtf" || end($explode) == "docx" || end($explode) == "odt")
                                                    {
                                                      $downloadfile_doc ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a><br/>';

                                                      $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_doc" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/doc.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                      <div class="hidden" id="type_'.$file['id'].'_doc" style="display:none">
                                                        <div class="popover-heading">
                                                          Attachment
                                                        </div>
                                                        <div class="popover-body">
                                                          '.$downloadfile_doc.'
                                                        </div>
                                                      </div>';
                                                    }
                                                    if(end($explode) == "xls" || end($explode) == "xlsx")
                                                    {
                                                      $downloadfile_excel ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a><br/>';

                                                      $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_excel" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/excel.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                      <div class="hidden" id="type_'.$file['id'].'_excel" style="display:none">
                                                        <div class="popover-heading">
                                                          Attachment
                                                        </div>
                                                        <div class="popover-body">
                                                          '.$downloadfile_excel.'
                                                        </div>
                                                      </div>';
                                                    }
                                                    if(end($explode) == "pdf")
                                                    {
                                                      $downloadfile_pdf ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a><br/>';

                                                      $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_pdf" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/pdf.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                      <div class="hidden" id="type_'.$file['id'].'_pdf" style="display:none">
                                                        <div class="popover-heading">
                                                          Attachment
                                                        </div>
                                                        <div class="popover-body">
                                                          '.$downloadfile_pdf.'
                                                        </div>
                                                      </div>';
                                                    }
                                                    if(end($explode) == "mov" || end($explode) == "mp4" || end($explode) == "webm" || end($explode) == "mpg" || end($explode) == "mp2" || end($explode) == "mpeg" || end($explode) == "mpv" || end($explode) == "ogc" || end($explode) == "m4p" || end($explode) == "m4v" || end($explode) == "avi" || end($explode) == "wmv" || end($explode) == "mov" || end($explode) == "flv" || end($explode) == "swf")
                                                    {
                                                      $downloadfile_video ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a><br/>';

                                                      $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_video" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/video.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                      <div class="hidden" id="type_'.$file['id'].'_video" style="display:none">
                                                        <div class="popover-heading">
                                                          Attachment
                                                        </div>
                                                        <div class="popover-body">
                                                          '.$downloadfile_video.'
                                                        </div>
                                                      </div>';
                                                    }
                                                  }
                                                }
							                                	$outputval.='
				                                    			<div class="col-md-12 inside_table_div" style="margin-top:15px">
							                                        '.$checkbox_sub.'
							                                        <div class="col-md-1">
							                                        	<label class="containerr">&nbsp; <input type="radio" name="input_'.$key.'_'.$keyvalinput.'" class="input_mark input_strong" id="input_strong" value="1" '.$strong_selected.' '.$disabled.'><span class="checkmark"></span></label>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<label class="containerr">&nbsp; <input type="radio" name="input_'.$key.'_'.$keyvalinput.'" class="input_mark input_sufficient" id="input_sufficient" value="2" '.$sufficient_selected.' '.$disabled.'><span class="checkmark"></span></label>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<label class="containerr">&nbsp; <input type="radio" name="input_'.$key.'_'.$keyvalinput.'" class="input_mark input_insufficient" id="input_insufficient" value="3" '.$insufficient_selected.' '.$disabled.'><span class="checkmark"></span></label>
							                                        </div>
							                                        <div class="col-md-1">
							                                        	<label class="containerr">&nbsp; <input type="radio" name="input_'.$key.'_'.$keyvalinput.'" class="input_mark input_na" id="input_na" value="4" '.$na_selected.' '.$disabled.'><span class="checkmark"></span></label>
							                                        </div>
                                                      <div class="col-md-2">
                                                        '.$downloadfile.'
                                                      </div>
							                                        <div class="col-md-2 action_div">
							                                        	<input type="hidden" name="mark[]" class="hidden_mark" value="'.$mark_value.'">
							                                        	'.$input['comments'].'
							                                        </div>
							                                    </div>
							                                    ';
							                                }
					                                	}
					                                }
					                            if($template_details['status'] == 4)
					                            {
					                            	$disabled_summary = 'disabled';
					                            }
					                            else{
					                            	$disabled_summary = '';
					                            }
					                            $outputval.='</div>
					                                <div class="col-md-8 summary_div">
			                                        <label class="summary_label">Summary:</label>
			                                        <textarea name="summary[]" class="form-control summary_input" onkeyup="textAreaAdjust(this)" '.$disabled_summary.'>'.$form['summary'].'</textarea>
			                                    </div>
                                          <div class="col-md-4">';
                                              $files_summary = $this->db->table('template_attachments')->select('*')->where('form_id',$form['id'])->get()->getResultArray();
                                              if(!empty($files_summary))
                                              {
                                                $downloadfile_image = '';
                                                $downloadfile_doc = '';
                                                $downloadfile_excel = '';
                                                $downloadfile_pdf = '';
                                                $downloadfile_video = '';
                                                foreach($files_summary as $file)
                                                {
                                                  $explode = explode(".",$file['filename']);
                                                  if(end($explode) == "jpg" || end($explode) == "jpeg" || end($explode) == "png" || end($explode) == "bmp" || end($explode) == "svg")
                                                  {
                                                    $downloadfile_image ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a> <a href="javascript:" class="fa fa-times trash_image" data-element="'.$file['id'].'"></a><br/>';

                                                    $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_image" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/img.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                    <div class="hidden" id="type_'.$file['id'].'_image" style="display:none">
                                                      <div class="popover-heading">
                                                        Attachment
                                                      </div>
                                                      <div class="popover-body">
                                                        '.$downloadfile_image.'
                                                      </div>
                                                    </div>';
                                                  }
                                                  if(end($explode) == "doc" || end($explode) == "txt" || end($explode) == "rtf" || end($explode) == "docx" || end($explode) == "odt")
                                                  {
                                                    $downloadfile_doc ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a> <a href="javascript:" class="fa fa-times trash_image" data-element="'.$file['id'].'"></a><br/>';

                                                    $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_doc" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/doc.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                    <div class="hidden" id="type_'.$file['id'].'_doc" style="display:none">
                                                      <div class="popover-heading">
                                                        Attachment
                                                      </div>
                                                      <div class="popover-body">
                                                        '.$downloadfile_doc.'
                                                      </div>
                                                    </div>';
                                                  }
                                                  if(end($explode) == "xls" || end($explode) == "xlsx" || end($explode) == "csv")
                                                  {
                                                    $downloadfile_excel ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a> <a href="javascript:" class="fa fa-times trash_image" data-element="'.$file['id'].'"></a><br/>';

                                                    $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_excel" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/excel.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                    <div class="hidden" id="type_'.$file['id'].'_excel" style="display:none">
                                                      <div class="popover-heading">
                                                        Attachment
                                                      </div>
                                                      <div class="popover-body">
                                                        '.$downloadfile_excel.'
                                                      </div>
                                                    </div>';
                                                  }
                                                  if(end($explode) == "pdf")
                                                  {
                                                    $downloadfile_pdf ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a> <a href="javascript:" class="fa fa-times trash_image" data-element="'.$file['id'].'"></a><br/>';

                                                    $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_pdf" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/pdf.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                    <div class="hidden" id="type_'.$file['id'].'_pdf" style="display:none">
                                                      <div class="popover-heading">
                                                        Attachment
                                                      </div>
                                                      <div class="popover-body">
                                                        '.$downloadfile_pdf.'
                                                      </div>
                                                    </div>';
                                                  }
                                                  if(end($explode) == "mov" || end($explode) == "mp4" || end($explode) == "webm" || end($explode) == "mpg" || end($explode) == "mp2" || end($explode) == "mpeg" || end($explode) == "mpv" || end($explode) == "ogc" || end($explode) == "m4p" || end($explode) == "m4v" || end($explode) == "avi" || end($explode) == "wmv" || end($explode) == "mov" || end($explode) == "flv" || end($explode) == "swf")
                                                  {
                                                    $downloadfile_video ='<a href="'.BASE_URL.$file['attachment_url'].'/'.$file['filename'].'" download>'.$file['filename'].'</a> <a href="javascript:" class="fa fa-times trash_image" data-element="'.$file['id'].'"></a><br/>';

                                                    $downloadfile.='<a data-placement="top" data-popover-content="#type_'.$file['id'].'_video" data-toggle="popover" data-trigger="focus" href="javascript:" tabindex="0"><img src="'.BASE_URL.'assets/images/video.png'.'" style="width:25px" data-toggle="tooltip" data-placement="bottom" title="'.$file['filename'].'"></a>
                                                    <div class="hidden" id="type_'.$file['id'].'_video" style="display:none">
                                                      <div class="popover-heading">
                                                        Attachment
                                                      </div>
                                                      <div class="popover-body">
                                                        '.$downloadfile_video.'
                                                      </div>
                                                    </div>';
                                                  }
                                                }
                                              }
                                              $outputval.='<label class="summary_label">Attachments:</label><br/><i class="fa fa-plus faplus" aria-hidden="true" data-element="'.BASE_URL.'school/upload_images?file_id='.$form['id'].'" data-value="'.$form['id'].'" title="Add Attachment"></i><br/>';
                                              $outputval.=$downloadfile;
                                          $outputval.='</div>';
                                    		}
                                    		echo $outputval;
                                    	}
                                    	else{
                                    		?>
                                    		<div class="table_row">
	                                    		<div class="col-md-12 inside_table_div main_div">
			                                        <div class="col-md-5">
			                                        	<span style="font-weight:800;font-size: 16px;line-height: 3;">1.</span>
			                                        	<h6>1. Education Program</h6>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<h6>Strong</h6>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<h6>Sufficient</h6>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<h6>Insufficient</h6>
			                                        </div>
			                                        <div class="col-md-1">
			                                        	<h6>N/A</h6>
			                                        </div>
			                                        <div class="col-md-1 action_div">
			                                        	&nbsp;
			                                        </div>
			                                    </div>
		                                    </div>
		                                    <div class="col-md-8 summary_div">
		                                        <label class="summary_label">Summary:</label>
		                                        <textarea name="summary[]" class="form-control summary_input" onkeyup="textAreaAdjust(this)" disabled></textarea>
		                                    </div>
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
                        if($template_details['status'] == 4)
                        {
                          ?>
                          <a href="<?php echo BASE_URL.'district/manage_reviewed_surveys?school_id='.$template_details['school_id']; ?>" class="btn btn-primary submit_step_3" name="submit_step3" style="margin-top:20px">Go Back to Reviewed Survey</a>
                          <?php
                        }
                        else{
                          ?>
                          <input type="submit" class="btn btn-primary submit_step_3" name="submit_step3" value="Save & Send Template" style="margin-top:20px">
                          <?php
                        }
                        ?>
                    </form>

                    <!--END FORM-->

            </section>
        </div>
    </div>
    </section>
    </div>
</section>
<div class="modal_load"></div>
<script>
$(function(){
  $('[data-toggle="tooltip"]').tooltip();
    $("[data-toggle=popover]").popover({
        html : true,
        content: function() {
          var content = $(this).attr("data-popover-content");
          return $(content).children(".popover-body").html();
        },
        title: function() {
          var title = $(this).attr("data-popover-content");
          return $(title).children(".popover-heading").html();
        }
    });
});
function textAreaAdjust(o) {
  o.style.height = "1px";
  o.style.height = (5+o.scrollHeight)+"px";
}
$(document).ready(function() {
	$("textarea").each(function(e){
		textAreaAdjust(this);
	});
    $(".fa-trash").detach();
    $(".add_title").detach();
    $(".add_sub_section").detach();
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
function detectPopupBlocker_download() {
  var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");
  if (!myTest) {
    return 1;
  } else {
    myTest.close();
    return 0;
  }
}
function SaveToDiskdownload(fileURL, fileName) {
	var idval = detectPopupBlocker_download();
	if(idval == 1)
	{
		alert("A popup blocker was detected. Please Allow the popups to download the file.");
	}
	else{
		// for non-IE
		if (!window.ActiveXObject) {
		  var save = document.createElement('a');
		  save.href = fileURL;
		  save.target = '_blank';
		  save.download = fileName || 'unknown';
		  var evt = new MouseEvent('click', {
		    'view': window,
		    'bubbles': true,
		    'cancelable': false
		  });
		  save.dispatchEvent(evt);
		  (window.URL || window.webkitURL).revokeObjectURL(save.href);
		}
		// for IE < 11
		else if ( !! window.ActiveXObject && document.execCommand)     {
		  var _window = window.open(fileURL, '_blank');
		  _window.document.close();
		  _window.document.execCommand('SaveAs', true, fileName || fileURL)
		  _window.close();
		}
	}
	$("body").removeClass("loading");
}
function print_pdf(url){
	var idval = detectPopupBlocker_download();
	if(idval == 1)
	{
		alert("A popup blocker was detected. Please Allow the popups to download the file.");
	}
	else{
	   	var objFra = document.createElement('iframe');   // Create an IFrame.
        objFra.style.visibility = "hidden";    // Hide the frame.
        objFra.src = url;                      // Set source.
        document.body.appendChild(objFra);  // Add the frame to the web page.
        objFra.contentWindow.focus();       // Set focus.
        objFra.contentWindow.print();      // Print it.
	}
}
$(window).click(function(e) {
  if($(e.target).hasClass('close_dropzone'))
  {
    window.location.reload();
  }
  if($(e.target).hasClass('image_submit'))
  {
    var files = $(e.target).parent().find('.image_file').val();
    if(files == '' || typeof files === 'undefines')
    {
      $(e.target).parent().find(".error_files").text("Please Choose the files to proceed");
      return false;
    }
    else{
      $(e.target).parents('td').find('.img_div').show();
    }
  }
  else{
    $(".img_div").each(function() {
      $(this).show();
    });
  }
  if($(e.target).hasClass('image_file'))
  {
    $(e.target).parents('td').find('.img_div').show();
    $(e.target).parents('.modal-body').find('.img_div').show();
  }
  if($(e.target).hasClass("dropzone"))
  {
    $(e.target).parents('td').find('.img_div').show();    
    $(e.target).parents('.modal-body').find('.img_div').show();    
  }
  if($(e.target).hasClass("remove_dropzone_attach"))
  {
    $(e.target).parents('td').find('.img_div').show();   
    $(e.target).parents('.modal-body').find('.img_div').show();
  }
  if($(e.target).parent().hasClass("dz-message"))
  {
    $(e.target).parents('td').find('.img_div').show();
    $(e.target).parents('.modal-body').find('.img_div').show();    
  }
  if($(e.target).hasClass('fa-plus'))
  {
    $(".add_attachment_modal").modal("show");
    var href = $(e.target).attr("data-element");
    var value = $(e.target).attr("data-value");

    $("#imageUpload").attr("action",href);
    $("#hidden_file_id").val(value);

    $(".attachment_show_div").hide();
    $(".attachment_inner_div").html("");

    $(".dz-message").find("span").html("Click here to BROWSE the files <br/>OR just drop files here to upload");
  }
  if($(e.target).hasClass('remove_dropzone_attach'))
  {
    var attachment_id = $(e.target).attr("data-element");
    $.ajax({
      url:"<?php echo BASE_URL.'district/remove_dropzone_attachment'; ?>",
      type:"post",
      data:{attachment_id:attachment_id},
      success: function(result)
      {
        $(e.target).parents("p").detach();
      }
    })
  }
  if($(e.target).hasClass('trash_image'))
  {
    var r = confirm("Are You sure you want to delete");
    if (r == true) {
      var imgid = $(e.target).attr('data-element');
      $.ajax({
          url:"<?php echo BASE_URL.'district/infile_delete_image'; ?>",
          type:"get",
          data:{imgid:imgid},
          success: function(result) {
            window.location.reload();
          }
      });
    }
  }
  if($(e.target).hasClass('delete_all_image')){
    var r = confirm("Are You sure you want to delete all the attachments?");
    if (r == true) {
      var id = $(e.target).attr('data-element');
      $.ajax({
          url:"<?php echo BASE_URL.'district/infile_delete_all_image'; ?>",
          type:"get",
          data:{id:id},
          success: function(result) {
            window.location.reload();
          }
      });
    }
  }
	if($(e.target).hasClass('download_sections'))
  {
    $(".download_sections_modal").modal("show");
    $(".select_sections").prop("checked",false);
  }
  if($(e.target).hasClass('print_sections'))
  {
    $(".print_sections_modal").modal("show");
    $(".select_sections_print").prop("checked",false);
  }
  if($(e.target).hasClass('download_selected_sections'))
  {
    $("body").addClass("loading");
    setTimeout( function() {
      var sections = '';
      $(".select_sections:checked").each(function() {
        if(sections == "")
        {
          sections = $(this).val();
        }
        else{
          sections = sections+'||'+$(this).val();
        }
      });

      var template_id = $("#hidden_template_id").val();
      var base_url = "<?php echo BASE_URL; ?>";
      $.ajax({
        url:"<?php echo BASE_URL.'district/download_pdf_sections'; ?>",
        type:"post",
        data:{template_id:template_id,sections:sections},
        success:function(result)
        {
          $(".download_sections_modal").modal("hide");
          $(".print_sections_modal").modal("hide");
          $("body").removeClass("loading");
          SaveToDiskdownload(base_url+'papers/district/'+result,result);
        }
      })
    },2000);
  }
  if($(e.target).hasClass('print_selected_sections'))
  {
    $("body").addClass("loading");
    setTimeout( function() {
      var sections = '';
      $(".select_sections_print:checked").each(function() {
        if(sections == "")
        {
          sections = $(this).val();
        }
        else{
          sections = sections+'||'+$(this).val();
        }
      });

      var template_id = $("#hidden_template_id").val();
      var base_url = "<?php echo BASE_URL; ?>";
      $.ajax({
        url:"<?php echo BASE_URL.'district/print_pdf_sections'; ?>",
        type:"post",
        data:{template_id:template_id,sections:sections},
        success:function(result)
        {
          $(".download_sections_modal").modal("hide");
          $(".print_sections_modal").modal("hide");
          $("body").removeClass("loading");
          printJS(base_url+'papers/district/'+result);
        }
      })
    },2000);
  }
	if($(e.target).hasClass('download_pdf'))
    {
    	$("body").addClass("loading");
    	setTimeout( function() {
    		var template_id = $("#hidden_template_id").val();
	        var base_url = "<?php echo BASE_URL; ?>";
	        $.ajax({
	        	url:"<?php echo BASE_URL.'district/download_pdf'; ?>",
	        	type:"post",
	        	data:{template_id:template_id},
	        	success:function(result)
	        	{
	        		$("body").removeClass("loading");
	        		SaveToDiskdownload(base_url+'papers/district/'+result,result);
	        	}
	        })
    	},1000);
    }
    if($(e.target).hasClass('print_pdf'))
    {
    	$("body").addClass("loading");
    	setTimeout( function() {
    		var template_id = $("#hidden_template_id").val();
	        var base_url = "<?php echo BASE_URL; ?>";
	        $.ajax({
	        	url:"<?php echo BASE_URL.'district/print_pdf'; ?>",
	        	type:"post",
	        	data:{template_id:template_id},
	        	success:function(result)
	        	{
	        		$("body").removeClass("loading");
	        		printJS(base_url+'papers/district/'+result);
	        	}
	        })
    	},1000);
    }
	if($(e.target).hasClass('input_mark'))
	{
		var value = $(e.target).val();
		$(e.target).parents(".inside_table_div").find(".hidden_mark").val(value);
	}
});
$(".alert_submitted").click(function() {
	alert("You are unable to make changes to the completed survey once submitted.");
})
fileList = new Array();
Dropzone.options.imageUpload = {
    acceptedFiles: null,
    maxFilesize:50000,
    timeout: 10000000,
    dataType: "HTML",
    parallelUploads: 1,
    init: function() {
        this.on('sending', function(file) {
            $("body").addClass("loading");
        });
        this.on("drop", function(event) {
            $("body").addClass("loading");        
        });
        this.on("success", function(file, response) {
            var obj = jQuery.parseJSON(response);
            file.serverId = obj.id; // Getting the new upload ID from the server via a JSON response
            if(obj.id != 0)
            {
              $(".attachment_show_div").show();
              $(".attachment_inner_div").append("<p>"+obj.filename+" <a href='javascript:' class='remove_dropzone_attach' data-element='"+obj.id+"'>Remove</a></p>");
            }
            else{
              $("#attachments_text").show();
              $("#add_attachments_div").append("<p>"+obj.filename+" </p>");
              $(".img_div").each(function() {
                $(this).show();
              });
            }
            $(".dropzone").removeClass("dz-started");
            $(".dz-preview").detach();
            $(".dz-message").find("span").html("Click here to BROWSE the files <br/>OR just drop files here to upload");
        });
        this.on("complete", function (file) {
          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            $("body").removeClass("loading");
          }
         });
        this.on("error", function (file) {
            console.log(file);
            $("body").removeClass("loading");
      });
        this.on("canceled", function (file) {
            $("body").removeClass("loading");
      });
    },
};

</script>