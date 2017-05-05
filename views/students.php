<!DOCTYPE html>
<html lang="en" dir="rtl">
    <!-- BEGIN HEAD -->
    <head>
        <?php require_once 'layout\head.php' ?>
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        <!-- BEGIN HEADER -->
        <?php require_once 'layout\header.php' ?>
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
                <?php require_once'layout\sidebar.php' ?>
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
                    <h1 class="page-title"> الطلبة
                        <small></small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="../views/home.php">الرئسية</a>
                                <i class="fa fa-angle-right">الطلبة</i>
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
                        <div id="prefix_1333978461963" title="اضافة طالب جديد" message="<?=$success_msg?>" btn-class="btn-success" type="success">
                        </div>
                    <?php } elseif ($error_msg != '') { ?>
                        <div id="prefix_1333978461963" title="اضافة طالب جديد" message="<?=$error_msg?>" btn-class="btn-danger" type="error">
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
                                        <span class="caption-subject bold">أضافة طالب جديد</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form method="POST" action="<?= URL ?>students" accept-charset="UTF-8" role="form" novalidate="novalidate">
                                        <div class="form-body row">
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <input class="form-control" id="form_control_1" required="required" name="name" type="text" value="<?= @$_POST['name'] ?>" autocomplete="off">
                                                <label for="form_control_1">ألاسم</label>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <input class="form-control" id="form_control_1" required="required" name="phone" number="phone" type="text" value="<?= @$_POST['phone'] ?>">
                                                <label for="form_control_1">التليفون</label>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="form-body row">
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <select name='country' class='form-control' id='countryList' required="required">
                                                    <option value='0'>أختر</option>
                                                    <?php
                                                    foreach ($countries as $country) {
                                                        ?>
                                                        <option value="<?= $country['id'] ?>" <?php if (@$_POST['country'] == $country['id']) { ?>selected<?php } ?>><?= $country['name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span id="delivery-error" class="help-block help-block-error"></span>
                                                <label for="form_control_1">الدولة</label>
                                            </div>

                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <input class="form-control" id="form_control_1" required="required" name="mobile" number="phone" type="text" value="<?= @$_POST['mobile'] ?>">
                                                <label for="form_control_1">الموبايل</label>
                                            </div>
                                        </div>
                                        <div class="form-body row">
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <select name='city' class='form-control' id='cityList'>
                                                    <option value='0'>أختر</option>
                                                    <?php
                                                    foreach ($cities as $city) {
                                                        ?>
                                                        <option value="<?= $city['id'] ?>"<?php if (@$_POST['city'] == $city['id']) { ?>selected<?php } ?>><?= $city['name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span id="delivery-error" class="help-block help-block-error"></span>
                                                <label for="form_control_1">المدينة</label>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <select name='branch' class='form-control' id='branchList' required="required">
                                                    <option value='0'>أختر</option>
                                                    <?php
                                                    foreach ($branches as $branch) {
                                                        ?>
                                                        <option value="<?= $branch['id'] ?>"<?php if (@$_POST['branch'] == $branch['id']) { ?>selected<?php } ?>><?= $branch['name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <span id="delivery-error" class="help-block help-block-error"></span>
                                                <label for="form_control_1">الفرع</label>
                                            </div>
                                        </div>
                                        <div class="form-body row">
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <input class="form-control" id="form_control_1" name="street" type="text" value="<?= @$_POST['street'] ?>">
                                                <label for="form_control_1">الشارع</label>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                                <textarea class="form-control" name="notes" rows="1"></textarea>
                                                <label for="form_control_1">الملاحظات</label>
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
                                    <span class="caption-subject bold">تعديل بيانات الطالب</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form method="PATCH" action="../controllers/studentscontroller.php" accept-charset="UTF-8" role="form" novalidate="novalidate"><input name="_token" type="hidden" value="aAMkER3ZqJ6AFVWwdc4LlP8IfgoXIO22PenRl6Oi">

                                    <div class="form-body row">
                                        <div class="col-md-1"></div>
                                        <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                            <input class="form-control" id="form_control_1" required="required" name="name" type="text">
                                            <label for="form_control_1">ألاسم</label>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                            <input class="form-control" id="form_control_1" required="required" name="phone" number="phone" type="text">
                                            <label for="form_control_1">التليفون</label>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="form-body row">
                                        <div class="col-md-1"></div>
                                        <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                            <input class="form-control" id="form_control_1" required="required" name="address" type="text">
                                            <label for="form_control_1">العنوان</label>
                                        </div>

                                        <div class="col-md-1"></div>
                                        <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                            <input class="form-control" id="form_control_1" required="required" name="mobile" number="phone" type="text">
                                            <label for="form_control_1">الموبايل</label>
                                        </div>
                                    </div>
                                    <div class="form-body row">
                                        <div class="col-md-1"></div>
                                        <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                            <input class="form-control" id="form_control_1" required="required" name="balance" number="number" type="text">
                                            <label for="form_control_1">الرصيد</label>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="form-group form-md-line-input form-md-floating-label col-md-4">
                                            <select name='branch' class='form-control' id='branchList'>
                                                <option value='0'>أختر</option>
                                            </select>
                                            <span id="delivery-error" class="help-block help-block-error"></span>
                                            <label for="form_control_1">الفرع</label>
                                        </div>
                                    </div>
                                    <div class="form-actions noborder" style="float:right;">
                                        <button type="reset" class="btn default pull-right" style="margin-left:9px;">إلغاء</button>
                                        <input type="submit" class="btn blue pull-right submit-button" value="تعديل">
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
                                        <i class="fa fa-globe"></i>الطلبة </div>
                                    <div class="tools"> </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th> ألاسم </th>
                                                <th> التليفون </th>
                                                <th> الموبايل </th>
                                                <th> الرصيد </th>
                                                <th> الفرع </th>
                                                <th>  الدولة</th>
                                                <th>  المدينة</th>
                                                <th> الشارع </th>
                                                <th>  ملاحظات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($students) {
                                                foreach ($students as $student) {
                                                    ?>
                                                    <tr>
                                                        <td><a href="<?= URL ?>students/<?= $student['id'] ?>"><?= $student['name'] ?> </a></td>
                                                        <td> <?= $student['phone'] ?> </td>
                                                        <td> <?= $student['mobile'] ?> </td>
                                                        <td> <?= $student['balance'] ?> </td>
                                                        <td> <?= $student['branch'] ?> </td>
                                                        <td> <?= $student['country'] ?> </td>
                                                        <td> <?= $student['city'] ?> </td>
                                                        <td> <?= $student['street'] ?> </td>
                                                        <td> <?= $student['notes'] ?> </td>
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
