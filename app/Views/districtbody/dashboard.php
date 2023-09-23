<?php 
$this->db = \Config\Database::connect();
$this->session = \Config\Services::session();
?>
<section class="page-content">
  <div class="page-content-inner">
    <!-- Dashboard -->
    <div class="dashboard-container">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven background-default">
                    <div class="widget-body">
                        <a href="<?php echo BASE_URL.'district/manage_schools'; ?>">
                            <div href="javascript: void(0);" class="widget-body-inner">
                                <h5 class="text-uppercase">Manage Schools</h5>
                                <i class="counter-icon fa fa-graduation-cap"></i>
                                <span class="counter-count">
                                    <?php $schools_count = $this->db->table('go_schools')->select('*')->countAllResults(); ?>
                                    <span class="counter-init" data-from="0" data-to="<?php echo $schools_count; ?>"></span>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven" style="background: #009750">
                    <div class="widget-body">
                        <a href="<?php echo BASE_URL.'district/documents_timeline'; ?>">
                            <div href="javascript: void(0);" class="widget-body-inner">
                                <h5 class="text-uppercase" style="color:#fff">Documents & Timeline</h5>
                                <i class="counter-icon fa fa-file" style="color: #fff;"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven">
                    <div class="widget-body">
                        <a href="<?php echo BASE_URL.'district/manage_full_surveys'; ?>">
                            <div href="javascript: void(0);" class="widget-body-inner">
                                <h5 class="text-uppercase">Manage Oversight Survey</h5>
                                <i class="counter-icon icmn-users"></i>
                                <span class="counter-count">
                                    <?php $survey_count = $this->db->table('master_templates')->select('*')->where('school_id !=',0)->countAllResults(); ?>
                                    <span class="counter-init" data-from="0" data-to="<?php echo $survey_count; ?>"></span>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12" >
                <div class="widget widget-seven" style="background: #93ffff">
                    <div class="widget-body">
                        <a href="<?php echo BASE_URL.'district/manage_reports'; ?>">
                            <div href="javascript: void(0);" class="widget-body-inner">
                                <h5 class="text-uppercase">Manage Fiscal Reports</h5>
                                <i class="counter-icon icmn-users"></i>
                                <span class="counter-count">
                                    <?php $report_count = $this->db->table('reports')->select('*')->where('master',1)->countAllResults(); ?>
                                    <span class="counter-init" data-from="0" data-to="14"></span>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                <div class="widget widget-seven" style="background: #7ebcff">
                    <div class="widget-body">
                        <a href="<?php echo BASE_URL.'district/view_result_reports'; ?>">
                            <div href="javascript: void(0);" class="widget-body-inner">
                                <h5 class="text-uppercase" style="color:#5b5b5b">View Status Fiscal Reports</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Dashboard -->
  </div>
  <!-- Page Scripts -->
<script>
    $(function() {

        ///////////////////////////////////////////////////////////
        // COUNTERS
        $('.counter-init').countTo({
            speed: 1500
        });

        ///////////////////////////////////////////////////////////
        // ADJUSTABLE TEXTAREA
        autosize($('#textarea'));

        ///////////////////////////////////////////////////////////
        // CUSTOM SCROLL
        if (!cleanUI.hasTouch) {
            $('.custom-scroll').each(function() {
                $(this).jScrollPane({
                    autoReinitialise: true,
                    autoReinitialiseDelay: 100
                });
                var api = $(this).data('jsp'),
                        throttleTimeout;
                $(window).bind('resize', function() {
                    if (!throttleTimeout) {
                        throttleTimeout = setTimeout(function() {
                            api.reinitialise();
                            throttleTimeout = null;
                        }, 50);
                    }
                });
            });
        }

        ///////////////////////////////////////////////////////////
        // CALENDAR
        $('.example-calendar-block').fullCalendar({
            //aspectRatio: 2,
            height: 450,
            header: {
                left: 'prev, next',
                center: 'title',
                right: 'month, agendaWeek, agendaDay'
            },
            buttonIcons: {
                prev: 'none fa fa-arrow-left',
                next: 'none fa fa-arrow-right',
                prevYear: 'none fa fa-arrow-left',
                nextYear: 'none fa fa-arrow-right'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            viewRender: function(view, element) {
                if (!cleanUI.hasTouch) {
                    $('.fc-scroller').jScrollPane({
                        autoReinitialise: true,
                        autoReinitialiseDelay: 100
                    });
                }
            },
            defaultDate: '2016-05-12',
            events: [
                {
                    title: 'All Day Event',
                    start: '2016-05-01',
                    className: 'fc-event-success'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2016-05-09T16:00:00',
                    className: 'fc-event-default'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2016-05-16T16:00:00',
                    className: 'fc-event-success'
                },
                {
                    title: 'Conference',
                    start: '2016-05-11',
                    end: '2016-05-14',
                    className: 'fc-event-danger'
                }
            ],
            eventClick: function(calEvent, jsEvent, view) {
                if (!$(this).hasClass('event-clicked')) {
                    $('.fc-event').removeClass('event-clicked');
                    $(this).addClass('event-clicked');
                }
            }
        });

        ///////////////////////////////////////////////////////////
        // CAROUSEL WIDGET
        $('.carousel-widget').carousel({
            interval: 4000
        });

        $('.carousel-widget-2').carousel({
            interval: 6000
        });

        ///////////////////////////////////////////////////////////
        // DATATABLES
        $('#example1').DataTable({
            responsive: true,
            "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]]
        });

        ///////////////////////////////////////////////////////////
        // CHART 1
        // new Chartist.Line(".chart-line", {
        //     labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
        //     series: [
        //         [12, 9, 7, 8, 5],
        //         [2, 1, 3.5, 7, 3],
        //         [1, 3, 4, 5, 6]
        //     ]
        // }, {
        //     fullWidth: !0,
        //     chartPadding: {
        //         right: 40
        //     },
        //     plugins: [
        //         Chartist.plugins.tooltip()
        //     ]
        // });

        ///////////////////////////////////////////////////////////
        // CHART 2
        // var overlappingData = {
        //             labels: ["Jan", "Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //             series: [
        //                 [5, 4, 3, 7, 5, 10, 3, 4, 8, 10, 6, 8],
        //                 [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4]
        //             ]
        //         },
        //         overlappingOptions = {
        //             seriesBarDistance: 10,
        //             plugins: [
        //                 Chartist.plugins.tooltip()
        //             ]
        //         },
        //         overlappingResponsiveOptions = [
        //             ["", {
        //                 seriesBarDistance: 5,
        //                 axisX: {
        //                     labelInterpolationFnc: function(value) {
        //                         return value[0]
        //                     }
        //                 }
        //             }]
        //         ];

        // new Chartist.Bar(".chart-overlapping-bar", overlappingData, overlappingOptions, overlappingResponsiveOptions);


    });
</script>
</section>