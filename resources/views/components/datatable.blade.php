<div class="card-body">
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
      <div class="card">
        <div class="card-body"> 
          <div class="table-responsive">
            <table id="datatables" class="table border">
              {{ $slot }}
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>