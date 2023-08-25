$.noConflict();
$(document).ready(function () {
	// Handler for .ready() called.
	$("#admin_activity-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#admin_activity-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=admin_activity",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting admin_activity-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted admin_activity-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#admin_activity-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#admin_activity-form > #form-output-message"
						).show();
						$("#admin_activity-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#admin_activity-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#admin_activity-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#admin_activity-form > #form-output-message"
						).show();
						$("#admin_activity-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#admin_activity-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#administrators-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#administrators-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=administrators",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting administrators-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted administrators-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#administrators-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#administrators-form > #form-output-message"
						).show();
						$("#administrators-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#administrators-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#administrators-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#administrators-form > #form-output-message"
						).show();
						$("#administrators-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#administrators-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#app_policies-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#app_policies-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=app_policies",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting app_policies-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted app_policies-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#app_policies-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#app_policies-form > #form-output-message"
						).show();
						$("#app_policies-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#app_policies-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#app_policies-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#app_policies-form > #form-output-message"
						).show();
						$("#app_policies-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#app_policies-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#category_class-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#category_class-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=category_class",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting category_class-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted category_class-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#category_class-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#category_class-form > #form-output-message"
						).show();
						$("#category_class-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#category_class-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#category_class-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#category_class-form > #form-output-message"
						).show();
						$("#category_class-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#category_class-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#community_group_members-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#community_group_members-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=community_group_members",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting community_group_members-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted community_group_members-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#community_group_members-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#community_group_members-form > #form-output-message"
						).show();
						$(
							"#community_group_members-form > #form-output-message"
						).removeClass("alert-info");
						$("#community_group_members-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#community_group_members-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#community_group_members-form > #form-output-message"
						).show();
						$(
							"#community_group_members-form > #form-output-message"
						).removeClass("alert-info");
						$("#community_group_members-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#community_posts-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#community_posts-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=community_posts",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting community_posts-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted community_posts-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#community_posts-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#community_posts-form > #form-output-message"
						).show();
						$("#community_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_posts-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#community_posts-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#community_posts-form > #form-output-message"
						).show();
						$("#community_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_posts-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#community_resources-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#community_resources-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=community_resources",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting community_resources-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted community_resources-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#community_resources-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#community_resources-form > #form-output-message"
						).show();
						$("#community_resources-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_resources-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#community_resources-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#community_resources-form > #form-output-message"
						).show();
						$("#community_resources-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_resources-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#exercise_drills-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#exercise_drills-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=exercise_drills",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting exercise_drills-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted exercise_drills-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#exercise_drills-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#exercise_drills-form > #form-output-message"
						).show();
						$("#exercise_drills-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercise_drills-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#exercise_drills-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#exercise_drills-form > #form-output-message"
						).show();
						$("#exercise_drills-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercise_drills-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#exercises-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#exercises-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=exercises",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting exercises-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted exercises-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#exercises-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#exercises-form > #form-output-message"
						).show();
						$("#exercises-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercises-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#exercises-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#exercises-form > #form-output-message"
						).show();
						$("#exercises-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercises-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#fitblog_comment_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#fitblog_comment_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=fitblog_comment_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting fitblog_comment_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted fitblog_comment_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).show();
						$(
							"#fitblog_comment_comments-form > #form-output-message"
						).removeClass("alert-info");
						$("#fitblog_comment_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).show();
						$(
							"#fitblog_comment_comments-form > #form-output-message"
						).removeClass("alert-info");
						$("#fitblog_comment_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#fitblog_post_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#fitblog_post_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=fitblog_post_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting fitblog_post_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted fitblog_post_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).show();
						$("#fitblog_post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_post_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).show();
						$("#fitblog_post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_post_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#fitblog_posts-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#fitblog_posts-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=fitblog_posts",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting fitblog_posts-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted fitblog_posts-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#fitblog_posts-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#fitblog_posts-form > #form-output-message"
						).show();
						$("#fitblog_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_posts-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#fitblog_posts-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#fitblog_posts-form > #form-output-message"
						).show();
						$("#fitblog_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_posts-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#followers-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#followers-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=followers",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting followers-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted followers-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#followers-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#followers-form > #form-output-message"
						).show();
						$("#followers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#followers-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#followers-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#followers-form > #form-output-message"
						).show();
						$("#followers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#followers-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#friends-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#friends-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=friends",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting friends-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted friends-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#friends-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#friends-form > #form-output-message"
						).show();
						$("#friends-form > #form-output-message").removeClass("alert-info");
						$("#friends-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#friends-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#friends-form > #form-output-message"
						).show();
						$("#friends-form > #form-output-message").removeClass("alert-info");
						$("#friends-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#general_user_profiles-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#general_user_profiles-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=general_user_profiles",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting general_user_profiles-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted general_user_profiles-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#general_user_profiles-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#general_user_profiles-form > #form-output-message"
						).show();
						$("#general_user_profiles-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#general_user_profiles-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#general_user_profiles-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#general_user_profiles-form > #form-output-message"
						).show();
						$("#general_user_profiles-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#general_user_profiles-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#groups-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#groups-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=groups",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting groups-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted groups-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#groups-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#groups-form > #form-output-message"
						).show();
						$("#groups-form > #form-output-message").removeClass("alert-info");
						$("#groups-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#groups-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#groups-form > #form-output-message"
						).show();
						$("#groups-form > #form-output-message").removeClass("alert-info");
						$("#groups-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#indi_weekly_activities-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#indi_weekly_activities-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=indi_weekly_activities",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting indi_weekly_activities-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted indi_weekly_activities-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#indi_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#indi_weekly_activities-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#indi_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#indi_weekly_activities-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#indi_weekly_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#indi_weekly_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=indi_weekly_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting indi_weekly_schedules-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted indi_weekly_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).show();
						$("#indi_weekly_schedules-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#indi_weekly_schedules-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).show();
						$("#indi_weekly_schedules-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#indi_weekly_schedules-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#muscle_groups-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#muscle_groups-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=muscle_groups",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting muscle_groups-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted muscle_groups-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#muscle_groups-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#muscle_groups-form > #form-output-message"
						).show();
						$("#muscle_groups-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#muscle_groups-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#muscle_groups-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#muscle_groups-form > #form-output-message"
						).show();
						$("#muscle_groups-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#muscle_groups-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#news-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#news-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=news",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting news-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted news-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#news-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#news-form > #form-output-message"
						).show();
						$("#news-form > #form-output-message").removeClass("alert-info");
						$("#news-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#news-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#news-form > #form-output-message"
						).show();
						$("#news-form > #form-output-message").removeClass("alert-info");
						$("#news-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#notifications-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#notifications-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=notifications",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting notifications-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted notifications-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#notifications-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#notifications-form > #form-output-message"
						).show();
						$("#notifications-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#notifications-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#notifications-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#notifications-form > #form-output-message"
						).show();
						$("#notifications-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#notifications-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#post_comment_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#post_comment_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=post_comment_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting post_comment_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted post_comment_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#post_comment_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#post_comment_comments-form > #form-output-message"
						).show();
						$("#post_comment_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comment_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#post_comment_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#post_comment_comments-form > #form-output-message"
						).show();
						$("#post_comment_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comment_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#post_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#post_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=post_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting post_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted post_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#post_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#post_comments-form > #form-output-message"
						).show();
						$("#post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#post_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#post_comments-form > #form-output-message"
						).show();
						$("#post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#post_media-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#post_media-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=post_media",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting post_media-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted post_media-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#post_media-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#post_media-form > #form-output-message"
						).show();
						$("#post_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_media-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#post_media-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#post_media-form > #form-output-message"
						).show();
						$("#post_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_media-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#premium_group_members-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#premium_group_members-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=premium_group_members",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting premium_group_members-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted premium_group_members-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#premium_group_members-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#premium_group_members-form > #form-output-message"
						).show();
						$("#premium_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#premium_group_members-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#premium_group_members-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#premium_group_members-form > #form-output-message"
						).show();
						$("#premium_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#premium_group_members-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#pro_subscriptions-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#pro_subscriptions-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=pro_subscriptions",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting pro_subscriptions-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted pro_subscriptions-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#pro_subscriptions-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#pro_subscriptions-form > #form-output-message"
						).show();
						$("#pro_subscriptions-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#pro_subscriptions-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#pro_subscriptions-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#pro_subscriptions-form > #form-output-message"
						).show();
						$("#pro_subscriptions-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#pro_subscriptions-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#sports_list-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#sports_list-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=sports_list",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting sports_list-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted sports_list-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#sports_list-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#sports_list-form > #form-output-message"
						).show();
						$("#sports_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#sports_list-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#sports_list-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#sports_list-form > #form-output-message"
						).show();
						$("#sports_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#sports_list-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#store_products-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#store_products-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=store_products",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting store_products-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted store_products-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#store_products-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#store_products-form > #form-output-message"
						).show();
						$("#store_products-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#store_products-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#store_products-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#store_products-form > #form-output-message"
						).show();
						$("#store_products-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#store_products-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#supplements_list-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#supplements_list-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=supplements_list",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting supplements_list-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted supplements_list-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#supplements_list-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#supplements_list-form > #form-output-message"
						).show();
						$("#supplements_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#supplements_list-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#supplements_list-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#supplements_list-form > #form-output-message"
						).show();
						$("#supplements_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#supplements_list-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#team_athletics_match_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#team_athletics_match_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=team_athletics_match_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting team_athletics_match_schedules-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted team_athletics_match_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).show();
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).show();
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#team_weekly_activities-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#team_weekly_activities-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=team_weekly_activities",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting team_weekly_activities-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted team_weekly_activities-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#team_weekly_activities-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#team_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#team_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#team_weekly_activities-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#team_weekly_activities-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#team_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#team_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#team_weekly_activities-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#teams_color_tags-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#teams_color_tags-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=teams_color_tags",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting teams_color_tags-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted teams_color_tags-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#teams_color_tags-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#teams_color_tags-form > #form-output-message"
						).show();
						$("#teams_color_tags-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_color_tags-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#teams_color_tags-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#teams_color_tags-form > #form-output-message"
						).show();
						$("#teams_color_tags-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_color_tags-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#teams_group_members-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#teams_group_members-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=teams_group_members",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting teams_group_members-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted teams_group_members-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#teams_group_members-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#teams_group_members-form > #form-output-message"
						).show();
						$("#teams_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_group_members-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#teams_group_members-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#teams_group_members-form > #form-output-message"
						).show();
						$("#teams_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_group_members-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#teams_weekly_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#teams_weekly_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=teams_weekly_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting teams_weekly_schedules-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted teams_weekly_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).show();
						$(
							"#teams_weekly_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#teams_weekly_schedules-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).show();
						$(
							"#teams_weekly_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#teams_weekly_schedules-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_access_tokens-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_access_tokens-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_access_tokens",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_access_tokens-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_access_tokens-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_access_tokens-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_access_tokens-form > #form-output-message"
						).show();
						$("#user_access_tokens-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_access_tokens-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_access_tokens-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_access_tokens-form > #form-output-message"
						).show();
						$("#user_access_tokens-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_access_tokens-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_activity-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_activity-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_activity",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_activity-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_activity-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_activity-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_activity-form > #form-output-message"
						).show();
						$("#user_activity-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_activity-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_activity-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_activity-form > #form-output-message"
						).show();
						$("#user_activity-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_activity-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_challenge_cmplt_log-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_challenge_cmplt_log-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_challenge_cmplt_log",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_challenge_cmplt_log-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_challenge_cmplt_log-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).show();
						$(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_challenge_cmplt_log-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).show();
						$(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_challenge_cmplt_log-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_conversation_messages-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_conversation_messages-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_conversation_messages",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_conversation_messages-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_conversation_messages-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_conversation_messages-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_conversation_messages-form > #form-output-message"
						).show();
						$(
							"#user_conversation_messages-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_conversation_messages-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_conversation_messages-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_conversation_messages-form > #form-output-message"
						).show();
						$(
							"#user_conversation_messages-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_conversation_messages-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_conversation_users-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_conversation_users-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_conversation_users",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_conversation_users-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_conversation_users-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_conversation_users-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_conversation_users-form > #form-output-message"
						).show();
						$(
							"#user_conversation_users-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_conversation_users-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_conversation_users-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_conversation_users-form > #form-output-message"
						).show();
						$(
							"#user_conversation_users-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_conversation_users-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_conversations-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_conversations-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_conversations",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_conversations-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_conversations-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_conversations-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_conversations-form > #form-output-message"
						).show();
						$("#user_conversations-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_conversations-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_conversations-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_conversations-form > #form-output-message"
						).show();
						$("#user_conversations-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_conversations-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_favourites-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_favourites-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_favourites",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_favourites-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_favourites-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_favourites-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_favourites-form > #form-output-message"
						).show();
						$("#user_favourites-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_favourites-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_favourites-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_favourites-form > #form-output-message"
						).show();
						$("#user_favourites-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_favourites-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_interests-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_interests-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_interests",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_interests-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_interests-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_interests-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_interests-form > #form-output-message"
						).show();
						$("#user_interests-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_interests-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_interests-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_interests-form > #form-output-message"
						).show();
						$("#user_interests-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_interests-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_likes-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_likes-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_likes",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_likes-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_likes-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_likes-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_likes-form > #form-output-message"
						).show();
						$("#user_likes-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_likes-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_likes-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_likes-form > #form-output-message"
						).show();
						$("#user_likes-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_likes-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_policy_acceptance-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_policy_acceptance-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_policy_acceptance",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_policy_acceptance-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_policy_acceptance-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).show();
						$(
							"#user_policy_acceptance-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_policy_acceptance-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).show();
						$(
							"#user_policy_acceptance-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_policy_acceptance-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_about-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_about-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_about",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_about-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_about-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_about-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_about-form > #form-output-message"
						).show();
						$("#user_profile_about-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_about-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_about-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_about-form > #form-output-message"
						).show();
						$("#user_profile_about-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_about-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_bmi-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_fitness_stats_bmi-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_bmi",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_bmi-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_bmi-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_body_temp-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_body_temp-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_body_temp",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_body_temp-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_body_temp-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_heart_rate-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_heart_rate-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_heart_rate",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_heart_rate-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_heart_rate-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_speed-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_speed-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_speed",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_speed-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_speed-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_step_count-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_step_count-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_step_count",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_step_count-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_step_count-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitprefs-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_fitprefs-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitprefs",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_fitprefs-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitprefs-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).show();
						$("#user_profile_fitprefs-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_fitprefs-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).show();
						$("#user_profile_fitprefs-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_fitprefs-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_goalsetting-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_goalsetting-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_goalsetting",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_goalsetting-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_goalsetting-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).show();
						$(
							"#user_profile_goalsetting-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_profile_goalsetting-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).show();
						$(
							"#user_profile_goalsetting-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_profile_goalsetting-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_media-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_media-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_media",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_media-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_media-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_media-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_media-form > #form-output-message"
						).show();
						$("#user_profile_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_media-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_media-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_media-form > #form-output-message"
						).show();
						$("#user_profile_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_media-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_xp-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_xp-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_xp",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_xp-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_xp-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_xp-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_xp-form > #form-output-message"
						).show();
						$("#user_profile_xp-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_xp-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_xp-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_xp-form > #form-output-message"
						).show();
						$("#user_profile_xp-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_xp-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_socials-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_socials-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_socials",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_socials-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_socials-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_socials-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_socials-form > #form-output-message"
						).show();
						$("#user_socials-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_socials-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_socials-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_socials-form > #form-output-message"
						).show();
						$("#user_socials-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_socials-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_system_settings-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_system_settings-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_system_settings",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_system_settings-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_system_settings-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_system_settings-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_system_settings-form > #form-output-message"
						).show();
						$("#user_system_settings-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_system_settings-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_system_settings-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_system_settings-form > #form-output-message"
						).show();
						$("#user_system_settings-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_system_settings-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_workout_achievements-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_workout_achievements-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_workout_achievements",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_workout_achievements-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_workout_achievements-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_workout_achievements-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_workout_achievements-form > #form-output-message"
						).show();
						$(
							"#user_workout_achievements-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_workout_achievements-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_workout_achievements-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_workout_achievements-form > #form-output-message"
						).show();
						$(
							"#user_workout_achievements-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_workout_achievements-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#users-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#users-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=users",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting users-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted users-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#users-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#users-form > #form-output-message"
						).show();
						$("#users-form > #form-output-message").removeClass("alert-info");
						$("#users-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#users-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#users-form > #form-output-message"
						).show();
						$("#users-form > #form-output-message").removeClass("alert-info");
						$("#users-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#weekly_workout_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#weekly_workout_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=weekly_workout_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting weekly_workout_schedules-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted weekly_workout_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).show();
						$(
							"#weekly_workout_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#weekly_workout_schedules-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).show();
						$(
							"#weekly_workout_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#weekly_workout_schedules-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_challenges-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_challenges-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_challenges",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_challenges-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_challenges-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_challenges-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_challenges-form > #form-output-message"
						).show();
						$("#workout_challenges-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_challenges-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_challenges-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_challenges-form > #form-output-message"
						).show();
						$("#workout_challenges-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_challenges-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_subscribers-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_subscribers-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_subscribers",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_subscribers-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_subscribers-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_subscribers-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_subscribers-form > #form-output-message"
						).show();
						$("#workout_subscribers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_subscribers-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_subscribers-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_subscribers-form > #form-output-message"
						).show();
						$("#workout_subscribers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_subscribers-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_summary-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_summary-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_summary",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_summary-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_summary-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_summary-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_summary-form > #form-output-message"
						).show();
						$("#workout_summary-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_summary-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_summary-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_summary-form > #form-output-message"
						).show();
						$("#workout_summary-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_summary-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_training-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_training-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_training",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_training-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_training-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_training-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_training-form > #form-output-message"
						).show();
						$("#workout_training-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_training-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_training-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_training-form > #form-output-message"
						).show();
						$("#workout_training-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_training-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workouts-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workouts-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workouts",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workouts-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workouts-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workouts-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workouts-form > #form-output-message"
						).show();
						$("#workouts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workouts-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workouts-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workouts-form > #form-output-message"
						).show();
						$("#workouts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workouts-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	// /script>
	// script> $("#admin_activity-form").on("submit", function (e) { e = e || window.event; e.preventDefault(); var form_data = new FormData($('#admin_activity-form')[0]); setTimeout(function () { $.ajax({ type: 'POST', url: 'scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=admin_activity', processData: false, contentType: false, async: false, cache: false, data: form_data, contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */, beforeSend: function () { console.log('beforeSend: submitting admin_activity-form'); }, success: function (response) { if (response.startsWith("success")) { console.log('success: returning response - submitted admin_activity-form successfully'); console.log("Response: " + response); /* pass success message output to ui */ $("#admin_activity-form > #form-output-message").html("Bulk data submitted successfully."); /* toggle alert classes */ $("#admin_activity-form > #form-output-message").show(); $("#admin_activity-form > #form-output-message").removeClass("alert-info"); $("#admin_activity-form > #form-output-message").addClass("alert-success"); } else { console.log("error: returning response - an error occurred"); console.log("Response: " + response); /* pass error message output to ui */ $("#admin_activity-form > #form-output-message").html("An error occured whilst processing your request. " + response); /* toggle alert classes */ $("#admin_activity-form > #form-output-message").show(); $("#admin_activity-form > #form-output-message").removeClass("alert-info"); $("#admin_activity-form > #form-output-message").addClass("alert-danger"); } }, error: function (xhr, ajaxOptions, thrownError) { console.log("exception error: " + thrownError + " " + xhr.statusText + " " + xhr.responseText); } }); }, 1000); e.stopImmediatePropagation(); return false; });
	$("#administrators-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#administrators-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=administrators",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting administrators-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted administrators-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#administrators-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#administrators-form > #form-output-message"
						).show();
						$("#administrators-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#administrators-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#administrators-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#administrators-form > #form-output-message"
						).show();
						$("#administrators-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#administrators-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#app_policies-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#app_policies-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=app_policies",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting app_policies-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted app_policies-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#app_policies-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#app_policies-form > #form-output-message"
						).show();
						$("#app_policies-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#app_policies-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#app_policies-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#app_policies-form > #form-output-message"
						).show();
						$("#app_policies-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#app_policies-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#category_class-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#category_class-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=category_class",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting category_class-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted category_class-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#category_class-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#category_class-form > #form-output-message"
						).show();
						$("#category_class-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#category_class-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#category_class-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#category_class-form > #form-output-message"
						).show();
						$("#category_class-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#category_class-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#community_group_members-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#community_group_members-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=community_group_members",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting community_group_members-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted community_group_members-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#community_group_members-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#community_group_members-form > #form-output-message"
						).show();
						$(
							"#community_group_members-form > #form-output-message"
						).removeClass("alert-info");
						$("#community_group_members-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#community_group_members-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#community_group_members-form > #form-output-message"
						).show();
						$(
							"#community_group_members-form > #form-output-message"
						).removeClass("alert-info");
						$("#community_group_members-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#community_posts-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#community_posts-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=community_posts",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting community_posts-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted community_posts-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#community_posts-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#community_posts-form > #form-output-message"
						).show();
						$("#community_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_posts-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#community_posts-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#community_posts-form > #form-output-message"
						).show();
						$("#community_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_posts-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#community_resources-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#community_resources-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=community_resources",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting community_resources-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted community_resources-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#community_resources-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#community_resources-form > #form-output-message"
						).show();
						$("#community_resources-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_resources-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#community_resources-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#community_resources-form > #form-output-message"
						).show();
						$("#community_resources-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#community_resources-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#exercise_drills-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#exercise_drills-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=exercise_drills",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting exercise_drills-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted exercise_drills-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#exercise_drills-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#exercise_drills-form > #form-output-message"
						).show();
						$("#exercise_drills-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercise_drills-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#exercise_drills-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#exercise_drills-form > #form-output-message"
						).show();
						$("#exercise_drills-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercise_drills-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#exercises-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#exercises-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=exercises",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting exercises-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted exercises-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#exercises-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#exercises-form > #form-output-message"
						).show();
						$("#exercises-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercises-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#exercises-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#exercises-form > #form-output-message"
						).show();
						$("#exercises-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#exercises-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#fitblog_comment_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#fitblog_comment_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=fitblog_comment_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting fitblog_comment_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted fitblog_comment_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).show();
						$(
							"#fitblog_comment_comments-form > #form-output-message"
						).removeClass("alert-info");
						$("#fitblog_comment_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#fitblog_comment_comments-form > #form-output-message"
						).show();
						$(
							"#fitblog_comment_comments-form > #form-output-message"
						).removeClass("alert-info");
						$("#fitblog_comment_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#fitblog_post_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#fitblog_post_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=fitblog_post_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting fitblog_post_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted fitblog_post_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).show();
						$("#fitblog_post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_post_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#fitblog_post_comments-form > #form-output-message"
						).show();
						$("#fitblog_post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_post_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#fitblog_posts-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#fitblog_posts-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=fitblog_posts",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting fitblog_posts-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted fitblog_posts-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#fitblog_posts-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#fitblog_posts-form > #form-output-message"
						).show();
						$("#fitblog_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_posts-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#fitblog_posts-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#fitblog_posts-form > #form-output-message"
						).show();
						$("#fitblog_posts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#fitblog_posts-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#followers-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#followers-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=followers",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting followers-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted followers-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#followers-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#followers-form > #form-output-message"
						).show();
						$("#followers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#followers-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#followers-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#followers-form > #form-output-message"
						).show();
						$("#followers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#followers-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#friends-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#friends-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=friends",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting friends-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted friends-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#friends-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#friends-form > #form-output-message"
						).show();
						$("#friends-form > #form-output-message").removeClass("alert-info");
						$("#friends-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#friends-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#friends-form > #form-output-message"
						).show();
						$("#friends-form > #form-output-message").removeClass("alert-info");
						$("#friends-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#general_user_profiles-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#general_user_profiles-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=general_user_profiles",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting general_user_profiles-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted general_user_profiles-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#general_user_profiles-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#general_user_profiles-form > #form-output-message"
						).show();
						$("#general_user_profiles-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#general_user_profiles-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#general_user_profiles-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#general_user_profiles-form > #form-output-message"
						).show();
						$("#general_user_profiles-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#general_user_profiles-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#groups-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#groups-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=groups",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting groups-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted groups-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#groups-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#groups-form > #form-output-message"
						).show();
						$("#groups-form > #form-output-message").removeClass("alert-info");
						$("#groups-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#groups-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#groups-form > #form-output-message"
						).show();
						$("#groups-form > #form-output-message").removeClass("alert-info");
						$("#groups-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#indi_weekly_activities-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#indi_weekly_activities-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=indi_weekly_activities",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting indi_weekly_activities-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted indi_weekly_activities-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#indi_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#indi_weekly_activities-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#indi_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#indi_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#indi_weekly_activities-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#indi_weekly_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#indi_weekly_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=indi_weekly_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting indi_weekly_schedules-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted indi_weekly_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).show();
						$("#indi_weekly_schedules-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#indi_weekly_schedules-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#indi_weekly_schedules-form > #form-output-message"
						).show();
						$("#indi_weekly_schedules-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#indi_weekly_schedules-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#muscle_groups-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#muscle_groups-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=muscle_groups",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting muscle_groups-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted muscle_groups-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#muscle_groups-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#muscle_groups-form > #form-output-message"
						).show();
						$("#muscle_groups-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#muscle_groups-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#muscle_groups-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#muscle_groups-form > #form-output-message"
						).show();
						$("#muscle_groups-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#muscle_groups-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#news-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#news-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=news",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting news-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted news-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#news-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#news-form > #form-output-message"
						).show();
						$("#news-form > #form-output-message").removeClass("alert-info");
						$("#news-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#news-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#news-form > #form-output-message"
						).show();
						$("#news-form > #form-output-message").removeClass("alert-info");
						$("#news-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#notifications-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#notifications-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=notifications",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting notifications-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted notifications-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#notifications-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#notifications-form > #form-output-message"
						).show();
						$("#notifications-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#notifications-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#notifications-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#notifications-form > #form-output-message"
						).show();
						$("#notifications-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#notifications-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#post_comment_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#post_comment_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=post_comment_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting post_comment_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted post_comment_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#post_comment_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#post_comment_comments-form > #form-output-message"
						).show();
						$("#post_comment_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comment_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#post_comment_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#post_comment_comments-form > #form-output-message"
						).show();
						$("#post_comment_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comment_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#post_comments-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#post_comments-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=post_comments",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting post_comments-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted post_comments-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#post_comments-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#post_comments-form > #form-output-message"
						).show();
						$("#post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comments-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#post_comments-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#post_comments-form > #form-output-message"
						).show();
						$("#post_comments-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_comments-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#post_media-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#post_media-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=post_media",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting post_media-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted post_media-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#post_media-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#post_media-form > #form-output-message"
						).show();
						$("#post_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_media-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#post_media-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#post_media-form > #form-output-message"
						).show();
						$("#post_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#post_media-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#premium_group_members-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#premium_group_members-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=premium_group_members",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting premium_group_members-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted premium_group_members-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#premium_group_members-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#premium_group_members-form > #form-output-message"
						).show();
						$("#premium_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#premium_group_members-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#premium_group_members-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#premium_group_members-form > #form-output-message"
						).show();
						$("#premium_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#premium_group_members-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#pro_subscriptions-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#pro_subscriptions-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=pro_subscriptions",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting pro_subscriptions-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted pro_subscriptions-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#pro_subscriptions-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#pro_subscriptions-form > #form-output-message"
						).show();
						$("#pro_subscriptions-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#pro_subscriptions-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#pro_subscriptions-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#pro_subscriptions-form > #form-output-message"
						).show();
						$("#pro_subscriptions-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#pro_subscriptions-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#sports_list-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#sports_list-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=sports_list",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting sports_list-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted sports_list-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#sports_list-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#sports_list-form > #form-output-message"
						).show();
						$("#sports_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#sports_list-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#sports_list-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#sports_list-form > #form-output-message"
						).show();
						$("#sports_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#sports_list-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#store_products-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#store_products-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=store_products",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting store_products-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted store_products-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#store_products-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#store_products-form > #form-output-message"
						).show();
						$("#store_products-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#store_products-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#store_products-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#store_products-form > #form-output-message"
						).show();
						$("#store_products-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#store_products-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#supplements_list-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#supplements_list-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=supplements_list",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting supplements_list-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted supplements_list-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#supplements_list-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#supplements_list-form > #form-output-message"
						).show();
						$("#supplements_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#supplements_list-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#supplements_list-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#supplements_list-form > #form-output-message"
						).show();
						$("#supplements_list-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#supplements_list-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#team_athletics_match_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#team_athletics_match_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=team_athletics_match_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting team_athletics_match_schedules-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted team_athletics_match_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).show();
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#team_athletics_match_schedules-form > #form-output-message"
						).show();
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#team_athletics_match_schedules-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#team_weekly_activities-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#team_weekly_activities-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=team_weekly_activities",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting team_weekly_activities-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted team_weekly_activities-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#team_weekly_activities-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#team_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#team_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#team_weekly_activities-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#team_weekly_activities-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#team_weekly_activities-form > #form-output-message"
						).show();
						$(
							"#team_weekly_activities-form > #form-output-message"
						).removeClass("alert-info");
						$("#team_weekly_activities-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#teams_color_tags-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#teams_color_tags-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=teams_color_tags",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting teams_color_tags-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted teams_color_tags-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#teams_color_tags-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#teams_color_tags-form > #form-output-message"
						).show();
						$("#teams_color_tags-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_color_tags-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#teams_color_tags-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#teams_color_tags-form > #form-output-message"
						).show();
						$("#teams_color_tags-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_color_tags-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#teams_group_members-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#teams_group_members-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=teams_group_members",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting teams_group_members-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted teams_group_members-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#teams_group_members-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#teams_group_members-form > #form-output-message"
						).show();
						$("#teams_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_group_members-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#teams_group_members-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#teams_group_members-form > #form-output-message"
						).show();
						$("#teams_group_members-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#teams_group_members-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#teams_weekly_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#teams_weekly_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=teams_weekly_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting teams_weekly_schedules-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted teams_weekly_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).show();
						$(
							"#teams_weekly_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#teams_weekly_schedules-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#teams_weekly_schedules-form > #form-output-message"
						).show();
						$(
							"#teams_weekly_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#teams_weekly_schedules-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_access_tokens-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_access_tokens-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_access_tokens",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_access_tokens-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_access_tokens-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_access_tokens-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_access_tokens-form > #form-output-message"
						).show();
						$("#user_access_tokens-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_access_tokens-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_access_tokens-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_access_tokens-form > #form-output-message"
						).show();
						$("#user_access_tokens-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_access_tokens-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_activity-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_activity-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_activity",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_activity-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_activity-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_activity-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_activity-form > #form-output-message"
						).show();
						$("#user_activity-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_activity-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_activity-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_activity-form > #form-output-message"
						).show();
						$("#user_activity-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_activity-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_challenge_cmplt_log-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_challenge_cmplt_log-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_challenge_cmplt_log",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_challenge_cmplt_log-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_challenge_cmplt_log-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).show();
						$(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_challenge_cmplt_log-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).show();
						$(
							"#user_challenge_cmplt_log-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_challenge_cmplt_log-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_conversation_messages-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_conversation_messages-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_conversation_messages",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_conversation_messages-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_conversation_messages-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_conversation_messages-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_conversation_messages-form > #form-output-message"
						).show();
						$(
							"#user_conversation_messages-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_conversation_messages-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_conversation_messages-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_conversation_messages-form > #form-output-message"
						).show();
						$(
							"#user_conversation_messages-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_conversation_messages-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_conversation_users-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_conversation_users-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_conversation_users",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_conversation_users-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_conversation_users-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_conversation_users-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_conversation_users-form > #form-output-message"
						).show();
						$(
							"#user_conversation_users-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_conversation_users-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_conversation_users-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_conversation_users-form > #form-output-message"
						).show();
						$(
							"#user_conversation_users-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_conversation_users-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_conversations-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_conversations-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_conversations",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_conversations-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_conversations-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_conversations-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_conversations-form > #form-output-message"
						).show();
						$("#user_conversations-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_conversations-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_conversations-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_conversations-form > #form-output-message"
						).show();
						$("#user_conversations-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_conversations-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_favourites-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_favourites-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_favourites",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_favourites-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_favourites-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_favourites-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_favourites-form > #form-output-message"
						).show();
						$("#user_favourites-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_favourites-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_favourites-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_favourites-form > #form-output-message"
						).show();
						$("#user_favourites-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_favourites-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_interests-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_interests-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_interests",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_interests-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_interests-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_interests-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_interests-form > #form-output-message"
						).show();
						$("#user_interests-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_interests-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_interests-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_interests-form > #form-output-message"
						).show();
						$("#user_interests-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_interests-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_likes-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_likes-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_likes",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_likes-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_likes-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_likes-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_likes-form > #form-output-message"
						).show();
						$("#user_likes-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_likes-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_likes-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_likes-form > #form-output-message"
						).show();
						$("#user_likes-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_likes-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_policy_acceptance-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_policy_acceptance-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_policy_acceptance",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_policy_acceptance-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_policy_acceptance-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).show();
						$(
							"#user_policy_acceptance-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_policy_acceptance-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_policy_acceptance-form > #form-output-message"
						).show();
						$(
							"#user_policy_acceptance-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_policy_acceptance-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_about-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_about-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_about",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_about-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_about-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_about-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_about-form > #form-output-message"
						).show();
						$("#user_profile_about-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_about-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_about-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_about-form > #form-output-message"
						).show();
						$("#user_profile_about-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_about-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_bmi-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_fitness_stats_bmi-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_bmi",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_bmi-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_bmi-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_bmi-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_body_temp-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_body_temp-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_body_temp",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_body_temp-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_body_temp-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_body_temp-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_heart_rate-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_heart_rate-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_heart_rate",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_heart_rate-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_heart_rate-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_heart_rate-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_speed-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_speed-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_speed",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_speed-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_speed-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_speed-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitness_stats_step_count-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData(
			$("#user_profile_fitness_stats_step_count-form")[0]
		);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitness_stats_step_count",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log(
						"beforeSend: submitting user_profile_fitness_stats_step_count-form"
					);
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitness_stats_step_count-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).show();
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_profile_fitness_stats_step_count-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_fitprefs-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_fitprefs-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_fitprefs",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_fitprefs-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_fitprefs-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).show();
						$("#user_profile_fitprefs-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_fitprefs-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_fitprefs-form > #form-output-message"
						).show();
						$("#user_profile_fitprefs-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_fitprefs-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_goalsetting-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_goalsetting-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_goalsetting",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_goalsetting-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_goalsetting-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).show();
						$(
							"#user_profile_goalsetting-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_profile_goalsetting-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_goalsetting-form > #form-output-message"
						).show();
						$(
							"#user_profile_goalsetting-form > #form-output-message"
						).removeClass("alert-info");
						$("#user_profile_goalsetting-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_media-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_media-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_media",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_media-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_media-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_media-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_media-form > #form-output-message"
						).show();
						$("#user_profile_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_media-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_media-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_media-form > #form-output-message"
						).show();
						$("#user_profile_media-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_media-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_profile_xp-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_profile_xp-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_profile_xp",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_profile_xp-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_profile_xp-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_profile_xp-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_profile_xp-form > #form-output-message"
						).show();
						$("#user_profile_xp-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_xp-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_profile_xp-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_profile_xp-form > #form-output-message"
						).show();
						$("#user_profile_xp-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_profile_xp-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_socials-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_socials-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_socials",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_socials-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_socials-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_socials-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_socials-form > #form-output-message"
						).show();
						$("#user_socials-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_socials-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_socials-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_socials-form > #form-output-message"
						).show();
						$("#user_socials-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_socials-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_system_settings-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_system_settings-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_system_settings",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_system_settings-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_system_settings-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_system_settings-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_system_settings-form > #form-output-message"
						).show();
						$("#user_system_settings-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_system_settings-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_system_settings-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_system_settings-form > #form-output-message"
						).show();
						$("#user_system_settings-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#user_system_settings-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#user_workout_achievements-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#user_workout_achievements-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=user_workout_achievements",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting user_workout_achievements-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted user_workout_achievements-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#user_workout_achievements-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#user_workout_achievements-form > #form-output-message"
						).show();
						$(
							"#user_workout_achievements-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_workout_achievements-form > #form-output-message"
						).addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#user_workout_achievements-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#user_workout_achievements-form > #form-output-message"
						).show();
						$(
							"#user_workout_achievements-form > #form-output-message"
						).removeClass("alert-info");
						$(
							"#user_workout_achievements-form > #form-output-message"
						).addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#users-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#users-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=users",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting users-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted users-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#users-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#users-form > #form-output-message"
						).show();
						$("#users-form > #form-output-message").removeClass("alert-info");
						$("#users-form > #form-output-message").addClass("alert-success");
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#users-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#users-form > #form-output-message"
						).show();
						$("#users-form > #form-output-message").removeClass("alert-info");
						$("#users-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#weekly_workout_schedules-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#weekly_workout_schedules-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=weekly_workout_schedules",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting weekly_workout_schedules-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted weekly_workout_schedules-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).show();
						$(
							"#weekly_workout_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#weekly_workout_schedules-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#weekly_workout_schedules-form > #form-output-message"
						).show();
						$(
							"#weekly_workout_schedules-form > #form-output-message"
						).removeClass("alert-info");
						$("#weekly_workout_schedules-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_challenges-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_challenges-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_challenges",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_challenges-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_challenges-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_challenges-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_challenges-form > #form-output-message"
						).show();
						$("#workout_challenges-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_challenges-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_challenges-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_challenges-form > #form-output-message"
						).show();
						$("#workout_challenges-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_challenges-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_subscribers-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_subscribers-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_subscribers",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_subscribers-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_subscribers-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_subscribers-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_subscribers-form > #form-output-message"
						).show();
						$("#workout_subscribers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_subscribers-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_subscribers-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_subscribers-form > #form-output-message"
						).show();
						$("#workout_subscribers-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_subscribers-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_summary-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_summary-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_summary",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_summary-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_summary-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_summary-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_summary-form > #form-output-message"
						).show();
						$("#workout_summary-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_summary-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_summary-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_summary-form > #form-output-message"
						).show();
						$("#workout_summary-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_summary-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workout_training-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workout_training-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workout_training",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workout_training-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workout_training-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workout_training-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workout_training-form > #form-output-message"
						).show();
						$("#workout_training-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_training-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workout_training-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workout_training-form > #form-output-message"
						).show();
						$("#workout_training-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workout_training-form > #form-output-message").addClass(
							"alert-danger"
						);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
	$("#workouts-form").on("submit", function (e) {
		e = e || window.event;
		e.preventDefault();
		var form_data = new FormData($("#workouts-form")[0]);
		setTimeout(function () {
			$.ajax({
				type: "POST",
				url: "scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=workouts",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: form_data,
				contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
				beforeSend: function () {
					console.log("beforeSend: submitting workouts-form");
				},
				success: function (response) {
					if (response.startsWith("success")) {
						console.log(
							"success: returning response - submitted workouts-form successfully"
						);
						console.log("Response: " + response);
						/* pass success message output to ui */ $(
							"#workouts-form > #form-output-message"
						).html("Bulk data submitted successfully.");
						/* toggle alert classes */ $(
							"#workouts-form > #form-output-message"
						).show();
						$("#workouts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workouts-form > #form-output-message").addClass(
							"alert-success"
						);
					} else {
						console.log("error: returning response - an error occurred");
						console.log("Response: " + response);
						/* pass error message output to ui */ $(
							"#workouts-form > #form-output-message"
						).html(
							"An error occured whilst processing your request. " + response
						);
						/* toggle alert classes */ $(
							"#workouts-form > #form-output-message"
						).show();
						$("#workouts-form > #form-output-message").removeClass(
							"alert-info"
						);
						$("#workouts-form > #form-output-message").addClass("alert-danger");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(
						"exception error: " +
							thrownError +
							" " +
							xhr.statusText +
							" " +
							xhr.responseText
					);
				},
			});
		}, 1000);
		e.stopImmediatePropagation();
		return false;
	});
});
