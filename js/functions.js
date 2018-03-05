$(function() {
    // 表示期間を変更
    $("select[name=select-period]").change(function() {
        $.ajax({
            url: "./api.php",
            type: "post",
            dataType: "json",
            data: {
                period: $(this).val(),
            }
        }).done(function(response) {
            $(".kakin-list-row").remove();

            kakinListRows = formKakinList(response);
            // for (i = 0; i < response.length; i++) {
            //     addCommaAmount = String(response[i]['amount']).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'); // 金額をカンマ区切りにする
            //     kakinListRows = '<tr class="block kakin-list-row">' +
            //                       '<td class="col-xs-3 text-center block">' + response[i]['date'] + '</td>' +
            //                       '<td class="col-xs-2 text-center block">' + response[i]['detail'] + '</td>' +
            //                       '<td class="col-xs-3 text-center block"><b>¥ ' + addCommaAmount + '</b></td>' +
            //                       '<td class="col-xs-4 block">' + response[i]['purpose'] + '</td>' +
            //                     '</tr>';
                $(kakinListRows).appendTo("#kakin-list").hide().fadeIn(400);
            }
        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
            window.alert("【" + XMLHttpRequest.status + " " + textStatus + "】" + errorThrown.message);
        });
    });

    // 表示期間を指定
    $("#specify-period-button").on("click", function() {
        periodFrom = $("input[name=specify-period-from]").val();
        periodTo   = $("input[name=specify-period-to]").val();
        console.log(periodFrom);
        console.log(periodTo);

        if (periodFrom && periodTo) {
            $.ajax({
                url: "./api.php",
                type: "post",
                dataType: "json",
                data: {
                    period    : "specify",
                    periodFrom: periodFrom,
                    periodTo  : periodTo,
                }
            }).done(function(response) {
                console.log("success!");
                $(".kakin-list-row").remove();

                for (i = 0; i < response.length; i++) {
                    addCommaAmount = String(response[i]['amount']).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'); // 金額をカンマ区切りにする
                    kakinListRows = '<tr class="block kakin-list-row">' +
                                      '<td class="col-xs-3 text-center block">' + response[i]['date'] + '</td>' +
                                      '<td class="col-xs-2 text-center block">' + response[i]['detail'] + '</td>' +
                                      '<td class="col-xs-3 text-center block"><b>¥ ' + addCommaAmount + '</b></td>' +
                                      '<td class="col-xs-4 block">' + response[i]['purpose'] + '</td>' +
                                    '</tr>';
                    $(kakinListRows).appendTo("#kakin-list").hide().fadeIn(400);
                }
            }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
                window.alert("【" + XMLHttpRequest.status + " " + textStatus + "】" + errorThrown.message);
            });
        } else {
            window.alert("表示したい期間を指定してください。");
        }
    });

    // サブメニューの開閉
    $(".accordion-icon").on("click", function() {
        target = $(this);
        accordion = target.closest(".menu");
        accordionBody = accordion.children(".sub-menu");

        if (accordionBody.is(":visible")) {
            accordion.removeClass("show");
            accordionBody.slideUp("normal");
        } else {
            accordion.addClass("show");
            accordionBody.slideDown("normal");
        }
    });
});


function formKakinList(response) {
    for (i = 0; i < response.length; i++) {
        addCommaAmount = String(response[i]['amount']).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'); // 金額をカンマ区切りにする

        kakinListRows = '<tr class="block kakin-list-row">' +
                          '<td class="col-xs-3 text-center block">' + response[i]['date'] + '</td>' +
                          '<td class="col-xs-2 text-center block">' + response[i]['detail'] + '</td>' +
                          '<td class="col-xs-3 text-center block"><b>¥ ' + addCommaAmount + '</b></td>' +
                          '<td class="col-xs-4 block">' + response[i]['purpose'] + '</td>' +
                        '</tr>';
        return kakinListRows;
    }
}
