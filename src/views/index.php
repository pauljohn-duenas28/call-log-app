<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Call Log App</title>
  
  <!-- Popperjs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
  <!-- Font awesome is not required provided you change the icon options -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/solid.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/fontawesome.min.js"></script>

  <!-- Tempus Dominus JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>

  <!-- Tempus Dominus Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <!-- Option 1: Include in HTML -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  
  <style>
    .table-collapsible {
      cursor: pointer;
    }
    .collapse.in {
      display: block;
    }
    .collapsing {
      -webkit-transition: height 0.35s ease;
      transition: height 0.35s ease;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row d-flex justify-content-between ">
      <div class="col mb-3">
        <div class="mt-5 align-items-center">
          <form class="d-flex" method="get" action="/call-header/search">
              <input name="search_query" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-primary" type="submit">Search</button>
          </form>
        </div>
      </div>
      <div class="col d-flex justify-content-end align-items-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">New Log</button>
      </div>
    </div>
    <table class="table table-bordered table-hover text-center">
      <thead class="table-secondary">
        <tr>
          <th scope="col">Call ID</th>
          <th scope="col">Date</th>
          <th scope="col">IT Person</th>
          <th scope="col">User Name</th>
          <th scope="col">Subject</th>
          <th scope="col">Details</th>
          <th scope="col">Total Hours</th>
          <th scope="col">Total Minutes</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(! empty($data) && is_array($data)) { ?>
          <?php foreach($data as $item) {?> 
            <tr class="">
              <td><?= $item['call_id'] ?></td>
              <td><?= $item['date'] ?></td>
              <td><?= $item['it_person'] ?></td>
              <td><?= $item['user_name'] ?></td>
              <td><?= $item['subject'] ?></td>
              <td><?= $item['details'] ?></td>
              <td><?= $item['total_hours'] ?></td>
              <td><?= $item['total_minutes'] ?></td>
              <td><?= $item['status'] ?></td>
              <td class="d-flex justify-content-evenly align-items-center">
                <button data-bs-toggle="collapse" data-bs-target="<?php echo '#row'.$item['call_id']; ?>"  type="button" class="btn btn-primary">View</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createNewLogDetails" data-bs-whatever="<?php echo $item['call_id']; ?>">Create</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCallLog" data-bs-whatever="<?php echo $item['call_id']; ?>">Delete</button>
              </td>
            </tr>
            <tr class="collapse" id="<?php echo 'row'.$item['call_id']; ?>">
              <td colspan="11">
                <div>
                  <table class="table table-bordered table-hover">
                    <thead class="table-info">
                      <th colspan="2" scope="col">Date</th>
                      <th colspan="2" scope="col">Details</th>
                      <th colspan="2" scope="col">Hours</th>
                      <th colspan="2" scope="col">Minutes</th>
                      <th colspan="2" scope="col">Action</th>
                    </thead>
                    <tbody>
                      <?php if(isset($item['caller_details']) && !empty($item['caller_details'])) {?>
                        <?php foreach($item['caller_details'] as $caller_details) {?>
                          <tr>
                            <td colspan="2"><?= $caller_details['date'] ?></td>
                            <td colspan="2"><?= $caller_details['details'] ?></td>
                            <td colspan="2"><?= $caller_details['hours'] ?></td>
                            <td colspan="2"><?= $caller_details['minutes'] ?></td>
                            <td colspan="2">
                              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCallDetail" data-id="<?php echo $caller_details['call_id']; ?>" data-bs-whatever="<?php echo $caller_details['id']; ?>">Delete</button>
                            </td>
                          </tr>
                        <?php }?>
                      <?php } else { ?>
                      <td colspan="10" class="text-center">No Data</td>
                      <?php }?>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>
          <?php }?>
        <?php } else {?>
          <tr>
            <td colspan="10" class="text-center">No Data</td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>


  <!-- create new log -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/call-header/create" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">New log</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <div class="mb-3">
            <label for="it_person" class="form-label">IT Person:</label>
            <input type="text" class="form-control" id="it_person" name="it_person">
          </div>
          <div class="mb-3">
            <label for="user_name" class="form-label">User Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name"></input>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject"></input>
          </div>
          <div class="mb-3">
            <label for="details" class="form-label">Subject</label>
            <textarea type="text" class="form-control" id="details" name="details" row="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" name="status">
              <option selected value="New">New</option>
              <option value="In Progress">In Progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- create new log details -->
  <div class="modal fade" id="createNewLogDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Log Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/call-details/create" method="POST">
          <div class="modal-body">
            <input type="hidden" class="caller_id" name="caller_id">
            <div class="mb-3">
              <label for="date_time" class="form-label">Date & Time:</label>
              <input type="text" class="form-control" id="date_time" name="date_time">
            </div>
            <div class="mb-3">
              <label for="details" class="form-label">Details</label>
              <input type="text" class="form-control" id="details" name="details"></input>
            </div>
            <div class="mb-3">
              <label for="hours" class="form-label">Hours</label>
              <input type="number" class="form-control" id="hours" name="hours" value="0"></input>
            </div>
            <div class="mb-3">
              <label for="minutes" class="form-label">Minutes</label>
              <input type="number" class="form-control" id="minutes" name="minutes" value="0" row="3"></input>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- delete call log modal -->
  <div class="modal fade" id="deleteCallLog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/call-header/delete" method="POST">
          <div class="modal-body">
            <input type="hidden" class="caller_id" name="caller_id">
            <p>Are you sure you want to delete.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- delete call details modal -->
  <div class="modal fade" id="deleteCallDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/call-details/delete" method="POST">
          <div class="modal-body">
            <input type="hidden" class="caller_details_id" name="caller_details_id">
            <input type="hidden" class="callerId" name="caller_id">
            <p>Are you sure you want to delete.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

  <script>
    var exampleModal = document.getElementById('createNewLogDetails')
    exampleModal.addEventListener('show.bs.modal', function (event) {
      // Button that triggered the modal
      var button = event.relatedTarget
      // Extract info from data-bs-* attributes
      var id = button.getAttribute('data-bs-whatever')

      var callerID = exampleModal.querySelector('.caller_id');

      callerID.value = id
    })
    var deleteModal =document.getElementById('deleteCallLog');

    deleteModal.addEventListener('show.bs.modal', function(event){
      // Button that triggered the modal
      var button = event.relatedTarget
      // Extract info from data-bs-* attributes
      var id = button.getAttribute('data-bs-whatever')

      var callerDetailsID = deleteModal.querySelector('.caller_id');
     
      callerDetailsID.value = id

    });

    var deleteModalDetail = document.getElementById('deleteCallDetail');

    deleteModalDetail.addEventListener('show.bs.modal', function(event){
      // Button that triggered the modal
      var button = event.relatedTarget
      // Extract info from data-bs-* attributes
      var id = button.getAttribute('data-bs-whatever')
      var callerId = button.getAttribute('data-id');

      var deleteCallerDetailId = deleteModalDetail.querySelector('.caller_details_id');
      deleteCallerDetailId.value = id;
      var deleteCallerId = deleteModalDetail.querySelector('.callerId');
      deleteCallerId.value = callerId;

    });
    
  </script>
  
  <script>
    // const picker = new tempusDominus
    // .TempusDominus(document.getElementById('date_time'));

    const datetimepicker1 = new tempusDominus.TempusDominus(document.getElementById('date_time'));

datetimepicker1.display.paint = (unit, date, classes, element) => {
  if (unit === tempusDominus.Unit.date) {
    //highlight tomorrow
    if (date.isSame(new tempusDominus.DateTime().manipulate(1, 'date'), unit)) {
      classes.push('special-day');
    }
  }
}
  </script>
</body>
</html>