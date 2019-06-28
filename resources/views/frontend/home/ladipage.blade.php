
<!DOCTYPE html>
<html>
<head>
    <title>cunghocvui - Cùng học cùng vui</title>
    <!-- Theme stylesheet -->
    <link href="{{ url('frontend/landingPage/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('frontend/landingPage/css/responsive.css') }}" rel="stylesheet" type="text/css">
    <!-- Roboto Font stylesheet -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <!-- FontAwesome stylesheet -->
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- LayerSlider stylesheet -->
    <link rel="stylesheet" href="{{ url('frontend/landingPage/css/layerslider.css') }}" type="text/css">
    <link rel="shortcut icon" type="image/png" href="{{ url('/favicon.png') }}"/>

    <link href="{{ url('frontend/landingPage/css/lightbox.css') }}" rel="stylesheet" />
    <meta name="robots" content="NOINDEX, NOFOLLOW">
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

</head>

<body>
<!--responsive menu placeholder-->
<div id="followMenu"><div class="clear"></div></div>

<!--BEGIN TOP CONTAINER (slider&nav)-->
<section id="topContainer">
    <div id="navigationWrap">
        <div class="row">
            <div class="three-col"><img src="{{ url('frontend/landingPage/img/cunghocvui.png') }}" alt="Delicious Mint"/></div>
            <div class="nine-col last-col menuWrap">
                <ul class="mainMenu">
                    <li><a href="#aboutContainer">Về chúng tôi</a></li>
                    <li><a href="#featureContainer">Tính năng</a></li>
                    <li><a href="#reviewContainer">Đánh giá</a></li>
                    <li><a href="#screensContainer">Giao diện</a></li>
                    <li><a href="#getappContainer">Tải app</a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <!-- BEGIN SLIDER -->
    <div id="sliderWraper" class="row">
        <div id="layerslider" style="width: 1170px;max-width: 1170px; height: 690px;">
            <!-- first slide -->
            <div class="ls-slide">
                <img src="{{ url('frontend/landingPage/img/loginScreen.png') }}" alt="Phone" class="ls-l" style="top: 30px; left: 130px;"
                     data-ls="offsetxin: 0; offsetxout : 0; offsetyin: 100; durationin: 2000"  width="300%"/>

                <p class="ls-l sliderText" style="top: 50px; left: 550px;"
                   data-ls="offsetxin: 0; offsetxout : 0; offsetyin: 50; durationin: 2000;">
                    <span>Công cụ học tập</span> <br/>hữu ích nhất</p>

                <a href="#aboutContainer" class="buttonBig ls-l" style="top: 300px; left: 550px;"
                   data-ls="offsetxin: 0; offsetxout: 0; delayin: 300; offsetyin: 100; durationin: 2000;">Tìm hiểu thêm</a>

                <a href="#getappContainer" class="buttonBig ls-l" style="top: 300px; left: 750px;"
                   data-ls="offsetxin: 0; offsetxout: 0; delayin: 300; offsetyin: 100; durationin: 2000;">Tải APP</a>
            </div>
            <!-- second slide -->
            <div class="ls-slide">
                <img src="{{ url('frontend/landingPage/img/chonmonhoc.png') }}" alt="Phone" class="ls-l" style="top: -20px; left: 130px;"
                     data-ls="offsetxin: 0; offsetxout : 0; offsetyin: 100; durationin: 2000" width="300%" />

                <p class="ls-l sliderText" style="top: 50px; left: 550px;"
                   data-ls="offsetxin: 0; offsetxout : 0; offsetyin: 50; durationin: 2000;">
                    <span>Giao diện </span><br/>đẹp mắt, dễ sử dụng</p>

                <a href="#aboutContainer" class="buttonBig ls-l" style="top: 300px; left: 550px;"
                   data-ls="offsetxin: 0; offsetxout: 0; delayin: 300; offsetyin: 100; durationin: 2000;">Tìm hiểu thêm </a>

                <a href="#getappContainer" class="buttonBig ls-l" style="top: 300px; left: 750px;"
                   data-ls="offsetxin: 0; offsetxout: 0; delayin: 300; offsetyin: 100; durationin: 2000;">Tải APP</a>
            </div>
        </div>
    </div>
    <!-- END SLIDER -->
    <div class="clear"></div>
