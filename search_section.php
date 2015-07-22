<?php
function get_engines()
{
    $basePath = 'engines';
    if ($handle = opendir($basePath)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && stripos($entry, '.php') !== false) {

                include_once("$basePath/" . $entry);
                $className = str_ireplace('.php', '', $entry);
                $obj = new $className();
                $name = $obj->getName();
                $parsers[$name] = $obj;
            }
        }
        closedir($handle);
    }
    return $parsers;
}

?>

<form class="col s12" method="post" action="results.php">
    <div class="row">
        <form class="col s12">
            <div class="row">
                <div class="input-field col">
                    <input id="query" name="query" type="text"
                           value="<?php echo(isset($_POST['query']) ? $_POST['query'] : ''); ?>"><button class="btn waves-effect waves-light" type="submit" name="action">Buscar</button>
                    <label for="query">Buscar torrent</label>

                    <p>
                        <?php
                        $search_engines = get_engines();
                        $i = 1;
                        foreach ($search_engines as $eng) {
                            $name = $eng->getName();
                            $checked = (isset($_POST[$name]) ? 'checked="checked"' : '');
                            echo '<input type="checkbox"  name="' . $name . '" id="filled-in-box' . $i . '" ' . $checked . '/>';
                            echo '<label for="filled-in-box' . $i . '">' . str_replace("_", " ", $name) . '</label>';
                            $i++;
                        } ?>
                    </p>
                </div>
            </div>
    </div>
</form>
