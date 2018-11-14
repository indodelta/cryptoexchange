// lazyload config
var MODULE_CONFIG = {
    chat:           [
                      '../admin_assets/libs/list.js/dist/list.js',
                      '../admin_assets/libs/notie/dist/notie.min.js',
                      'admin_assets/scripts/plugins/notie.js',
                      'admin_assets/scripts/app/chat.js'
                    ],
    mail:           [
                      '../admin_assets/libs/list.js/dist/list.js',
                      '../admin_assets/libs/notie/dist/notie.min.js',
                      'admin_assets/scripts/plugins/notie.js',
                      'admin_assets/scripts/app/mail.js'
                    ],
    user:           [
                      '../admin_assets/libs/list.js/dist/list.js',
                      '../admin_assets/libs/notie/dist/notie.min.js',
                      'admin_assets/scripts/plugins/notie.js',
                      'admin_assets/scripts/app/user.js'
                    ],
    screenfull:     [
                      '../admin_assets/libs/screenfull/dist/screenfull.js',
                      'admin_assets/scripts/plugins/screenfull.js'
                    ],
    jscroll:        [
                      '../admin_assetslibs/jscroll/jquery.jscroll.min.js'
                    ],
    stick_in_parent:[
                      '../admin_assets/libs/sticky-kit/jquery.sticky-kit.min.js'
                    ],
    scrollreveal:   [
                      '../admin_assets/libs/scrollreveal/dist/scrollreveal.min.js',
                      'admin_assets/scripts/plugins/jquery.scrollreveal.js'
                    ],
    owlCarousel:    [
                      '../admin_assets/libs/owl.carousel/dist/assets/owl.carousel.min.css',
                      '../admin_assets/libs/owl.carousel/dist/assets/owl.theme.css',
                      '../admin_assets/libs/owl.carousel/dist/owl.carousel.min.js'
                    ],
    html5sortable:  [
                      '../admin_assets/libs/html5sortable/dist/html.sortable.min.js',
                      'admin_assets/scripts/plugins/jquery.html5sortable.js',
                      'admin_assets/scripts/plugins/sortable.js'
                    ],
    easyPieChart:   [
                      '../admin_assets/libs/easy-pie-chart/dist/jquery.easypiechart.min.js' 
                    ],
    peity:          [
                      '../admin_assets/libs/peity/jquery.peity.js',
                      'admin_assets/scripts/plugins/jquery.peity.tooltip.js',
                    ],
    chart:          [
                      '../admin_assets/libs/moment/min/moment-with-locales.min.js',
                      '../admin_assets/libs/chart.js/dist/Chart.min.js',
                      'admin_assets/scripts/plugins/jquery.chart.js',
                      'admin_assets/scripts/plugins/chartjs.js'
                    ],
    dataTable:      [
                      '../admin_assets/libs/datatables/media/js/jquery.dataTables.min.js',
                      '../admin_assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.js',
                      '../admin_assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css',
                      'admin_assets/scripts/plugins/datatable.js'
                    ],
    bootstrapTable: [
                      '../admin_assets/libs/bootstrap-table/dist/bootstrap-table.min.css',
                      '../admin_assets/libs/bootstrap-table/dist/bootstrap-table.min.js',
                      '../admin_assets/libs/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js',
                      '../admin_assets/libs/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.min.js',
                      'admin_assets/scripts/plugins/tableExport.min.js',
                      'admin_assets/scripts/plugins/bootstrap-table.js'
                    ],
    bootstrapWizard:[
                      '../admin_assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js'
                    ],
    dropzone:       [
                      '../admin_assets/libs/dropzone/dist/min/dropzone.min.js',
                      '../admin_assets/libs/dropzone/dist/min/dropzone.min.css'
                    ],
    datetimepicker: [
                      '../admin_assets/libs/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css',
                      '../admin_assets/libs/moment/min/moment-with-locales.min.js',
                      '../admin_assets/libs/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js',
                      'admin_assets/scripts/plugins/datetimepicker.js'
                    ],
    datepicker:     [
                      "../admin_assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
                      "../admin_assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css",
                    ],
    fullCalendar:   [
                      '../admin_assets/libs/moment/min/moment-with-locales.min.js',
                      '../admin_assets/libs/fullcalendar/dist/fullcalendar.min.js',
                      '../admin_assets/libs/fullcalendar/dist/fullcalendar.min.css',
                      'admin_assets/scripts/plugins/fullcalendar.js'
                    ],
    parsley:        [
                      '../admin_assets/libs/parsleyjs/dist/parsley.min.js'
                    ],
    select2:        [
                      '../admin_assets/libs/select2/dist/css/select2.min.css',
                      '../admin_assets/libs/select2/dist/js/select2.min.js',
                      '../admin_assets/scripts/plugins/select2.js'
                    ],
    summernote:     [
                      '../admin_assets/libs/summernote/dist/summernote.css',
                      '../admin_assets/libs/summernote/dist/summernote-bs4.css',
                      '../admin_assets/libs/summernote/dist/summernote.min.js',
                      '../admin_assets/libs/summernote/dist/summernote-bs4.min.js'
                    ],
    vectorMap:      [
                      '../admin_assets/libs/jqvmap/dist/jqvmap.min.css',
                      '../admin_assets/libs/jqvmap/dist/jquery.vmap.js',
                      '../admin_assets/libs/jqvmap/dist/maps/jquery.vmap.world.js',
                      '../admin_assets/libs/jqvmap/dist/maps/jquery.vmap.usa.js',
                      '../admin_assets/libs/jqvmap/dist/maps/jquery.vmap.france.js',
                      'admin_assets/scripts/plugins/jqvmap.js'
                    ],
    waves:          [
                      '../admin_assets/libs/node-waves/dist/waves.min.css',
                      '../admin_assets/libs/node-waves/dist/waves.min.js',
                      'admin_assets/scripts/plugins/waves.js'
                    ]
  };

var MODULE_OPTION_CONFIG = {
  parsley: {
    errorClass: 'is-invalid',
    successClass: 'is-valid',
    errorsWrapper: '<ul class="list-unstyled text-sm mt-1 text-muted"></ul>'
  }
}
