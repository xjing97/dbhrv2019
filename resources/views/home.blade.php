@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  @if(Auth::check() && Auth::user()->isAdmin())
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                  @else
                    You have no access rights. This page only available for admin.
                  @endif
                </div>

                @if (Auth::check() && Auth::user()->isAdmin())


                    <center><strong>Overall User Data</strong>
                    <br>
                    <div class="col-md-6">

                        {!! Charts::styles() !!}

                        <!-- Main Application (Can be VueJS or other JS framework) -->

                        <div class="app">

                            <center>

                                {!! $chart->html() !!}

                            </center>

                        </div>

                        <!-- End Of Main Application -->

                        {!! Charts::scripts() !!}

                        {!! $chart->script() !!}
                    </div>

                    <div class="col-md-6">

                        {!! Charts::styles() !!}

                        <!-- Main Application (Can be VueJS or other JS framework) -->

                        <div class="app">

                            <center>

                                {!! $chartAge->html() !!}

                            </center>

                        </div>

                        <!-- End Of Main Application -->

                        {!! Charts::scripts() !!}

                        {!! $chartAge->script() !!}
                    </div>

                    <br><br><p>--------------------------------------------------------------------------------------</p><br><br>
                <div>
                  <center>
                    <table>
                      <strong>Overall Breathing Training Data</strong><br>
                      <tr>
                        <th>No. </th>
                        <th>Username</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Race</th>
                        <th>Country</th>
                        <th>Illness</th>
                        <th>Date Time</th>
                        <th>Feeling before</th>
                        <th>Feeling after</th>
                      </tr>
                      <?php $counter = 0 ?>
                        @foreach ($filterbreathing as $b)
                        <?php $counter++ ?>
                          <tr>
                            <td>
                            {{$counter}}
                            </td>
                            <td>
                            {{$b->name}}
                            </td>
                            <td>
                            {{$b->age}}
                            </td>
                            <td>
                            {{$b->gender}}
                            </td>
                            <td>
                            {{$b->weight}} kg
                            </td>
                            <td>
                            {{$b->height}} cm
                            </td>
                            <td>
                            {{$b->race}}
                            </td>
                            <td>
                            {{$b->country}}
                            </td>
                            <td>
                            {{$b->illness}}
                            </td>
                            <td>
                            {{$b->created_at}}
                            </td>
                            <td>
                            {{$b->before}}
                            </td>
                            <td>
                            {{$b->after}}
                            </td>
                          </tr>
                        @endforeach
                  </table>
                </center>
              </div>
              <br>




              <div>



                  <!-- Main Application (Can be VueJS or other JS framework) -->

                  <div class="app">

                      <center>

                          {!! $chartBt->html() !!}

                      </center>

                  </div>

                  <!-- End Of Main Application -->

                  {!! Charts::scripts() !!}

                  {!! $chartBt->script() !!}
              </div>



              <br><br><p>--------------------------------------------------------------------------------------</p><br><br>
              <div>
                <center>
                  <table>
                    <strong>Overall HRV Data</strong><br>
                    <tr>
                      <th>No. </th>
                      <th>Username</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Weight</th>
                      <th>Height</th>
                      <th>Race</th>
                      <th>Country</th>
                      <th>Illness</th>
                      <th>Date Time</th>
                      <th>Feeling before</th>
                      <th>HRV (ms)</th>
                      <th>Feeling after</th>
                    </tr>
                      <?php $counter = 0 ?>
                      <?php $totalAge = 0 ?>
                      <?php $totalHeight = 0 ?>
                      <?php $totalWeight = 0 ?>
                      <?php $totalHrv = 0 ?>
                      @foreach ($filterhrv as $b)
                        <?php $counter++ ?>
                        <tr>
                          <td>
                          {{$counter}}
                          </td>
                          <td>
                          {{$b->name}}
                          </td>
                          <td>
                          {{$b->age}} <?php $totalAge += $b->age ?>
                          </td>
                          <td>
                          {{$b->gender}}
                          </td>
                          <td>
                          {{$b->weight}} kg <?php $totalWeight += $b->weight ?>
                          </td>
                          <td>
                          {{$b->height}} cm <?php $totalHeight += $b->height ?>
                          </td>
                          <td>
                          {{$b->race}}
                          </td>
                          <td>
                          {{$b->country}}
                          </td>
                          <td>
                          {{$b->illness}}
                          </td>
                          <td>
                          {{$b->created_at}}
                          </td>
                          <td>
                          {{$b->before}}
                          </td>
                          <td>
                          {{$b->hrv}} <?php $totalHrv += $b->hrv ?>
                          </td>
                          <td>
                          {{$b->after}}
                          </td>
                        </tr>
                      @endforeach
                </table>

                  <p>Average Age: {{$totalAge/$counter}}</p>
                  <p>Average Weight: {{$totalWeight/$counter}}</p>
                  <p>Average Height: {{$totalHeight/$counter}}</p>
                  <p>Average HRV: {{$totalHrv/$counter}}</p><br>

              </center>
            </div>


            <div>



                <!-- Main Application (Can be VueJS or other JS framework) -->

                <div class="app">

                    <center>

                        {!! $chartHrv->html() !!}

                    </center>

                </div>

                <!-- End Of Main Application -->

                {!! Charts::scripts() !!}

                {!! $chartHrv->script() !!}
            </div>

            @endif
        </div>
    </div>
</div>
@endsection
