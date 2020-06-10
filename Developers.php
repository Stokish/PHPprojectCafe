<?php session_start();


require_once ("executers/GuestVoydi.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Developers</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="styles/dev.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400&display=swap" rel="stylesheet">


</head>
<?php require_once("PartsOfSite/header.php"); ?>



<!-- BODY -->

<body>
<div class="d-flex flex-wrap">
    <div class="card mx-3 my-3" style="width:300px">
        <img class="card-img-top imgContact" src="photo/Dev/Santana.png" alt="" style="width:100%">
        <div class="card-body">
            <h4 class="card-title">Alisher Orazbay</h4>
            <p class="card-text">Astana IT Student, Computer Science</p>
            <a href="mailto:alisher.pvl67@gmail.com" class="btn btn-primary">Contact Developer</a>
        </div>
    </div>

    <div class="card mx-3 my-3" style="width:300px">
        <img class="card-img-top imgContact" src="photo/Dev/Wamuu.png" alt="" style="width:100%">
        <div class="card-body">
            <h4 class="card-title">Samat Tokish</h4>
            <p class="card-text">Astana IT Student, Computer Science</p>
            <a href="mailto:samtokish@gmail.com" class="btn btn-primary">Contact Developer</a>
        </div>
    </div>

    <div class="card mx-3 my-3" style="width:300px">
        <img class="card-img-top imgContact" src="photo/Dev/Esidisi.png" alt="" style="width:100%">
        <div class="card-body">
            <h4 class="card-title">Madiar Sabyrbek</h4>
            <p class="card-text">Astana IT Student, Computer Science</p>
            <a href="mailto:madi.sabyrbek@gmail.com" class="btn btn-primary">Contact Developer</a>
        </div>
    </div>
</div>

<div class="open">

</div>

</body>


<?php require_once("PartsOfSite/footer.php"); ?>


</html>
