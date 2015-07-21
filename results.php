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
<?php


?>
<div class="container">

    <?php
    require('engines/KickAss.php');
    require('engines/ExtraTorrent.php');
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
            echo "<td><a href='$obj[1]' onclick=\"return saveLink('$obj[1]');\">Link</a></td>";
            echo "<td>" . $engine->getName() . "</td>";
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
        foreach($search_engines as $item) {
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
    function saveLink(link) {
        console.log(link);

        $.ajax({
            type: "POST",
            url: 'save_results.php',
            data: {
                data: link
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
<style>
    thead {
        cursor: pointer;
    }
</style>