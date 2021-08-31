<!doctype html>
<html lang="en">
  <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    </head>
  <body>
    <center><h1>62103452 Dararat Khanngang</h1></center>
  <div class="container">
     <div class="row">
        <div class="col-6">
          <canvas id="myChart" width="400" height="200"></canvas>
        </div>

      <div class="row">
        <div class="col-6">
          <canvas id="chart1" width="400" height="200"></canvas>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <canvas id="chart2" width="400" height="200"></canvas>
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="row">
              <div class="col-4">
                <b>Temperature</b>
              </div>
               <div class="col-8">
                  <b><span id="lastTempearature"></span></b>
               </div> 
          </div>

          <div class="row">
            <div class="col-4">
              <b>Humidity</b>
            </div>
             <div class="col-8">
                <b><span id="lastHumidity"></span></b>
             </div> 
        </div>
        <div class="row">
          <div class="col-4">
            <b>Update</b>  
          </div>
           <div class="col-8">
          <b><span id="lastUpdate"></span></b> 
           </div> 
      </div>

        
        <div class="row">
         <div class="col-4">
            <b>Light</b>  
        </div>
         <div class="col-8">
            <b><span id="lastLight"></span></b> 
         </div> 
        </div>
      </div>
  </div>
    
  </body>
  <script>

    function showChart(data){
            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx,{
                type:'line',
                data:{
                    labels:data.xlabel,
                    datasets:[{
                        label:data.label,
                        data:data.data,
                       
                    }]
                }
            });
        }
    
        function Charttemperature(data_2){
            var ctxy = document.getElementById("chart1").getContext("2d");
            var myChart = new Chart(ctxy,{
                type:'line',
                data:{
                    labels:data_2.xlabel,
                    datasets:[{
                        label:data_2.label,
                        data:data_2.data,
                        
                    }]
                }
            });
        }
    
        function Chartlight(data_3){
            var ctxy = document.getElementById("chart2").getContext("2d");
            var myChart = new Chart(ctxy,{
                type:'line',
                data:{
                    labels:data_3.xlabel,
                    datasets:[{
                        label:data_3.label,
                        data:data_3.data,
                        
                    }]
                }
            });
        }
    
        $(()=>{
            let url = "https://api.thingspeak.com/channels/1458744/feeds.json?results=240";
            $.getJSON(url)
                .done(function(data){
                    let feed = data.feeds;
                    let chan = data.channel;
    
    
                    const d = new Date(feed[239].created_at);
                        const monthNames = ["January","February","March","April","May","July","August","September","October","November","December"];
                        let dateStr = d.getDate()+" "+monthNames[d.getMonth()]+" "+d.getFullYear();
                        dateStr += " "+d.getHours()+":"+d.getMinutes();
    
                  
                  $("#lastTempearature").text(feed[239].field2+ " C");
                    $("#lastHumidity").text(feed[239].field1+ " %");
                    $("#lastLight").text(feed[239].field3 );
                    $("#lastUpdate").text(dateStr);
    
                    var plot = Object();
                    var xlabel = [];
                    var temp = [];
                    var hum = [];
                    var light =[];
    
                    $.each(feed,(k,v)=>{
                        xlabel.push(v.created_at);
                        hum.push(v.field1);
                        temp.push(v.field2);
                        light.push(v.field3)
                    });
                    var data = new Object();
                    data.xlabel = xlabel;
                    data.data = temp;
                    data.label = chan.field2;
                    
                    var data_2 = new Object();
                    data_2.xlabel = xlabel;
                    data_2.data = hum;
                    data_2.label = chan.field1;
                   
                    var data_3 = new Object();
                    data_3.xlabel = xlabel;
                    data_3.data = light;
                    data_3.label = chan.field3;
                   
    
                    showChart(data);
                    Charttemperature(data_2);
                    Chartlight(data_3);
    
    
    
                });
        });
         
    </script>
