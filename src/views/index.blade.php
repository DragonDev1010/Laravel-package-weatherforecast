<form action="{{ route('getWeatherForecast') }}" method="POST">
  @csrf

  <div>
    <label for="ip_address">IP Address:</label>
    <input type="text" name="ip_address" value="{{ $initialIpAddress }}" placeholder="Enter IP address">
  </div>

  <div>
    <label for="datetime">Start Date:</label>
    <input type="date" name="datetime" id="datetime">
  </div>

  <div>
    <label for="server">Server:</label>
    <select name="server" id="server">
      <option value="dwd-icon">DWD ICON</option>
      <option value="noaa-gfs">NOAA GFS</option>
    </select>
  </div>

  <button type="submit">Weather Forecast</button>
</form>
@isset($latitude)
<p>Latitude: {{$latitude}}</p>
@endisset
@isset($longitude)
<p>Longitude: {{$longitude}}</p>
@endisset
@isset($forecastData)
  <!-- Your code for rendering the forecast data -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="module" src="{{ asset('weatherforecast/js/charts.js') }}"></script>

  <!-- Store forecast array data to use in js file -->
  <div id="forecast-data" data-forecast="{{ json_encode($forecastData) }}"></div>
  <!-- Store Weather Forecast service to pass to js function -->
  <div id="forecast-service" data-forecast-service="{{$server}}"></div>
  <div>
    <canvas id="myChart" width="800" height="400"></canvas>
  </div>
@else
  <!-- Your code for handling the case when forecast data is not available -->
  <p>There is not any forecasting data.</p>
@endisset


