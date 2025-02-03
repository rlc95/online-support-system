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



<div class="container" id="usr">

    <div class="container">
        <div class="card-box mb-30">
						
						<div class="pb-20">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
							</thead>

                            <tbody>

                            @foreach ($customers as $customer)
                                   <tr role="row" class="odd">
                                        <td class="table-plus">{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->sts }}</td>
                                           <td>
                                            
                                           <a href="#" data-id="{{ $customer->id }}" data-tkct="{{ $customer->tid }}" data-name="{{ $customer->name }}" data-email="{{ $customer->email }}" data-mobi="{{ $customer->phone }}" data-ref="{{ $customer->ref }}" class="btn-block view btn btn-secondary btn-sm" data-toggle="modal" data-target="#Medium-modal" type="button">View</a>

                                           </td>
                                    </tr>
                                @endforeach


                            </tbody>

                        </table>
						</div>
					</div>

           </div>



</div>


    <div class="modal fade"
        id="Medium-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Tickets Details
                    </h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                    >
                        ×
                    </button>
                </div>
                <div class="modal-body">

                <div class="col-md-12">
                <table class="table table-striped">
                    <tbody>
                        <tr><th>Customer</th><td id="cusnm"></td></tr>
                        <tr><th>Email</th><td id="cusem"></td></tr>
                        <tr><th>Mobile</th><td id="cusmb"></td></tr>
                        <tr><th>Reference</th><td id="cusrf"></td></tr>
                    </tbody>
                </table>
                </div>

                <div class="col-md-12">
                <form action="" name="tcktfrm" id="tcktfrm" autocomplete="off" enctype="multipart/form-data" method="POST">
                @csrf

                <input type="hidden" id="cusid" class="form-control" value="">
                <input type="hidden" id="tikid" class="form-control" value="">

                <div class="form-group">
                    <label for="reply">Reply</label>
                    <textarea class="form-control" id="reply" name="reply" rows="3"></textarea>
                </div>

                
                </div>
                    
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" id="rplybtn" class="btn btn-primary">
                        Reply
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>



<script src="{{ url('assets/js/support/support.js') }}"></script>

@endsection


