<!DOCTYPE html>
<html>
<head>
    <title>User Data Chart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
    
<body>
    <div style="width: 75%; margin: auto;">
        <h2>User Data Chart</h2>
        <canvas id="userChart"></canvas>
        <p>Total Users: {{ $totalUsers }}</p>
    </div>
</body>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
<script type="text/javascript">
  
      const labels = @json($labels);
      const data = @json($data);

      const ctx = document.getElementById('userChart').getContext('2d');
      const userChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: labels,
              datasets: [{
                  label: 'Number of Users',
                  data: data,
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
  
</script>
</html>