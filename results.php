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
function human_filesize($bytes, $decimals = 2) {
    $size = array('b','Kb','Mb','Gb','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

?>
<div class="container">

    <?php
    $engine = $search_engines[1];
    require('engines/KickAss.php');
    include('search_section.php');

    if (isset($_POST['query']))
        echo("Mostrando resultados para: <b>" . $_POST['query'] . "</b><br />\n");

    function generate_table($array,$engine)
    {
        foreach ($array as $obj) {
            echo "<tr>";
            echo "<td>$obj[0]</td>";
            $human_size = human_filesize($obj[2]);
            echo "<td>$human_size</td>";
            echo "<td>$obj[3]</td>";
            echo "<td>$obj[4]</td>";
            echo "<td><a href='$obj[1]' onclick=\"return saveLink('$obj[1]');\">Link</a></td>";
            echo "<td>".$engine->getName()."</td>";
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
        <?php generate_table($engine->search(urlencode($_POST['query'])), $engine); ?>
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
    $(document).ready(function()
        {
            $("#results").tablesorter();
        }
    );

</script>
<style>
    thead {
        cursor: pointer;
    }
</style>