<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    
</head>
    <?php require_once "html/head.php"?>
<body class="stretched overlay-menu">

    <div id="wrapper" class="clearfix bg-light">

        <!-- Header Start -->
        <?php require_once "html/header.php"?>
        <!-- Header End -->

        <div class="container-fluid">
            <div class="row">
                <!-- Content Start-->
                <section id="content" class="bg-light">
                    <div class="content-wrap pt-lg-0 pt-xl-0 pb-0">
                        <div class="container-fluid clearfix">
                            <div class="heading-block border-bottom-0 center pt-4 mb-3">
                                <h3>Tin tức</h3>
                            </div>
                            <!-- Posts Start -->
                            <div class="row grid-container infinity-wrapper clearfix align-align-items-start">
                                <?php require_once "news.php" ?>
                            </div>
                            <!-- Posts End -->
                
                        </div>
                    </div>
                </section> 
                <!-- Content End -->
                <!-- Section Start -->
                <section class="right-side mb-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="box mt-4">
                                <h3 class="mb-1">Giá Vàng</h3>
                                <div class="card card-body" id="boxgold">
                                    <!-- <?php require_once "boxgold.php" ?> -->
                                    <div class="text-center">
                                            <div class="spinner-border" style="width: 3rem; height: 3rem;"
                                                role="status">
                                            </div>
                                        </div>
                                </div>
                                
                                <div class="box mt-4">
                                <h3 class="mb-1">Giá coin</h3>
                                <div class="card card-body" id="boxcoin">
                                    <!-- <?php require_once "boxcoin.php" ?> -->
                                    <div class="text-center">
                                            <div class="spinner-border" style="width: 3rem; height: 3rem;"
                                                role="status">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Section End -->
            </div>
        </div>

        <!-- Footer Start -->
        <?php require_once "html/footer.php"?>
        <!-- Footer End -->
    </div>

    <!-- Go To Top
	============================================= -->
    <div id="gotoTop" class="icon-angle-up rounded-circle"></div>

    <!-- Script Start -->
    <?php require_once "html/script.php"?>
    <!-- Script End -->
</body>

</html>