</section>
<!--END TOP CONTAINER-->


<!--BEGIN CONTENT WRAPPER-->
<div id="contentWrapper">
    <!--add your own sections in this div-->

    <!--ABOUT CONTAINER-->
    <section id="aboutContainer" class="section-80-130 whiteBgSection">
        <img class="triangleTop" src="{{ url('frontend/landingPage/img/tri-white-top.png') }}" alt="" />
        <div class="row">

            <div class="four-col">
                <div class="iconColWrap">
                    <i class="fa fa-download"></i>
                    <h2>Dễ dàng cài đặt</h2>
                </div>
            </div>

            <div class="four-col">
                <div class="iconColWrap">
                    <i class="fa fa-file"></i>
                    <h2>Tài liệu miễn phí</h2>
                </div>
            </div>

            <div class="three-col">
                <div class="iconColWrap">
                    <i class="fa fa-users"></i>
                    <h2>Cộng đồng học tập</h2>
                </div>
            </div>

            <div class="clear"></div>
        </div>
    </section>
    <!--END ABOUT CONTAINER-->

    <!--FEATURES CONTAINER-->
    <section id="featureContainer" class="section-80-80 grayBgSection">
        <h1 class="sectionTitle">Tính năng</h1>
        <div class="titleSeparator"></div>
        <h3 class="sectionDescription">Tìm hiểu thêm về các tính năng của App</h3>
        <div class="separator80"></div>
        <div class="row">

            <!--left side icons-->
            <div class="four-col">
                <div class="iconRightColWrap">
                    <i class="fa fa-user"></i>
                    <div class="rightColTextWrap">
                        <h2>Quản lý tài khoản</h2>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="iconRightColWrap">
                    <i class="fa fa-envelope"></i>
                    <div class="rightColTextWrap">
                        <h2>Góp ý</h2>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="iconRightColWrap">
                    <i class="fa fa-download"></i>
                    <div class="rightColTextWrap">
                        <h2>Lưu Offline</h2>
                    </div>
                    <div class="clear"></div>
                </div>

            </div>

            <!--phone image-->
            <div class="four-col" style="text-align: center;">
                <img src="{{ url('frontend/landingPage/img/screen.png') }}" alt="iOS" width="80%" />
            </div>

            <!--right side icons-->
            <div class="four-col last-col">
                <div class="iconLeftColWrap">
                    <i class="fa fa-share-square"></i>
                    <div class="leftColTextWrap">
                        <h2>Chia sẻ tài liệu</h2>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="iconLeftColWrap">
                    <i class="fa fa-microphone"></i>
                    <div class="leftColTextWrap">
                        <h2>Tìm kiếm bằng giọng nói</h2>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="iconLeftColWrap">
                    <i class="fa fa-image"></i>
                    <div class="leftColTextWrap">
                        <h2>Tìm kiếm bằng hình ảnh</h2>
                    </div>
                    <div class="clear"></div>
                </div>

            </div>
            <div class="clear"></div>
        </div>
        <img class="triangleBottom" src="{{ url('frontend/landingPage/img/tri-gray-bot.png') }}" alt="" />
    </section>
    <!--END FEATURES CONTAINER-->


    <!--REVIEW CONTAINER-->
    <section id="reviewContainer" class="section-160-160 textureBgSection" style="background-image: url('{{ url('frontend/landingPage/img/bg-texture1.jpg') }}');">
        <h1 class="sectionTitle">Đánh giá</h1>
        <div class="titleSeparator"></div>
        <div class="separator80"></div>

        <!--reviews wrapper-->
        <div class="row">
            <div class="eight-col prefix-two last-col testWrapper">
                <div class="revViewport">

                    <div class="revWrap">
                        <div class="revLeft">
                            <img src="{{ url('frontend/landingPage/img/review1.png') }}" alt="happy customer" class="revCustomer">
                        </div>
                        <div class="revRight">
                            <div class="arrowLeftRev"></div>
                            <div class="revBubble">
                                <p class="revText">"Cám ơn anh chị đã tạo ra ứng dụng vô cùng hữu ích này. Vô cùng đầy đủ và chi tiết luôn ạ."</p>
                                <p class="revAuthor">- Phương Luyến <img class="revStars" src="{{ url('frontend/landingPage/img/5stars.jpg') }}" alt="5/5 Stars!"/></p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="revWrap">
                        <div class="revLeft">
                            <img src="{{ url('frontend/landingPage/img/review2.png') }}" alt="happy customer" class="revCustomer">
                        </div>
                        <div class="revRight">
                            <div class="arrowLeftRev"></div>
                            <div class="revBubble">
                                <p class="revText">"App hay quá, bài tập nào cũng có lời giải luôn, học trên lớp điểm cao lên đáng kể!"</p>
                                <p class="revAuthor">- Phi Huy <img class="revStars" src="{{ url('frontend/landingPage/img/5stars.jpg') }}" alt="5/5 Stars!"/></p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="revWrap">
                        <div class="revLeft">
                            <img src="{{ url('frontend/landingPage/img/review3.png') }}" alt="happy customer" class="revCustomer">
                        </div>
                        <div class="revRight">
                            <div class="arrowLeftRev"></div>
                            <div class="revBubble">
                                <p class="revText">"App rất bổ ích đối với nhũng người cùng tuổi học sinh như em. Cảm ơn những ng đã thiết kế và phat triển phần mềm"</p>
                                <p class="revAuthor">- Phạm Nhung. <img class="revStars" src="{{ url('frontend/landingPage/img/5stars.jpg') }}" alt="5/5 Stars!"/></p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="revsNavi"></div>
    </section>
    <!--END REVIEW CONTAINER-->

    <!--SCREENS CONTAINER-->
    <section id="screensContainer" class="section-80-130 whiteBgSection">
        <img class="triangleTop" src="{{ url('frontend/landingPage/img/tri-white-top.png') }}" alt="" />

        <h1 class="sectionTitle">Giao diện</h1>
        <div class="titleSeparator"></div>
        <div class="separator80"></div>
        <!--Screens images-->
        <div id="screensViewportWrap" class="row">
            <div id="screensLeftAr" class="screensArrows"><i class="fa fa-angle-left"></i></div>
            <div id="screensOfHide">
                <div id="screensWrapOuter">
                    <div id="screensWrap">

                        <div class="screen-item" data-groups='["socialn", "all"]'>
                            <a href="{{ url('frontend/landingPage/img/chonlop.png') }}" data-lightbox="screens1" data-title="Cunghocvui"><img src="{{ url('frontend/landingPage/img/chonlop.png') }}" alt="SCREEN" class="screenImg" /></a>
                            <span>Lớp học</span>
                        </div>
                        <div class="screen-item" data-groups='["socialn", "all"]'>
                            <a href="{{ url('frontend/landingPage/img/chonlop.png') }}" data-lightbox="screens3" data-title="Delicious caption"><img src="{{ url('frontend/landingPage/img/1.png') }}" alt="SCREEN" class="screenImg" /></a>
                            <span>Đăng nhập</span>
                        </div>

                        <div class="screen-item" data-groups='["socialn", "all"]'>
                            <a href="{{ url('frontend/landingPage/img/loginScreen.png') }}" data-lightbox="screens4" data-title="Delicious caption"><img src="{{ url('frontend/landingPage/img/2.png') }}" alt="SCREEN" class="screenImg" /></a>
                            <span>Đăng ký</span>
                        </div>

                        <div class="screen-item" data-groups='["media", "all"]'>
                            <a href="{{ url('frontend/landingPage/img/chonmonhoc.png') }}" data-lightbox="screens2" data-title="Delicious caption"><img src="{{ url('frontend/landingPage/img/chonmonhoc.png') }}" alt="SCREEN" class="screenImg" /></a>
                            <span>Môn học</span>
                        </div>


                    </div>
                </div>
            </div>
            <div id="screensRightAr" class="screensArrows"><i class="fa fa-angle-right"></i></div>
        </div>
    </section>
    <!--END SCREENS WRAPPER-->



    <!--BEGIN GET APP CONTAINER-->
    <section id="getappContainer" class="section-160-160 textureBgSection" style="background-image: url('{{ url('frontend/landingPage/img/bg-texture2.jpg') }}') ;">
        <h1 class="sectionTitle">Tải App</h1>
        <div class="titleSeparator"></div>
        <h3 class="sectionDescription">TẢI APP CUNGHOCVUI CHO ĐIỆN THOẠI </h3>
        <div class="separator80"></div>
        <div class="row alignTextCenter">
            <a href="{{ config('app.app_mobile.ios') }}" class="dlButton"><i class="fa fa-apple"></i><span class="dlButtonWrap">Download for<br/><span class="dlButtonSmall">Apple iOS</span></span></a>
            <a href="{{ config('app.app_mobile.android') }}" class="dlButton"><i class="fa fa-android"></i><span class="dlButtonWrap">Download for<br/><span class="dlButtonSmall">Android</span></span></a>
        </div>

        {{--<div class="separator160"></div>--}}
        {{--<div class="floatingPhone"></div>--}}
    </section>
    <!--END GET APP WRAPPER-->



    <!--BEGIN FOOTER WRAPPER-->
    <section id="footerContainer" class="section-160-30 footer">
        <div class="separator80"></div>
        <a href="#"><img src="{{ url('frontend/landingPage/img/cunghocvui.png') }}" alt="cunghocvui" width="25%"/></a>
        <div class="separator80"></div>

        <a href="https://www.facebook.com/cunghocvui-473332793174039"><i class="fa fa-facebook"></i></a>
        <a href="https://www.instagram.com/cunghocvui"><i class="fa fa-instagram"></i></a>
        <a href="https://plus.google.com/u/1/communities/107426007745651444107"><i class="fa fa-google-plus"></i></a>
        <a href="https://cunghocvuivn.wordpress.com"><i class="fa fa-wordpress"></i></a>
        <a href="https://twitter.com/cunghocvui"><i class="fa fa-twitter"></i></a>

        <div class="separator80"></div>
        <p>Copyright &copy; 2018 CungHocVui</p>
    </section>
    <!--END FOOTER WRAPPER-->

