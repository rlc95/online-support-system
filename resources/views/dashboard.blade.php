@extends('layouts.admin-dashboard')

@section('title','dashboard')

<style>
  .error {
  color: #F00;
  background-color: #FFF;
  font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  font-size: small;
  }
</style>

@section('content')

<div class="container" id="main">

    <div class="row" style="margin-top: 20px;">

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>


        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Services</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        

    </div>

    <div class="row">

      <div class="col-6">

        <div class="card card-info">
          <div class="card-header">
          <h3 class="card-title">Transactions - Line Chart</h3>
          <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
          </button>
          </div>
          </div>
          <div class="card-body">
          <div class="chart">
          <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
          </div>
          
        </div>

      </div>



      <div class="col-6">

      <div class="card card-primary" style="display: none">
        <div class="card-header">
        <h3 class="card-title">Area Chart</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
        </button>
        </div>
        </div>
        <div class="card-body">
        <div class="chart">
        <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        </div>
        
      </div>

      <div class="card card-primary" style="display: none">
        <div class="card-header">
        <h3 class="card-title">Users - Area Chart</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
        </button>
        </div>
        </div>
        <div class="card-body">
        <div class="chart">
        <canvas id="usrareaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        </div>
        
      </div>


      <div class="card card-info">
        <div class="card-header">
        <h3 class="card-title">User - Line Chart</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
        </button>
        </div>
        </div>
        <div class="card-body">
        <div class="chart">
        <canvas id="usrlineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        </div>
        
      </div>


      </div>

      
    </div>
    

</div>




<div class="container" id="aduser" style="display: none;">

@include('supprt_agent.tickets-control')

</div>

<div class="container" id="adcus" style="display: none;">


</div>


<div class="container" id="datamgrtn" style="display: none;">


</div>


<div class="container" id="surv" style="display: none;">

</div>


<div class="container" id="logerrs" style="display: none;">

</div>


@endsection


