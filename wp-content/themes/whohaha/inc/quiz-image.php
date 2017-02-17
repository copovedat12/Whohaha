<?php
use Intervention\Image\ImageManagerStatic as Image;
// use Intervention\Image\ImageManager;

function make_quiz_image_ajax(){
	$best_friend = $_POST['best_friend'];
	$user = $_POST['user'];
	$slug = $_POST['slug'];
	$uploads_dir = wp_upload_dir();
	$template_dir = get_template_directory();

	// Variables
	global $title;
	global $font_file;
	switch ($slug) {
		case 'gotta-get-with-my-friend':
			$img_coords = [
				'left' => ['x' => 175, 'y' => 201],
				'right' => ['x' => 695, 'y' => 201]
			];
			$font_file = 'brandon_med-webfont.ttf';
			$title = [
				'color' => '#FFFFFF',
				'line1' => [
					'text' => 'IF SOMEONE WANTS TO BE YOUR LOVER',
					'top' => 52,
					'size' => 42
				],
				'line2' => [
					'text' => 'THEY GOTTA GET WITH ' . strtoupper($best_friend['first_name']),
					'top' => 102,
					'size' => 42
				]
			];
			break;
		case 'legally-blonde':
			$img_coords = [
				'left' => ['x' => 250, 'y' => 175],
				'right' => ['x' => 620, 'y' => 175]
			];
			$font_file = 'Oswald-Bold.ttf';
			$title = [
				'color' => '#FEDEF0',
				'line1' => [
					'text' => strtoupper($best_friend['first_name']) . ' IS THE PAULETTE',
					'top' => 32,
					'size' => 60
				],
				'line2' => [
					'text' => 'TO YOUR ELLE',
					'top' => 95,
					'size' => 60
				]
			];
			break;
	}

	try {

		if (!file_exists( $uploads_dir['basedir'] . '/user-images' )) {
		    mkdir($uploads_dir['basedir'] . '/user-images', 0777, true);
		}

		$canvas = Image::canvas(1200, 630, '#ff5555');

		$image1 = Image::make($user[img])->resize(330, 330);
		$canvas->insert($image1, 'top-left', $img_coords['left']['x'], $img_coords['left']['y']);

		$image2 = Image::make($best_friend[img])->resize(330, 330);
		$canvas->insert($image2, 'top-left', $img_coords['right']['x'], $img_coords['right']['y']);

		$imgTemplate = Image::make(__DIR__.'/quiz/'.$slug .'/whh-quiz-share.png')->resize(1200, 630);
		$canvas->insert($imgTemplate, 'top-left', 0, 0);

		$canvas->text($title['line1']['text'], 600, $title['line1']['top'], function($font){
			global $title;
			global $font_file;
			$font->file(__DIR__.'/quiz/fonts/'.$font_file);
			$font->size($title['line1']['size']);
			$font->color($title['color']);
			$font->align('center');
			$font->valign('top');
		});
		$canvas->text($title['line2']['text'] , 600, $title['line2']['top'], function($font){
			global $title;
			global $font_file;
			$font->file(__DIR__.'/quiz/fonts/'.$font_file);
			$font->size($title['line2']['size']);
			$font->color($title['color']);
			$font->align('center');
			$font->valign('top');
		});

		$share_img = $canvas->save( $uploads_dir['basedir'] . '/user-images/'. $slug .'_'.$user['id'].'_share.png', 50);

		$imgTemplate = Image::make(__DIR__.'/quiz/'.$slug .'/whh-quiz-display.png')->resize(1200, 630);
		$canvas->insert($imgTemplate, 'top-left', 0, 0);

		$canvas->text($title['line1']['text'], 600, $title['line1']['top'], function($font){
			global $title;
			global $font_file;
			$font->file(__DIR__.'/quiz/fonts/'.$font_file);
			$font->size($title['line1']['size']);
			$font->color($title['color']);
			$font->align('center');
			$font->valign('top');
		});
		$canvas->text($title['line2']['text'] , 600, $title['line2']['top'], function($font){
			global $title;
			global $font_file;
			$font->file(__DIR__.'/quiz/fonts/'.$font_file);
			$font->size($title['line2']['size']);
			$font->color($title['color']);
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
