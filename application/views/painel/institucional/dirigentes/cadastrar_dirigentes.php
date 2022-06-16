

  <div class="container body">


    <div class="main_container">

      

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <div class="page-title">
            <div class="title_left">
              <h3>Dirigente</h3>
            </div>
            
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>CADASTRO</h2>
                 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                <?php 
	            	//echo form_close();
					get_msg('msgok');
					get_msg('msgerro');
					erros_validacao();
				?>	

                <?php 
			 		echo form_open('painel/cadastrar_dirigentes',array('id'=>'demo-form2','class'=>'form-horizontal form-label-left')); 
			 	?>
				                

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nome 
							<span class="required">*</span>
						</label>
						<div class="col-md-9 col-sm-9 col-xs-9">
							<?php
								echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Nome do dirigente'), set_value('nome'), 'autofocus required');
							?>
							<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cargo 
							<span class="required">*</span>
						</label>
						<div class="col-md-9 col-sm-9 col-xs-9">
							<?php
								echo form_input(array('name' => 'cargo', 'class' => 'form-control', 'placeholder' => 'Cargo do dirigente'), set_value('cargo'), 'autofocus required');
							?>
							<span class="fa fa-address-book-o form-control-feedback right" aria-hidden="true"></span>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email 
							
						</label>
						<div class="col-md-9 col-sm-9 col-xs-9">
							<?php
								echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email do dirigente'), set_value('cargo'), 'autofocus required');
							?>
							<span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
						</div>
						
					</div>
					
                    <div class="form-group">
                    <!-- 
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div id="gender" class="btn-group" data-toggle="buttons">
                          
                           <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                          	
                          	<?php
                          /*	$data = array(
							    'name'        => 'situacao',
							    'value'       => 'ativo',
							    'style'       => 'margin:10px',
							    );
                          		
                          	?>
                          	
                          	<?php
                          		echo form_radio($data).'&nbsp; Ativo &nbsp;';
                          	?>
                          </label>
                          <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                      		<?php
                          		echo form_radio($data).'Inativo';*/
                          	?>
                          </label>
                          
                        </div>
                      </div>
                      
                      Verificar depois a questão do status de ativo e inativo
                      -->
                    </div>
                   
                    
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                      	<?php
                      		echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-success'), 'Cadastrar');	 
		                	echo form_hidden('codusuario', $this -> session -> userdata('user_codusuario'));
		                 ?>
                       <input type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-danger submit">
                        
                      </div>
                    </div>

                  <?php
                 	 echo form_close();
                  ?>
                </div>
              </div>
            </div>
          </div>

		
   
        </div>
        <!-- /page content -->

      </div>

    </div>
  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>


  <!-- icheck -->
  <!-- tags -->
  <script  src="<?php echo base_url();?>assets/painel/js/tags/jquery.tagsinput.min.js"></script>
  <!-- switchery -->
  <script  src="<?php echo base_url();?>assets/painel/js/switchery/switchery.min.js"></script>
   
   <script type="text/javascript" src="<?php echo base_url();?>assets/painel/js/moment/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/painel/js/datepicker/daterangepicker.js"></script>
  <!-- input mask -->
  <script src="<?php echo base_url();?>assets/painel/js/input_mask/jquery.inputmask.js"></script>
  <!-- knob -->
  <script src="<?php echo base_url();?>assets/painel/js/knob/jquery.knob.min.js"></script>
  <!-- range slider -->
  <script src="<?php echo base_url();?>assets/painel/js/ion_range/ion.rangeSlider.min.js"></script>
   
   
  <script src="<?php echo base_url();?>assets/painel/js/input_mask/jquery.inputmask.js"></script>
  <!-- richtext editor -->
  <script  src="<?php echo base_url();?>assets/painel/js/editor/bootstrap-wysiwyg.js"></script>
  <script  src="<?php echo base_url();?>assets/painel/js/editor/external/jquery.hotkeys.js"></script>
  <script  src="<?php echo base_url();?>assets/painel/js/editor/external/google-code-prettify/prettify.js"></script>
  <!-- select2 -->
  <script  src="<?php echo base_url();?>assets/painel/js/select/select2.full.js"></script>
  <!-- form validation -->
  <script type="text/javascript"  src="<?php echo base_url();?>assets/painel/js/parsley/parsley.min.js"></script>
  <!-- textarea resize -->
  <script  src="<?php echo base_url();?>assets/painel/js/textarea/autosize.min.js"></script>
  <script>
    autosize($('.resizable_textarea'));
  </script>
  <!-- Autocomplete -->
  <script type="text/javascript"  src="<?php echo base_url();?>assets/painel/js/autocomplete/countries.js"></script>
  <script  src="<?php echo base_url();?>assets/painel/js/autocomplete/jquery.autocomplete.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      var countriesArray = $.map(countries, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  <script src="<?php echo base_url();?>assets/painel/js/custom.js"></script>


  <!-- select2 -->
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Select a state",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "With Max Selection limit 4",
        allowClear: true
      });
    });
  </script>
  <!-- /select2 -->
  <!-- input tags -->
  <script>
    function onAddTag(tag) {
      alert("Added a tag: " + tag);
    }

    function onRemoveTag(tag) {
      alert("Removed a tag: " + tag);
    }

    function onChangeTag(input, tag) {
      alert("Changed a tag: " + tag);
    }

    $(function() {
      $('#tags_1').tagsInput({
        width: 'auto'
      });
    });
  </script>
  <!-- /input tags -->
  <!-- form validation -->
  <script type="text/javascript">
    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form .btn').on('click', function() {
        $('#demo-form').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });

    $(document).ready(function() {
      $.listen('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form2 .btn').on('click', function() {
        $('#demo-form2').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form2').parsley().isValid()) {
          $('.bs-callout-info').removeClass('hidden');
          $('.bs-callout-warning').addClass('hidden');
        } else {
          $('.bs-callout-info').addClass('hidden');
          $('.bs-callout-warning').removeClass('hidden');
        }
      };
    });
    try {
      hljs.initHighlightingOnLoad();
    } catch (err) {}
  </script>
  <!-- /form validation -->
  <!-- editor -->
  <script>
    $(document).ready(function() {
      $('.xcxc').click(function() {
        $('#descr').val($('#editor').html());
      });
    });

    $(function() {
      function initToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'
          ],
          fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function(idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
        });
        $('a[title]').tooltip({
          container: 'body'
        });
        $('.dropdown-menu input').click(function() {
            return false;
          })
          .change(function() {
            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
          })
          .keydown('esc', function() {
            this.value = '';
            $(this).change();
          });

        $('[data-role=magic-overlay]').each(function() {
          var overlay = $(this),
            target = $(overlay.data('target'));
          overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
        });
        if ("onwebkitspeechchange" in document.createElement("input")) {
          var editorOffset = $('#editor').offset();
          $('#voiceBtn').css('position', 'absolute').offset({
            top: editorOffset.top,
            left: editorOffset.left + $('#editor').innerWidth() - 35
          });
        } else {
          $('#voiceBtn').hide();
        }
      };

      function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
          msg = "Unsupported format " + detail;
        } else {
          console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
          '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
      };
      initToolbarBootstrapBindings();
      $('#editor').wysiwyg({
        fileUploadError: showErrorAlert
      });
      window.prettyPrint && prettyPrint();
    });
  </script>
  <!-- /editor -->
  
  <!-- datepicker -->
  <script type="text/javascript">
    $(document).ready(function() {

      var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2016',
        maxDate: '31/12/2016',
        dateLimit: {
          days: 90
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
          'Hoje': [moment(), moment()],
          'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
          'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
          'Este mês': [moment().startOf('month'), moment().endOf('month')],
          'Último mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
          applyLabel: 'Submit',
          cancelLabel: 'Clear',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          firstDay: 1
        }
      };
      $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
      });
      $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
      });
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
      });
      $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
      });
      $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
      });
      $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
      });
    });
  </script>
  <!-- /datepicker -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#single_cal1').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_1"
      }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });
      $('#single_cal2').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_2"
      }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });
      $('#single_cal3').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_3"
      }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });
      $('#single_cal4').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_4"
      }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#reservation').daterangepicker(null, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });
    });
  </script>
  <!-- /datepicker -->
  <!-- input_mask -->
  <script>
    $(document).ready(function() {
      $(":input").inputmask();
    });
  </script>
  <!-- /input mask -->
  <!-- ion_range -->
  <script>
    $(function() {
      $("#range_27").ionRangeSlider({
        type: "double",
        min: 1000000,
        max: 2000000,
        grid: true,
        force_edges: true
      });
      $("#range").ionRangeSlider({
        hide_min_max: true,
        keyboard: true,
        min: 0,
        max: 5000,
        from: 1000,
        to: 4000,
        type: 'double',
        step: 1,
        prefix: "$",
        grid: true
      });
      $("#range_25").ionRangeSlider({
        type: "double",
        min: 1000000,
        max: 2000000,
        grid: true
      });
      $("#range_26").ionRangeSlider({
        type: "double",
        min: 0,
        max: 10000,
        step: 500,
        grid: true,
        grid_snap: true
      });
      $("#range_31").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 30,
        to: 70,
        from_fixed: true
      });
      $(".range_min_max").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100,
        from: 30,
        to: 70,
        max_interval: 50
      });
      $(".range_time24").ionRangeSlider({
        min: +moment().subtract(12, "hours").format("X"),
        max: +moment().format("X"),
        from: +moment().subtract(6, "hours").format("X"),
        grid: true,
        force_edges: true,
        prettify: function(num) {
          var m = moment(num, "X");
          return m.format("Do MMMM, HH:mm");
        }
      });
    });
  </script>
  <!-- /ion_range -->
  <!-- knob -->
  <script>
    $(function($) {

      $(".knob").knob({
        change: function(value) {
          //console.log("change : " + value);
        },
        release: function(value) {
          //console.log(this.$.attr('value'));
          console.log("release : " + value);
        },
        cancel: function() {
          console.log("cancel : ", this);
        },
        /*format : function (value) {
         return value + '%';
         },*/
        draw: function() {

          // "tron" case
          if (this.$.data('skin') == 'tron') {

            this.cursorExt = 0.3;

            var a = this.arc(this.cv) // Arc
              ,
              pa // Previous arc
              , r = 1;

            this.g.lineWidth = this.lineWidth;

            if (this.o.displayPrevious) {
              pa = this.arc(this.v);
              this.g.beginPath();
              this.g.strokeStyle = this.pColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
              this.g.stroke();
            }

            this.g.beginPath();
            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
            this.g.stroke();

            this.g.lineWidth = 2;
            this.g.beginPath();
            this.g.strokeStyle = this.o.fgColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
            this.g.stroke();

            return false;
          }
        }
      });

      // Example of infinite knob, iPod click wheel
      var v, up = 0,
        down = 0,
        i = 0,
        $idir = $("div.idir"),
        $ival = $("div.ival"),
        incr = function() {
          i++;
          $idir.show().html("+").fadeOut();
          $ival.html(i);
        },
        decr = function() {
          i--;
          $idir.show().html("-").fadeOut();
          $ival.html(i);
        };
      $("input.infinite").knob({
        min: 0,
        max: 20,
        stopper: false,
        change: function() {
          if (v > this.cv) {
            if (up) {
              decr();
              up = 0;
            } else {
              up = 1;
              down = 0;
            }
          } else {
            if (v < this.cv) {
              if (down) {
                incr();
                down = 0;
              } else {
                down = 1;
                up = 0;
              }
            }
          }
          v = this.cv;
        }
      });
    });
  </script>
  <!-- /knob -->

