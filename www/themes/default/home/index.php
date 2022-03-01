<?php
require_once(ROOT . "/functions/contentEngine.php");
require_once(ROOT . "/functions/userEngine.php");
require_once(ROOT . "/functions/authEngine.php");
if (isset($_COOKIE["token"])) {
    $tokenStatus = checkTokenStatus($_COOKIE["token"]);
    if ($tokenStatus !== "INVALID_TOKEN" and $tokenStatus !== "TOKEN_EXPIRED") {
        $udata = getUserData(whoami($_COOKIE["token"]));
        $config["default_lang"] = $udata["lang"];
    }
}
if (isset($_COOKIE["token"])) {
    $tokenStatus = checkTokenStatus($_COOKIE["token"]);
    if ($tokenStatus !== "INVALID_TOKEN" and $tokenStatus !== "TOKEN_EXPIRED") {
        $udata = getUserData(whoami($_COOKIE["token"]));
        $config["default_lang"] = $udata["lang"];
    }
}
require(ROOT . "/locale/" . $config["default_lang"] . ".php");      //Cargar idioma
if (isset($_COOKIE['token'])) {                                     //SI EXISTE LA COOKIE CON TOKEN
    $token = $_COOKIE['token'];                                     //GUARDALA EN $token
    if (checkTokenStatus($token) != "INVALID_TOKEN") {              //Si el estado del token no es invalido
        //Mostrar la pagina

?>
        <!-- Aqui puedes añadir contenido exta a head -->
        <link rel="stylesheet" href="<?= $config["fullsiteurl"] . "themes/" . $config["theme"] . "/home/" . "index" ?>.css">

        <!-- Hasta aqui el contenido head -->
        </head>

        <body>
            <!-- Aqui va el contenido principal de la pagina -->
            <!-- Load navbar -->
            <?php require(ROOT . "/themes/" . $config["theme"] . "/components/navbar.phtml"); ?>
            <div class="row" style="width:100%">
            </div>
            <div class="row" style="margin-top: 80px; width:100%">
                <div class="col-sm-3">

                    <!-- Include suggestions at left -->
                    <?php include(ROOT . "/themes/" . $config["theme"] . "/components/left-profile-suggestions.phtml") ?>

                </div>
                <div class="col-sm-8" style="overflow:scroll ">
                    <div class="title-wrapper" style="padding:10px">
                        <div id="accordion-newpost">

                            <div id="title_suggestion_new_post" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" class="title-wrapper" style="padding:10px; padding-top: 0px;">
                                <ul style="cursor:pointer; text-align: center; width: 100%" class="breadcrumb">
                                    <li style="text-align: center; width: 100%"><?= lang("inspired_publish_something") ?></li>
                                </ul>
                            </div>

                            <div id="collapseThree" class="collapse show" aria-labelledby="headingTwo" style="margin-bottom: 10px;" data-parent="#accordion-newpost">
                                <form id="newPostForm">
                                    <div class="card card-body" style="padding:20px;">
                                        <div style="text-align: center;">
                                            <label for="postTextTextarea">Texto de la publicacion</label>
                                            <p id="tooLongTextWarn" style="display:none" class="text-danger">El texto es demasiado largo. Limite de 1200 caracteres.</p>
                                            <textarea onkeydown="controlInput()" onkeyup="controlInput()" onchange="controlInput()" placeholder="Publica lo que quieras! #Anime #Hentai #xXx" class="form-control" id="postTextTextarea" rows="3"></textarea>
                                            <!-- style="background-color: var(--bs-body-bg); color: var(--bs-body-color)" -->
                                        </div>
                                        <div id="previews">
                                        </div>
                                        <div style="margin-top: 10px; text-align:center">
                                            <button onclick="$('#postImagesInput').click()" type="button" class="btn btn-sm btn-primary"><i class="fa fa-camera" aria-hidden="true"></i> <?= lang("add_content") ?> </button>
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-sticky-note" aria-hidden="true"></i> <?= lang("add_gif") ?> </button>
                                            <button type="button" id="chars-left-btn" disabled class="btn btn-sm btn-outline-success"><i class="fa fa-font" aria-hidden="true"></i> <span id="chars-left">0</span></button>
                                        </div>
                                        <input style="display: none;" id="postImagesInput" accept=".jpg,.png,.webp,.giff,.tiff" type="file" name="my_file[]" multiple>
                                        <span style="margin-top: 10px; display:flex; flex-direction:row">
                                            <span style="position: relative; top:5px">
                                                <p><?= lang("adult_content") ?>&nbsp;&nbsp;&nbsp;</p>
                                            </span>
                                            <label class="form-check-label switch">
                                                <input class="form-check-input" name="newPostIsNSFW" id="newPostIsNSFW" value="checkedValue" type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </span>
                                        <span style="margin-top: 10px; display:flex; flex-direction:row">
                                            <span style="position: relative; top:5px">
                                                <p>Public Content&nbsp;&nbsp;&nbsp;</p>
                                            </span>
                                            <label class="form-check-label switch">
                                                <input class="form-check-input" name="newPostIsPublic" id="newPostIsPublic" value="checkedValue" type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </span>
                                        <button type="button" onclick="createPost()" style="margin-top: 5px; width:60%; margin-left:20%" id="submitNewPost" class="btn btn-primary">Publicar <span style="display: none;" class="loading_item"><i class="fas fa-spinner fa-spin"></i></span></button>
                                        <script>
                                            function getToken() {
                                                cookie = document.cookie.split('; ').reduce((prev, current) => {
                                                    const [name, ...value] = current.split('=');
                                                    prev[name] = value.join('=');
                                                    return prev;
                                                }, {});
                                                return cookie.token;
                                            }
                                            const setLoading = () => {
                                                $(".loading_item").fadeIn(100)
                                            }
                                            const unsetLoading = () => {
                                                $(".loading_item").fadeOut(100)

                                            }
                                            async function createPost() {
                                                //TODO: Check if there's something to upload, NO BLANK POSTS!!!!
                                                setLoading()
                                                var files = document.getElementById("postImagesInput").files;

                                                var formData = new FormData()
                                                for (let i = 0; i < files.length; i++) {
                                                    const file = files[i];
                                                    formData.append(i, files[i]);
                                                }
                                                formData.append("postTextTextarea", $("#postTextTextarea").val())
                                                formData.append("newPostIsNSFW", $("#newPostIsNSFW").is(":checked"))
                                                formData.append("newPostIsPublic", $('#newPostIsPublic').is(":checked"))

                                                $.ajax({
                                                        // Your server script to process the upload
                                                        url: siteURL + "api/post",
                                                        type: 'POST',

                                                        // Form data
                                                        data: formData,
                                                        contentType: 'multipart/form-data',
                                                        // Tell jQuery not to process data or worry about content-type
                                                        // You *must* include these options!
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,

                                                        // Custom XMLHttpRequest
                                                        xhr: function() {
                                                            var myXhr = $.ajaxSettings.xhr();
                                                            if (myXhr.upload) {
                                                                // For handling the progress of the upload
                                                            }
                                                            return myXhr;
                                                        },
                                                    }).done(function(r) {
                                                        console.log("---------------OK---------------");
                                                        unsetLoading()
                                                        $("#title_suggestion_new_post").click();
                                                        $("#newPostForm").trigger("reset")
                                                        $("#previews").html("");
                                                        console.log(r);
                                                    })
                                                    .fail(function(status, xhr, error) {
                                                        console.log("---------------ER---------------");
                                                        console.log(status);
                                                        console.log(xhr);
                                                        console.log(error);
                                                        alert("Something went wrong :(")
                                                    })
                                            }
                                        </script>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                        $posts = getPublicPosts();
                        for ($i = 0; $i < count($posts); $i++) {
                            $post = $posts[$i];
                            $img_array = json_decode($post["post_img_array"]);
                            include(ROOT . "/themes/" . $config['theme'] . "/components/post.php");
                        } ?>
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="dynFlexHV Subs" id="accordion-subs">
                        <div data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="title-wrapper" style="padding:10px; padding-top: 0px;">
                            <ul style="cursor:pointer" class="breadcrumb">
                                <li style="text-align: center; width: 100%">Subs</li>
                            </ul>
                        </div>

                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-subs">
                            <div class="card">
                                <div class="card-body subs ccard" style="padding-top: 0px; text-align: center;">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                    <img class="avatar sub-item" src="https://cataas.com/cat/says/<?php echo rand(1, 5000) ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Espacio necesario para que en la version movil no se solapen los menus -->
            <div class="separator" style="margin-top: 80px;"></div>
            <script>
                $('#postImagesInput').change(function() {
                    $("#previews").html('');
                    for (var i = 0; i < $(this)[0].files.length; i++) {
                        $("#previews").append('<img src="' + window.URL.createObjectURL(this.files[i]) + '" class="preview"/>');
                    }
                });

                function controlMaxFiles() {
                    $("#submitNewPost").click(function() {
                        var $fileUpload = $("input[type='file']");
                        if (parseInt($fileUpload.get(0).files.length) > 6) {
                            alert("You can only upload a maximum of 6 files");
                            return false;
                        }
                        return true;
                    });
                }

                function controlInput() {
                    let text = $("#postTextTextarea").val();
                    if (text.length > 1200) {
                        $("#chars-left-btn").addClass("btn-outline-danger");
                        $("#chars-left-btn").removeClass("btn-outline-warning");
                        $("#chars-left-btn").removeClass("btn-outline-success");
                        $("#tooLongTextWarn").show();
                    } else {
                        $("#tooLongTextWarn").hide();
                        $("#chars-left-btn").removeClass("btn-outline-danger");
                        if (text.length > 1000) {
                            // WARN
                            $("#chars-left-btn").addClass("btn-outline-warning");
                            $("#chars-left-btn").removeClass("btn-outline-success");
                        } else {
                            // OK
                            $("#chars-left-btn").addClass("btn-outline-success");
                            $("#chars-left-btn").removeClass("btn-outline-warning");
                        }
                    }
                    $("#chars-left").html(text.length);
                }
            </script>
        </body>
<?php
    } else {
        redirect();
    }
} else {
    redirect();
}
