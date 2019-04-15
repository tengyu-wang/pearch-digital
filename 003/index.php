<!DOCTYPE html>
<html>
<head>
    <script src="js/gallery.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="css/gallery.css?v=<?php echo time(); ?>" />
</head>
<body>
    <div id="gallery">
        <div class="left_arrow disable"></div>
        <div class="images_block">
            <div id="images_row" class="images_row">

            </div>
        </div>
        <div class="right_arrow"></div>
    </div>

    <script>
        // images example
        let images = [{
            id: 1,
            name: "Audi",
            link: "img/audi.png"
        }, {
            id: 2,
            name: "BMW",
            link: "img/bmw.png"
        }, {
            id: 3,
            name: "Mercedes Benz",
            link: "img/benz.png"
        }];

        // create an instance of Gallery and initialise it
        let gallery = new Gallery(images);
        gallery.initialize();

    </script>
</body>
</html>