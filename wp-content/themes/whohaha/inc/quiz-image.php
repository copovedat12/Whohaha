<?php
use Intervention\Image\ImageManagerStatic as Image;
// use Intervention\Image\ImageManager;

function make_quiz_image_ajax(){
	$best_friend = $_POST['best_friend'];
	$user = $_POST['user'];
	$slug = $_POST['slug'];
	$uploads_dir = wp_upload_dir();
	$template_dir = get_template_directory();

	header('Content-Type: application/json');
	try {

		if (!file_exists( $uploads_dir['basedir'] . '/user-images' )) {
		    mkdir($uploads_dir['basedir'] . '/user-images', 0777, true);
		}

		$canvas = Image::canvas(1200, 630, '#ff5555');

		$image1 = Image::make($user[img])->resize(330, 330);
		$canvas->insert($image1, 'top-left', 175, 201);

		$image2 = Image::make($best_friend[img])->resize(330, 330);
		$canvas->insert($image2, 'top-left', 695, 201);

		$imgTemplate = Image::make(__DIR__.'/quiz/whh-quiz-share.png')->resize(1200, 630);
		$canvas->insert($imgTemplate, 'top-left', 0, 0);

		$canvas->text('IF SOMEONE WANTS TO BE YOUR LOVER', 600, 52, function($font){
			$font->file(__DIR__.'/quiz/fonts/brandon_med-webfont.ttf');
			$font->size(42);
			$font->color('#FFFFFF');
			$font->align('center');
			$font->valign('top');
		});
		$canvas->text('THEY GOTTA GET WITH ' . strtoupper($best_friend['first_name']) , 600, 102, function($font){
			$font->file(__DIR__.'/quiz/fonts/brandon_med-webfont.ttf');
			$font->size(42);
			$font->color('#FFFFFF');
			$font->align('center');
			$font->valign('top');
		});

		$share_img = $canvas->save( $uploads_dir['basedir'] . '/user-images/'. $slug .'_'.$user['id'].'_share.png', 50);

		$imgTemplate = Image::make(__DIR__.'/quiz/whh-quiz-display.png')->resize(1200, 630);
		$canvas->insert($imgTemplate, 'top-left', 0, 0);

		$canvas->text('IF SOMEONE WANTS TO BE YOUR LOVER', 600, 52, function($font){
			$font->file(__DIR__.'/quiz/fonts/brandon_med-webfont.ttf');
			$font->size(42);
			$font->color('#FFFFFF');
			$font->align('center');
			$font->valign('top');
		});
		$canvas->text('THEY GOTTA GET WITH ' . strtoupper($best_friend['first_name']) , 600, 102, function($font){
			$font->file(__DIR__.'/quiz/fonts/brandon_med-webfont.ttf');
			$font->size(42);
			$font->color('#FFFFFF');
			$font->align('center');
			$font->valign('top');
		});

		$img = $canvas->save( $uploads_dir['basedir'] . '/user-images/'. $slug .'_'.$user['id'].'.png', 50);

		print_r( json_encode(array('response' => 'success', 'img_path' => $img->basename)) );
	} catch (Exception $e) {
		print_r( json_encode( array('response' => 'error', 'exception' => $e) ) );
	}

	wp_die();
}
add_action( 'wp_ajax_make_quiz_image_ajax', 'make_quiz_image_ajax' );
add_action( 'wp_ajax_nopriv_make_quiz_image_ajax', 'make_quiz_image_ajax' );
