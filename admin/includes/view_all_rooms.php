<div id="viewRoom" class="mb-2 col-12">


  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Room Inventory</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
              <th></th>
              <th></th>
            </tr>
          </thead>
          <!-- <tfoot>
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
              <th></th>
              <th></th>
            </tr>
          </tfoot> -->
          <tbody>
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
              if ($_SESSION['user_role'] != 'RA') {
              ?>
                <td>
                  <a :href="'rooms.php?source=edit_room&p_id=' + row.room_id">
                    <i style="color: turquoise;" class="far fa-edit"></i>
                  </a>
                </td>
                <td data-toggle="modal" data-target="#deleteModal" @click="setTemp(row)">
                  <i style='color: red;' class='far fa-trash-alt'></i>
                </td>
              <?php  }

              ?>


            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


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