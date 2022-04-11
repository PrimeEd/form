<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>What's your story?</title>


    <link href="/wys/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/wys/css/custom.css?{{ uniqid() }}" rel="stylesheet">


    <script src="/wys/libs/jquery/dist/jquery.min.js"></script>
    <script src="/wys/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/wys/libs/jquery-plugins/textcounter.min.js"></script>

    <script type="text/javascript">
        function setElementsHeights() {
            var $window = $(window);
            winHeight = $window.height();
            winWidth = $window.width();

            $("#js-top").height(winHeight / 2);
            $("#js-bottom").height(winHeight / 2);

            if (winHeight >= 726 && winWidth >= 992) {
                $(".js-full-height").height(winHeight);
                $(".js-full-height-first").height(winHeight - 171);
            }
        }

        $(document).ready(function () {
            setElementsHeights();
            $(window).resize(function () {
                setElementsHeights();
            });
        });

    </script>

</head>

<body>

<div id="main-container">
    <div id="js-top">
        <div id="top-content">
        </div>
        <section class="pt-5 text-center container">
            <img class="top-half-logo" src="/wys/images/logo1.svg" alt="What's your story?" title="What's your story?">
        </section>
    </div>

    <div id="js-bottom">
        <section class="pt-5 text-center container d-block d-lg-none" id="main-bottom-info-small">
            <div class="col-sm-12">
                <div class="success-text">
                    Thank you for submitting your story!
                </div>
            </div>
        </section>
        <section class="pt-5 text-center container d-none d-lg-block main-bottom-info-big">
            <div class="col-sm-12">
                <div class="success-text">
                    Thank you for submitting your story!
                </div>
            </div>
        </section>
    </div>
</div>

</body>

</html>
