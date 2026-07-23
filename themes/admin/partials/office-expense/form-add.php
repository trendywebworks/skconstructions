<div class="row">                
    <div class="col-xl-5 col-lg-5 col-sm-5 layout-spacing">
        <div class="statbox widget box box-shadow">

        <form>
        <div class="form-group mb-4">
                <label for="date">Date</label>
                <div id="datepicker" 
             class="input-group date" 
             data-date-format="dd-mm-yyyy">
            <input class="form-control" 
                   type="text" readonly />
            <span class="input-group-addon">
            </span>
        </div>
            </div>
            <div class="form-group mb-4">
                <label for="particular">Type</label>
                <select class="form-select">
                    <option>Salary</option>
                    <option>Electricity</option>
                    <option>Repair</option>
                    <option>Other Expenses</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="contactperson">Concern Person</label>
                <select class="form-select mb-3" id="contact-person">
                    <option>Sumit</option>
                    <option selected="">Sammer</option>
                    <option>Bhupesh</option>
                    <option>Ram</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="particular">Amount</label>
                <input type="number" class="form-control">
            </div>
            <div class="form-group mb-4">
                    <label for="exampleFormControlTextarea1">Remark</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary">
        </form>

        </div>
    </div>
</div>