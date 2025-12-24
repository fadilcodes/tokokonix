<?php

use Codeat3\BladeIconGeneration\IconProcessor;

$svgNormalization = static function (string $tempFilepath, array $iconSet) {

    $attrsToRemove = [
        'sodipodi:docname',
        'version',
        'docname',
        'enable-background',
        'x',
        'y'
    ];
    $nsAttrsToRemove = [
        'dc' => 'http://purl.org/dc/elements/1.1/',
        'cc' => 'http://creativecommons.org/ns#',
        'rdf' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#',
        'svg' => 'http://www.w3.org/2000/svg',
        'sodipodi' => 'http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd',
        'inkscape' => 'http://www.inkscape.org/namespaces/inkscape',
        'xlink' => 'http://www.w3.org/1999/xlink',
        'version' => '0.48.4 r9939'
    ];

    // perform generic optimizations
    $iconProcessor = new IconProcessor($tempFilepath, $iconSet);
    $iconProcessor
        ->optimize(pre: function (&$svgEl) use ($attrsToRemove, $nsAttrsToRemove) {
            foreach ($svgEl->attributes as $att) { // get the attributes
                if (in_array($att->nodeName, $attrsToRemove)) {
                    $svgEl->removeAttributeNode($att); //remove the attribute
                    $svgEl->removeAttribute($att->nodeName); //remove the attribute
                }
            }

            foreach ($nsAttrsToRemove as $nk => $nv) {
                $svgEl->removeAttributeNS($nv, $nk);
            }


            $namedview = $svgEl->getElementsByTagName('namedview');
            if ($namedview && $namedview[0]) {
                $svgEl->removeChild($namedview[0]);
            }


        })
        ->postOptimizationAsString(function ($svgLine) {
            $svgLine = str_replace('<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">', '', $svgLine);
            return $svgLine;
            // $replacePattern = [
            //     '/<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">/s' => '',
            // ];
            // return preg_replace(array_keys($replacePattern), array_values($replacePattern), $svgLine);
        })
        ->save();
};

return [
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__ . '/../dist/dev/icons-svg',

        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__ . '/../resources/svg',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => false,

        // Call an optional callback to manipulate the icon
        // with the pathname of the icon and the settings from above...
        'after' => $svgNormalization,

        'is-solid' => true,
    ],
];
