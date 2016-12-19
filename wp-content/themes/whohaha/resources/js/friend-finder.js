var fbFriendFind = (function($){

	/**
	 * All variables sored in a data object
	 * @type {Object}
	 */
	var data = {
		host : window.location.host,
		href : window.location.href,
		appId : '330367630668728',
		queryCount : 0,
		user : {
			loggedIn : false,
			id : null,
			name : null,
			first_name : null,
			img : null
		},
		friends : {}
	},
	url = window.location.href;

	if (data.host !== 'whohaha.com') data.appId = '333568150348676';

	/**
	 * Check if user is logged in on page load
	 */
	$(document).ready(function(){
		$.ajaxSetup({ cache: true });
		$.getScript('//connect.facebook.net/en_US/sdk.js', function(){
			FB.init({
				appId	: data.appId,
				status  : true,
				version : 'v2.7',
			});
			// $('#loginbutton').removeAttr('disabled').text('FIND OUT');
			checkLoginStatus();
		});
	});

	/**
	 * Check login status with FB API
	 * Change data.user.loggedIn to bool
	 */
	var checkLoginStatus = function(){
		FB.getLoginStatus(function(response){
			data.user.loggedIn = (response.status === 'connected');
			if (data.user.loggedIn === true) {
				$('#loginbutton').removeAttr('disabled').removeClass('facebook').text('FIND OUT');
			} else {
				$('#loginbutton').removeAttr('disabled');
			}
		});
	}
	/**
	 * Use FB API for user login
	 */
	var login = function(){
		// console.log('log in function here');
		FB.login(function(response){
			if (response.authResponse) {
				FriendFind.start();
			} else {
				console.log('User Login Failed');
				$('#loginbutton').removeAttr('disabled').html('<i class="fa fa-facebook" aria-hidden="true"></i> LOG IN TO FIND OUT');
			}
		},
		{ scope:'user_posts,user_photos,email,public_profile' });
	}

	/**
	 * Use FB API to share page
	 */
	$('body').on('click', '#sharequizbutton', function(){
		if (data.user && data.user.id !== null) {
			FB.ui({
			  method: 'share',
			  href: window.location.href,
			}, function(response){
				console.log(response);
			});
		} else {
			alert('something went wrong');
		}
	});

	/**
	 * Check if user is logged in
	 * If true: start FriendFind
	 * If false: login()
	 */
	// $('#canvas').click(function(){
	$('#loginbutton').click(function(){
		$('#loginbutton').attr('disabled', 'disabled').text('LOADING...');
		if(data.user.loggedIn){
			FriendFind.start();
		} else {
			login();
		}
		return false;
	});

	/**
	 * Put all FriendFind functions in one object
	 * @return {object}
	 */
	var FriendFind = (function(){
		var start = function(){
			FB.api('/me', {'fields':['id','first_name','name','picture.height(400).width(400)']}, function(response) {
				data.user.id = response.id;
				data.user.name = response.name;
				data.user.first_name = response.first_name;
				data.user.img = response.picture.data.url;
				// console.log(data.user);
				checkPosts();
			});
		}

		var addToFriends = function(user, rating){
			if (user.id !== data.user.id) {
				// data.friends
				if ( data.friends[user.id] ) {
					data.friends[user.id]['rating'] += rating;
				} else {
					data.friends[user.id] = {
						id : user.id,
						name : user.name,
						rating : rating
					}
				}
			}
		}

		var checkPosts = function(){
			FB.api("/me/posts?fields=likes.limit(1000),comments.limit(1000),with_tags,from,to&limit=25",
				"GET",
				function(response) {
					// Getting info
					if (response && response.data){
						for (var i = 0; i < response.data.length; i++) {
							var post = response.data[i];
							if (post.likes) {
								// 1
								for (var j = 0; j < post.likes.data.length; j++) {
									var user = post.likes.data[j];
									if (user.id)
										addToFriends(user, 1);
								}
							}
							if (post.comments) {
								// 2
								for (var j = 0; j < post.comments.data.length; j++) {
									var comment = post.comments.data[j];
									var user = comment.from;
									if (comment.id)
										addToFriends(user, 2);
								}
							}
							if (post.to) {
								// 3
								for (var j = 0; j < post.to.data.length; j++) {
									var user = post.to.data[j];
									if (user.id)
										addToFriends(user, 3);
								}
							}
							if (post.with_tags) {
								// 3
								for (var j = 0; j < post.with_tags.data.length; j++) {
									var user = post.with_tags.data[j];
									if (user.id)
										addToFriends(user, 3);
								}
							}
						}
					}
					checkPhotos();
				}
			);
		}

		var checkPhotos = function(){
			FB.api('me/photos?fields=from&limit=10', 'GET', function(response){
				if (response && response.data) {
					for (var i = 0; i < response.data.length; i++) {
						var post = response.data[i];
						if (post.from.id !== data.user.id)
							addToFriends(post.from, 2);
					}
				}
				getHighestRated();
			});
		}

		var getHighestRated = function(){
			var allFriends = data.friends;
			var sorted = _.sortBy(allFriends, ['rating']);
			_.reverse(sorted);
			var bestFriend = sorted[Math.floor( Math.random() * 4 )];
			/*var res = '<h3>JK, it\'s actually '+ bestFriend.name +'.</h3>';
			$('#canvas').append(res);*/
			getFriendInfo(bestFriend);
		}

		var getFriendInfo = function(friend){
			FB.api(friend.id, {'fields':['id','first_name','name','picture.height(400).width(400)']}, function(response) {
				var bestFriend = {
					id : response.id,
					name : response.name,
					first_name : response.first_name,
					img : response.picture.data.url
				}
				makeQuizImg(bestFriend);
			});
		}

		var makeQuizImg = function(bestFriend){
			var slug = $('article#quiz').data('name');

			$.ajax({
				url : '/wp-admin/admin-ajax.php',
				method : 'POST',
				data : {
					'action' : 'make_quiz_image_ajax',
					'user' : data.user,
					'best_friend' : bestFriend,
					'slug' : slug
				}
			})
			.done(function(output){
				console.log(output);
				if (output.response === 'error') {
					alert('Something Went Wrong');
					window.location.reload();
				} else {
					history.replaceState(null, null, '/quiz/' + slug + '/' + data.user.id);
					replaceViews(slug, data.user.id, output.img_path);
				}
			})
			.fail(function(){
				// AJAX Error
				alert('Something Went Wrong');
			});
		}

		var replaceViews = function(slug, user_id, img_path){
			$('.post-featured-image').empty().append('<div id="share_canvas_img"><img width="1200" height="630" src="/wp-content/uploads/user-images/'+img_path+'" alt="Rendered quiz image"></img><button id="sharequizbutton" class="btn btn-primary">SHARE</button></div>');
		}

		return{
			start:start
		}
	})();

})(jQuery);