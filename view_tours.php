<?php
include_once 'db_connection/config.php';
if(session_id() == '' || !isset($_SESSION))
{session_start();}
error_reporting(0);
$u_id=$_SESSION['id'] ;


?>



<!DOCTYPE html>
<html>
<head>
    <?php include 'head.php'; ?>
    <title>X-Corporation</title>

    <style type="text/css">
        .seh_boxx {
            background-color: #84c05c !important;
            border-radius: 4px;
            overflow: auto;
            padding: 9px 20px 11px;

        }

        .se_height{height: 45px!important; border: 1px solid #F7931E!important;}

        .single-page-title{
            max-height: 350px;
            padding-top: 130px;
            padding-bottom: 10px;
            background-color: #3498db;
        }
    </style>
</head>
<body>
<div id="main-wrapper">
    <!-- Page Preloader -->


    <div class="uc-mobile-menu-pusher">

        <div class="content-wrapper">
            <?php include 'menu.php'; ?>
            <!-- .nav -->


            <?php include 'search_show.php'?>
            <!-- .page-title -->

            <section class="contact-form ptb-100" >
                <div class="container" style="border-top: 3px solid green; border-radius: 10px;">
                    <div class="col-lg-12" style="padding-top: 20px" >
                        <?php
                        extract($_REQUEST);
                        $search_name = $tour_name;
                        $search_location = $location;
                        $sql = '';
                        if ($search_name!=''){
                            $sql="SELECT * FROM `tour` WHERE `name` LIKE '%$search_name%' and available_seat>0 order by id DESC";
                        }
                        elseif ($search_location!=''){
                            $sql="SELECT * FROM `tour` WHERE spot_name LIKE '%$search_location%'or location LIKE '%$search_location%' AND available_seat>0order by id DESC";
                        }
                        elseif ($search_location!='' and $search_location!=''){
                            $sql="SELECT * FROM `tour` WHERE `name` LIKE '%$search_name%' or spot_name LIKE '%$search_location%' AND available_seat>0 order by id DESC";
                        }
                        else{
                            $sql="SELECT * FROM `tour` WHERE available_seat>0 order by id DESC";
                        }
                        //echo $sql;
                        $qeury_result = mysqli_query($connection ,$sql);
                        while($rows= mysqli_fetch_assoc($qeury_result)) {
                            $tour_id = $rows['id'];
                            //var_dump($bus_id);
                            $content = $rows['description'];
                            $sub_content = substr($content,0,150);
                            $tour_arranger_id = $rows['arranger_id'];
                            ?>

                            <section id="global-settings" class="card col-lg-10 col-md-10" style="padding: 10px;">
                                <div class="col-lg-10 col-md-10">

                                    <span class="h2"><a class="tp-heading" href="tour_details.php?id=<?php echo $rows['id'];?>"><?php echo $rows['name']; ?></a><br></span>
                                    <span class="h4"><i class="icon-ios-location"></i> </span> From <span class="text-success h4"> <?php echo $rows['from'] ?></span>  To <span class="text-success h4"><?php echo $rows['spot_name'] ?></span></div>

                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                    <?php
                                    $sql4=" SELECT * FROM `tour_photos` WHERE tour_id= '$tour_id' AND type = 1 limit 1";
                                    $qeury_result4 = mysqli_query($connection ,$sql4);
                                    $rows4= mysqli_fetch_assoc($qeury_result4); ?>

                                        <img src="uploads/tour_photos/<?php echo $rows4['photo'];?>" style="height: 150px; width: 100%; padding-bottom: 15px" />
                                </div>

                                <div class="col-lg-7 col-md-7 col-sm-7" style=" padding-bottom: 15px;">
                                    <div style="text-align: justify"><p><br><?php echo $sub_content;?> .......</p></div>
                                    <div class=" col-lg-2 col-md-2 col-sm-2 bg-primary" style="font-size: larger; font-weight: bolder">Offer: </div> <div class="col-lg-10" style="text-align: justify"><?php echo $rows['offer'];?></div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2" style=" padding-bottom: 15px; color: green; font-weight: bolder; text-align: center">
                                    <div class="h4"><?php echo $rows['price'];?> TK.</div>

                                    <a class="tp-heading" href="tour_details.php?id=<?php echo $rows['id'];?>"><button style="padding-right: 20px; padding-left: 20px" class="btn btn-success">Join Us</button></a><br><br>
                                    <?php if ($_SESSION['logged_in']== true && $rows['user_id']==$_SESSION['id']){ ?>
                                        <div class="col-lg-3 pull-left" style="padding-left: 0px; padding-right: 20px"> <a  href="blog_post_edit.php?id=<?php echo $rows['id']?>"><button class="btn btn-info">Edit</button></a></div>
                                    <?php } ?>
                                </div>

                            </section>


                            <?php
                        }
                        ?>

                    </div>


                </div>
            </section>
            <!-- .contact-form-->

            <?php include 'footer.php'; ?>
            <!-- .footer -->

        </div>
        <!-- .content-wrapper -->
    </div>
    <!-- .offcanvas-pusher -->

    <div class="uc-mobile-menu uc-mobile-menu-effect">
        <button type="button" class="close" aria-hidden="true" data-toggle="offcanvas"
                id="uc-mobile-menu-close-btn">&times;</button>
        <div>
            <div>
                <ul id="menu">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="view_hotel.php">Hotels</a></li>
                    <li><a href="view_cars.php">Cars</a></li>
                    <li><a href="view_spot.php">Places</a></li>
                    <li><a href="blog_show.php">Blog</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- .uc-mobile-menu -->


</div>
<!-- #main-wrapper -->


<?php include 'script.php'; ?>
<script>
    $(document).ready(function() {
        $("#content-slider").lightSlider({
            loop:true,
            keyPress:true
        });
        $('#image-gallery').lightSlider({
            gallery:true,
            item:1,
            thumbItem:9,
            slideMargin: 0,
            speed:500,
            auto:true,
            loop:true,
            onSliderLoad: function() {
                $('#image-gallery').removeClass('cS-hidden');
            }
        });
    });
</script>
<!-- Script -->

</body>
</html>
