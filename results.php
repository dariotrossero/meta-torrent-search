<head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="css/main.css"/>

<div class="container">
    <?php
    include('search_section.php');
    if (isset($_POST['query']))
        echo("Mostrando resultados para: <b>" . $_POST['query'] . "</b><br />\n");

    function generate_table($array, $engine)
    {
        foreach ($array as $obj) {
            echo "<tr>";
            echo "<td>$obj[0]</td>";
            echo "<td>$obj[2]</td>";
            echo "<td>$obj[3]</td>";
            echo "<td>$obj[4]</td>";
            echo "<td><a href='$obj[1]' onclick=\"return saveLink('$obj[1]', 'movie');\"> <i class='material-icons'>movie</i></a>  ";
            echo "<a href='$obj[1]' onclick=\"return saveLink('$obj[1]', 'tv_show');\"><i class='material-icons'>video_library</i></a>";
            echo "<a href='$obj[1]' onclick=\"return saveLink('$obj[1]', 'other');\"><i class='material-icons'>description</i></a></td>";
            echo "<td>" . str_replace("_", " ", $engine->getName()) . "</td>";
            echo "</tr>";
        }
    }

    ?>
    <table class='striped tablesorter' id="results">
        <thead>
        <tr>
            <th data-field="id">Name</th>
            <th data-field="size">File Size</th>
            <th data-field="seeds">Seeds</th>
            <th data-field="peers">Peers</th>
            <th data-field="link">Link</th>
            <th data-field="engine">Engine</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($search_engines as $item) {
            if (isset($_POST[$item->getName()]))
                generate_table($item->search(urlencode($_POST['query'])), $item);
        }
        ?>
        </tbody>
    </table>

</div>

<?php include('layouts/footer.php'); ?>
</body>

<script>
    function saveLink(link, type) {

        $.ajax({
            type: "POST",
            url: 'save_results.php',
            data: {
                data: {
                    link,
                    type
                }
            },
            cache: false,
            success: function (respuesta) {
                console.log(respuesta);
            }
        });

        return false;
    }
    $(document).ready(function () {
            $("#results").tablesorter();
        }
    );

</script>
