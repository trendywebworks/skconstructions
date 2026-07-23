<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
        <div class="form widget-content-area br-8">
            <div class="row mb-4">
                <div class="col-md-3" id="allsites">
                        <div class="form-group">
                            <label for="fullName">All Sites</label>
                            <select class="form-select mb-3" id="state" onchange="allsites(this)" onclick="enafun()" >
                                <option value="selct">Select</option>
                                <option value="marketl">All Sites</option>
                                <option value="marketl">Kondagaon</option>
                                <option value="purchase">Lohandiguda</option>
                                <option value="gstbill">Kumarpara</option>
                                <option value="ccaccount">Kondagaon</option>
                            </select>
                        </div>
                </div>
                <div class="col-md-3" id="reportype">
                    <div class="form-group">
                        <label for="fullName">Report Types</label>
                        <select class="form-select mb-3" id="state" onchange="reporttype(this)" onclick="enafun()" >
                            <option value="selct">Select</option>
                            <option value="marketl">Market Loan</option>
                            <option value="purchase">Purchase</option>
                            <option value="gstbill">GST Bill</option>
                            <option value="ccaccount">CC Account</option>
                            <option value="products">Products</option>
                            <option value="officeex">Office Expense</option>
                            <option value="staffl">Staff Loan</option>
                            <option value="partn">Partners</option>
                            <option value="vehicls">Vehicles</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 d-none" id="reportfor">
                    <div class="form-group">
                    <label for="reportforena">Report For</label>
                        <select class="form-select mb-3" 
                        onchange="reportforf(this)" id="reportforena" disabled>
                            <option selected="">Select</option>
                            <option value="site">Site</option>
                            <option value="officestaff"  >Office Staff</option>
                            <option value="vehicles"  >Vehicles</option>
                            <option value="loanparty"  >Loan Party</option>
                            <option value="supplier"  >Supplier</option>
                            <option value="employee"  >Employee</option>
                            <option value="bank"  >Bank</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3 d-none" id="partnersname">
                    <div class="form-group">
                        <label for="partnernena">Partners Name</label>
                        <select class="form-select mb-3" id="partnernena" disabled>
                            <option selected="">Select</option>
                            <option>Sameer</option>
                            <option>Rakesh</option>
                            <option>Rohan</option>
                            <option>Rohit</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="sitename">
                    <div class="form-group">
                        <label for="sitenena">Site Name</label>
                        <select class="form-select mb-3" id="sitenena" disabled>
                            <option selected="">Select</option>
                            <option>Kondagon Site</option>
                            <option >Kumarpara Site</option>
                            <option>Rohan Traders</option>
                            <option>Rohit</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="vehiclneno">
                    <div class="form-group" >
                    <label for="vehiclnena">Vehicle Name</label>
                        <select class="form-select mb-3" id="vehiclnena" disabled>
                            <option selected="">Select</option>
                            <option>JCB</option>
                            <option>Truck</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="vehicleno">
                    <div class="form-group" >
                    <label for="vehiclena">Vehicle No</label>
                        <select class="form-select mb-3" id="vehiclena" disabled>
                            <option selected="">Select</option>
                            <option>CG-17 K 9045</option>
                            <option>CG-17 B 9045</option>
                            <option>CG-17 M 6034</option>
                            <option>CG-17 P 2067</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="staffn">
                    <div class="form-group" >
                        <label for="staffena">Staff Name</label>
                        <select class="form-select mb-3" id="staffena" disabled>
                            <option selected="">Select</option>
                            <option>Summit</option>
                            <option>Rakesh</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="lpartyname">
                    <div class="form-group" >
                        <label for="loanpena">Loan Party Name</label>
                        <select class="form-select mb-3" id="loanpena" disabled>
                            <option selected="">Select</option>
                            <option>Summit</option>
                            <option>Rakesh</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="partyname">
                    <div class="form-group" >
                        <label for="partynena">Bank Name</label>
                        <select class="form-select mb-3" id="partynena" disabled>
                            <option selected="">Select</option>
                            <option>HDFC Bank</option>
                            <option>SBI Bank</option>
                            <option>Axis Bank</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="suppliern">
                    <div class="form-group">
                        <label for="supplierena">Supplier Name</label>
                        <select class="form-select mb-3" id="supplierena" disabled>
                            <option selected="">Select</option>
                            <option>Summit</option>
                            <option>Rakesh</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="officeexpen">
                    <div class="form-group" >
                        <label for="state">Office Expenses Types</label>
                        <select class="form-select" id="officeexenable" disabled>
                            <option selected="">Select</option>
                            <option>Salary</option>
                            <option>Electricity</option>
                            <option>Repair</option>
                            <option>Other Expenses</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-none" id="productname">
                    <div class="form-group" >
                        <label for="state">Product name</label>
                        <select class="form-select" id="prodnenable" disabled>
                            <option selected="">Select</option>
                            <option>Plywood</option>
                            <option>Bricks</option>
                            <option>Bath Tub</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" >
              <div class="col-md-3" id="particu">
                    <div class="form-group" >
                        <label for="state">Search Term</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-4">
                        <label for="date">Start Date</label>
                        <div id="datepicker" 
                            class="input-group date" 
                            data-date-format="dd-mm-yyyy">
                            <input class="form-control" style=" z-index: 1100;display: block;" 
                                type="text" readonly />
                            <span class="input-group-addon">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-4">
                        <label for="date">End Date</label>
                        <div id="datepicker2" 
                            class="input-group date" 
                            data-date-format="dd-mm-yyyy">
                            <input class="form-control" 
                                type="text" readonly disabled />
                            <span class="input-group-addon">
                            </span>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-md-12 mt-1">
                    <div class="form-group text-start">
                        <button class="btn btn-primary _effect--ripple waves-effect waves-light">Search</button>
                    </div>
                </div>
        </div>
    </div>
