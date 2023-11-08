function openDay(day){
  newsCount = $(".news-count.active").data("count");
  $.get(
      "/personal/calendar/ajax/dateFilter.php",
      {
        date: day,
        count: newsCount
      },
      function (data) {
        $(".choosedDate").html(data);
      }
  );
}

function changeMonth(month, year, sectionId){
  $.ajax({
    type: "GET",
    url: "/personal/calendar/ajax/changeMonth.php",
    data: {sectionId: sectionId, month: month, year: year},
    dataType: "json",
    success: function (data) {
      $(".calendar-inner").html(data["calendar"]);
      $(".choosedDate").html(data["bottom"]);
    }
  });
}