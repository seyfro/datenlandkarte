<?php
    $root = './';
    require_once($root.'global.php');
    require_once($root.'lib/lib.php');

    $n = new Notifications();
    $f = new FileManager($location_creation, $location_raw_data,
            $location_pattern_svgs, $n);
    $g = new Geo($geo_hierarchy, $f);

    $method = isset($_GET['method']) ? $_GET['method'] : '';
    $indent = isset($_GET['indent']) ? $_GET['indent'] : 0;
    $keys = NULL;
    $svg = false;

    if (endswith($method, '_form'))
    {
        $vp = new VisPath(isset($_GET['vis_path']) ? $_GET['vis_path'] : NULL);
        $keys = $g->get($vp);
    }

    if ($method == 'manual_form') {
        die(create_manual_form($keys, $indent));
    } else if ($method == 'list_form') {
        die(create_list_form($keys, $indent));
    } else if ($method == 'json_form') {
        die(create_json_form($keys, $indent));
    } else if ($method == 'kvalloc_form') {
        die(create_kvalloc_form($keys, $indent));
    }


    /* Example

    {
        "title" : "Testing",
        "subtitle" : "test",
        "base" : ["austria", "bl"],
        "dec" : 1,
        "colors" : 10,
        "grad" : 2,
        "data" : {
            "Feldkirchen" : 1, "Hermagor" : 2,
            "Klagenfurt" : 3, "Klagenfurt-Land" : 4,
            "Spittal an der Drau" : 5, "St. Veit an der Glan" : 6,
            "Villach" : 7, "Villach-Stadt" : 8,
            "Völkermarkt" : 9,"Wolfsberg" : 10
        }
    }
    */

    //
    // Create SVG source code from a JSON object (API request or raw data
    // file written by Data::export_json). Uses the same classes as the
    // webinterface, but does not write any files.
    //
    // @param json_obj decoded JSON object (array)
    // @return SVG source code. false on error.
    //
    function json2svg($json_obj, &$g, &$f, &$color_gradients, &$color_allocation)
    {
        if (!is_array($json_obj) || !isset($json_obj['data'])
            || !is_array($json_obj['data']))
            return false;

        // build a pseudo $_POST for UserInterface::from_webinterface()
        $post = array();
        foreach (array('title', 'subtitle', 'author', 'source', 'dec',
            'fac', 'grad', 'colors') as $key)
        {
            if (isset($json_obj[$key]) && is_scalar($json_obj[$key]))
                $post[$key] = (string)$json_obj[$key];
        }

        if (isset($json_obj['palette']) && is_array($json_obj['palette']))
            $post['palette'] = implode(',', $json_obj['palette']);
        else if (isset($json_obj['palette']) && is_string($json_obj['palette']))
            $post['palette'] = $json_obj['palette'];
        if (!isset($post['grad']))
            $post['grad'] = '0';

        // vispath (apiversion >= 1) or base (apiversion 0)
        if (isset($json_obj['vispath']) && is_string($json_obj['vispath']))
            $post['vis_path'] = $json_obj['vispath'];
        else if (isset($json_obj['base']) && is_array($json_obj['base']))
            $post['base'] = $json_obj['base'];

        // a list of values is in order of the template,
        // an object maps names to values
        if (array_keys($json_obj['data']) === range(0, count($json_obj['data']) - 1))
        {
            $post['format'] = 'manual';
            $post['manual'] = $json_obj['data'];
        } else {
            $post['format'] = 'json';
            $post['json'] = json_encode($json_obj['data']);
        }

        $n = new Notifications();
        $ui = new UserInterface($g, $n);
        if (!$ui->from_webinterface($post, $color_gradients, $color_allocation))
            return false;

        $d = new Data();
        $d->import_ui($ui);

        $svg = new Svg($g, $d, $f, $n);
        if ($svg->fetch() === false)
            return false;
        $svg->write_titles();
        $svg->write_legend();
        return $svg->write_areas();
    }

    $param = ($_GET) ? $_GET : $_POST;
    if (!empty($param['data']))
    {
        $path = $location_raw_data.basename(base64_decode($param['data']));
        if (file_exists($path))
        {
            $content = file_get_contents($path);
            if (!$content) die();

            $json = json_decode($content, true);
            if (!$json) die();

            $svg = json2svg($json, $g, $f, $color_gradients, $color_allocation);
            if (!$svg) die();
        } else {
            die();
        }
    } else if (!empty($param['q']))
    {
        $json = json_decode($param['q'], true);
        if (!$json) die();

        $svg = json2svg($json, $g, $f, $color_gradients, $color_allocation);
        if (!$svg) die();
    }

    if ($svg) {
        header('Content-type: image/svg+xml; charset=utf-8');
        echo $svg;
    } else {
?><!DOCTYPE html>
<html>
  <head>
    <title>API für datenlandkarten.at</title>
    <meta name="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      body { font-family: Verdana, Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 0 12px; }
      textarea { box-sizing: border-box; }
    </style>
  </head>

  <body>
    <h1>Application Programming Interface</h1>
    <p>
        Send the following JSON object as GET or POST request to
        <?=basename($_SERVER['SCRIPT_FILENAME']); ?>. It has to be
        the value of key "q". For testing you can simply send
        a test example below.
    </p>
    <p>
        The API will return a valid SVG file or an empty file
        on error.
    </p>

    <form action="<?=basename($_SERVER['SCRIPT_FILENAME']); ?>" method="post">
      <textarea name="q" cols="100" rows="15" style="width:100%">{
    "base" : [ "austria", "bl" ],
    "colors" : 10,
    "data" : { "Burgenland" : 1, "Kärnten" : 2, "Wien" : 9 },
    "dec" : 3,
    "grad" : 2,
    "subtitle" : "Untertitel",
    "title" : "Haupttitel"
}</textarea> <br>
    <input type="submit" value="Aufrufen" style="float:right">
    </form>

    <h2>Small specification</h2>
    <p>
        Sorry, a better API design would be nice, but internal function
        do not work out that well.
    </p>

    <p><strong>base:</strong> A two-value list. Is one of (['austria',
        'bz'], ['oe', 'gm'], ['austria', 'bl'], ['europe', 'l'],
        [int, 'bz'], [int, 'gm']). int has to be an integer. [int, 'gm']
        means "int. Bundesland Gemeinden". "gm" stands for "Gemeinde".
        "bz" stands for "Bezirk". Checkout the 
        <a href="https://github.com/meisterluk/datenlandkarte/blob/master/global.php">global.php</a>
        file in the github repository for the exact order of Gemeinden
        and Bezirke.
    </p>
    <p>
        <strong>colors:</strong> Number of colors (2-10).
    </p>
    <p>
        <strong>data:</strong> JSON-Objekt for allocation of Key and Value.
            Just leave out
    </p>
    <p>
        <strong>dec:</strong> Number of decimal points (0-3).

    </p>
    <p>
        <strong>grad:</strong> Number for color gradient (0-<?=count($color_gradients) - 1; ?>).
    </p>
    <p>
        <strong>(sub)title:</strong> String for (sub)title.
    </p>
  </body>
</html><?php } ?>
