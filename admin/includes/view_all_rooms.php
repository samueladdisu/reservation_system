
<div id="viewRoom" class="col-12 row mb-2">

  <div class="t-datepicker col-3">
    <div class="t-check-in">
      <div class="t-dates t-date-check-in">
        <label class="t-date-info-title">Check In</label>
      </div>
      <input type="hidden" class="t-input-check-in" name="start">
      <div class="t-datepicker-day">
        <table class="t-table-condensed">
          <!-- Date theme calendar -->
        </table>
      </div>
    </div>
    <div class="t-check-out">
      <div class="t-dates t-date-check-out">
        <label class="t-date-info-title">Check Out</label>
      </div>
      <input type="hidden" class="t-input-check-out" name="end">
    </div>
  </div>



  <?php

  if ($_SESSION['user_role'] == 'SA') {

  ?>
    <div class="form-group col-2">
      <select name="room_location" class="custom-select" v-model="location" id="">
        <option disabled value="">Resort Location</option>
        <?php

        $query = "SELECT * FROM locations";
        $result = mysqli_query($connection, $query);
        confirm($result);

        while ($row = mysqli_fetch_assoc($result)) {
          $location_id = $row['location_id'];
          $location_name = $row['location_name'];

          echo "<option value='$location_name'>{$location_name}</option>";
        }
        ?>
      </select>
    </div>
  <?php } else { ?>
    <input type="hidden" id="user_location" name="room_location" value="<?php echo $_SESSION['user_location']; ?>">


  <?php  }


  ?>

  <div class="form-group col-2">
    <select name="room_location" class="custom-select" v-model="roomType" id="">
      <option disabled value="">Room Type</option>
      <?php

      $query = "SELECT * FROM room_type";
      $result = mysqli_query($connection, $query);
      confirm($result);

      while ($row = mysqli_fetch_assoc($result)) {
        $type_name = $row['type_name'];
        $type_location = $row['type_location'];

        echo "<option value='$type_name'>{$type_name}</option>";
      }
      ?>
    </select>
  </div>


  <div id="bulkContainer" class="col-3">
    <button name="booked" @click.prevent="filterRooms" class="btn btn-success">Filter</button>

    <button name="booked" value="location" id="location" @click.prevent="clearFilter" class="btn btn-danger mx-2">Clear Filters</button>
  </div>


  <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

    <thead>
      <tr>
        <th>Id</th>
        <th>Occupancy</th>
        <th>Accomodation</th>
        <th>Image</th>
        <th>Price</th>
        <th>Number</th>
        <th>Status</th>
        <th>Location</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody class="insert-data">


      <tr v-for="row in allData" :key="row.room_id">
        <td>
          {{ row.room_id }}
        </td>
        <td>
          {{ row.room_occupancy }}
        </td>
        <td>
          {{ row.room_acc }}
        </td>
        <td>
          <img width="100" :src="'./room_img/'+ row.room_image" alt="">
        </td>
        <td>
          {{ row.room_price }}
        </td>
        <td>
          {{ row.room_number }}
        </td>
        <td>
          {{ row.room_status }}
        </td>
        <td>
          {{ row.room_location }}
        </td>
        <td>
          {{ row.room_desc.substring(0,50)+"..." }}
        </td>

        <?php 
          if($_SESSION['user_role'] != 'RA'){
          ?>
          <td>
          <a :href="'rooms.php?source=edit_room&p_id=' + row.room_id">
            <i style="color: turquoise;" class="far fa-edit"></i>
          </a>
        </td>
        <td data-toggle="modal" data-target="#deleteModal" @click="setTemp(row)">
          <i style="color: red;" class="far fa-trash-alt"></i>
        </td>
        <?php  }
        
        ?>

        
      </tr>
    </tbody>
  </table>

  <nav class="pag" aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <button type="button" class="page-link" v-if="page != 1" @click="page--"> Previous </button>
      </li>
      <li class="page-item">
        <button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" @click="page = pageNumber"> {{pageNumber}} </button>
      </li>
      <li class="page-item">
        <button type="button" @click="page++" v-if="page < pages.length" class="page-link"> Next </button>
      </li>
    </ul>
  </nav>

  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Are you sure You want to Delete?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Select "Delete" to confirm deletion.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" @click="deleteRes" data-dismiss="modal">Delete</button>
            </div>
          </div>
        </div>
      </div>
</div>