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

  <button type="submit">Submit</button>
</form>

@isset($forecastData)
  <!-- Your code for rendering the forecast data -->
  <script type="module" src="{{ mix('packages/great/weather-forecast/src/assets/js/charts.js') }}"></script>

  <!-- Store forecast array data to use in js file -->
  <div id="forecast-data" data-forecast="{{ json_encode($forecastData) }}"></div>
  <!-- Store Weather Forecast service to pass to js function -->
  <div id="forecast-service" data-forecast-service="{{$server}}"></div>
  <div>
    <canvas id="myChart" width="800" height="400"></canvas>
  </div>
@else
  <!-- Your code for handling the case when forecast data is not available -->
  <p>no forecast data</p>
@endisset


