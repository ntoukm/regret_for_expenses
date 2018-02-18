$(function() {
    $("select[name=period]").change(function() {
        $.ajax({
            url: "./api.php",
            type: "post",
            dataType: "json",
            data: {
                period: $(this).val(),
            }
        }).done(function(response) {
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
    })
});