</div>
    
<div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <table id="html5-extension" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email-Address</th>
                                <th>ID Proof</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                
                                <td>
                                    <span class="inv-date">12 Jan, 2023 </span>
                                </td>
                                <td>
                                        <p class="align-self-center mb-0 admin-name"> Roshan </p>
                                </td>
                                <td>790947834</td>
                                <td>rakesh.sahu@gmail.com</span></td>
                                <td>
                                    <div class="usr-img-frame me-2 rounded-circle">
                                        <img alt="avatar" class="img-fluid rounded-circle" src="src/assets/img/boy.png">
                                    </div>
                                </td>
                                <td>Hardware partner</td>
                                <td>
                                    <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit" data-bs-original-title="Edit" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>              
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="inv-date"> 15 Dec, 2023 </span>
                                </td>
                                <td>
                                        <p class="align-self-center mb-0 admin-name"> Aakash </p>
                                </td>
                                <td>8967893613</td>
                                <td>aaksahmishra@gmail.com</span></td>
                                <td>
                                    <div class="usr-img-frame me-2 rounded-circle">
                                        <img alt="avatar" class="img-fluid rounded-circle" src="src/assets/img/boy.png">
                                    </div>
                                </td>
                                <td>Manager of Kondagon's Site</td>
                                <td>
                                    <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit" data-bs-original-title="Edit" aria-label="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>              
                                </td>
                            </tr> 
                        </tbody>
                    </table>
        </div>
    </div>
