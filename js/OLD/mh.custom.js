$(document).ready(function() {

    $(window).load(function() {
        $(window).scroll();
    });


    $("textarea, input").focus(function() {
        $(this).css("color", "rgb(0, 0, 0)");
    });

    $("textarea, input").blur(function() {
        $(this).css("color", "rgb(102, 102, 102)");
    });

    var oldStatus;


    $("#Ustatus").click(function() {
        var l_result;
        if ($("#UserMessage").val() != oldStatus && $("#UserMessage").val() != "Update Personal Status Here..") {
            var message = $("#UserMessage").val();
            document.getElementById("mstatus").innerHTML = message;
            
            $.ajax({async: false,
                url: base_url + 'index.php/dynamicAjax/dynamicUpdateUserMessage',
                type: 'POST',
                dataType: 'json',
                data: {'UserMessage': message},
                success:
                        function(result) {
                    $('#UserMessage').val('');
                            l_result = result;
                            /*$.bootstrapGrowl("Status Updated Successfully", {
                                type: "success",
                                align: "center",
                                stackup_spacing: 30
                            });*/
                            $("#UserMessage").val("Update Personal Status Here...");
                        }});

            $("#um_lastupdate").html(l_result.dateHtml);
            jQuery("abbr.timeago").timeago();

        }
        if ($("#UserMessage").val() == "") {
            $("#UserMessage").val("Update Personal Status Here..");
            //$(".lastupdate").html("");
        }

    });


    $("#UserMessage").focus(function() {

        $(this).val("");

        oldStatus = $(this).val();
    });

    var lastScrollPos = 0;
    $(window).scroll(function() {

        var scrollTop = $(window).scrollTop();
        if (lastScrollPos == 0) {
            if (scrollTop != 0) {
                $("#fixed-header").css('box-shadow', '0 0 6px 1px rgb(216, 216, 216)');
                $("#fixed-header").css('border-bottom', '2px solid rgb(216, 216, 216)');
            }
        } else {
            if (scrollTop == 0) {
                $("#fixed-header").css('box-shadow', '');
                $("#fixed-header").css('border-bottom', '');
            }
        }

        lastScrollPos = scrollTop;
    });


    $('div[id^="accept_"], div[id^="reject_"]').click(function() {

        var l_result = "";
        var l_parts = $(this).attr("id").split("_");


        $.ajax({async: false,
            url: base_url + 'index.php/dynamicAjax/dynamicAcceptMatch',
            type: 'POST',
            dataType: 'json',
            data: {'mid': $(this).attr("id")},
            success:
                    function(result) {
                        l_result = result;
                    }});

        if (l_result.action == "accepted") {
            $("#topMsg").html("Sucessfully Accepted this match.");
        } else if (l_result.action == "rejected") {
            $("#topMsg").html("This Match has been Declined and Blocked.");
        }
        $("#topMsg").fadeIn().delay(4000).fadeOut();


        if (l_result.innerHtml == "") {
            $("#question_" + l_parts[1]).slideUp();
        } else {
            $("#question_" + l_parts[1]).replaceWith(l_result.innerHtml);
        }

        if (l_result.headerHtml != "") {
            $("#header_" + l_parts[1]).html(l_result.headerHtml);
        }

        $("#headerDate_" + l_parts[1]).html(l_result.headerDateInnerHtml);
        return false;
    });


    $('.signupsteps').on("click", 'div[id^="albumYes_"], div[id^="albumNo_"]', function() {
        var l_result;
        var l_parts = $(this).attr("id").split("_");


        $.ajax({async: false,
            url: base_url + 'index.php/dynamicAjax/dynamicToggleAlbumAccess',
            type: 'POST',
            dataType: 'json',
            data: {'mid': $(this).attr("id")},
            success:
                    function(result) {
                        l_result = result;
                    }});

        $("#topMsg").html("Saved album access!");
        $("#topMsg").fadeIn().delay(3000).fadeOut();

        //$("#optionsPending_"+l_parts[1]).html(l_result.html).fadeIn(1500);
        $("#question_" + l_parts[1]).replaceWith(l_result.html);
        $("#header_" + l_parts[1]).html(l_result.headerHtml);
        $("#headerDate_" + l_parts[1]).html(l_result.headerDateInnerHtml);
        return false;
    });
    var l_emptyTag = "<option selected='selected' value=''></option>";
    $(document).on('change', ".countryList", function(event) {

        var l_data;

        $.ajax({async: false,
            url: '../dynamicAjax/dynamicGetRegionsJSON',
            type: 'POST',
            dataType: 'json',
            data: {'countryId': $(this).val(), 'isAcc': 'false'},
            success: function(data) {
                l_data = data;
            }
        });

        if (l_data.count == 0) {
            $(this).siblings(".regionList").attr('data-placeholder', 'No Regions for ' + $(this).find('option:selected').val());
            //$(this).siblings(".cityList").attr('data-placeholder', 'No Cities for '+$(this).find('option:selected').val());
            $(this).siblings(".cityList").attr('data-placeholder', 'Unsupported Region');

            $(this).siblings(".proxList").attr('data-placeholder', 'Not Applicable -');

        } else {
            $(this).siblings(".regionList").attr('data-placeholder', 'Select Region');
            $(this).siblings(".cityList").attr('data-placeholder', 'Select Region First');
            $(this).siblings(".proxList").attr('data-placeholder', 'Select City First');

        }

        $(this).siblings(".regionList").html(l_data.regionDD);
        $(this).siblings(".cityList").html(l_emptyTag);
        $(this).siblings(".proxList").html(l_emptyTag);

        $(this).siblings(".regionList, .cityList, .proxList").trigger("liszt:updated");

    });

    $(document).on('change', ".regionList", function(event) {

        var l_data;
        $.ajax({async: false,
            url: '../dynamicAjax/dynamicGetCitiesJSON',
            type: 'POST',
            dataType: 'json',
            data: {'countryId': $(this).siblings('.countryList').val(),
                'regionId': $(this).val(),
                'isAcc': 'false'},
            success: function(data) {
                l_data = data;
            }
        });

        if (l_data.count == 0) {
            //$(this).siblings(".cityList").attr('data-placeholder', 'No Cities for '+$(this).find('option:selected').val());
            $(this).siblings(".cityList").attr('data-placeholder', 'Unsupported Region');
            $(this).siblings(".proxList").attr('data-placeholder', 'Not Applicable');

        } else {
            $(this).siblings(".cityList").attr('data-placeholder', 'Select City');
        }

        $(this).siblings(".cityList").html(l_data.cityDD); //Default
        $(this).siblings(".proxList").html(l_emptyTag);

        $(this).siblings(".cityList, .proxList").trigger("liszt:updated");

    });

    $(document).on('change', ".cityList", function(event) {

        var l_data;

        if ($(this).val() != '') {

            $.ajax({async: false,
                url: '../dynamicAjax/dynamicGetProxJSON',
                type: 'POST',
                dataType: 'json',
                data: {'cityId': $(this).val(),
                    'isAcc': 'false'},
                success: function(data) {
                    l_data = data;
                }
            });

            $(this).siblings(".proxList").attr('data-placeholder', 'Select Proximity');
            $(this).siblings(".proxList").html(l_data.accProxDD); //Default

            $(this).siblings(".proxList").trigger("liszt:updated");

        } else {
            $(this).siblings(".proxList").attr('data-placeholder', 'Select City First');
        }
    });
    $(document).on('change', ".accCountryList", function(event) {

        var l_data;

        $.ajax({async: false,
            url: '../dynamicAjax/dynamicGetRegionsJSON',
            type: 'POST',
            dataType: 'json',
            data: {'countryId': $(this).val(), 'isAcc': 'false'},
            success: function(data) {
                l_data = data;
            }
        });

        if (l_data.count == 0) {
            $(this).siblings(".accRegionList").attr('data-placeholder', 'All Regions in ' + $(this).find('option:selected').val());
            $(this).siblings(".accCityList").attr('data-placeholder', 'All Cities in ' + $(this).find('option:selected').val());
            $(this).siblings(".accProxList").attr('data-placeholder', 'Not Applicable');

        } else {
            $(this).siblings(".accRegionList").attr('data-placeholder', 'All Regions');
            $(this).siblings(".accCityList").attr('data-placeholder', 'All Cities');
            $(this).siblings(".accProxList").attr('data-placeholder', 'Not Applicable');

        }

        $(this).siblings(".accRegionList").html(l_data.regionDD);
        $(this).siblings(".accCityList").html(l_emptyTag);
        $(this).siblings(".accProxList").html(l_emptyTag);

        $(this).siblings(".accRegionList, .accCityList, .accProxList").trigger("liszt:updated");

    });

    $(document).on('change', ".accRegionList", function(event) {

        var l_data;
        $.ajax({async: false,
            url: '../dynamicAjax/dynamicGetCitiesJSON',
            type: 'POST',
            dataType: 'json',
            data: {'countryId': $(this).siblings('.accCountryList').val(),
                'regionId': $(this).val(),
                'isAcc': 'false'},
            success: function(data) {
                l_data = data;
            }
        });

        if (l_data.count == 0) {
            $(this).siblings(".accCityList").attr('data-placeholder', 'All Cities in ' + $(this).find('option:selected').text());
            $(this).siblings(".accProxList").attr('data-placeholder', 'Not Applicable');

        } else {
            $(this).siblings(".accCityList").attr('data-placeholder', 'All Cities');
        }

        $(this).siblings(".accCityList").html(l_data.cityDD); //Default
        $(this).siblings(".accProxList").html(l_emptyTag);

        $(this).siblings(".accCityList, .accProxList").trigger("liszt:updated");

    });

    $(document).on('change', ".accCityList", function(event) {

        var l_data;

        if ($(this).val() != '') {

            $.ajax({async: false,
                url: '../dynamicAjax/dynamicGetProxJSON',
                type: 'POST',
                dataType: 'json',
                data: {'cityId': $(this).val(),
                    'isAcc': 'false'},
                success: function(data) {
                    l_data = data;
                }
            });

            $(this).siblings(".accProxList").attr('data-placeholder', 'This City Only');
            $(this).siblings(".accProxList").prop('disabled', false);
            $(this).siblings(".accProxList").html(l_data.accProxDD); //Default

            $(this).siblings(".accProxList").trigger("liszt:updated");

        } else {
            $(this).siblings(".accProxList").attr('data-placeholder', 'Not Applicable');
        }
    });

    $('a[id^="dismissSmile_"]').click(function() {

        var l_result;
        var l_parts = $(this).attr("id").split("_");

        $.ajax({async: false,
            url: '../dynamicAjax/dynamicDismissSmile',
            type: 'POST',
            dataType: 'json',
            data: {'mid': l_parts[1]},
            success:
                    function(result) {
                        l_result = result;
                    }});

        $("#wallSideFaveContainerLg_" + l_parts[1]).slideUp();

        return false;

    });


    $('div[id^="sendsmile_"]').click(function() {

        var l_result;
        var l_parts = $(this).attr("id").split("_");


        $.ajax({async: false,
            url: '../dynamicAjax/dynamicSendSmile',
            type: 'POST',
            dataType: 'json',
            data: {'mid': l_parts[1]},
            success:
                    function(result) {
                        l_result = result;
                    }});

        if (l_result.success == false) {

            alertify.dismissAll();
            alertify.set('notifier', 'position', 'top-left');
            alertify.error("A Smile has already been sent.  Once they respond to it then you can send another.", 0);
            setTimeout(function(){ alertify.dismissAll(); }, 2000);
        } else {
            $("#wallSideFaveContainerLg_" + l_parts[1]).slideUp();
            $("#topMsg").html("Smile has been sent.");
            $("#topMsg").fadeIn().delay(3000).fadeOut();
        }
        return false;

    });


});