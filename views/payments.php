<!DOCTYPE html>
<html lang="en" dir="rtl">
    <!-- BEGIN HEAD -->
    <head>
        <?php require_once 'layout/head.php' ?>
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        <!-- BEGIN HEADER -->
        <?php require_once 'layout/header.php' ?>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- END SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <?php require_once'layout/sidebar.php' ?>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->
                    <?php //require_once'layout\theme_panel.php' ?>
                    <!-- END THEME PANEL -->
                    <h1 class="page-title"> الخرج
                        <small></small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="<?= URL ?>">الرئسية</a>
                                <i class="fa fa-angle-right">الخرج</i>
                            </li>
                            <li>
                                <span></span>
                            </li>
                        </ul>
                        <div class="page-toolbar">

                        </div>
                    </div>
                    <!-- END PAGE HEADER-->
                    <?php if ($success_msg != '') { ?>
                        <div id="prefix_1333978461963" title="" message="<?= $success_msg ?>" btn-class="btn-success" type="success">
                        </div>
                    <?php } elseif ($error_msg != '') { ?>
                        <div id="prefix_1333978461963" title="" message="<?= $error_msg ?>" btn-class="btn-danger" type="error">
                        </div>
                    <?php } ?>
                    <div class="row">
                        <!-- WRITE YOUR CONTENT HERE -->
                        <?php
                        if ($form_type == 'insert') {
                            ?>
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption font-green">
                                        <i class="icon-pin font-green"></i>
                                        <span class="caption-subject bold">  اذن خرج</span>
                                    </div>
                                    <br>
                                    <div class="caption font-green">
                                        <span class="caption-subject bold"> المجموع الكلى = <?=$sum?></span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form method="POST" action="<?= URL ?>payments" accept-charset="UTF-8" role="form" novalidate="novalidate">
                                        <div class="form-body row">
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <select name='who' class='form-control' id='whoList' required="required">
                                                    <option value='0'>أختر</option>
                                                    <option value='1'>المحاضرين</option>
                                                    <option value='2'>الموظفين</option>
                                                    <option value='3'>المعامل</option>
                                                    <option value='4'>اخرى</option>
                                                </select>
                                                <span id="delivery-error" class="help-block help-block-error"></span>
                                                <label for="form_control_1">لمن</label>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                                    <span class="twitter-typeahead" style="position: relative; display: inline-block;">
                                                        <input type="text" class="form-control tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);">
                                                        <input type="text" id="typeahead_example_2" name="typeahead_example_2" class="form-control tt-input" autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;" required="required" value="<?=@$_POST['typeahead_example_2']?>">
                                                        <pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Open Sans, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;">e</pre>
                                                        <div class="tt-menu tt-empty">
                                                            <div class="tt-dataset tt-dataset-typeahead_example_2">
                                                                <div class="tt-suggestion tt-selectable">Eritrea</div>
                                                            </div>                                 
                                                        </div>
                                                    </span> 
                                                </div>
                                                <p class="help-block"> E.g: USA, Malaysia. Prefetch from JSON source
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-body row">
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <select name='branches' class='form-control' id='branchList' required="required">
                                                    <option value='0'>أختر</option>
                                                    <?php
                                                    foreach ($branches as $branch) {
                                                        ?>
                                                        <option value="<?= $branch['id'] ?>"<?php if (@$_POST['branches'] == $branch['id']) { ?>selected<?php } ?>><?= $branch['name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span id="delivery-error" class="help-block help-block-error"></span>
                                                <label for="form_control_1">الفرع</label>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <input class="form-control" id="form_control_1" required="required" name="value" type="text" number="number" value="<?= @$_POST['value'] ?>" autocomplete="off">
                                                <label for="form_control_1">المبلغ</label>
                                            </div>
                                        </div>
                                        <div class="form-body row">
                                            <div class="col-md-3"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <select name='paymentmethods' class='form-control' id='branchList' required="required">
                                                    <option value='0'>أختر</option>
                                                    <?php
                                                    foreach ($paymentmethods as $paymentmethod) {
                                                        ?>
                                                        <option value="<?= $paymentmethod['id'] ?>"<?php if (@$_POST['paymentmethods'] == $paymentmethod['id']) { ?>selected<?php } ?>><?= $paymentmethod['name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span id="delivery-error" class="help-block help-block-error"></span>
                                                <label for="form_control_1">طريقة الدفع</label>
                                            </div>
                                        </div>
                                        <div class="form-actions noborder">
                                            <input type="submit" class="btn blue submit-button" value="إضافة">
                                            <button type="reset" class="btn default" style="margin-right:9px;">إلغاء</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    <?php } elseif ($form_type == 'update') { ?>
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption font-green">
                                    <i class="icon-pin font-green"></i>
                                    <span class="caption-subject bold">تعديل بيانات الفرع</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form method="POST" action="<?= URL ?>branches/<?= $row['id'] ?>" accept-charset="UTF-8" role="form" novalidate="novalidate">
                                    <div class="form-body row">
                                        <div class="col-md-1"></div>
                                        <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                            <input class="form-control" id="form_control_1" required="required" name="name" type="text" value="<?= $row['name'] ?>" autocomplete="off">
                                            <label for="form_control_1">ألاسم</label>
                                        </div>
                                    </div>
                                    <div class="form-actions noborder">
                                        <input type="submit" class="btn blue submit-button" value="تعديل">
                                        <button type="reset" class="btn default" style="margin-right:9px;">إلغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->

                            <!-- END EXAMPLE TABLE PORTLET-->
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>الخرج</div>
                                    <div class="tools"> </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th> المحاضر </th>
                                                <th> الموظف </th>
                                                <th> المعمل </th>
                                                <th> اخرى</th>
                                                <th> المبلغ </th>
                                                <th> التاريخ</th>
                                                <th> الفرع</th>
                                                <th> طريقة الدفع</th>
                                                <th> انشاء ب</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($payments) {
                                                foreach ($payments as $payment) {
                                                    ?>
                                                    <tr>
                                                        <td><a href="<?=URL.'instructors/'.$payment['instructor_id'].'/pays'?>" target="_blank"><?= $payment['instructor'] ?></a></td>
                                                        <td><a href="<?=URL.'employes/'.$payment['employe_id'].'/pays'?>" target="_blank"><?= $payment['employe'] ?></a></td>
                                                        <td><a href="<?=URL.'vendors/'.$payment['vendor_id'].'/pays'?>" target="_blank"><?= $payment['vendor'] ?></a></td>
                                                        <td><?= $payment['other'] ?></td>
                                                        <td><?= $payment['value'] ?></td>
                                                        <td><?= $payment['created_at'] ?></td>
                                                        <td><?= $payment['branch'] ?></td>
                                                        <td><?= $payment['paymentmethod'] ?></td>
                                                        <td><?= $payment['creator'] ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>

                    <!-- End Your Content -->
                </div>

            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <?php require_once'layout/footer.php' ?>
    </div>
</body>

</html>
