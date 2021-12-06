<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Admin Panel</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <link rel="stylesheet" href="<?php echo e(url('css/cropper.min.css')); ?>">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            #resizable { width: 150px; height: 150px; padding: 0.5em; }
            #resizable h3 { text-align: center; margin: 0; }
        </style>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <!--page specific css styles-->
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/chosen-bootstrap/chosen.min.css')); ?>" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/jquery-tags-input/jquery.tagsinput.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/jquery-pwstrength/jquery.pwstrength.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-fileupload/bootstrap-fileupload.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-duallistbox/duallistbox/bootstrap-duallistbox.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/dropzone/downloads/css/dropzone.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-colorpicker/css/colorpicker.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-timepicker/compiled/timepicker.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/clockface/css/clockface.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-datepicker/css/datepicker.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-daterangepicker/daterangepicker.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-switch/static/stylesheets/bootstrap-switch.css')); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css')); ?>" />

        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />


        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo e(url('assets/data-tables/bootstrap3/dataTables.bootstrap.css')); ?>" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />


        <!--base css styles-->
        <link rel="stylesheet" href="<?php echo e(url('assets/bootstrap/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/font-awesome/css/font-awesome.min.css')); ?>">
        <!--page specific css styles-->

        <!--flaty css styles-->
        <link rel="stylesheet" href="<?php echo e(url('css/flaty.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('css/flaty-responsive.css')); ?>">

        
        <?php if(App::getLocale() == 'ar'): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(url('css/rtl.css')); ?>">
        <link href="<?php echo e(url('https://fonts.googleapis.com/css?family=Cairo:600')); ?>" rel="stylesheet">
        <?php endif; ?>

        <link rel="shortcut icon" href="<?php echo e(url('img/favicon.png')); ?>">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
        return false;
}
        </script>


    </head>
    <body>
        <div id="theme-setting">
            <a href="#"><i class="fa fa-gears fa fa-2x"></i></a>
            <ul>
                <li>
                    <span>Skin</span>
                    <ul class="colors" data-target="body" data-prefix="skin-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="magenta" href="#"></a></li>
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span>Navbar</span>
                    <ul class="colors" data-target="#navbar" data-prefix="navbar-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="magenta" href="#"></a></li>
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span>Sidebar</span>
                    <ul class="colors" data-target="#main-container" data-prefix="sidebar-">
                        <li class="active"><a class="blue" href="#"></a></li>
                        <li><a class="red" href="#"></a></li>
                        <li><a class="green" href="#"></a></li>
                        <li><a class="orange" href="#"></a></li>
                        <li><a class="yellow" href="#"></a></li>
                        <li><a class="pink" href="#"></a></li>
                        <li><a class="magenta" href="#"></a></li>
                        <li><a class="gray" href="#"></a></li>
                        <li><a class="black" href="#"></a></li>
                    </ul>
                </li>
                <li>
                    <span></span>
                    <a data-target="navbar" href="#"><i class="fa fa-square-o"></i> Fixed Navbar</a>
                    <a class="hidden-inline-xs" data-target="sidebar" href="#"><i class="fa fa-square-o"></i> Fixed Sidebar</a>
                </li>
            </ul>
        </div>
        <!-- BEGIN Navbar -->
        <div id="navbar" class="navbar">
            <button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
                <span class="fa fa-bars"></span>
            </button>
            <a class="navbar-brand" href="<?php echo e(url('/dashboard')); ?>">
                <small>
                    <i class="fa fa-home"></i>
                    <?php echo app('translator')->get('messages.dashboard'); ?>
                </small>
            </a>

            <!-- BEGIN Navbar Buttons -->
            <ul class="nav flaty-nav pull-right">

                <!-- BEGIN Tasks Dropdown -->
                <li>
                    <a href="<?php

                    use App\Notification;

