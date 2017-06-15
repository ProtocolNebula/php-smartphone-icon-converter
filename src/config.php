<?php
// APP Settings:
//define('MAX_FILE_SIZE', '5242880'); // In Bytes (default 5 MB)

// AVOID DDOS: minimum time between conversions
define('SECONDS_BETWEEN_CONVERSIONS', '10'); // In seconds (0 = disable this)


// Icons Settings:
/*
    Output Sizes:
    'OS (ANDROID|IOS|WPH)'=>array(
            // NOTA: En el caso de ANDROID, en lugar de "archivo" es el directorio donde se incluira
            'nombre_archivo'=>array(
                    'width' => '',
                    'height' => '',
                    'fileName'=>'', // SOLO ANDROID
                    'bg'=>'transparent|white', // OPCIONAL (transparent por defecto)
            )
*/
$sizes = array(
    'ANDROID'=>array(
        'drawable'=>array('width'=>72, 'height'=>72, 'fileName'=>'icon.png'),
        'drawable-hdpi'=>array('width'=>72, 'height'=>72, 'fileName'=>'icon.png'),
        'drawable-xhdpi'=>array('width'=>96, 'height'=>96, 'fileName'=>'icon.png'),
        'drawable-xxhdpi'=>array('width'=>144, 'height'=>144, 'fileName'=>'icon.png'),
    ),
    'IOS'=>array(
        'AppStoreIcon.png'=>array('width'=>1024, 'height'=>1024, 'bg'=>'white'),
        'Default.png'=>array('width'=>320, 'height'=>480, 'bg'=>'white'),
        'Default@2x.png'=>array('width'=>640, 'height'=>960, 'bg'=>'white'),
        'Default-568.png'=>array('width'=>320, 'height'=>568, 'bg'=>'white'),
        'Default-568h@2x.png'=>array('width'=>640, 'height'=>1136, 'bg'=>'white'),
        'Default-Portrait.png'=>array('width'=>768, 'height'=>1004, 'bg'=>'white'),
        'Default-Portrait@2x.png'=>array('width'=>1536, 'height'=>2008, 'bg'=>'white'),
        'Icon-60@2x.png'=>array('width'=>120, 'height'=>120, 'bg'=>'white'),
        'Icon-60@3x.png'=>array('width'=>180, 'height'=>180, 'bg'=>'white'),
        'Icon-76.png'=>array('width'=>76, 'height'=>76, 'bg'=>'white'),
        'Icon-76@2x.png'=>array('width'=>152, 'height'=>152, 'bg'=>'white'),
        'Icon-83.png'=>array('width'=>84, 'height'=>84, 'bg'=>'white'),
        'Icon-83@2x.png'=>array('width'=>167, 'height'=>167, 'bg'=>'white'),
        'Icon-Small.png'=>array('width'=>29, 'height'=>29, 'bg'=>'white'),
        'Icon-Small@2x.png'=>array('width'=>58, 'height'=>58, 'bg'=>'white'),
        'Icon-Small@3x.png'=>array('width'=>87, 'height'=>87, 'bg'=>'white'),
        'Icon-Small-40.png'=>array('width'=>40, 'height'=>40, 'bg'=>'white'),
        'Icon-Small-40@2x.png'=>array('width'=>80, 'height'=>80, 'bg'=>'white'),
        'Icon-Small-40@3x.png'=>array('width'=>120, 'height'=>120, 'bg'=>'white'),
    ),
);