<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
    <!--<![endif]-->
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
                    <h1 class="page-title"> الدخل
                        <small></small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="../views/home.php">الرئسية</a>
                                <i class="fa fa-angle-right">الدخل</i>
                            </li>
                            <li>
                                <span></span>
                            </li>
                        </ul>
                        <div class="page-toolbar">

                        </div>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="invoice">
                        <div class="row invoice-logo">
                            <div class="col-xs-6 invoice-logo-space">
                                <img src="<?= URL ?>assets/pages/media/invoice/walmart.png" class="img-responsive" alt=""> </div>
                            <div class="col-xs-6">
                                <p> <?= date('h:i:s Y-m-d') ?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-4">
                                <?php
                                $title = 'اخرى';
                                switch ($who) {
                                    case 5:
                                        $title = 'الطالب';
                                        break;
                                    case 6:
                                        $title = 'الكورس';
                                        break;
                                }
                                ?>
                                <h3><?= $title ?>:</h3>
                                <ul class="list-unstyled">
                                    <li> <?= $obj['name'] ?> </li>
                                    <!--li> Mr Nilson Otto </li>
                                    <li> FoodMaster Ltd </li>
                                    <li> Madrid </li>
                                    <li> Spain </li>
                                    <li> 1982 OOP </li-->
                                </ul>
                            </div>
                            <div class="col-xs-4">
                                <h3>المجموع الكلى:</h3>
                                <ul class="list-unstyled">
                                    <li> <?= $total ?> </li>
                                    <!--li> Laoreet dolore magna </li>
                                    <li> Consectetuer adipiscing elit </li>
                                    <li> Magna aliquam tincidunt erat volutpat </li>
                                    <li> Olor sit amet adipiscing eli </li>
                                    <li> Laoreet dolore magna </li-->
                                </ul>
                            </div>
                            <!--div class="col-xs-4 invoice-payment">
                                <h3>Payment Details:</h3>
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>V.A.T Reg #:</strong> 542554(DEMO)78 </li>
                                    <li>
                                        <strong>Account Name:</strong> FoodMaster Ltd </li>
                                    <li>
                                        <strong>SWIFT code:</strong> 45454DEMO545DEMO </li>
                                    <li>
                                        <strong>Account Name:</strong> FoodMaster Ltd </li>
                                    <li>
                                        <strong>SWIFT code:</strong> 45454DEMO545DEMO </li>
                                </ul>
                            </div-->
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <?php if ($who == 5) { ?>
                                                <th> الكورس </th>
                                            <?php } else { ?>
                                                <th> الطالب </th>
                                            <?php } ?>
                                            <th> المبلغ </th>
                                            <th> المتبقى </th>
                                            <th> التاريخ </th>
                                            <th> الفرع </th>
                                            <th>  طربقة الدفع </th>
                                            <th> انشاء ب </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($allPayments as $payment) {
                                            ?>
                                            <tr>
                                                <td> <?= $i ?> </td>
                                                <?php if ($who == 5) { ?>
                                                    <td> <?= $payment['course'] ?> </td>
                                                <?php } else { ?>
                                                    <td> <?= $payment['student'] ?> </td>
                                                <?php } ?>
                                                <td> <?= $payment['value'] ?> </td>
                                                <td> <?= $payment['remaing'] ?> </td>
                                                <td> <?= $payment['created_at'] ?> </td>
                                                <td> <?= $payment['branch'] ?> </td>
                                                <td> <?= $payment['paymentmethod'] ?> </td>
                                                <td> <?= $payment['creator'] ?> </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <!--div class="col-xs-4">
                                <div class="well">
                                    <address>
                                        <strong>Loop, Inc.</strong>
                                        <br> 795 Park Ave, Suite 120
                                        <br> San Francisco, CA 94107
                                        <br>
                                        <abbr title="Phone">P:</abbr> (234) 145-1810 </address>
                                    <address>
                                        <strong>Full Name</strong>
                                        <br>
                                        <a href="mailto:#"> first.last@email.com </a>
                                    </address>
                                </div>
                            </div-->
                            <div class="col-xs-8 invoice-block">
                                <!--ul class="list-unstyled amounts">
                                    <li>
                                        <strong>Sub - Total amount:</strong> $9265 </li>
                                    <li>
                                        <strong>Discount:</strong> 12.9% </li>
                                    <li>
                                        <strong>VAT:</strong> ----- </li>
                                    <li>
                                        <strong>Grand Total:</strong> $12489 </li>
                                </ul-->
                                <br>
                                <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                                    <i class="fa fa-print"></i>
                                </a>
                            </div>
                        </div>
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
