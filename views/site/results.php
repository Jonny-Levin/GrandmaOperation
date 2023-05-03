<?php 
   use yii\helpers\Html; 
   $this->title = 'Results';
   $this->params['breadcrumbs'][] = $this->title;
?> 

<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.27.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@0.1.1"></script>
   </head>

   <body>
      <?php if(Yii::$app->user->isGuest): ?>
         <div>Please log in to view the results.</div>
      <?php else: ?>
         <div>
            <canvas id="myChart"></canvas>
         </div>
         
         <?php
            // Connect to the database
            $servername = "localhost";
            $username = "root";
            $password = "1234";
            $dbname = "results";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
            }

            // Query the database for the necessary data
            $sql = "SELECT Result, Date FROM results ORDER BY Date ASC";
            $result = mysqli_query($conn, $sql);

            // Format the data for Chart.js
            $data = array();
            while($row = mysqli_fetch_assoc($result)) {
               $date = date('M-d H:i:s', strtotime($row['Date']));
               $data[] = array("x" => $date, "y" => $row['Result']);
            }
         ?>

         <script>
            var config = {
               type: 'line',
               data: {
                  datasets: [{
                     label: 'Results',
                     data: <?php echo json_encode($data); ?>,
                     borderColor: 'rgb(255, 99, 132, 1)',
                     fill: false
                  }]
               },
               options: {
                  scales: {
                     xAxes: {
                        type: 'category',
                        min: '',
                        ticks: {
                           source: 'data',
                           autoSkip: true,
                        },
                        title: {
                           display: true,
                           text: 'Date / Time',
                           color: 'rgb(0, 0, 255)'
                        }
                     },
                     yAxes: {
                        min: 10000,
                        max: 21000,
                        ticks: {
                           stepSize: 1000
                        },
                        title: {
                           display: true,
                           text: 'Frequency (Hz)',
                           color: 'rgb(0, 0, 255)'
                        }
                     }
                  },
                  plugins: {
                     title: {
                        display: true,
                        text: 'Welcome, <?php echo isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : 'Guest'; ?>!' 
                     }

                  }
               }
            };
            var myChart = new Chart(document.getElementById('myChart'), config);
         
         </script>
      <?php endif; ?>
   </body>
</html>
