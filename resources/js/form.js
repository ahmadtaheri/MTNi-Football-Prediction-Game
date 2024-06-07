$(document).ready(function () {
    $("form").submit(function (event) {
        var formData = {
            "_token": "{{ csrf_token() }}",
            teamA_Score_prediction: $("#teamA_Score_prediction").val(),
            teamB_Score_prediction: $("#teamB_Score_prediction").val(),
            superheroAlias: $("#superheroAlias").val(),
        };

        $.ajax({
            type: "POST",
            url: "/matchPrediction",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data);
        });

        event.preventDefault();
    });
});