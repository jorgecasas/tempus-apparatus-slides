<?php
/**
 * Idea: Crear automaticamente los slides a partir de imagenes, parseando su nombre
 */
// Variables configuracion
$path_images = dirname( __FILE__ ) . '/images/others/';
$path_html = dirname( __FILE__ ) . '/';

 // Limpiamos el array para que no de errores 
$array_images = scandir( $path_images ); 
$array_images = array_diff( $array_images, array( '.', '..'  ) );

if ( empty( $array_images ) ) {
	die( "No images available in ". $path_images);
}
$str = file_get_contents( $path_html . 'index-start.html');

// Recorremos todas las imagenes
$array_extensions_valid = array( 'jpg', 'png', 'gif');
foreach( $array_images as $image ) {
	$pathinfo = pathinfo($image);
	if ( in_array( strtolower($pathinfo['extension']), $array_extensions_valid)) {
		echo "\nProcessing ". $pathinfo['basename'];
		$filename_exploded = explode( '-', strtolower($pathinfo['filename']) );
		$filename_exploded_ucfirst = strtoupper( implode( ' ' , array_map( 'ucfirst', $filename_exploded ) ) );
		$str.= '<slide>
            <hgroup>
                <h2>'.$filename_exploded[ 0 ] . ( $filename_exploded[ 1 ] == 'circa' ? ' - Circa' : '' ).'</h2>
                <div>' . $filename_exploded_ucfirst . '</div>
            </hgroup>
            <article>
                
                <div class="flexbox vcenter">
                    <img src="images/others/'.$pathinfo['basename'].'" class="large" alt="'.$filename_exploded_ucfirst.'" title="'.$filename_exploded_ucfirst.'" />
                </div>
            </article>
        </slide>'. "\n\n";
	}
}

$str.= file_get_contents( $path_html . 'index-end.html');

// Escribimos el fichero en el directorio
file_put_contents( $path_html . 'index.html', $str );

echo "\n\nFile index.html done!\n\n";