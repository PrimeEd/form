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

        // function setMaxWordsTextarea() {
        //     $('#js-story').textcounter({
        //         type: "word",
        //         max: 400,
        //         stopInputAtMaximum: true,
        //         displayErrorText: false,
        //         counterText: "fff",
        //     });
        // }

        function tryFormValidation() {
            let result = document.getElementById("js-form").reportValidity();
            let uploadStatus = false;
            if ($("#js-file-media").val()) {
                uploadStatus = true;
            }
            if ($("#js-file-text").val()) {
                uploadStatus = true;
            }
            if ($("#js-share_link").val() && isValidHttpUrl($("#js-share_link").val())) {
                uploadStatus = true;
            }
            if (result) {
                if (uploadStatus) {
                    // All is ok
                    $("#js-btn-submit").text("PLEASE WAIT ...").addClass("disabled");
                    document.getElementById("js-form").submit();
                } else {
                    alert("Please select a file to upload or fill the share link!");
                }
            } else {
                // Some errors, ignore them for now
            }
        }

        function isValidHttpUrl(string) {
            let url;
            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }
            return url.protocol === "http:" || url.protocol === "https:";
        }

        $(document).ready(function () {
            setElementsHeights();
            $(window).resize(function () {
                setElementsHeights();
            });
            // setMaxWordsTextarea();
            $("#js-btn-submit").on("click", function () {
                return tryFormValidation();
            });

            $("#js-btn-upload-media").on("click", function () {
                $("#js-file-media").click();
            });

            $("#js-btn-upload-text").on("click", function () {
                $("#js-file-text").click();
            });

        });

        document.addEventListener("DOMContentLoaded", function () {

            window.addEventListener('scroll', function () {

                if (window.scrollY > window.winHeight) {
                    $(".js-navbar-form").addClass("fixed-top");
                    navbar_height = $('#nav-form-big').height() + 30;
                    document.body.style.paddingTop = navbar_height + 'px';
                } else {
                    $(".js-navbar-form").removeClass("fixed-top");
                    document.body.style.paddingTop = '0';
                }
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

{{--    <?php if (session('alert_ok', FALSE)): ?>--}}
{{--    <div class="col-sm-12">--}}
{{--        <div id="js-confirmation-box" class="alert alert-success alert-dismissible">--}}
{{--            {{ session('alert_ok') }}--}}
{{--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <?php session()->forget('alert_ok'); ?>--}}
{{--    <?php endif; ?>--}}

    <?php if (session('alert_ko', FALSE)): ?>
    <div class="col-sm-12">
        <div id="js-confirmation-box" class="alert alert-danger alert-dismissible">
            {{ session('alert_ko') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php session()->forget('alert_ko'); ?>
    <?php endif; ?>

    <div id="js-bottom">
        <section class="pt-5 text-center container d-block d-lg-none" id="main-bottom-info-small">
            <p>
                Everyone has a <br> story to tell.
            </p>
            <p>
                We want to hear <br> yours.
            </p>
            <a class="btn btn-pink-rounded mt-3 js-btn-get-started" href="#js-form-content-1">
                GET STARTED
            </a>
        </section>
        <section class="pt-5 text-center container d-none d-lg-block main-bottom-info-big">
            <p>
                Everyone has a story to tell. We want to hear yours.
            </p>
            <p>
                It can be about anything: perhaps it's about your academic journey <br>
                or an adventure you've had since coming to Kings?
            </p>
            <p>
                Maybe you have an interesting hobby or talent. Words, pictures and <br>
                video — whatever you want to share — we want to hear about it.
            </p>
            <p>
                So tell us, <strong>what's your story?</strong>
            </p>
            <a class="btn btn-pink-rounded mt-3 js-btn-get-started" href="#nav-form-big">
                GET STARTED
            </a>
        </section>
    </div>
</div>

<div id="form-container" class="col-lg-8 mx-auto pt-3 pb-3 py-md-5">
    <nav id="nav-form-big"
         class="navbar navbar-expand-md navbar-dark bg-dark navbar-form-big justify-content-center d-none d-lg-block js-navbar-form">
        <div class="container-fluid text-center justify-content-center">
            <img class="nav-logo-big" src="/wys/images/logo3.svg" alt="What's your story?" title="What's your story?">
        </div>
        <a href="https://kingseducation.com" id="visit-link" class="text-end pe-4">
            Visit Kings website
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right"
                 viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
            </svg>
        </a>
    </nav>

    <nav id="nav-form-small"
         class="navbar navbar-expand-md navbar-dark bg-dark navbar-form-small justify-content-center d-block d-lg-none js-navbar-form">
        <div class="container-fluid text-center justify-content-center">
            <img class="nav-logo-small" src="/wys/images/logo2.svg" alt="What's your story?" title="What's your story?">
        </div>
    </nav>

    <main id="form-content">

        <form id="js-form" method="post" action="" enctype="multipart/form-data">
            <div class="full-height js-full-height-first">
                <div id="js-form-content-1" class="text-center">
                    <section class="pt-5 pb-5 text-center container d-block d-lg-none main-bottom-info-big">
                        <p>
                            Everyone has a story to tell. We want to hear yours.
                        </p>
                        <p>
                            It can be about anything: perhaps it's about your academic journey
                            or an adventure you've had since coming to Kings?
                        </p>
                        <p>
                            Maybe you have an interesting hobby or talent. Words, pictures and
                            video — whatever you want to share — we want to hear about it.
                        </p>
                        <p>
                            So tell us, <strong>what's your story?</strong>
                        </p>
                    </section>

                    <img class="pt-1" src="/wys/images/noun-profile-781943.svg" alt="Profile" title="Profile">
                    <div class="form-part-title">About you</div>
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-lg-5">
                            <label for="js-name" class="mx-auto">Name</label>
                            <input type="text" required class="mx-auto" name="name" id="js-name">
                            <label for="js-email" class="mx-auto">Email</label>
                            <input type="email" required class="mx-auto" name="email" id="js-email">
                        </div>
                        <div class="col-12 col-lg-5">
                            <label for="js-nationality" class="mx-auto">Nationality</label>
                            <select required name="nationality" class="form-select form-select-lg mx-auto text-start"
                                    id="js-nationality">
                                <option value="">Select</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <label for="js-are-you" class="mx-auto">Are you</label>
                            <select required name="are-you" class="form-select form-select-lg mx-auto text-start"
                                    id="js-are-you">
                                <option value="">Select</option>
                                <option value="a_student">A student</option>
                                <option value="an_alumna">An alumna/us</option>
                                <option value="a_parent">A parent</option>
                                <option value="a_member_of_staff">A member of staff</option>
                                <option value="an_agent">An agent</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <a href="#js-form-content-2"><img src="/wys/images/arrow_down.svg" alt="Next" title="Next"
                                                      class="arrow-next d-none d-lg-block"></a>
                </div>
            </div>
            <div class="full-height js-full-height">
                <div id="js-form-content-2" class="text-center">
                    <div class="empty-top"></div>

                    <img class="pt-2" src="/wys/images/noun-chat-781945.svg" alt="Your story" title="Your story">
                    <div class="form-part-title">Your story</div>
                    <label for="js-title" class="mx-auto pt-3">Give your story a title</label>
                    <input required type="text" class="mx-auto" name="title" id="js-title">

                    <div class="ps-2 pe-2">
                        <label for="js-story">What's your story?</label>
                        <textarea required class="form-control mx-auto" name="story" id="js-story"
                                  placeholder="Max 400 words"></textarea>
                    </div>

                    <a href="#js-form-content-3"><img src="/wys/images/arrow_down.svg" alt="Next" title="Next"
                                                      class="arrow-next d-none d-lg-block"></a>
                </div>
            </div>
            <div class="full-height js-full-height">
                <div id="js-form-content-3" class="text-center">
                    <div class="empty-top"></div>

                    <img class="pt-2" src="/wys/images/noun-camera-781947.svg" alt="Media" title="Media">
                    <div class="form-part-title"><a id="link-media-upload"></a>Media</div>
                    <div class="row justify-content-md-center">
                        <div class="col-12 col-xl-4">
                            <label class="mx-auto">Video and photo</label>
                            <button type="button" id="js-btn-upload-media" class="btn btn-pink-rounded w-100">
                                UPLOAD FILE
                            </button>
                            <input type="file" accept=".png,.jpg,.jpeg,.gif,.avi,.mp4,.mp3,.mpg" id="js-file-media"
                                   style="display: none;" multiple="multiple" name="file_media[]">
                        </div>
                        <div class="col-12 col-xl-4">
                            <label class="mx-auto">Text document</label>
                            <button type="button" id="js-btn-upload-text" class="btn btn-pink-rounded w-100">
                                UPLOAD FILE
                            </button>
                            <input type="file" multiple="multiple" id="js-file-text" accept=".doc,.docx,.txt,.pdf" style="display: none;"
                                   name="file_text[]">
                        </div>
                        <div class="col-12 col-xl-4">
                            <label for="js-share_link" class="mx-auto">Share link</label>
                            <input type="text" class="mx-auto" name="share_link" id="js-share_link">
                            <div class="info-text-gray">
                                This can be a space like Google Drive or Dropbox where we can access the files you
                                want to share with us.
                            </div>
                        </div>
                    </div>

                    <a href="#js-form-content-4"><img src="/wys/images/arrow_down.svg" alt="Next" title="Next"
                                                      class="arrow-next d-none d-lg-block"></a>
                </div>
            </div>
            <div class="full-height js-full-height bg-white">
                <div id="js-form-content-4">
                    <div class="empty-top d-none d-lg-block"></div>
                    <div class="empty-top-small d-block d-lg-none"></div>

                    <div class="confirm-message-container">
                        <div class="confirm-message">
                            Please confirm you give us permission <br> to use photos and videos:
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accept" id="js-accept" value="1" checked>
                            <label class="form-check-label confirm-label" for="js-accept">
                                I accept
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accept" id="js-do_not_accept" value="0">
                            <label class="form-check-label confirm-label" for="js-do_not_accept">
                                I do not accept
                            </label>
                        </div>
                    </div>
                    <div class="w-100 text-center">
                        <button type="button" id="js-btn-submit" class="btn btn-pink-rounded mt-5 mb-5">
                            SUBMIT YOUR STORY
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <footer class="pt-5 text-center">
        <img src="/wys/images/KingsLogo_WhitePink.svg" alt="Kings Education" title="Kings Education">
        <div class="copyright-info pt-3">&copy; Kings Education 2022</div>
    </footer>
</div>

</body>

</html>
