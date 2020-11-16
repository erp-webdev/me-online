<?php include("../config.php"); ?>
// JavaScript Document

$(function ()
{
    var pagenum = $('#pagenum').val();

    /* ADS */

    $('#adadd form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var adadd_msg;

			if (!$('.adadd_msg').length)
			{
				$('#adadd_title').after('<div class="adadd_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#activity_title').val().length && $('#activity_attach').val().length)
            {
                $('.adadd_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Creating ads&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.adadd_msg')
                    .html('Ad title and file is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.adadd_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on creating ads')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Ads has been successfully created.</p>';

				$('.adadd_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchads = $("#searchads").val();
                adspage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=table",
                    data: "searchads=" + searchads,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#adsdata").html(data);
                    }
                })

			}
		}
	});

    $('#adedit form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var adedit_msg;

			if (!$('.adedit_msg').length)
			{
				$('#adedit_title').after('<div class="adedit_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#uactivity_title').val().length)
            {
                $('.adedit_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing ads&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.adedit_msg')
                    .html('Ads title is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.adedit_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on updating ads')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{

                if (response.rmailcount) {
                    html += '<p>Ads has been successfully sent to ' + response.rmailcount + ' employees.</p>';
                } else {
				    html += '<p>Ads has been successfully updated.</p>';
                }

				$('.adedit_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchads = $("#searchads").val();
                adspage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=table",
                    data: "searchads=" + searchads,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#adsdata").html(data);
                    }
                })

			}
		}
	});

    /* ACTIVITY */

    $('#actreg form').iframePostForm //registration
	({
		json : true,
		post : function ()
		{
			var actreg_msg;

			if (!$('.actreg_msg').length)
			{
				$('#actreg_title').after('<div class="actreg_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#registry_activitytype').val() == 1)
            {
                var gueerror = 0;
                if ($('#numgue').val() > 0) {
                    for (g=0; g<$('#numgue').val(); g++) {
                        if ($('#registry_gname' + g).val().trim() == '') {
                            gueerror++;
                        }
                    }
                }

                if (gueerror == 0)
                {
                    $('.actreg_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Signing up on activity&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.actreg_msg')
                        .html('Guest name are required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }

            } else if ($('#registry_activitytype').val() == 3)
            {
                var indierror = 0;
                if ($('#numindi').val() > 0) {
                    for (g=0; g<$('#numindi').val(); g++) {
                        if ($('#registry_dname' + g).val().trim() == '') {
                            indierror++;
                        }
                    }
                }

                if (indierror == 0)
                {
                    $('.actreg_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Signing up on activity&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.actreg_msg')
                        .html('Dependent name are required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }

            } else if ($('#registry_activitytype').val() == 5)
            {
                var chierror = 0;

                if ($('#numchi').val() > 0) {
                    for (g=0; g<$('#numchi').val(); g++) {
                        if ($('#registry_cname' + g).val().trim() == '') {
                            chierror++;
                        }
                    }
                } else {
                    $('.actreg_msg')
                        .html('Any children?')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }

                if (chierror == 0)
                {
                    $('.actreg_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Signing up on activity&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.actreg_msg')
                        .html('Children name are required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }

            } else if ($('#registry_activitytype').val() == 6) {

                var cverror = 0;
                var indierror = 0;

                if ($('#numindi').val() > 0) {
                    for (g=0; g<$('#numindi').val(); g++) {
                        if ($('#registry_dname' + g).val().trim() == '') {
                            indierror++;
                        }
                    }
                }

                if (indierror == 0)
                {
                    if (cverror == 0)
                    {
                        $('.actreg_msg')
                        .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Signing up on activity&hellip;')
                        .css({
                            color : '#006100',
                            background : '#c6efce',
                            border : '2px solid #006100',
                            height : 'auto'
                        })
                        .slideDown();
                    } else {
                        $('.actreg_msg')
                            .html('Vehicle plate number is required.')
                            .css({
                                color : '#9c0006',
                                background : '#ffc7ce',
                                border : '2px solid #9c0006',
                                height : 'auto'
                            })
                            .slideDown()
                            .effect('shake', {times: 3, distance: 5}, 420);

                        return false;
                    }
                }
                else
                {
                    $('.actreg_msg')
                        .html('Dependent name are required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }

            } else {

                var cverror = 0;

                if (cverror == 0)
                {
                    $('.actreg_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Signing up on activity&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.actreg_msg')
                        .html('Vehicle plate number is required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
                if (response.details = 'not available') {
                    html += 'Registration denied. Maybe the event registration has been end or slot is full.';
                } else {
				    html += 'There was a problem on registering on activity';
                }

				$('.actreg_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
                $('.actreg_msg').slideUp();
                alert('You have been successfully registered to the activity.');
                window.location.href='<?php echo WEB; ?>/registration';
			}
		}
	});

    $('#actadd form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var actadd_msg;

			if (!$('.actadd_msg').length)
			{
				$('#actadd_title').after('<div class="actadd_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#activity_title').val().length && $('#activity_venue').val().length && $('#activity_attach').val().length)
            {
                $('.actadd_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Creating activity&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.actadd_msg')
                    .html('Activity title, venue and file are required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.actadd_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on creating activity')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Activity has been successfully created.</p>';

				$('.actadd_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchact = $("#searchactivity").val();
                actpage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=table",
                    data: "searchactivity=" + searchact,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#activitydata").html(data);
                    }
                })

			}
		}
	});

    $('#actedit form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var actedit_msg;

			if (!$('.actedit_msg').length)
			{
				$('#actedit_title').after('<div class="actedit_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#uactivity_title').val().length && $('#uactivity_venue').val().length)
            {
                $('.actedit_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing activity&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.actedit_msg')
                    .html('Ads title and venue are required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.actedit_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on updating activity')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{

                if (response.rmailcount) {
                    html += '<p>Activity has been successfully sent to ' + response.rmailcount + ' employees.</p>';
                } else {
				    html += '<p>Activity has been successfully updated.</p>';
                }

				$('.actedit_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchact = $("#searchactivity").val();
                actpage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=table",
                    data: "searchactivity=" + searchact,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#activitydata").html(data);
                    }
                })

			}
		}
	});

    $('#frmactreg').iframePostForm
	({
		json : true,
		post : function ()
		{
			var actreg_msg;

			if (!$('.actreg_msg').length)
			{
				$('#actreg_title').after('<div class="actreg_msg" style="display:none; padding:10px; text-align:center" />');
			}

            $('.actreg_msg')
            .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Auto-register employee&hellip;')
            .css({
                color : '#006100',
                background : '#c6efce',
                border : '2px solid #006100',
                height : 'auto'
            })
            .slideDown();

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.actreg_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on regitering employee')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>' + response.numreg + ' employees has been updated to the set activity</p>';

				$('.actreg_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

			}
		}
	});


    /* MEMORANDUM */

    $('#madd form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var madd_msg;

			if (!$('.madd_msg').length)
			{
				$('#madd_title').after('<div class="madd_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#memo_title').val().length && $('#memo_attach').val().length)
            {
                $('.madd_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Creating memo&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.madd_msg')
                    .html('Memo title and file is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.madd_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on creating memo')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Memo has been successfully created.</p>';

				$('.madd_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchmemo = $("#searchmemo").val();
                memofrom = $("#memofrom").val();
                memoto = $("#memoto").val();

                memopage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=table",
                    data: "searchmemo=" + searchmemo + "&memofrom=" + memofrom + "&memoto=" + memoto,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#memodata").html(data);
                    }
                })

			}
		}
	});

    $('#medit form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var medit_msg;

			if (!$('.medit_msg').length)
			{
				$('#medit_title').after('<div class="medit_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#umemo_title').val().length)
            {
                $('.medit_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing memo&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.medit_msg')
                    .html('Memo title is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.medit_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on updating memo')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{

                if (response.rmailcount) {
                    html += '<p>Memo has been successfully sent to ' + response.rmailcount + ' employees.</p>';
                } else {
				    html += '<p>Memo has been successfully updated.</p>';
                }

				$('.medit_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchmemo = $("#searchmemo").val();
                memofrom = $("#memofrom").val();
                memoto = $("#memoto").val();

                memopage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=table",
                    data: "searchmemo=" + searchmemo + "&memofrom=" + memofrom + "&memoto=" + memoto,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#memodata").html(data);
                    }
                })

			}
		}
	});

    /* FORMS */

    $('#dladd form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var dladd_msg;

			if (!$('.dladd_msg').length)
			{
				$('#dladd_title').after('<div class="dladd_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#download_title').val().length && $('#download_filename').val().length)
            {
                $('.dladd_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Creating form&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.dladd_msg')
                    .html('Form title and file is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.dladd_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on creating form')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Form has been successfully created.</p>';

				$('.dladd_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchform = $("#searchform").val();
                formpage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=table",
                    data: "searchform=" + searchform,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#downdata").html(data);
                    }
                })

			}
		}
	});

    $('#dledit form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var dledit_msg;

			if (!$('.dledit_msg').length)
			{
				$('#dledit_title').after('<div class="dledit_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#udownload_title').val().length)
            {
                $('.dledit_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Updating form&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.dledit_msg')
                    .html('Form title is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.dledit_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on updating form')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{

                if (response.rmailcount) {
                    html += '<p>Form has been successfully sent to ' + response.rmailcount + ' employees.</p>';
                } else {
				    html += '<p>Form has been successfully updated.</p>';
                }

				$('.dledit_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchform = $("#searchform").val();
                formpage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=table",
                    data: "searchform=" + searchform,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#downdata").html(data);
                    }
                })

			}
		}
	});

    /* ANNOUNCEMENT */

    $('#aadd form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var aadd_msg;

			if (!$('.aadd_msg').length)
			{
				$('#madd_title').after('<div class="aadd_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#memo_title').val().length && $('#memo_attach').val().length)
            {
                $('.aadd_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Creating announcement&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.aadd_msg')
                    .html('Announcement title and file is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.aadd_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on creating announcement')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Announcement has been successfully created.</p>';

				$('.aadd_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchmemo = $("#searchmemo").val();
                memofrom = $("#memofrom").val();
                memoto = $("#memoto").val();

                memopage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=table",
                    data: "searchmemo=" + searchmemo + "&memofrom=" + memofrom + "&memoto=" + memoto,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#memodata").html(data);
                    }
                })

			}
		}
	});

    $('#aedit form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var aedit_msg;

			if (!$('.aedit_msg').length)
			{
				$('#medit_title').after('<div class="aedit_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#umemo_title').val().length)
            {
                $('.aedit_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Updating announcement&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.aedit_msg')
                    .html('Announcement title is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.aedit_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on updating announcement')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{

                if (response.rmailcount) {
                    html += '<p>Announcement has been successfully sent to ' + response.rmailcount + ' employees.</p>';
                } else {
				    html += '<p>Announcement has been successfully updated.</p>';
                }

				$('.aedit_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                searchmemo = $("#searchmemo").val();
                memofrom = $("#memofrom").val();
                memoto = $("#memoto").val();

                memopage = 1;

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=table",
                    data: "searchmemo=" + searchmemo + "&memofrom=" + memofrom + "&memoto=" + memoto,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#memodata").html(data);
                    }
                })

			}
		}
	});

    /* BIRTHDAY */

    $('#add_bimg').iframePostForm
	({
		json : true,
		post : function ()
		{
			var bimgadd_msg;

			if (!$('.bimgadd_msg').length)
			{
				$('#bimg_title').after('<div class="bimgadd_msg" style="display:none; padding:10px; margin-bottom: 20px; text-align:center" />');
			}

            $('.bimgadd_msg')
            .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Creating birthday card&hellip;')
            .css({
                color : '#006100',
                background : '#c6efce',
                border : '2px solid #006100',
                height : 'auto'
            })
            .slideDown();


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
                if (response.fileerror) {
                    html += '<p>Birthday card files are required and must be JPG, GIF or PNG and less than 1Mb</p>';
                } else if (response.required) {
                    html += '<p>Birthday card message is required</p>';
                } else {
				    html += '<p>There was a problem on creating birthday card.</p>';
                }

				$('.bimgadd_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
                if (response.rmailcount) {
                    html += '<p>Birthday card has been successfully sent to ' + response.rmailcount + ' birthday celebrant.</p>';
                } else {
				    html += '<p>Birthday card has been successfully created.</p>';
                }

				$('.bimgadd_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=bdayimg",
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#divbdayimg").html(data);
                    }
                })

			}
		}
	});

    /* FEEDBACK */

    $('#fback form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var fback_msg;

			if (!$('.fback_msg').length)
			{
				$('#fback_title').after('<div class="fback_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#fback_rate').val().length && $('#fback_comment').val().length)
            {
                $('.fback_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing feedback&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.fback_msg')
                    .html('Feedback rate and comment are required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.fback_msg').slideUp(function ()
				{
					$(this)
						.html('There was a problem on creating feedback')
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Feedback has been successfully submitted.</p>';

				$('.fback_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							color : '#006100',
							background : '#c6efce',
							borderColor : '#006100',
                            height : 'auto'
						})
						.slideDown();
				});

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=regtable",
                    success: function(data) {
                        $("#registration_table").html(data);
                    }
                })

			}
		}
	});

    /* APPLICATION */

    /* Overtime */

    $('#mainot form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var mot_msg;

			if (!$('.mot_msg').length)
			{
				$('#alert').after('<div class="mot_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#ot_reason').val().length && $('#invalid').val() == 0 && $('#txtothours').val() != 0)
            {
                $('.mot_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing overtime&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else if ($('#txtothours').val() == 0)
            {
                $('.mot_msg')
                    .html('OT hours rendered is zero.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }
            else if ($('#invalid').val() == 1)
            {
                $('.mot_msg')
                    .html('This is not a regular day.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }
            else if ($('#invalid').val() == 2)
            {
                $('.mot_msg')
                    .html('This is not a rest day.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }
            else if ($('#invalid').val() == 3)
            {
                $('.mot_msg')
                    .html('This is not a holiday.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }
            else
            {
                $('.mot_msg')
                    .html('Reason is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.mot_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				//html += '<p>Leave has been successfully applied.</p>';

				$('.mot_msg').slideUp();
                alert('Overtime has been successfully applied.');
                window.location.href='<?php echo WEB; ?>/myrequest?type=1';

			}
		}
	});

    /* Leave */

    $('#mainleave form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var mleave_msg;

			if (!$('.mleave_msg').length)
			{
				$('#alert').after('<div class="mleave_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#leave_reason').val().length && $('#tdays').val().length)
            {
                $('.mleave_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing leave&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                if ($('#tdays').val().length == 0)
                {
                    $('.mleave_msg')
                    .html('Please choose the leave\'s date coverage.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);
                }
                else
                {
                    $('.mleave_msg')
                        .html('Reason is required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);
                }

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.mleave_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				//html += '<p>Leave has been successfully applied.</p>';

				$('.mleave_msg').slideUp();
                alert('Leave has been successfully applied.');
                window.location.href='<?php echo WEB; ?>/myrequest?type=2';

			}
		}
	});

    /* OBT */

    $('#mainob form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var mob_msg;

			if (!$('.mob_msg').length)
			{
				$('#alert').after('<div class="mob_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#ndays').val() >= 1)
            {

                if ($('#obt_destination').val().length && $('#obt_from').val().length && $('#obt_to').val().length && $('#obt_purpose').val().length)
                {
                    $('.mob_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing official business trip&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.mob_msg')
                        .html('OBT coverage, destination and purpose are required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }
            }
            else
            {
                $('.mob_msg')
                    .html('Date coverage is invalid.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.mob_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				//html += '<p>Leave has been successfully applied.</p>';

				$('.mob_msg').slideUp();
                alert('OBT has been successfully applied.');
                window.location.href='<?php echo WEB; ?>/myrequest?type=4';

			}
		}
	});

	/* WFH */

    $('#mainwfh form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var wfh_msg;

			if (!$('.wfh_msg').length)
			{
				$('#alert').after('<div class="wfh_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#ndays').val() >= 1)
            {

                if ($('#wfh_from_').val().length && $('#wfh_to_').val().length)
                {
                    $('.wfh_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing Work From Home&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.wfh_msg')
                        .html('Date coverage is required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }
            }
            else
            {
                $('.wfh_msg')
                    .html('Date coverage is invalid.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.wfh_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				//html += '<p>WFH has been successfully applied.</p>';
        localStorage.removeItem('wfh-entries');
				$('.wfh_msg').slideUp();
                alert('Work from Home has been successfully applied.');
                window.location.href='<?php echo WEB; ?>/myrequest?type=10';

			}
		}
	});

    /* Manual DTR */

    $('#maindtr form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var mdtr_msg;

			if (!$('.mdtr_msg').length)
			{
				$('#alert').after('<div class="mdtr_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#ndays').val() >= 1)
            {

                if ($('#mdtr_from').val().length && $('#mdtr_to').val().length)
                {
                    $('.mdtr_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing manual DTR&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.mdtr_msg')
                        .html('Date coverage is required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }
            }
            else
            {
                $('.mdtr_msg')
                    .html('Date coverage is invalid.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.mdtr_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				//html += '<p>Leave has been successfully applied.</p>';

				$('.mdtr_msg').slideUp();
                alert('Manual DTR has been successfully applied.');
                window.location.href='<?php echo WEB; ?>/myrequest?type=7';

			}
		}
	});

    /* Non Punch Auhtorization */

    $('#mainnpa form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var mnp_msg;

			if (!$('.mnp_msg').length)
			{
				$('#alert').after('<div class="mnp_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#npa_din').val().length && $('#npa_dout').val().length && $('#npa_in').val().length && $('#npa_out').val().length && $('#npa_reason').val().length)
            {
                $('.mnp_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing non punching authorization&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.mnp_msg')
                    .html('Reason, date/time in and out are required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.mnp_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				//html += '<p>Leave has been successfully applied.</p>';

				$('.mnp_msg').slideUp();
                alert('Non punching authorization has been successfully applied.');
                window.location.href='<?php echo WEB; ?>/myrequest?type=6';

			}
		}
	});

    /* Time Scheduler */

    $('#mainsc form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var msc_msg;

			if (!$('.msc_msg').length)
			{
				$('#alert').after('<div class="msc_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#ndays').val() >= 1)
            {

                if ($('#tsched_from').val().length && $('#tsched_to').val().length)
                {
                    $('.msc_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing time schedule&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();
                }
                else
                {
                    $('.msc_msg')
                        .html('Date coverage is required.')
                        .css({
                            color : '#9c0006',
                            background : '#ffc7ce',
                            border : '2px solid #9c0006',
                            height : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                    return false;
                }
            }
            else
            {
                $('.msc_msg')
                    .html('Date coverage is invalid.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.msc_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				//html += '<p>Leave has been successfully applied.</p>';

				$('.msc_msg').slideUp();
                alert('Time schedule has been successfully applied.');
                window.location.href='<?php echo WEB; ?>/myrequest?type=8';

			}
		}
	});


    /* REGISTRATION */

    $('#regis form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var regis_msg;

			if (!$('.regis_msg').length)
			{
				$('#lasttable').after('<div class="regis_msg" style="display:none; padding:10px; text-align:center" />');
			}


			if ($('#binFile').val().length)
			{

                var x = new Array('empnum', 'position', 'lastname', 'firstname', 'middlename', 'nickname', 'address_num', 'address_street', 'address_brgy', 'address_city', 'address_region', 'address_zip', 'address_country', 'provincial_address', 'contact', 'email', 'birthplace', 'sss', 'tin', 'philhealth', 'pagibig', 'father_name', 'father_comp', 'mother_name', 'mother_comp', 'schoolname[0]', 'schoolname[1]', 'skill[0]', 'comp_supervisor[0]', 'department', 'local', 'corp_email', 'emergency_name', 'emergency_address', 'emergency_telno');

                for (var i = 0; i < x.length; i += 1)
                {
                    l = document.forms['formreg'][x[i]];
                    if (l.value == null || l.value == '' || l.value == 0) {
                        $('.regis_msg')
                        .html('Some fields are required.' + x[i])
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'border' : '2px solid #9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown()
                        .effect('shake', {times: 3, distance: 5}, 420);

                        return false;
                    }
                    else {
                        $('.regis_msg')
                        .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Registering your profile&hellip;')
                        .css({
                            'color' : '#006100',
                            'background' : '#c6efce',
                            'border' : '2px solid #006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                    }
                }
			}

			else
			{
				$('.regis_msg')
					.html('Please select an image for uploading.')
					.css({
						'color' : '#9c0006',
						'background' : '#ffc7ce',
						'border' : '2px solid #9c0006',
                        'margin-top' : '10px',
                        'height' : 'auto'
					})
					.slideDown();

				return false;
			}
		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.regis_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Your profile has been successfully registered and subject for approval.</p>';

				$('.regis_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=table",
                    success: function(data) {
                        $("#activity_table").html(data);
                    }
                });
			}
		}
	});

    /* PROFILE */

    $('#uprofile form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var uprofile_msg;

			if (!$('.uprofile_msg').length)
			{
				$('#lasttable').after('<div class="uprofile_msg" style="display:none; padding:10px; text-align:center" />');
			}


            $('.uprofile_msg')
            .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Updating your profile&hellip;')
            .css({
                'color' : '#006100',
                'background' : '#c6efce',
                'border' : '2px solid #006100',
                'margin-top' : '10px',
                'height' : 'auto'
            })
            .slideDown();

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.uprofile_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Your profile has been successfully updated.</p>';

				$('.uprofile_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}
		}
	});



    $('#uprofile2 form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var uprofile_msg;

			if (!$('.uprofile_msg').length)
			{
				$('#lasttable').after('<div class="uprofile_msg" style="display:none; padding:10px; text-align:center" />');
			}

            if ($('#disclaim').is(':checked')) {

                $('.uprofile_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Submitting your profile&hellip;')
                .css({
                    'color' : '#006100',
                    'background' : '#c6efce',
                    'border' : '2px solid #006100',
                    'margin-top' : '10px',
                    'height' : 'auto'
                })
                .slideDown();
                var validate_error = false;
                var validate_message = "";

                var userinput = $('#EmailAdd2').val();
                var userinput2 = $('#EmailAdd').val();
        				var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

                if (!($('#MobileNumber').inputmask("isComplete"))){
                  validate_error = true;
                  validate_message = "Your contact number is incomplete.";
                }else if(!(userinput.match(mailformat))){
                  validate_error = true;
                  validate_message = "Your personal e-mail address is either incomplete or has incorrect format.";
                }else if(!(userinput2.match(mailformat))){
                  validate_error = true;
                  validate_message = "Your corporate e-mail address is either incomplete or has incorrect format.";
                }else if (!($('#ContactMobileNbr').inputmask("isComplete"))){
                  validate_error = true;
                  validate_message = "Your emergency contact number is incomplete.";
                }

                if(validate_error){
            			$('.uprofile_msg')
            			.html(validate_message)
            			.css({
            				'color' : '#9c0006',
            				'background' : '#ffc7ce',
            				'border' : '2px solid #9c0006',
            										'margin-top' : '10px',
            										'height' : 'auto'
            			})
            			.slideDown();
                  return false;
            		}

            } else {
                $('.uprofile_msg')
					.html('You must agree on declaration.')
					.css({
						'color' : '#9c0006',
						'background' : '#ffc7ce',
						'border' : '2px solid #9c0006',
                        'margin-top' : '10px',
                        'height' : 'auto'
					})
					.slideDown();

				return false;
            }

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.uprofile_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Your profile update has been successfully submitted for approval.</p>';

				$('.uprofile_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}
		}
	});

    $('#uprofile3 form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var uprofile_msg;

			if (!$('.uprofile_msg').length)
			{
				$('#lasttable').after('<div class="uprofile_msg" style="display:none; padding:10px; text-align:center" />');
			}


            $('.uprofile_msg')
            .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Updating your profile&hellip;')
            .css({
                'color' : '#006100',
                'background' : '#c6efce',
                'border' : '2px solid #006100',
                'margin-top' : '10px',
                'height' : 'auto'
            })
            .slideDown();

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.uprofile_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Your profile has been successfully updated.</p>';

				$('.uprofile_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}
		}
	});

    /* FORGOT PASSWORD */

    $('#forgot form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var forgot_msg;

			if (!$('.forgot_msg').length)
			{
				$('#forgot_title').after('<div class="forgot_msg" style="display:none; margin-top:10px; padding:10px; text-align:center" />');
			}

            if ($('#empidnum').val().length)
            {
                $('.forgot_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.forgot_msg')
                    .html('Employee ID is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.forgot_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Your password has been successfully reset and sent you your email.</p>';

				$('.forgot_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}
		}
	});

    /* CHANGE PASSWORD */

    $('#fpass form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var fpass_msg;

			if (!$('.fpass_msg').length)
			{
				$('#fpass_title').after('<div class="fpass_msg" style="display:none; padding:10px; margin-top:10px; margin-bottom:10px; text-align:center" />');
			}

            if ($('#opassword').val().length && $('#npassword').val().length && $('#cpassword').val().length)
            {
                $('.fpass_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.fpass_msg')
                    .html('All fields are required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

		},
		complete : function (response)
		{
			var style,
				width,
				html = '';


			if (!response.success)
			{
				$('.fpass_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}

			else
			{
				html += '<p>Your password has been successfully changed.</p>';

                alert('Your password has been successfully changed.');


                window.location.href='<?php echo WEB; ?>';

				/*$('.fpass_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});*/
			}
		}
	});

/*                                   *
 * - Add-ons Performance Appraisal - *
 *                                   */

     /* PERFORMANCE APPRAISAL  */

    /* ^evaluate */
    $('#pafevaluate form').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var paf_msg;

            $('.paf_msg').html('');

            if (!$('.paf_msg').length)
            {
                $('#alert').after('<div class="paf_msg" style="display:none; padding:3px; margin-top:5px; text-align:center" />');
            }

            //var btn = $(this).find("input[type=submit]:focus" );
            //var btn = $("input[type=submit][clicked=true]").val();


            if ($('.boxRem').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Competency Assessment Form must be filled in, kindly contact the hr if the form is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

            if ($('.boxPom').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Generated Score from HR must be available, kindly contact the hr if the Conduct and Attendance Score is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

        },
        complete : function (response)
        {
            var style,
                width,
                html = '';


            if (!response.success)
            {
                $('.paf_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }
            else
            {

                if (response.type == 1) {

                    html += '<p>Appraisal rating is successfully initiated.</p>';

                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('.subapp').attr('disabled',true);
                    $('.subapp').html('Submitted');
                    $('.subapp').hide('slow');
                    $('#saveapp').hide('slow');
                    $('#viewapp').show('fast');

                }
                else if (response.type == 2) {

                    html += '<p>Appraisal rating is successfully saved.</p>';

                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('#saveapp').hide('slow');
                    $('.subapp').hide('slow');
                    $('.relapp').show('fast');
                    $('#saveapp').attr('disabled',true);
                    $('#saveapp').html('Saved');
					location.reload();

                }
            }
        }
    });

    /* ^global evaluate */
    $('#pafevaluateglobal form').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var paf_msg;

            $('.paf_msg').html('');

            if (!$('.paf_msg').length)
            {
                $('#alert').after('<div class="paf_msg" style="display:none; padding:3px; margin-top:5px; text-align:center" />');
            }

            //var btn = $(this).find("input[type=submit]:focus" );
            //var btn = $("input[type=submit][clicked=true]").val();


            if ($('#globalpart3').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Work Results Form must be filled in, kindly contact the hr if the form is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }


            if ($('#globalpart4').val())
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Personal Core Competencies Form must be filled in, kindly contact the hr if the form is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

            if ($('#globalhr').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Generated Score from HR must be available, kindly contact the hr if the Conduct and Attendance Score is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

        },
        complete : function (response)
        {
            var style,
                width,
                html = '';


            if (!response.success)
            {
                $('.paf_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }
            else
            {

                if (response.type == 1) {

                    html += '<p>Appraisal rating is successfully initiated.</p>';

                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('.subapp').attr('disabled',true);
                    $('.subapp').html('Submitted');
                    $('.subapp').hide('slow');
                    $('#saveapp').hide('slow');
                    $('#viewapp').show('fast');

                }
                else if (response.type == 2) {

                    html += '<p>Appraisal rating is successfully saved.</p>';

                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('#saveapp').show('fast');
                    $('.subapp').hide('slow');
                    $('.relapp').show('fast');
                    //$('#saveapp').attr('disabled',true);
                    //$('#saveapp').html('Saved');
					location.reload();

                }
            }
        }
    });

    /* ^pafupdater */
    $('#paf .formx').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var pafup_msg;

            if (!$('.pafup_msg').length)
            {
                $('#alert').after('<div class="pafup_msg" style="display:none; padding:3px; margin-top:5px; margin-bottom:5px; text-align:center" />');
            }

            if ($('.remarks').val().length)
            {
                $('.pafup_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.pafup_msg')
                    .html('Your comment must not be empty.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

        },
        complete : function (response)
        {
            var style,
                width,
                html = '';


            if (!response.success)
            {
                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }else if(response.type == 2){
				html += '<p>Your rating has been successfully saved.</p>';

				$('.pafup_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
							'height' : 'auto'
						})
						.slideDown();
				});

				//$('.approveapp').attr('disabled',true);
				//$('.approveapp').val('Submitted');
				//$('.subapp').hide('slow');
				$('#saveapp').show('fast');
				$('#saveapp2').show('fast');
				$('#refrbtn').show('fast');
				location.reload();

				$('#pow1').slideUp(function ()
				{
					$(this)
						.html(html)
						.slideDown();
				});
			}

            else
            {
                html += '<p>You successfully sent your comment and approved the rating result.</p>';

                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .css({
                            'color' : '#006100',
                            'background' : '#c6efce',
                            'borderColor' : '#006100',
                            'height' : 'auto'
                        })
                        .slideDown();
                });

                //$('.approveapp').attr('disabled',true);
                //$('.approveapp').val('Submitted');
                //$('.subapp').hide('slow');
                //$('#saveapp').hide('slow');
                $('#approveapp').hide('slow');
                $('#viewapp').show('fast');
				$('#refrbtn').hide('fast');
				$('#saveapp2').hide('fast');

                $('#pow1').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .slideDown();
                });

            }
        }
    });

    /* ^uploader */
    $('#paf .formg').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var pafup_msg;

            if (!$('.pafup_msg').length)
            {
                $('#alert').after('<div class="pafup_msg" style="display:none; padding:2px; margin-top:3px; text-align:center" />');
            }

            if ($('.remarks').val().length)
            {
                $('.pafup_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.pafup_msg')
                    .html('Comment must not be empty.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420);

                return false;
            }

        },
        complete : function (response)
        {
            var style,
                width,
                html = '';


            if (!response.success)
            {
                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }

            else
            {
                html += '<p>You successfully sent your comment and accept the appraisal rating result.</p>';

                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .css({
                            'color' : '#006100',
                            'background' : '#c6efce',
                            'borderColor' : '#006100',
                            'height' : 'auto'
                        })
                        .slideDown();
                });

                $('#pow1').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .slideDown();
                });
            }
        }
    });
    /* end of pafupdater */
});