if (Config::get('languages')[App::getLocale()] == "English") {
                        echo route('lang.switch', "ar");
                    } else {
                        echo route('lang.switch', "en");
                    }
                    ?>" >
                           <?php
                           if (Config::get('languages')[App::getLocale()] == "English")
                               echo "عربي";
                           else
                               echo "English";
                           ?>
                    </a>
                </li>
                <!-- BEGIN Button User -->
                <li class="user-profile">
                    <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                        <span class="hhh" id="user_info">
                            <?php echo Auth::user()->name; ?>

                        </span>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <!-- BEGIN User Dropdown -->
                    <ul class="dropdown-menu dropdown-navbar" id="user_menu">
                        <li>
                            <a href="<?php echo e(url('user_profile')); ?>">
                                <i class="fa fa-user"></i>
                                <?php echo app('translator')->get('messages.profile'); ?>
                            </a>
                        </li>

                        <li class="divider visible-xs"></li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo e(url('logout')); ?>" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                <i class="fa fa-off"></i>
                                <?php echo app('translator')->get('messages.logout'); ?>
                            </a>
                            <form id="frm-logout" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </li>
                    </ul>
                    <!-- BEGIN User Dropdown -->
                </li>
                <!-- END Button User -->
            </ul>
            <!-- END Navbar Buttons -->
        </div>
        <!-- END Navbar -->

        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            <!-- BEGIN Sidebar -->
            <div id="sidebar" class="navbar-collapse collapse">
                <!-- BEGIN Navlist -->
                <ul class="nav nav-list">
                    <?php if(get_action_icons('users', 'get')): ?>
                    <li id="user">
                        <a href="#" class="dropdown-toggle">
                            <i class="fa fa-users"></i>
                            <span><?php echo app('translator')->get('messages.users.users'); ?></span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                        <ul class="submenu">
                            <li id="user-create"><a href="<?php echo e(url('users/new')); ?>"><?php echo app('translator')->get('messages.users.add_user'); ?></a></li>
                            <li id="user-index"><a href="<?php echo e(url('users')); ?>"><?php echo app('translator')->get('messages.users.users'); ?></a></li>
                        </ul>
                        <!-- END Submenu -->
                    </li>
                    <?php endif; ?>

                    <?php if(get_action_icons('roles', 'get')): ?>
                    <li id="role">
                        <a href="#" class="dropdown-toggle">
                            <i class="glyphicon glyphicon-road"></i>
                            <span><?php echo app('translator')->get('messages.role'); ?></span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                        <ul class="submenu">
                            <li id="role-create"><a href="<?php echo e(url('roles/new')); ?>"><?php echo app('translator')->get('messages.create-role'); ?></a></li>
                            <li id="role-index"><a href="<?php echo e(url('roles')); ?>"><?php echo app('translator')->get('messages.role'); ?></a></li>
                            <li id="route-index"><a href="<?php echo e(url('all_routes')); ?>"><?php echo app('translator')->get('messages.Routes.Routes'); ?></a></li>
                            <li id="route-v2-index"><a href="<?php echo e(url('routes/index_v2')); ?>"><?php echo app('translator')->get('messages.Routes.Routes'); ?> V2</a></li>

                        </ul>
                        <!-- END Submenu -->
                    </li>
                    <?php endif; ?>

                    <?php if(get_action_icons('setting', 'get')): ?>
                    <li id="file_manager">
                        <a href="#" class="dropdown-toggle">
                            <i class="fa fa-file"></i>
                            <span><?php echo app('translator')->get('messages.File Manager.File Manager'); ?></span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                        <ul class="submenu">
                            <!--<li id="elfinder"><a href="<?php echo e(url('file_manager')); ?>">UI File Manager</a></li>-->
                            <li id="file_elfinder"><a href="<?php echo e(url('admin/elfinder')); ?>"><?php echo app('translator')->get('messages.File Manager.uiFile Manager'); ?></a></li>
                            <li id="uploader"><a href="<?php echo e(url('upload_items')); ?>"><?php echo app('translator')->get('messages.File Manager.file uploader'); ?></a></li>
                        </ul>
                        <!-- END Submenu -->
                    </li>
                    <?php endif; ?>

                    <?php if(get_action_icons('setting', 'get')): ?>
                    <li id="images">
                        <a href="#" class="dropdown-toggle">
                            <i class="glyphicon glyphicon-fullscreen"></i>
                            <span><?php echo app('translator')->get('messages.Image.Image'); ?></span>
                            <b class="arrow fa fa-angle-right"></b>
                        </a>

                        <!-- BEGIN Submenu -->
                        <ul class="submenu">
                            <li id="upload_resize"><a href="<?php echo e(url('upload_resize')); ?>"><?php echo app('translator')->get('messages.Image.Upload/Resize Image'); ?></a></li>
                            <li id="upload_resize_v2"><a href="<?php echo e(url('upload_resize_v2')); ?>"><?php echo app('translator')->get('messages.Image.Upload/Resize Image'); ?> V2</a></li>
                        </ul>
                        <!-- END Submenu -->
                    </li>
                    <?php endif; ?>

                    <?php if(get_action_icons('language', 'get')): ?>
                    <ul class="nav nav-list">
                        <li id="language">
                            <a href="#" class="dropdown-toggle">
                                <i class="glyphicon glyphicon-cloud"></i>
                                <span><?php echo app('translator')->get('messages.Static Translations.Languages'); ?></span>
                                <b class="arrow fa fa-angle-right"></b>
                            </a>

                            <!-- BEGIN Submenu -->
                            <ul class="submenu">
                                <li id="language-create"><a href="<?php echo e(url('language/create')); ?>"><?php echo app('translator')->get('messages.Static Translations.Add Language'); ?></a></li>
                                <li id="language-index"><a href="<?php echo e(url('language')); ?>"><?php echo app('translator')->get('messages.Static Translations.Languages'); ?></a></li>
                            </ul>
                            <!-- END Submenu -->
                        </li>
                    </ul>
                    <?php endif; ?>

                    <?php if(get_action_icons('country', 'get')): ?>
                    <ul class="nav nav-list">
                        <li id="country">
                            <a href="#" class="dropdown-toggle">
                                <i class="glyphicon glyphicon-globe"></i>
                                <span><?php echo app('translator')->get('messages.country.country'); ?></span>
                                <b class="arrow fa fa-angle-right"></b>
                            </a>

                            <!-- BEGIN Submenu -->
                            <ul class="submenu">
                                <li id="country_index"><a href="<?php echo e(url('country')); ?>"><?php echo app('translator')->get('messages.country.countries'); ?></a></li>
                                <li id="country_create"><a href="<?php echo e(url('country/create')); ?>"><?php echo app('translator')->get('messages.country.add'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php endif; ?>

                    <!-- <ul class="nav nav-list">
                        <li id="appointment">
                            <a href="#" class="dropdown-toggle">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo app('translator')->get('messages.reservations.reservations'); ?></span>
                                <b class="arrow fa fa-angle-right"></b>
                            </a>

                            <ul class="submenu">
                                <li id="reservation_index"><a href="<?php echo e(url('reservation')); ?>"><?php echo app('translator')->get('messages.reservations.reservations'); ?></a></li>
                                <li id="reservation_create"><a href="<?php echo e(url('reservation/create')); ?>"><?php echo app('translator')->get('messages.reservations.create_reservation'); ?></a></li>
                            </ul>
                        </li>
                    </ul> -->

                    <ul class="nav nav-list">
                        <li id="doctor">
                            <a href="#" class="dropdown-toggle">
                                <i class="fa fa-users"></i>
                                <span><?php echo app('translator')->get('messages.clients.clients'); ?></span>
                                <b class="arrow fa fa-angle-right"></b>
                            </a>

                            <!-- BEGIN Submenu -->
                            <ul class="submenu">
                                <li id="client_index"><a href="<?php echo e(url('client')); ?>"><?php echo app('translator')->get('messages.clients.clients'); ?></a></li>
                                <li id="client_create"><a href="<?php echo e(url('client/create')); ?>"><?php echo app('translator')->get('messages.clients.create_client'); ?></a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="nav nav-list">
                        <li id="center">
                            <a href="#" class="dropdown-toggle">
                                <i class="fa fa-gears"></i>
                                <span><?php echo app('translator')->get('messages.general_settings'); ?></span>
                                <b class="arrow fa fa-angle-right"></b>
                            </a>

                            <!-- BEGIN Submenu -->
                            <ul class="submenu">
                                <li id="center_index"><a href="<?php echo e(url('center')); ?>"><?php echo app('translator')->get('messages.centers.centers'); ?></a></li>
                                <li id="massara_index"><a href="<?php echo e(url('massara')); ?>"><?php echo app('translator')->get('messages.massara.massara_about'); ?></a></li>
                                <li id="term_index"><a href="<?php echo e(url('term')); ?>"><?php echo app('translator')->get('messages.terms_conditions.terms_conditions'); ?></a></li>
                            </ul>
                        </li>
                    </ul>

                </ul>
                <!-- END Navlist -->

                <!-- BEGIN Sidebar Collapse Button -->
                <div id="sidebar-collapse" class="visible-lg">
                    <i class="fa fa-angle-double-left"></i>
                </div>
                <!-- END Sidebar Collapse Button -->
            </div>
            <!-- END Sidebar -->

            <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-file-o"></i> <?php echo $__env->yieldContent('page_title'); ?></h1>
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="active"><i class="fa fa-home"></i> <?php echo app('translator')->get('messages.home'); ?>/ <?php echo $__env->yieldContent('page_title'); ?> </li>
                    </ul>
                </div>
                <!-- END Breadcrumb -->

                <?php echo $__env->make('partial.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <div class="footer" align="center" style=" position: absolute; width: 100%; bottom: 0;">
                <p><?php echo e(\Carbon\Carbon::now()->year); ?> © Massara</p>
            </div>
            <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- END Content -->
        <!-- END Container -->

        <!--basic scripts-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/jquery/jquery-2.1.4.min.js"><\/script>')</script>
        <script src="<?php echo e(url('assets/jquery-cookie/jquery.cookie.js')); ?>"></script>
        <script src="<?php echo e(url('assets/bootstrap/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
        <script src="<?php echo e(url('js/flaty.js')); ?>"></script>
        <?php
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        if (strpos($url, 'elfinder') === false) {
            ?>
            <!--page specific plugin scripts-->
            <script src="<?php echo e(url('assets/flot/jquery.flot.js')); ?>"></script>
            <script src="<?php echo e(url('assets/flot/jquery.flot.resize.js')); ?>"></script>
            <script src="<?php echo e(url('assets/flot/jquery.flot.pie.js')); ?>"></script>
            <script src="<?php echo e(url('assets/flot/jquery.flot.stack.js')); ?>"></script>
            <script src="<?php echo e(url('assets/flot/jquery.flot.crosshair.js')); ?>"></script>
            
        <script src="<?php echo e(url('assets/sparkline/jquery.sparkline.min.js')); ?>"></script>


        <script type="text/javascript" src="<?php echo e(url('assets/chosen-bootstrap/chosen.jquery.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-inputmask/bootstrap-inputmask.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/jquery-tags-input/jquery.tagsinput.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/jquery-pwstrength/jquery.pwstrength.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-fileupload/bootstrap-fileupload.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-duallistbox/duallistbox/bootstrap-duallistbox.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/dropzone/downloads/dropzone.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-timepicker/js/bootstrap-timepicker.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/clockface/js/clockface.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-daterangepicker/date.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-switch/static/js/bootstrap-switch.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(url('assets/ckeditor/ckeditor.js')); ?>"></script>


        <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo e(url('assets_/data-tables/bootstrap3/dataTables.bootstrap.js')); ?>"></script>


        <!--flaty scripts-->

        <script>
    $('#mySwitch').on('switch-change', function (e, data) {
    var $el = $(data.el)
            , value = data.value;
    // console.log(value);
    if (value == false) {
        $('input[name="featured"]').val(0);
    } else {
        $('input[name="featured"]').val(1);
    }
    // console.log(e, $el, value);
    });
        </script>
        <script>
            $(function () {
                $("audio").on("play", function () {
                    $("audio").not(this).each(function (index, audio) {
                        audio.pause();
                    });
                    $("video").each(function (index, video) {
                        video.pause();
                    });
                });

                $("video").on("play", function () {
                    $("video").not(this).each(function (index, video) {
                        video.pause();
                    });
                    $("audio").each(function (index, audio) {
                        audio.pause();
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                // $('#example').DataTable();
                var el = $('.chosen-rtl');
                if ("<?php echo App::getLocale(); ?>" == "ar") {
                    el.chosen({
                        rtl: true,
                        width: '100%'
                    });
                }
                else {
                    el.addClass("chosen");
                    el.removeClass("chosen-rtl");
                    $(".chosen").chosen();
                }
            });
        </script>



        <script>
            var table_ids_array = [], table_name = '';

            $("body").on("click", "#check_all", function() {
                var ele = $(this);
                if (ele.prop('checked')) {
                    table_ids_array = [];
                    $('input[type=checkbox].select_all_template').each(function() {
                        $(this).prop('checked', true);
                        table_ids_array.push($(this).val());
                        table_name = $(this).data('table');
                    });
                } else {
                    table_ids_array = [];
                    ele.prop("checked", false);
                }
            });


            $('body').on('click', '.select_all_template', function () {
                if ($(this).prop('checked')) {
                    $(this).prop('checked', true);
                    table_ids_array.push($(this).val());
                } else {
                    $(this).prop('checked', false);
                    var index = table_ids_array.indexOf($(this).val());
                    if (index !== -1) {
                        table_ids_array.splice(index, 1);
                    }
                }

                console.log(table_ids_array);
            });
        </script>


        <script>
            $(document).ready(function () {
                // $('#example').DataTable();
            });


            function delete_selected(table_name) {
                var confirmation = confirm('Are you sure you want to delete this ?');
                if (confirmation)
                {
                    var form = document.createElement("form");
                    var element = document.createElement("input");
                    var tb_name = document.createElement("input");
                    var csrf = document.createElement("input");
                    csrf.name = "_token";
                    csrf.value = "<?php echo e(csrf_token()); ?>";
                    csrf.type = "hidden";

                    form.method = "POST";
                    form.action = "<?php echo e(url('delete_multiselect')); ?>";

                    element.value = table_ids_array;
                    element.name = "selected_list";
                    element.type = "hidden";

                    tb_name.value = table_name;
                    tb_name.name = "table_name";
                    tb_name.type = "hidden";

                    form.appendChild(element);
                    form.appendChild(csrf);
                    form.appendChild(tb_name);

                    document.body.appendChild(form);

                    if (table_ids_array.length > 0)
                        form.submit();
                    else
                        alert ('Select Some Item');
                }
            }

            var initChosenWidgets = function () {
                $(".chosen").chosen();
            };
        </script>
        <script>
            $(document).ready(function () {
                $('#example').DataTable({
                    //  'lengthMenu': [5, 10, 15, 20, 25, 50, 'All']
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "pageLength": 50
                });
            });
        </script>
        <script src="<?php echo e(url('js/cropper.min.js')); ?>" defer></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#resizable").resizable();
            });
            try {
                $('.js-datepicker').datepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoUpdateInput": false,
                     dateFormat: 'yy-mm-dd'
                });



            } catch(er) {console.log(er);}
        </script>
        <script src="<?php echo e(url('js/flaty-demo-codes.js')); ?>"></script>
    <?php } ?>
    <?php echo $__env->yieldContent('script'); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\safir\resources\views/template.blade.php ENDPATH**/ ?>