</div>
<!-- For report filter -->
<script type="text/javascript">
        function reporttype(answer){
            
            if(answer.value=="ccaccount"){
                document.getElementById('partynena').disabled = false;
                document.getElementById('partyname').classList.remove('d-none');

                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('productname').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');

            }
            else if(answer.value=="marketl"){
                document.getElementById('loanpena').disabled = false;
                document.getElementById('lpartyname').classList.remove('d-none');
                
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');

            }
            else if(answer.value=="purchase"){
                document.getElementById('supplierena').disabled = false;
                document.getElementById('suppliern').classList.remove('d-none');
                
                document.getElementById('productname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('staffn').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');
            }
            else if(answer.value=="gstbill"){
                document.getElementById('supplierena').disabled = false;
                document.getElementById('suppliern').classList.remove('d-none');

                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('staffn').classList.add('d-none');
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('productname').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');
            }
            else if(answer.value=="officeex"){
                document.getElementById('officeexenable').disabled = false;
                document.getElementById('officeexpen').classList.remove('d-none');
                
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('productname').classList.add('d-none');
                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');

            }

            else if(answer.value=="products"){
                document.getElementById('prodnenable').disabled = false;
                document.getElementById('productname').classList.remove('d-none');

                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');

            }
            else if(answer.value=="staffl"){
                document.getElementById('staffn').classList.remove('d-none');

                document.getElementById('staffena').disabled = false;
                
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('productname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
            }
            else if(answer.value=="partn"){

                document.getElementById('partnersname').classList.remove('d-none');
                document.getElementById('partnernena').disabled = false;

                document.getElementById('productname').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('staffn').classList.add('d-none');
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('vehicleno').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
                document.getElementById('vehiclneno').classList.add('d-none');
            }
            else if(answer.value=="vehicls"){
                document.getElementById('vehiclena').disabled = false;
                document.getElementById('vehiclnena').disabled = false;
                document.getElementById('vehicleno').classList.remove('d-none');
                document.getElementById('vehiclneno').classList.remove('d-none');

                document.getElementById('productname').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('staffn').classList.add('d-none');
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
            }

            else{

                document.getElementById('productname').classList.add('d-none');
                document.getElementById('suppliern').classList.add('d-none');
                document.getElementById('partnersname').classList.add('d-none');
                document.getElementById('officeexpen').classList.add('d-none');
                document.getElementById('staffn').classList.add('d-none');
                document.getElementById('reportfor').classList.add('d-none');
                document.getElementById('sitename').classList.add('d-none');
                document.getElementById('lpartyname').classList.add('d-none');
                document.getElementById('partyname').classList.add('d-none');
                document.getElementById('vehicleno').classList.add('d-none');

            }
        }

            function reportforf(answer){
                    if(answer.value=="site"){
                        document.getElementById('sitename').classList.remove('d-none');
                        document.getElementById('suppliern').classList.add('d-none');
                        document.getElementById('vehicleno').classList.add('d-none');
                        document.getElementById('staffn').classList.add('d-none');
                        document.getElementById('officeexpen').classList.add('d-none');
                        document.getElementById('productname').classList.add('d-none');

                    }
                    if(answer.value=="vehicles"){
                        document.getElementById('vehicleno').classList.remove('d-none');
                        document.getElementById('suppliern').classList.add('d-none');
                        document.getElementById('staffn').classList.add('d-none');
                        document.getElementById('officeexpen').classList.add('d-none');
                        document.getElementById('productname').classList.add('d-none');

                    }
                    if(answer.value=="officestaff"){
                        document.getElementById('officeexpen').classList.remove('d-none');
                        document.getElementById('staffn').classList.remove('d-none');
                        document.getElementById('suppliern').classList.add('d-none');
                        document.getElementById('vehicleno').classList.add('d-none');
                        document.getElementById('sitename').classList.add('d-none');
                        document.getElementById('partnersname').classList.add('d-none');
                        document.getElementById('productname').classList.add('d-none');
                        document.getElementById('officeexenable').disabled = false;
                        document.getElementById('staffena').disabled = false;

                    }
                    if(answer.value=="loanparty"){
                        document.getElementById('loanpena').disabled = false;
                        
                        document.getElementById('sitename').classList.add('d-none');
                        document.getElementById('suppliern').classList.add('d-none');
                        document.getElementById('vehicleno').classList.add('d-none');
                        document.getElementById('lpartyname').classList.remove('d-none');
                        document.getElementById('productname').classList.add('d-none');

                    }
                    if(answer.value=="supplier"){
                        document.getElementById('supplierena').disabled = false;

                        document.getElementById('sitename').classList.add('d-none');
                        document.getElementById('suppliern').classList.remove('d-none');
                        document.getElementById('productname').classList.add('d-none');

                        document.getElementById('vehicleno').classList.add('d-none');
                        document.getElementById('lpartyname').classList.add('d-none');
                        document.getElementById('staffn').classList.add('d-none');
                        document.getElementById('officeexpen').classList.add('d-none');
                    }

                    if(answer.value=="employee"){
                        document.getElementById('staffena').disabled = false;

                        document.getElementById('sitename').classList.add('d-none');
                        document.getElementById('suppliern').classList.add('d-none');
                        document.getElementById('productname').classList.add('d-none');
                        
                        document.getElementById('vehicleno').classList.add('d-none');
                        document.getElementById('lpartyname').classList.add('d-none');
                        document.getElementById('officeexpen').classList.add('d-none');
                        document.getElementById('staffn').classList.remove('d-none');
                    }

                }
    </script>

</div>