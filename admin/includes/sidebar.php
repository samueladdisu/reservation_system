 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark daccordion" id="accordionSidebar">
 <!-- navbar-nav bg-gradient-dark sidebar sidebar-dark daccordion -->
     <!-- Sidebar - Brand -->
     <a class="sidebar-brand my-3 d-flex align-items-center justify-content-center" href="dashboard.php">
         <div class="sidebar-brand-icon rotate-n-15">
         </div>
         <div class="sidebar-brand-text py-3">
             <img width="150" src="../img/Kuriftu_logo.svg" alt="">

         </div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
         <a class="nav-link" href="dashboard.php">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     <li class="nav-item">
         <a class="nav-link" href="./qrcode">
             <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
             <span> Scan QR code </span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Interface
     </div>



     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#res" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-newspaper fa-2x text-gray-300"></i>
             <span>Reservations</span>
             <i style="margin-left: 3.5rem; font-size: 0.8rem;" class="fas fa-chevron-down  text-gray-300"></i>
         </a>
         <div id="res" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="./reservations.php">View All reservations</a>
                 <!-- <a class="collapse-item" href="./unconfirmed_reservation.php">Unconfirmed Reservation</a> -->
                 <a class="collapse-item" href="./reservations.php?source=add_reservation">Add Reservation</a>
                 <a class="collapse-item" href="./view_bulk_reservations.php">View Group Reservation</a>
                 <a class="collapse-item" href="./reservations.php?source=bulk">Add Group Reservation</a>
             </div>
         </div>
     </li>

     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#special_request" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-newspaper fa-2x text-gray-300"></i>
             <span>Special Request</span>
             <i style="margin-left: 2.4rem; font-size: 0.8rem;" class="fas fa-chevron-down  text-gray-300"></i>
         </a>
         <div id="special_request" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="./view_special.php">View Special Request</a>
                 <a class="collapse-item" href="./add_special.php">Add Special Request</a>
             </div>
         </div>
     </li>

     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inhouse" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-newspaper fa-2x text-gray-300"></i>
             <span>Inhouse </span>
             <i style="margin-left: 5.6rem; font-size: 0.8rem;" class="fas fa-chevron-down  text-gray-300"></i>
         </a>
         <div id="inhouse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="./view_inhouse.php">View</a>
                 <a class="collapse-item" href="./add_inhouse.php">Add </a>
             </div>
         </div>
     </li>

     
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ticket" aria-expanded="true" aria-controls="collapseTick">
             <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
             <span>Tickets </span>
             <i style="margin-left: 5.6rem; font-size: 0.8rem;" class="fas fa-chevron-down  text-gray-300"></i>
         </a>
         <div id="ticket" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="./view_tickets.php">View Tickets</a>
                 <a class="collapse-item" href="./scanned_tickets.php">Scanned Tickets </a>
             </div>
         </div>
     </li>
     
     <!-- <li class="nav-item">
         <a class="nav-link" href="./view_tickets.php">
             <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
             <span> Ticket Reservations </span></a>
     </li> -->


     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-newspaper fa-2x text-gray-300"></i>
             <span>Rooms</span>
             <i style="margin-left: 5.8rem; font-size: 0.8rem;" class="fas fa-chevron-down  text-gray-300"></i>
         </a>
         <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="./rooms.php">View All Rooms</a>
                 <?php
                    if ($_SESSION['user_role'] != 'RA') {
                    ?>
                     <a class="collapse-item" href="./rooms.php?source=add_room">Add Room</a>
                     <a class="collapse-item" href="./acc.php">Room Type</a>
                 <?php
                    }
                    ?>


                 <?php if ($_SESSION['user_role'] == 'SA') {
                    ?>
                     <a class="collapse-item" href="./locations.php">
                         <span>Locations</span>
                     </a>
                 <?php
                    } ?>
             </div>
         </div>
     </li>
     <!-- Nav Item - Utilities Collapse Menu -->





     <li class="nav-item">
         <a class="nav-link" href="./promo.php">
             <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
             <span> Promo Code </span></a>
     </li>



     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#member" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-users fa-2x text-gray-300"></i>
             <span>Members</span>
             <i style="margin-left: 4.5rem; font-size: 0.8rem;" class="fas fa-chevron-down  text-gray-300"></i>
         </a>
         <div id="member" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="./members.php">View All members</a>
                 <a class="collapse-item" href="./members.php?source=add_member">Add Member</a>
             </div>
         </div>
     </li>

     <?php

        if ($_SESSION['user_role'] == 'SA' || $_SESSION['user_role'] == 'PA') {
        ?>
         <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-users fa-2x text-gray-300"></i>

                 <span>Users</span>
                 <i style="margin-left: 6rem; font-size: 0.8rem;" class="fas fa-chevron-down  text-gray-300"></i>
             </a>

             <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item" href="./users.php">View all Users</a>
                     <a class="collapse-item" href="./users.php?source=add_user">Add User</a>
                 </div>
             </div>
         </li>



     <?php   } ?>


    





     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle">
             <i style=" font-size: 0.8rem;" class="fas fa-chevron-left text-white"></i>
         </button>
     </div>

     <!-- Sidebar Message -->


 </ul>