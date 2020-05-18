$(document).on("ready", function(){

    $("div.es").hide();

})

$('table.download').DataTable({
    paging: false,
    dom: 'Bfrtip',
    ordering: false,
    buttons: [{ extend: 'excel', text: 'Download as Excel', className: 'mb-1',filename: function(){
            var d = new Date();
            return 'SOB' + d;
        }}]
});

// setInterval(function(){
//   $( "table.table-refresh" ).load( "sob_approval.php table.table-refresh" );
//   $( "p.total_count" ).load( "sob_approval.php p.total_count" );
// }, 2000); //refresh every 2 seconds

$(document).on("click", ".sob_submit", function(){

  var notify = $.notify('<strong>Updating</strong> Do not close this page...', {
    allow_dismiss: false,
    showProgressbar: false,
    delay: 0
  });
  var getdate = $('input#getdate').val();
  console.log(getdate);
  $.post(

      "Handler/SOB_submit.php",{

        'getdate' : getdate

      },
      function(data){
          console.log(data);

          notify.update({'type': 'success', 'message': '<strong>Success</strong> SOB Records Succesfully Updated!'});
          setTimeout(function() {
            $.notifyClose();
          }, 3000);
          $( "table.table-refresh" ).load( "sob_approval.php table.table-refresh" );
          $( "p.total_count" ).load( "sob_approval.php p.total_count" );
      }
  );
    
});

$(document).on("click", ".es_submit", function(){
  
  var notify = $.notify('<strong>Updating</strong> Do not close this page...', {
    allow_dismiss: false,
    showProgressbar: false,
    delay: 0
  });

  $.post(
      "Handler/ES_submit.php",
      function(data){
          console.log(data);

          notify.update({'type': 'success', 'message': '<strong>Success</strong> E-Safety Records Succesfully Updated!'});
          setTimeout(function() {
            $.notifyClose();
          }, 3000);
          $( "table.table-refresh" ).load( "es_approval.php table.table-refresh" );
          $( "p.total_count" ).load( "es_approval.php p.total_count" );
      }
  );
  
});

$(document).on("click", ".es_fixed_submit", function(){

  var notify = $.notify('<strong>Updating</strong> Do not close this page...', {
    allow_dismiss: false,
    showProgressbar: false,
    delay: 0
  });

  $.post(
      "Handler/ES_fixed_submit.php",
      function(data){

          console.log(data);

          notify.update({'type': 'success', 'message': '<strong>Success</strong> E-Safety Records Succesfully Updated!'});
          setTimeout(function() {
            $.notifyClose();
          }, 3000);
          $( "table.table-refresh" ).load( "es_fixed_approval.php table.table-refresh" );
          $( "p.total_count" ).load( "es_fixed_approval.php p.total_count" );
      }
  );
  
});

$(document).on("click", ".eq_submit", function(){

  var notify = $.notify('<strong>Updating</strong> Do not close this page...', {
    allow_dismiss: false,
    showProgressbar: false,
    delay: 0
  });

  $.post(
      "Handler/EQ_submit.php",
      function(data){

          console.log(data);

          notify.update({'type': 'success', 'message': '<strong>Success</strong> E-Quality Records Succesfully Updated!'});
          setTimeout(function() {
            $.notifyClose();
          }, 3000);
          $( "table.table-refresh" ).load( "eq_approval.php table.table-refresh" );
          $( "p.total_count" ).load( "eq_approval.php p.total_count" );
      }
  );
  
});

$(document).on("click", ".eq_fixed_submit", function(){

  var notify = $.notify('<strong>Updating</strong> Do not close this page...', {
    allow_dismiss: false,
    showProgressbar: false,
    delay: 0
  });

  $.post(
      "Handler/EQ_fixed_submit.php",
      function(data){

          console.log(data);

          notify.update({'type': 'success', 'message': '<strong>Success</strong> E-Quality Records Succesfully Updated!'});
          setTimeout(function() {
            $.notifyClose();
          }, 3000);
          $( "table.table-refresh" ).load( "eq_fixed_approval.php table.table-refresh" );
          $( "p.total_count" ).load( "eq_fixed_approval.php p.total_count" );
      }
  );
  
});



$(document).ready(function(){
    
    $.post(
        "chart/sob_stat.php",
        function(data){
            console.log(data);
            var dataObj = JSON.parse(data);
            console.log(dataObj);
                       
            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';
            
            var tempDataSorted = dataObj.data.sort(function(a, b){return b - a});
            var maximum = tempDataSorted[0].value;
            var newMax = Number(maximum) + 5;
            
            // Area Chart Example
            var ctx = document.getElementById("ChartSOB");
            var myLineChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: dataObj.labels,
                datasets: [{
                  label: "Quantity",
                  lineTension: 0.3,
                  backgroundColor: "rgba(2,117,216,0.2)",
                  borderColor: "rgba(2,117,216,1)",
                  pointRadius: 5,
                  pointBackgroundColor: "rgba(2,117,216,1)",
                  pointBorderColor: "rgba(255,255,255,0.8)",
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(2,117,216,1)",
                  pointHitRadius: 50,
                  pointBorderWidth: 2,
                  data: dataObj.data
                }],
              },
              options: {
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'date'
                    },
                    gridLines: {
                      display: false
                    },
                    ticks: {
                      maxTicksLimit: 7,
                      autoSkip: false
                    }
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: maximum,
                      maxTicksLimit: 5
                    },
                    gridLines: {
                      color: "rgba(0, 0, 0, .125)",
                    }
                  }],
                },
                legend: {
                  display: false
                }
              }
            });
        }
    );
});