</div>
<!--END CONTENT WRAPPER-->

<div id="responsiveMenuToggle"><i class="fa fa-bars"></i></div>
<a id="toTop" href="#"><i class="fa fa-angle-up"></i></a>


<!-- jQuery & GreenSock -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="{{ url('frontend/landingPage/js/greensock.js') }}" type="text/javascript"></script>

<!-- LayerSlider script files -->
<script src="{{ url('frontend/landingPage/js/layerslider.transitions.js') }}" type="text/javascript"></script>
<script src="{{ url('frontend/landingPage/js/layerslider.kreaturamedia.jquery.js') }}" type="text/javascript"></script>

<!-- Lightbox -->
<script src="{{ url('frontend/landingPage/js/lightbox.min.js') }}"></script>

<!-- Shuffle.js (screens) -->
<script src="{{ url('frontend/landingPage/js/jquery.shuffle.modernizr.js') }}"></script>

<!-- Layer Slider init -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#layerslider').layerSlider({
            thumbnailNavigation: 'disabled',
            skinsPath: 'frontend/landingPage/css/',
            navPrevNext: false,
            navStartStop: false,
            showCircleTimer: false
        });

    });
</script>


<!-- Theme JS -->
<script src="{{ url('frontend/landingPage/js/delicioustheme.js') }}" type="text/javascript"></script>
</body>
</html> 