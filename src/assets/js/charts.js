import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
  var forecastDataElement = document.getElementById('forecast-data');
  var forecastData = JSON.parse(forecastDataElement.getAttribute('data-forecast'));

  var forecastServiceElement = document.getElementById('forecast-service');
  var forecastServiceData = forecastServiceElement.getAttribute('data-forecast-service')

  switch (forecastServiceData) {
    case 'dwd-icon':
      var label = 'DWD ICON'
      break;
  
    case 'noaa-gfs':
      var label = 'NOAA GFS'
      break;

    default:
      break;
  }

  var labels = forecastData[0].map(function(data, index) {
    // Generate labels based on the index and show the value every 24 data points
    if (index % 24 === 0)
      return data;
    
    // Return an empty string for labels that should be hidden
    return '';
  });

  const data = {
    labels: labels,
    datasets: [{
      label: label,
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: forecastData[1],
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  };

  new Chart(
    document.getElementById('myChart'),
    config
  );
});
