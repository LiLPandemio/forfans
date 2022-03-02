<!-- NEEDS $post ARRAY TO BE SETTED UP -->
<?php
if (isset($post)) {
    //GO
?>
    <div style="padding: 0; min-height: 160px" class="card text-left post-body">
        <?php
        if ($img_array != "") {
        ?>
            <script>
                function next_picture(elem) {
                    var ids = $(elem).attr("id");
                    var ids_array = ids.split("_");
                    next = parseInt(ids_array[1]) + 1;
                    if ($("#" + ids_array[0] + "_" + next).length) {
                        //Exists
                        $("#" + ids).hide();
                        $("#" + ids_array[0] + "_" + next).show();
                        $("#currentImages_" + ids_array[0]).html(next + 1)
                    } else {
                        //Not exists
                        $("#" + ids).hide();
                        $("#" + ids_array[0] + "_" + 0).show();
                        $("#currentImages_" + ids_array[0]).html(1)
                    }
                }
            </script>
            <div style="flex:5" class="card-body">
                <?php
                if (count($img_array) > 1) {
                ?>
                    <p class="text-muted text-center" style="font-size: 70%;">Haz click en la imagen para ver mas<br><span id="currentImages_<?= $post["post_id"] ?>">1</span>/<?= count($img_array) ?></p>
                <?php }
                ?>
                <div id="images_<?= $post["post_id"] ?>">
                    <?php
                    for ($j = 0; $j < count($img_array); $j++) {
                        $img_array = str_replace("{fullsiteurl}", $config["fullsiteurl"], $img_array) //remplaza {fullsiteurl} por cfg fullsiteurl
                    ?>
                        <img onclick="next_picture(this)" id="<?php echo $post["post_id"] . "_" . $j  ?>" style="object-fit:cover; margin: 10px; margin-top:10px; border-radius: 5px; width:95%;<?php if ($j > 0) {
                                                                                                                                                                                                    echo " display:none";
                                                                                                                                                                                                } ?>" src="<?php echo $img_array[$j] ?>" alt="POST">
                    <?php
                    }
                    ?>
                </div>
            </div>

        <?php

        } else {

        ?>
            <div style="flex:3"></div>
        <?php

        }

        ?>
        <div class="card-body" style="display:flex; flex-direction:row; flex:6">
            <img class="avatar" style="border-radius: 50px; height: 50px; width: 50px; margin-right:10px;" src="<?= $config["fullsiteurl"] . $post["profile_picture_rpath"] ?>">
            <div style="flex-wrap: wrap;">
                <div class="post-info-about" style="max-height: 40px">
                    <div class="row" style="height: 50%;">
                        <div class="col-sm-6">
                            <p class="card-text">@<?= $post["username"] ?></p>
                        </div>
                        <div style="text-align: right;" class="col-sm-6">
                            <small class="text-muted"><?php
                                                        //2022-02-22 16:49:39
                                                        $ptarr = explode("_", str_replace(array("-", ":", " "), "_", $post["post_time"]));
                                                        echo $ptarr[2] . "/" . $ptarr[1] . "/" . $ptarr[0];
                                                        ?></small>
                        </div>
                    </div>
                    <div style="height: 50%;">
                        <a class="badge badge-primary" href="#"><?php echo howManyPostsHasUsername($post['username']) ?> Posts</a>
                        <a class="badge badge-danger" href="#">Suscribirse</a>
                        <a class="badge badge-success" href="#">Donado $<?= $post["post_donations"] ?></a>
                        <a class="badge badge-accent" style="color:var(--bs-primary-rgb);border:1px solid gray" href="#">Seguir</a>
                    </div>
                </div>
                <div style="flex: 1 1 250px; margin-top:40px; margin-left:-50px">
                    <?= $post["post_text"] ?>
                </div>
            </div>
        </div>
        <?php
        if ($img_array !== "") {
        ?>
            <div style="flex:3"></div>
        <?php
        }

        if ($post["is_nsfw"] == "1") {
        ?>
            <div class="nsfwnotice" id="nsfwnotice-post-<?= $post["post_id"] ?>">

                <div style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:9;filter: blur(4px);background: repeating-linear-gradient(45deg,var(--bs-primary),var(--bs-primary) 25px,var(--bs-dark) 25px,var(--bs-dark) 50px);"></div>
                <div style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:9;">
                    <div style="position:absolute; width:60%;margin-top:10px;margin-left:20%;text-align:center; background-color:var(--bs-dark);opacity: 0.8; border-radius:5px; padding: 10px">
                        <p style="color: white">El contenido esta marcado como inapropiado</p> <br>
                        <button type="button" onclick="$('#nsfwnotice-post-<?= $post["post_id"] ?>').fadeOut()" class="btn btn-primary">SHOW POST</button>
                    </div>
                </div>
            </div>
        <?php
        }

        ?>
    </div>
<?php

} else {
    echo "MISSING DATA";
}

?>