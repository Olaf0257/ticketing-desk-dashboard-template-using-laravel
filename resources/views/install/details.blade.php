@extends('layouts.install')

@section('content')

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid p-3">
                        <div class="col-md-8 install-margin">
                            <div class="card">
                                <div class="card-header">Install Ticketing Expert</div>
                                <label class=" text-secondary col-md-4-offset col-md-8 col-form-label font-weight-bold">
                                    Step-2 Setup Database
                                </label>
                                <div class="card-body">
                                    <form method="POST" action="/install">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="host" class="col-md-4 col-form-label text-md-right">Host*</label>

                                            <div class="col-md-6">
                                                <input id="host" type="text" class="form-control"  name="db_host" value="">
                                                <small class="error text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="port" class="col-md-4 col-form-label text-md-right">Port*</label>

                                            <div class="col-md-6">
                                                <input id="port" type="text" class="form-control" name="db_port" value="">
                                                <small class="error text-danger"> </small>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="database" class="col-md-4 col-form-label text-md-right">Database*</label>

                                            <div class="col-md-6">
                                                <input id="database" type="text" class="form-control" name="database" value="">
                                                <small class="error text-danger"></small>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="username" class="col-md-4 col-form-label text-md-right">Username*</label>

                                            <div class="col-md-6">
                                                <input id="username" type="text" class="form-control" name="db_username" value="">
                                                <small class="error text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control" name="db_password" >
                                            </div>
                                        </div>


                                        <div class="col-form-label text-danger font-weight-bold text-center">App URL</div>

                                        <div class="form-group row">
                                            <label for="url" class="col-md-4 col-form-label text-md-right">Enter URL*</label>

                                            <div class="col-md-6">
                                                <input id="url" type="text" class="form-control" name="url" value="">
                                                <small class="error text-danger"></small>
                                            </div>
                                        </div>

                                <label class=" text-secondary col-md-4-offset col-md-8 col-form-label font-weight-bold">
                                    SMTP Details
                                </label>



                                 <div class="form-group row">
                                            <label for="host" class="col-md-4 col-form-label text-md-right">Host*</label>

                                            <div class="col-md-6">
                                                <input id="host" type="text" class="form-control" name="smtp_host" value="">
                                                <small class="error text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="port" class="col-md-4 col-form-label text-md-right">Port*</label>

                                            <div class="col-md-6">
                                                <input id="port" type="text" class="form-control" name="smtp_port" value="">
                                                <small class="error text-danger"> </small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="username" class="col-md-4 col-form-label text-md-right">Username*</label>

                                            <div class="col-md-6">
                                                <input id="username" type="email" class="form-control" name="smtp_username" value="">
                                                <small class="error text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">Password*</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control" name="smtp_password" value="">
                                                <small class="error text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">Email from name</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control" name="name" value="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="smtp_encryption" class=" col-md-4 col-form-label text-md-right">SMTP Encryption*</label>
                                            <div class="col-md-6">
                                                <select class="form-control" id="smtp_encryption" name="smtp_encryption">
                                                    <option value="SSL">ssl</option>
                                                    <option value="TLS">tls</option>
                                                </select>
                                            </div>
                                        </div>

                                        <input type="hidden" name="action" value="next">


                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-secondary float-right m-3">
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

@endsection
