$(document).ready(function(){
    //  Календарь
    $("#myCalendar-1").ionCalendar({
        lang: "ru",                     // language
        sundayFirst: false,             // first week day
        years: "80",                    // years diapason
        format: "DD.MM.YYYY",           // date format
        onClick: function(date){
            //  Информация о занятых курьерах в выбранный в календаре день
            $.ajax({
                type: "POST",
                url: "trips.php",
                data: {date: date},
                success: function(couriers){
                    var r= $('<input id="clean" type="button" value="Очистить"/>');
                    $("#result-1").html('Сейчас в пути:<br><br>' + couriers).append(r);
                    $("#clean").click(function(){
                        $('#result-1').empty();
                    });
                }
            });
        }
    });

    //  Действия при выборе Даты и Региона в форме
    $('.js-arriveTime').on('change', function(){
        var data = {};
        var form = $('#add_trip');
        data['region'] = $('#city').val();
        data['date'] = $('#depart').val();
        //  Заполнение поля со времени прибытия курьера в регион
        $.ajax({
            type: "POST",
            url: "form.php",
            data: data,
            success: function(date) {
                $('#arrive').html(date);
            }
        });
        //  Добавление атрибута "disabled" занятым курьерам
        $.ajax({
            type: "POST",
            url: "busyCouriers.php",
            data: form.serialize(),
            dataType: "json",
            success: function(data) {
                var cour = Object.values(data);
                console.log(cour);
                $('option').removeAttr("disabled");
                cour.forEach(function(entry) {
                    $('option[value = "' + entry + '"').attr("disabled", "disabled");
                })
            }
        });
    });

    // Отправка данных формы
    $(function() {
      $('#add_trip').submit(function(e) {
        var form = $(this);
        var now = moment();
        e.preventDefault();
        if ($('#depart').val() < now.format('YYYY-MM-DD')) {
            alert('Дата не может быть в прошедшем времени, выберите другую дату');
        } else {
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    $( '#add_trip' ).each(function(){
                        this.reset();
                    });
                    alert(response);
                }
            });
        }
      });
    });
});