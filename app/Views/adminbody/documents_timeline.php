<style>
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
</style>
<div class="modal" id="show_pdf_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <iframe src="" style="width:100%;height:800px" class="show_iframe_pdf"></iframe>
    </div>
  </div>
</div>
<section class="page-content">
    <div class="page-content-inner">
		<section class="panel">
		    <div class="panel-heading">
		        <h3>DOCUMENTS AND TIMELINE</h3>
		    </div>
		    <hr>
		    <div class="panel-body">
		        <div class="row">
					<section class="content">
						<form name="export_import" id="export_import" method="post" enctype="multipart/form-data">
							<div class="row" id="content">
								<div class="col-md-12">

									<div class="col-md-2">
										<label style="font-weight:600">Select District:</label>
										<select name="select_district" class="form-control select_district">
											<option value="">Select District</option>
											<?php
											if(!empty($districts))
											{
												foreach($districts as $district)
												{
													echo '<option value="'.$district['id'].'">'.$district['district_name'].'</option>';
												}
											}
											?>
										</select>
									</div>
									<div class="col-md-2">
										<label style="font-weight:600">Select School:</label>
										<select name="select_school" class="form-control select_school">
											<option value="">Select School</option>
										</select>
									</div>
									<div class="col-md-2">
										<label style="font-weight:600">Select Year:</label>
										<select name="select_year" class="form-control select_year">
											<option value="">Select Year</option>
											<?php
											$current_year = date('Y');
											for($year=2018; $year<=$current_year; $year++)
											{
												$next_year = $year + 1;
												echo '<option value="'.$year.'">'.$year.' - '.$next_year.'</option>';
											}
											?>
										</select>
									</div>
									<div class="col-md-1">
										<input type="button" class="btn btn-primary submit_filter" value="Submit" style="margin-top:27px">
									</div>
									<div class="col-md-2 school_pdfs_div" style="display:none">
										<label style="font-weight:600;font-size:18px;margin-top:27px">Charter Petition: <a href="javascript:" class="charter_petition_a view_pdf" data-src=""><img src="<?php echo BASE_URL.'assets/images/pdf.png'; ?>" class="charter_petition_img view_pdf" style="width:38px" data-src=""></a></label>
									</div>
									<div class="col-md-2 school_pdfs_div" style="display:none">
										<label style="font-weight:600;font-size:18px;margin-top:27px">MOU: <a href="javascript:" class="mou_a view_pdf" data-src=""><img src="<?php echo BASE_URL.'assets/images/pdf.png'; ?>" class="mou_img view_pdf" style="width:38px" data-src=""></a></label>
									</div>
								</div>
					    	</div>
						</form>
						<div class="table_div">
						</div>
					</section>
				</div>
			</div>
		</section>
	</div>
</section>
<div class="modal_load"></div>
<script>
jQuery(document).ready(function(){
	var base_url = $("#base_url").val();
	$("#adddistrictschools").click(function(e) {
		e.preventDefault();
			window.location.replace(base_url+"admin/adddistricts")
	});	

});
$(window).change(function(e) {
	if($(e.target).hasClass('select_district'))
	{
		var value = $(e.target).val();
		$.ajax({
			url:"<?php echo BASE_URL.'admin/school_lists_not_all'; ?>",
			type:"post",
			data:{district_id:value},
			success:function(result)
			{
				$(".select_school").html(result);
			}
		})
	}
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
	if($(e.target).hasClass('view_pdf'))
	{
		var src = $(e.target).attr("data-src");
		src = "<?php echo BASE_URL.'uploads/index.html?file=../'; ?>"+src;
        console.log(src);
		$(".show_iframe_pdf").attr("src",src);
		$("#show_pdf_modal").modal("show");
	}
	if($(e.target).hasClass('submit_filter'))
	{
		var district = $(".select_district").val();
		var school = $(".select_school").val();
		var year = $(".select_year").val();
		if(district == "") { alert("Please select the District."); }
		else if(school == "") { alert("Please select the School."); }
		else if(year == "") { alert("Please select the Year."); }
		else{
			$.ajax({
				url:"<?php echo BASE_URL.'admin/get_documents_timeline'; ?>",
				type:"post",
				dataType:"json",
				data:{district:district,school:school,year:year},
				success:function(result)
				{
					$(".school_pdfs_div").show();
					$(".table_div").html(result['output']);
					if(result['charter_petition'] == "")
					{
						$(".charter_petition_a").parents(".school_pdfs_div").hide();
					}
					else{
						$(".charter_petition_a").attr("data-src",result['charter_petition']);
						$(".charter_petition_img").attr("data-src",result['charter_petition']);
					}
					if(result['mou'] == "")
					{
						$(".mou_a").parents(".school_pdfs_div").hide();
					}
					else{
						$(".mou_a").attr("data-src",result['mou']);
						$(".mou_img").attr("data-src",result['mou']);
					}
					
				}
			})
		}
	}
	if($(e.target).hasClass('download_full_report'))
    {
      $("body").addClass("loading");
      setTimeout( function() {
        var template_id = $(e.target).attr("data-element");
          var base_url = "<?php echo BASE_URL; ?>";
          $.ajax({
            url:"<?php echo BASE_URL.'admin/download_report_pdf'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              $("body").removeClass("loading");
              //SaveToDiskdownload(base_url+'papers/admin/'+result,result);

                var src = 'papers/admin/'+result;
				src = "<?php echo BASE_URL.'papers/index.html?file=../'; ?>"+src;
				$(".show_iframe_pdf").attr("src",src);
				$("#show_pdf_modal").modal("show");
            }
          })
      },1000);
    }
    if($(e.target).hasClass('download_full_survey'))
    {
      $("body").addClass("loading");
      setTimeout( function() {
        var template_id = $(e.target).attr("data-element");
          var base_url = "<?php echo BASE_URL; ?>";
          $.ajax({
            url:"<?php echo BASE_URL.'admin/download_pdf'; ?>",
            type:"post",
            data:{template_id:template_id},
            success:function(result)
            {
              $("body").removeClass("loading");
              //SaveToDiskdownload(base_url+'papers/admin/'+result,result);
              var src = 'papers/admin/'+result;
				src = "<?php echo BASE_URL.'papers/index.html?file=../'; ?>"+src;
				$(".show_iframe_pdf").attr("src",src);
				$("#show_pdf_modal").modal("show");
            }
          })
      },1000);
    }
});
</script>