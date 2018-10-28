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
    <div id="preloader">
        <div id="status">
            <div class="status-mes"></div>
        </div>
    </div>

    <div class="uc-mobile-menu-pusher">

        <div class="content-wrapper">
            <?php include 'menu.php'; ?>
            <!-- .nav -->


            <section class="single-page-title">
                <div class="container text-center">
                    <div class="container"  >
                        <div class="col-md-12">

                            <div   class="seh_boxx">
                                <div class="col-md-10 col-md-offset-1" style="padding-bottom: 35px">
                                    <h3>Search Your Destination....</h3>
                                    <form action="view_spot.php" method="GET">
                                        <div class="input-group col-lg-12 ">
                                            <input type="text" id="demo3"  name="spot_name" class="form-control se_height " placeholder="Enter Place name, Location or country..." />

                                            <span class="input-group-btn ">
                                                <input type="submit" class="btn btn-primary btn_height" value="Search" />
                                            </span>
                                        </div>
                                        <div id="display">
                                            <!--data result display here-->
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- .page-title -->

            <section class="contact-form ptb-100" >
                <div class="container" style="border-top: 3px solid green; border-radius: 10px;">
                    <div class="col-lg-12" style="padding-top: 20px" >
                        <?php
                        extract($_REQUEST);
                        //var_dump($blog_topic);
                        if ($spot_name != ''){
                            $sql="SELECT * FROM `spot` WHERE name LIKE '%$spot_name%' or location LIKE '%$spot_name%' or country LIKE '%$spot_name%' AND confirmation='approve' order by id DESC LIMIT 10";
                        }
                        else{
                            $sql="SELECT * FROM `spot` WHERE confirmation='approve' order by id DESC LIMIT 10";
                        }

                        $qeury_result = mysqli_query($connection ,$sql);
                        while($rows= mysqli_fetch_assoc($qeury_result)) {
                            $spot_id = $rows['id'];
                            //var_dump($spot_id);
                            $content = $rows['description'];
                            $sub_content = substr($content,0,250);
                            ?>

                            <div id="global-settings" class="card col-lg-10" style="padding: 10px;">
                                <p class="col-lg-10">

                                    <span class="h2"><a class="tp-heading" href="profile_page.php?id=<?php echo $rows['user_id'];?>"><?php echo $rows['name']; ?></a><br></span>
                                    <i class="icon-ios-location"></i> <?php echo $rows['location'] ?>


                                <div class="col-lg-4">
                                    <?php
                                    $sql2="SELECT * FROM `spot_photos` WHERE spot_id= '$spot_id'";
                                    $qeury_result2 = mysqli_query($connection ,$sql2);
                                    $rows2= mysqli_fetch_assoc($qeury_result2);
                                    if ($rows2!=''){
                                    ?>
                                    <div class="item">
                                        <div class="clearfix" style="max-width:474px;">
                                            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                            <?php
                                            while ($rows2= mysqli_fetch_assoc($qeury_result2)) {
                                                //var_dump($rows2);
                                            ?>
                                                <li data-thumb="uploads/place/<?php echo $rows2['photo']; ?>">
                                                    <img src="uploads/place/<?php echo $rows2['photo']; ?>" style="height: 200px; width: 100%; padding-bottom: 15px" />
                                                </li>
                                                <?php
                                            }?>
                                                <div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php }
                                    else{ ?>
                                        <img src="uploads/place/<?php echo $rows['photo'];?>" style="height: 200px; width: 100%; padding-bottom: 15px" />
                                    <?php } ?>
                                </div>


                                <div class="col-lg-6" style=" padding-bottom: 15px;">
                                    <div style="text-align: justify"><p><?php echo $sub_content;?> .......</p></div>

                                    <?php if ($_SESSION['logged_in']== true && $rows['user_id']==$_SESSION['id']){ ?>
                                        <a href="blog_post_edit.php?id=<?php echo $rows['id']?>"><button class="btn btn-info">Edit</button></a>
                                    <?php } ?>


                                </div>

                                <div class="col-lg-2" style=" padding-bottom: 15px; color: green; font-weight: bolder; text-align: center">
                                    <a class="tp-heading" href="spot_profile.php?id=<?php echo $rows['id'];?>"><button class="btn btn-success">View Details</button></a>
                                </div>

                            </div>


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
